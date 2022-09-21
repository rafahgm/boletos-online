<?php

require_once('./vendor/autoload.php');

use BoletosOnline\BB\IntegracaoBB;
use BoletosOnline\BB\Boleto;
use BoletosOnline\BB\Desconto;
use BoletosOnline\BB\Juros;
use BoletosOnline\BB\Multa;
use BoletosOnline\BB\Pagador;

/**
 * 
 * @param string $appKey
 * @param string $clientId
 * @param string $clientSecret
 * 
 * @param int $tipoInsrcicaoPagador Código que identifica o tipo de inscrição do Pagador. 1 - CPF; 2 - CNPJ
 *  
 * @param int $numeroInscricaoPagador Número de inscrição do pagador. Para o tipo = 1, informar numero do CPF. Para o tipo = 2, informar numero do CNPJ.
 * 
 * 
 * @param string $nomePagador Nome do pagador.
 * 
 * 
 * @param string $bairroPagador Bairro do pagador.
 * 
 * 
 * @param string $cidadePagador Cidade do pagador.
 * 
 * 
 * @param string $ufPagador Estado do Pagador, (SP, ES, RJ, ...)
 * 
 * 
 * @param int $cepPagador Código postal do pagador.
 * 
 * 
 * @param string $enderecoPagador Endereço do pagador.
 * 
 *  
 * 
 * @param int $numeroConvenio Número do convênio de Cobrança do Cliente. Identificador determinado pelo sistema Cobrança para controlar a emissão de boletos, liquidação, crédito de valores ao Beneficiário e intercâmbio de dados com o cliente.
 * 
 * 
 * @param int $numeroCarteira Características do serviço de boleto bancário e como ele deve ser tratado pelo banco.
 * 
 * 
 * @param int $numeroVariacaoCarteira Número da variação da carteira do convênio de cobrança.
 * 
 * 
 * @param int $codigoModalidade Identifica a característica dos boletos dentro das modalidades de cobrança existentes no banco.
 * Domínio:
 * 01 - SIMPLES;
 * 04 - VINCULADA
 * 
 * 
 * @param DateTime $dataVencimento Data de vencimento
 * 
 * 
 * @param float $valor Valor do boleto
 * 
 * 
 * @param string $codigoAceite Código para identificar se o boleto de cobrança foi aceito (reconhecimento da dívida pelo Pagador).
 * Domínios: A - ACEITE N - NAO ACEITE
 *

 * @param int $codigoTipoTitulo Código para identificar o tipo de boleto de cobrança.
 *
 * Domínios: 
 * 1- CHEQUE 
 * 2- DUPLICATA MERCANTIL 
 * 3- DUPLICATA MTIL POR INDICACAO 
 * 4- DUPLICATA DE SERVICO 
 * 5- DUPLICATA DE SRVC P/INDICACAO 
 * 6- DUPLICATA RURAL 
 * 7- LETRA DE CAMBIO 
 * 8- NOTA DE CREDITO COMERCIAL 
 * 9- NOTA DE CREDITO A EXPORTACAO 
 * 10- NOTA DE CREDITO INDULTRIAL 
 * 11- NOTA DE CREDITO RURAL 
 * 12- NOTA PROMISSORIA 
 * 13- NOTA PROMISSORIA RURAL 
 * 14- TRIPLICATA MERCANTIL 
 * 15- TRIPLICATA DE SERVICO 
 * 16- NOTA DE SEGURO 
 * 17- RECIBO 
 * 18- FATURA 
 * 19- NOTA DE DEBITO 
 * 20- APOLICE DE SEGURO 
 * 21- MENSALIDADE ESCOLAR 
 * 22- PARCELA DE CONSORCIO 
 * 23- DIVIDA ATIVA DA UNIAO 
 * 24- DIVIDA ATIVA DE ESTADO 
 * 25- DIVIDA ATIVA DE MUNICIPIO 
 * 31- CARTAO DE CREDITO 
 * 32- BOLETO PROPOSTA 
 * 33- BOLETO APORTE 
 * 99- OUTROS.
 * 
 * 
 * @param string $recebimentoParcial Código para identificação da autorização de pagamento parcial do boleto.
 * Domínios: S - SIM N - NÃO
 * 
 * 
 * @param string $numeroTituloCliente Número de identificação do boleto (correspondente ao NOSSO NÚMERO) que deverá ser formatado da seguinte forma: 
 * 10 algarismos - se necessário, completar com zeros à esquerda).
 * 
 * 
 * @param string $indicadorPix Código para informar se o boleto terá um QRCode Pix atrelado. Se informado caracter inválido, assumirá 'N'.
 * Domínios: 
 * 'S' - QRCODE DINAMICO;
 * 'N' - SEM PIX;
 * OUTRO - SEM PIX
 * 
 * 
 * @param string $mensagem Mensagem definida pelo beneficiário para ser impressa no boleto. (Limitado a 30 caracteres) 
 * 
 * 
 * @param int $tipoDesconto1 Como o desconto será concedido, inteiro >= 0. 
 * Domínios: 
 * 0 - SEM DESCONTO; 
 * 1 - VLR FIXO ATE A DATA INFORMADA; 
 * 2 - PERCENTUAL ATE A DATA INFORMADA; 
 * 3 - DESCONTO POR DIA DE ANTECIPACAO.
 * 
 * 
 * @param \DateTime $dataExpiracaoDesconto1 Se tipo > 0, Definir uma data de expiração do desconto.
 * 
 * 
 * @param float $porcentagemDesconto1 Se tipo = 2, definir uma porcentagem de desconto >= 0.00 
 * 
 * 
 * @param float $valorDesconto1 Se tipo = 1, definir um valor de desconto >= 0.00 (formato decimal separado por ".")
 * 
 * 
 * @param int $tipoDesconto2 Como o desconto será concedido, inteiro >= 0. 
 * Domínios: 
 * 0 - SEM DESCONTO; 
 * 1 - VLR FIXO ATE A DATA INFORMADA; 
 * 2 - PERCENTUAL ATE A DATA INFORMADA; 
 * 3 - DESCONTO POR DIA DE ANTECIPACAO.
 * 
 * 
 * @param \DateTime $dataExpiracaoDesconto2 Se tipo > 0, Definir uma data de expiração do desconto.
 * 
 * 
 * @param float $porcentagemDesconto2 Se tipo = 2, definir uma porcentagem de desconto >= 0.00 
 * 
 * 
 * @param float $valorDesconto2 Se tipo = 1, definir um valor de desconto >= 0.00 (formato decimal separado por ".")
 * 
 * 
 * @param int $tipoDesconto3 Como o desconto será concedido, inteiro >= 0. 
 * Domínios: 
 * 0 - SEM DESCONTO; 
 * 1 - VLR FIXO ATE A DATA INFORMADA; 
 * 2 - PERCENTUAL ATE A DATA INFORMADA; 
 * 3 - DESCONTO POR DIA DE ANTECIPACAO.
 * 
 * 
 * @param \DateTime $dataExpiracaoDesconto3 Se tipo > 0, Definir uma data de expiração do desconto.
 * 
 * 
 * @param float $porcentagemDesconto3 Se tipo = 2, definir uma porcentagem de desconto >= 0.00 
 * 
 * 
 * @param float $valorDesconto3 Se tipo = 1, definir um valor de desconto >= 0.00 (formato decimal separado por ".")
 * 
 * 
 * @param int $tipoJuros Código utilizado pela FEBRABAN para identificar o tipo de taxa de juros.
 * Domínios:
 * 0 - DISPENSAR; 
 * 1 - VALOR DIA ATRASO; 
 * 2 - TAXA MENSAL; 
 * 3 - ISENTO.
 * 
 * 
 * @param float $porcentagemJuros Se tipo = 2, definir uma porcentagem de juros >= 0.00
 * 
 * 
 * @param float $valorJuros Se tipo = 1, definir um valor de juros >= 0.00 
 * 
 * 
 * @param int $tipoMulta Como a multa será concedida, inteiro >= 0.
 * 0 - DISPENSAR;
 * 1 - VALOR DIA ATRASO;
 * 2 - TAXA MENSAL;
 * 3 - ISENTO.
 * 
 *
 * @param \DateTime $dataMulta  Se tipo > 0, Definir uma data de multa
 * 
 * 
 * @param float $procentagemMulta Se tipo = 2, definir porcentagem >= 0.00
 * 
 * 
 * @param float $valorMulta Se tipo = 1, definir valor do juros >= 0.00
 * 
 * 
 * @param string $descricaoTipoBoleto Descrição do tipo de boleto.
 * 
 * 
 * @param string $aceiteTituloVencido Indicador de que o boleto pode ou não ser recebido após o vencimento. Campo não obrigatório
 * Se não informado, será assumido a informação de limite de recebimento que está definida no convênio.
 * Quando informado "S" em conjunto com o campo "numeroDiasLimiteRecebimento", será definido a quantidade de dias (corridos) 
 * que este boleto ficará disponível para pagamento após seu vencimento. 
 * Obs.: Se definido "S" e o campo "numeroDiasLimiteRecebimento" ficar com valor zero também será assumido a informação de limite de recebimento que está definida no convênio.
 *
 * Quando informado "N", fica definindo que o boleto NÃO permite pagamento em atraso, portanto só aceitará pagamento até a data do vencimento ou o próximo dia útil, quando o vencimento ocorrer em dia não útil.
 *
 * Quando informado qualquer valor diferente de "S" ou "N" será assumido a informação de limite de recebimento que está definida no convênio.
 */
