<?php

require_once('./vendor/autoload.php');


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

$emissao = new \DateTime();
$vencimento = new \DateTime();
$quinze_dias = new DateInterval('P15D');
$vencimento->add($quinze_dias);

$boleto->setNumeroConvenio(3128557)
    ->setNumeroCarteira(17)
    ->setNumeroVariacaoCarteira(35)
    ->setCodigoModalidade(1)
    ->setDataEmissao($emissao)
    ->setDataVencimento($vencimento)
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

$integracao = new IntegracaoBB('d27b077904ffaba0136fe17d40050f56b911a5b7', 'eyJpZCI6Ijk0OWM2ZDgtMDQ5IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjIyNTczLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0', 'eyJpZCI6IjM3YjE5MmEtOGU5Ny00NTRiLThhYjQtNjkzYzU5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyMjU3Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6ImhvbW9sb2dhY2FvIiwiaWF0IjoxNjMyMzIxMjI3Nzc1fQ');

$retorno = $integracao->registraBoleto($boleto);
var_dump($retorno);

