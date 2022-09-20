<?php

/**
 * User: Wagner Mengue
 * Date: 01/2018
 * Version: 1.0
 * 
 * Classe do banco Caixa Econômica Federal que integra com webservice
 *
 */

namespace BoletosOnline\Caixa;

use DateTime;
use SimpleXMLElement;
use Exception;
use BoletosOnline\XMLBuilder;
use BoletosOnline\Util;

class IntegracaoCaixa
{
	/**
	 * @var string
	 */
	private $urlIntegracao = 'https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo';

	/**
	 * @var string $dadosXML
	 */
	private $dadosXML;

	public function __construct(BoletoCaixa $boleto)
	{

		$autenticacao = $this->geraHashAutenticacao(array(
			'codigoBeneficiario' => $boleto->beneficiario->codigo,
			'nossoNumero' => $boleto->nossoNumero,
			'dataVencimento' => $boleto->dataVencimento,
			'valorNominal' => $boleto->valor,
			'cnpj' => $boleto->beneficiario->cnpj
		));

		// Gera array de Descontos, se existir
		$descontos = null;
		if ($boleto->descontos && count($boleto->descontos) > 0) {
			$descontos = array();
			foreach ($boleto->descontos as $d) {
				$descontos[] = $d->toArray();
			}
		}

		$arrayDados = array(
			'soapenv:Body' => array(
				'manutencaocobrancabancaria:SERVICO_ENTRADA' => array(
					'sibar_base:HEADER' => array(
						'VERSAO' => '3.0',
						'AUTENTICACAO' => $autenticacao,
						'USUARIO_SERVICO' => 'SGCBS02P', //SGCBS02P - Produção | SGCBS01D - Desenvolvimento
						'OPERACAO' => 'INCLUI_BOLETO', //Implementado apenas para inclusão
						'SISTEMA_ORIGEM' => 'SIGCB',
						'UNIDADE' => $boleto->unidade,
						'DATA_HORA' => date('YmdHis')
					),
					'DADOS' => array(
						'INCLUI_BOLETO' => array(
							'CODIGO_BENEFICIARIO' => $boleto->beneficiario->codigo,
							'TITULO' => array(
								'NOSSO_NUMERO' => $boleto->nossoNumero,
								'NUMERO_DOCUMENTO' => $boleto->numeroDocumento, //código interdo do boleto/título
								'DATA_VENCIMENTO' => $boleto->dataVencimento->format('Y-m-d'),
								'VALOR' => sprintf('%0.2f', $boleto->valor),
								'TIPO_ESPECIE' => '99', // Olhar no manual qual enviar
								'FLAG_ACEITE' => 'S', // S-Aceite | N-Não aceite (reconhecimento de dívida pelo pagador)
								'DATA_EMISSAO' => (new DateTime())->format('Y-m-d'),
								'JUROS_MORA' => $boleto->juros->toArray(),
								'VALOR_ABATIMENTO' => sprintf('%0.2f', $boleto->abatimento),
								'POS_VENCIMENTO' => $boleto->posVencimento->toArray(),
								'CODIGO_MOEDA' => '09', //Real
								'PAGADOR' => $boleto->pagador->toArray(),
								'MULTA' => $boleto->multa ? $boleto->multa->toArray() : null,
							)
						)
					)
				)
			)
		);

		$xml = $this->geraEstruturaXml($arrayDados, $boleto->descontos);
		$this->addMensagensXML($xml, 'RECIBO_PAGADOR', $boleto->mensagensPagador);
		$this->addMensagensXML($xml, 'FICHA_COMPENSACAO', $boleto->mensagensCompensacao);
		$this->addDescontosXML($xml, $boleto->descontos);

		$this->dadosXML = $xml->saveXML();
	}

	private function addMensagensXML(XMLBuilder $xml, $root, $mensagens)
	{
		$rootElement = $xml->createElement($root);
		// Adiciona disconto, se hover
		if ($mensagens && count($mensagens) > 0) {
			$mensagensRoot = $xml->createElement('MENSAGENS');

			foreach ($mensagens as $m) {
				$node = $xml->createElement('MENSAGEM');
				$node->appendChild($xml->createTextNode(substr($m, 0, 40)));
				$mensagensRoot->appendChild($node);
			}

			$multasNode = $this->getElementByTagName($xml, 'MULTA');
			$rootElement->appendChild($mensagensRoot);
			$multasNode->parentNode->insertBefore($rootElement, $multasNode->nextSibling);
		}
	}

