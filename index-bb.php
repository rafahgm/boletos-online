<?php

require_once('./vendor/autoload.php');

use Dotenv\Dotenv;

// Inicialização do dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Exemplo de uso
 */


use BoletosOnline\BB\IntegracaoBB;
use BoletosOnline\BB\Boleto;
use BoletosOnline\BB\Desconto;
use BoletosOnline\BB\Juros;
use BoletosOnline\BB\Multa;
use BoletosOnline\BB\Pagador;

$pagador = new Pagador();

$pagador->setTipoInscricao(1)
->setNumeroInscricao(46564612885)
->setNome('Rafael Henrique Gomes de Morais')
->setBairro('Distrito de Potunduva')
->setCidade('Jaú')
->setUf('SP')
->setCep(17220133)
->setEndereco('Rua Marino Tomazini, 440');

$boleto = new Boleto();

$boleto->setNumeroConvenio(3128557)
    ->setNumeroCarteira(17)
    ->setNumeroVariacaoCarteira(35)
    ->setCodigoModalidade(1)
    ->setDataEmissao(new \DateTime())
    ->setDataVencimento((new \DateTime())->add(new \DateInterval('P15D')))
    ->setValorOriginal(100.00)
    // ->setDesconto((new Desconto())->setTipo(0))
    // ->setJuros((new Juros())->setTipo(0))
    // ->setMulta((new Multa())->setTipo(0))
    ->setCodigoAceite('S')
    ->setCodigoTipoTitulo(2)
    // ->setDescricaoTipoTitulo('Recibo')
    // ->setIndicadorAceiteTituloVencido('N')
    ->setIndicadorPermissaoRecebimentoParcial('N')
    ->setNumeroTituloCliente('0000019999')
    // ->setMensagemBloquetoOcorrencia('Pagamento disponível até a data de vencimento')
    ->setPagador($pagador);
    // ->setIndicadorPix('S');

$integracao = new IntegracaoBB();

$retorno = $integracao->registraBoleto($boleto);