function registra_boleto_bb(
    $appKey,
    $clientId,
    $clientSecret,
    $tipoInscricaoPagador,
    $numeroInscricaoPagador,
    $nomePagador,
    $bairroPagador,
    $cidadePagador,
    $ufPagador,
    $cepPagador,
    $enderecoPagador,
    $numeroConvenio,
    $numeroCarteira,
    $numeroVariacaoCarteira,
    $codigoModalidade,
    $dataVencimento,
    $valor,
    $codigoAceite,
    $codigoTipoTitulo,
    $recebimentoParcial,
    $numeroTituloCliente,
    $indicadorPix,
    $mensagem,
    $tipoDesconto1 = null,
    $dataExpiracaoDesconto1 = null,
    $porcentagemDesconto1 = null,
    $valorDesconto1 = null,
    $tipoDesconto2 = null,
    $dataExpiracaoDesconto2 = null,
    $porcentagemDesconto2 = null,
    $valorDesconto2 = null,
    $tipoDesconto3 = null,
    $dataExpiracaoDesconto3 = null,
    $porcentagemDesconto3 = null,
    $valorDesconto3 = null,
    $tipoJuros = null,
    $porcentagemJuros = null,
    $valorJuros = null,
    $tipoMulta = null,
    $dataMulta = null,
    $porcentagemMulta = null,
    $valorMulta = null,
    $descricaoTipoTitulo = null,
    $aceiteTituloVencido = null
) {
    $pagador = new Pagador();

    $pagador->setTipoInscricao($tipoInscricaoPagador)
        ->setNumeroInscricao($numeroInscricaoPagador)
        ->setNome($nomePagador)
        ->setBairro($bairroPagador)
        ->setCidade($cidadePagador)
        ->setUf($ufPagador)
        ->setCep($cepPagador)
        ->setEndereco($enderecoPagador);

    $boleto = new Boleto();

    $emissao = new \DateTime();

    $boleto->setNumeroConvenio($numeroConvenio)
        ->setNumeroCarteira($numeroCarteira)
        ->setNumeroVariacaoCarteira($numeroVariacaoCarteira)
        ->setCodigoModalidade($codigoModalidade)
        ->setDataEmissao($emissao)
        ->setDataVencimento($dataVencimento)
        ->setValorOriginal($valor)
        ->setCodigoTipoTitulo($codigoTipoTitulo)
        ->setIndicadorPermissaoRecebimentoParcial($recebimentoParcial)
        ->setNumeroTituloCliente($numeroTituloCliente)
        ->setMensagemBloquetoOcorrencia($mensagem)
        ->setPagador($pagador)
        ->setIndicadorPix($indicadorPix)
        ->setCodigoAceite($codigoAceite);

    if ($tipoDesconto1 && $dataExpiracaoDesconto1 && ($porcentagemDesconto1 || $valorDesconto1)) {
        $desconto = new Desconto();
        $desconto->setTipo($tipoDesconto1)->setDataExpiracao($dataExpiracaoDesconto1);

        if ($porcentagemDesconto1) {
            $desconto->setPorcentagem($porcentagemDesconto1);
        } else {
            $desconto->setValor($valorDesconto1);
        }

        $boleto->setDesconto($desconto);
    }

    if ($tipoDesconto2 && $dataExpiracaoDesconto2 && ($porcentagemDesconto2 || $valorDesconto2)) {
        $desconto = new Desconto();
        $desconto->setTipo($tipoDesconto2)->setDataExpiracao($dataExpiracaoDesconto2);

        if ($porcentagemDesconto2) {
            $desconto->setPorcentagem($porcentagemDesconto2);
        } else {
            $desconto->setValor($valorDesconto2);
        }

        $boleto->setSegundoDesconto($desconto);
    }

    if ($tipoDesconto3 && $dataExpiracaoDesconto3 && ($porcentagemDesconto3 || $valorDesconto3)) {
        $desconto = new Desconto();
        $desconto->setTipo($tipoDesconto3)->setDataExpiracao($dataExpiracaoDesconto3);

        if ($porcentagemDesconto3) {
            $desconto->setPorcentagem($porcentagemDesconto3);
        } else {
            $desconto->setValor($valorDesconto3);
        }

        $boleto->setTerceiroDesconto($desconto);
    }

    if ($tipoJuros && ($porcentagemJuros || $valorJuros)) {
        $juros = new Juros();
        $juros->setTipo($tipoJuros);

        if ($porcentagemJuros) {
            $juros->setPorcentagem($porcentagemJuros);
        } else {
            $juros->setValor($juros);
        }

        $boleto->setJuros($juros);
    }

    if ($tipoMulta && $dataMulta && ($porcentagemMulta || $valorMulta)) {
        $multa = new Multa();
        $multa->setTipo($tipoMulta)->setData($dataMulta);

        if ($porcentagemMulta) {
            $multa->setPorcentagem($porcentagemMulta);
        } else {
            $multa->setValor($multa);
        }

        $boleto->setMulta($multa);
    }

    if ($descricaoTipoTitulo) $boleto->setDescricaoTipoTitulo($descricaoTipoTitulo);

    if ($aceiteTituloVencido) $boleto->setIndicadorAceiteTituloVencido($aceiteTituloVencido);

    $integracao = new IntegracaoBB($appKey, $clientId, $clientSecret);

    return $integracao->registraBoleto($boleto);
}