	private function addDescontosXML($xml, $descontos)
	{
		// Adiciona disconto, se hover
		if ($descontos && count($descontos) > 0) {
			$descontoRoot = $xml->createElement('DESCONTOS');

			foreach ($descontos as $desconto) {
				$node = $xml->createElement('DESCONTO');

				// Data
				$dataNode = $xml->createElement('DATA');
				$dataNode->appendChild($xml->createTextNode($desconto->data->format('Y-m-d')));
				$node->appendChild($dataNode);

				//Valor
				if ($desconto->valor === 0 && $desconto->percentual) {
					$valorNode = $xml->createElement('PERCENTUAL');
					$valorNode->appendChild($xml->createTextNode(sprintf('%0.2f', $desconto->percentual)));
					$node->appendChild($valorNode);
				} else {
					$valorNode = $xml->createElement('VALOR');
					$valorNode->appendChild($xml->createTextNode(sprintf('%0.2f', $desconto->valor)));
					$node->appendChild($valorNode);
				}

				$descontoRoot->appendChild($node);
			}

			$multasNode = $this->getElementByTagName($xml, 'MULTA');
			$multasNode->parentNode->insertBefore($descontoRoot, $multasNode->nextSibling);
		}
	}

	/**
	 * Realiza o registro no webservice da Caixa Econômica Federal
	 *
	 * @throws Exception
	 * @return SimpleXMLElement
	 */
	public function realizarRegistro()
	{
		try {
			$connCURL = curl_init($this->urlIntegracao);
			curl_setopt($connCURL, CURLOPT_POSTFIELDS, $this->dadosXML);
			curl_setopt($connCURL, CURLOPT_POST, true);
			curl_setopt($connCURL, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($connCURL, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($connCURL, CURLOPT_SSL_VERIFYHOST, false);

			curl_setopt($connCURL, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/xml',
				'SOAPAction: "INCLUI_BOLETO"'
			));

			$responseCURL = curl_exec($connCURL);
			$err = curl_error($connCURL);
			curl_close($connCURL);

			if ($err) {
				throw new Exception('Erro na requisição');
			}

			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $responseCURL);
			return simplexml_load_string($response);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * Retorna o XML que é enviado para o Webservice
	 * @return string
	 */
	public function getDadosXML() {
		return $this->dadosXML;
	}

	/**
	 * Gera o HASH de autenticação
	 * @param array $arrayDadosHash
	 * @return string
	 */
	private function geraHashAutenticacao(array $arrayDadosHash)
	{
		$numeroParaHash = Util::padZero($arrayDadosHash['codigoBeneficiario'], 7);
		$numeroParaHash .= $arrayDadosHash['nossoNumero'];
		$numeroParaHash .= $arrayDadosHash['dataVencimento']->format('dmY');

		$numeroParaHash = preg_replace('/[^A-Za-z0-9]/', '', $numeroParaHash);
		$numeroParaHash .= Util::padZero(preg_replace('/[^0-9]/', '', sprintf('%0.2f', $arrayDadosHash['valorNominal'])), 15);
		$numeroParaHash .= Util::padZero($arrayDadosHash['cnpj'], 14);


		$autenticacao = base64_encode(hash('sha256', $numeroParaHash, true));
		return $autenticacao;
	}

	/**
	 * Retorna um DOMElement a partir do seu nome, feito para converter
	 * DOMNode em DOMelement
	 * @param XMLBuilder $xml
	 * @param string $name
	 * @return \DOMElement
	 */
	private function getElementByTagName(XMLBuilder $xml, string $name)
	{
		return $xml->getElementsByTagName($name)->item(0);
	}

	/**
	 * Recebe o array de dados e faz a geração do XML conforme layout da CAIXA
	 * será armazenado em $this->dadosXml para envio posterior
	 * 
	 * @param array $arrayDados
	 */
	private function geraEstruturaXml(array $arrayDados, $descontos)
	{
		$xml_root = 'soapenv:Envelope';
		$xml = new XMLBuilder('1.0', 'utf-8');
		$xml->preserveWhiteSpace = false;
		$xml->formatOutput = true;
		$xml->convertArrayToXml(array($xml_root => $arrayDados));
		$xml_root_item = $this->getElementByTagName($xml, $xml_root);
		$xml_root_item->setAttribute(
			'xmlns:soapenv',
			'http://schemas.xmlsoap.org/soap/envelope/'
		);
		$xml_root_item->setAttribute(
			'xmlns:manutencaocobrancabancaria',
			'http://caixa.gov.br/sibar/manutencao_cobranca_bancaria/boleto/externo'
		);
		$xml_root_item->setAttribute(
			'xmlns:sibar_base',
			'http://caixa.gov.br/sibar'
		);

		return $xml;
	}
}
