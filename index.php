<?php

require_once('./vendor/autoload.php');

/**
 * Exemplo de uso
 */


use BoletosOnline\Caixa\BoletoCaixa;
use BoletosOnline\Caixa\IntegracaoCaixa;
use BoletosOnline\Pagador;
use BoletosOnline\Beneficiario;
use BoletosOnline\Multa;
use BoletosOnline\Desconto;
use BoletosOnline\Juros;
use BoletosOnline\PosVencimento;

$boleto = new BoletoCaixa();

$pagador = new Pagador();
$pagador->cpf = '46564612885';
$pagador->nome = 'Rafael Henrique Gomes de Morais';
$pagador->logradouro = 'Rua das Laranjeiras 123';
$pagador->bairro = 'Nova Olinda';
$pagador->cidade = 'OSASCO';
$pagador->uf = 'SP';
$pagador->cep = '12356111';

$boleto->beneficiario = new Beneficiario('95040150000135', '088272');
$boleto->unidade = '0524';
$boleto->nossoNumero = '14123456789012345';
$boleto->numeroDocumento = '11111111111';
$boleto->dataVencimento = (new DateTime())->add(new DateInterval(('P15D')));
$boleto->valor = 1000.00;
$boleto->juros = new Juros(Juros::TAXA_MENSAL, null, 2);
$boleto->abatimento = 0;
$boleto->posVencimento = new PosVencimento(PosVencimento::DEVOLVER);
$boleto->pagador = $pagador;
$boleto->multa = new Multa($boleto->dataVencimento->add(new DateInterval('P1D')), 20);
$boleto->descontos = array(
    new Desconto((new DateTime())->add(new DateInterval('P3D')), 20),
    new Desconto((new DateTime())->add(new DateInterval('P7D')), 10),
    new Desconto((new DateTime())->add(new DateInterval('P12D')), 5)
);
$boleto->mensagensCompensacao = array("Teste de mensagem 1", "Teste de Mensagem 2");
$boleto->mensagensPagador = array("Teste de mensagem 3", "Teste de Mensagem 4");

$integracao = new IntegracaoCaixa($boleto);
header('Content-Type: application/xml');
echo($integracao->getDadosXML());
