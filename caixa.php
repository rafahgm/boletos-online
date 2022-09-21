<?php

require_once('./vendor/autoload.php');

use BoletosOnline\Caixa\BoletoCaixa;
use BoletosOnline\Caixa\IntegracaoCaixa;
use BoletosOnline\Pagador;
use BoletosOnline\Beneficiario;
use BoletosOnline\Multa;
use BoletosOnline\Desconto;
use BoletosOnline\Juros;
use BoletosOnline\PosVencimento;

/**
 * @param int $tipoInsrcicaoPagador Código que identifica o tipo de inscrição do Pagador. 1 - CPF; 2 - CNPJ
 * 
 * @param int $numeroInscricaoPagador Número de inscrição do pagador. Para o tipo = 1, informar numero do CPF. Para o tipo = 2, informar numero do CNPJ.
 * 
 * @param string $nomePagador Nome do pagador.
 * 
 * @param string $bairroPagador Bairro do pagador.
 * 
 * @param string $cidadePagador Cidade do pagador.
 * 
 * @param string $ufPagador Estado do Pagador, (SP, ES, RJ, ...)
 * 
 * @param int $cepPagador Código postal do pagador.
 * 
 * @param string $enderecoPagador Endereço do pagador.
 * 
 * @param int $unidade Codigo da unidade
 * 
 * @param string $nossoNumero Nosso número do boleto, seguindo padrões da Caixa
 * 
 * @param string $numeroDocumento Número do documento para identificação interna
 * 
 * @param DateTime $dataVencimento Data de vencimento do boleto
 * 
 * @param float $valor Valor do boleto
 * 
 * @param string $tipoJuros 'VALOR_POR_DIA' | 'TAXA_MENSAL' | 'ISENTO'
 * 
 * @param \DateTime|null $dataJuros Data indicativa do início da cobrança de Juros de Mora, se null assumirá data de vencimento
 * 
 * @param float $valorJuros Valor absoluto do juros
 * 
 * @param float $abatimento Valor a ser descontado
 * 
 * @param string $posVencimento 'PROTESTAR' | 'DEVOLVER'
 * 
 * @param \DateTime|null $dataMulta Data de aplicação da multa, se null usa data de vencimento
 * 
 * @param float $valorMulta Valor absoluto da multa
 * 
 * @param string[] $mensagensCompensacao Mensagens na Ficha de Compensação (até 2 linhas, até 40 caracteres por linha)
 * 
 * @var string[] $mensagensPagador Mensagens no Recibo Pagador (até 4 linhas, até 40 caracteres por linha)
 * 
 * @param \DateTime $dataExpiracaoDesconto1 Definir uma data de expiração do desconto.
 * 
 * @param float $valorDesconto1 definir um valor de desconto >= 0.00
 * 
 * @param \DateTime $dataExpiracaoDesconto2 Se tipo > 0, Definir uma data de expiração do desconto.
 * 
 * @param float $valorDesconto2 Se tipo = 1, definir um valor de desconto >= 0.00 (formato decimal separado por ".")
 * 
 * @param \DateTime $dataExpiracaoDesconto3 Se tipo > 0, Definir uma data de expiração do desconto.
 * 
 * @param float $valorDesconto3 Se tipo = 1, definir um valor de desconto >= 0.00 (formato decimal separado por ".")
 */
function registra_boleto_caixa(
    $tipoInscricaoPagador,
    $numeroInscricaoPagador,
    $nomePagador,
    $bairroPagador,
    $cidadePagador,
    $ufPagador,
    $cepPagador,
    $enderecoPagador,
    $cnpjBeneficario,
    $codigoBeneficiario,
    $unidade,
    $nossoNumero,
    $numeroDocumento,
    $dataVencimento,
    $valor,
    $tipoJuros,
    $dataJuros,
    $valorJuros,
    $abatimento,
    $posVencimento,
    $dataMulta = null,
    $valorMulta = null,
    $mensagemCompensacao = null,
    $mensagemPagador = null,
    $dataExpiracaoDesconto1 = null,
    $valorDesconto1 = null,
    $dataExpiracaoDesconto2 = null,
    $valorDesconto2 = null,
    $dataExpiracaoDesconto3 = null,
    $valorDesconto3 = null
) {
    $boleto = new BoletoCaixa();

    $pagador = new Pagador();

    if ($tipoInscricaoPagador === 1) {
        $pagador->cpf = strval($numeroInscricaoPagador);
        $pagador->nome = $nomePagador;
    } else if ($tipoInscricaoPagador === 2) {
        $pagador->cnpj = strval($numeroInscricaoPagador);
        $pagador->razaoSocial = $nomePagador;
    }

    $pagador->logradouro = $enderecoPagador;
    $pagador->bairro = $bairroPagador;
    $pagador->cidade = $cidadePagador;
    $pagador->uf = $ufPagador;
    $pagador->cep = strval($cepPagador);

    $boleto->beneficiario = new Beneficiario(strval($cnpjBeneficario), strval($codigoBeneficiario));
    $boleto->unidade = str_pad(strval($unidade), 4, '0', STR_PAD_LEFT);
    $boleto->nossoNumero = $nossoNumero;
    $boleto->numeroDocumento = $numeroDocumento;
    $boleto->dataVencimento = $dataVencimento;
    $boleto->valor = $valor;

    $juros = new Juros($tipoJuros, $dataJuros, $valorJuros);

    $boleto->juros = $juros;

    $boleto->abatimento = $abatimento;

    $boleto->posVencimento = new PosVencimento($posVencimento);
    $boleto->pagador = $pagador;

    if($dataMulta) $boleto->multa = new Multa($dataMulta, $valorMulta);

    $descontos = array();

    if ($dataExpiracaoDesconto1) {
        $descontos[] = new Desconto($dataExpiracaoDesconto1, $valorDesconto1);
    }


    if ($dataExpiracaoDesconto2) {
        $descontos[] = new Desconto($dataExpiracaoDesconto2, $valorDesconto2);
    }


    if ($dataExpiracaoDesconto3) {
        $descontos[] = new Desconto($dataExpiracaoDesconto3, $valorDesconto3);
    }

    $boleto->descontos = $descontos;

    $boleto->mensagensCompensacao = $mensagemCompensacao;
    $boleto->mensagensPagador = $mensagemPagador;

    $integracao = new IntegracaoCaixa($boleto);

    return $integracao->getDadosXML();
}
