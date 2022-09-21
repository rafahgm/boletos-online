<?php
ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');
// require_once('./caixa.php');
require_once('./banco-brasil.php');

// pagador = new Pagador();
// $pagador->cpf = '46564612885';
// $pagador->nome = 'Rafael Henrique Gomes de Morais';
// $pagador->logradouro = 'Rua das Laranjeiras 123';
// $pagador->bairro = 'Nova Olinda';
// $pagador->cidade = 'OSASCO';
// $pagador->uf = 'SP';
// $pagador->cep = '12356111';

// $boleto->beneficiario = new Beneficiario('95040150000135', '088272');
// $boleto->unidade = '0524';
// $boleto->nossoNumero = '14123456789012345';
// $boleto->numeroDocumento = '11111111111';
// $boleto->dataVencimento = (new DateTime())->add(new DateInterval(('P15D')));
// $boleto->valor = 1000.00;
// $boleto->juros = new Juros(Juros::TAXA_MENSAL, null, 2);
// $boleto->abatimento = 0;
// $boleto->posVencimento = new PosVencimento(PosVencimento::DEVOLVER);
// $boleto->pagador = $pagador;
// $boleto->multa = new Multa($boleto->dataVencimento->add(new DateInterval('P1D')), 20);
// $boleto->descontos = array(
//     new Desconto((new DateTime())->add(new DateInterval('P3D')), 20),
//     new Desconto((new DateTime())->add(new DateInterval('P7D')), 10),
//     new Desconto((new DateTime())->add(new DateInterval('P12D')), 5)
// );
// $boleto->mensagensCompensacao = array("Teste de mensagem 1", "Teste de Mensagem 2");
// $boleto->mensagensPagador = array("Teste de mensagem 3", "Teste de Mensagem 4");

// header('Content-Type: application/xml');
// echo (registra_boleto_caixa(
//     1,
//     46564612885,
//     'Rafael Henrique Gomes de Morais',
//     'Nova Olinda',
//     'Jaú',
//     'SP',
//     12356111,
//     'Rua das Laranjeiras, 123',
//     95040150000135,
//     088272,
//     0524,
//     '14123456789012345',
//     '11111111111',
//     new DateTime('2022-09-25'),
//     100.00,
//     'ISENTO',
//     null,
//     0,
//     0,
//     'DEVOLVER'
// ));



// use BoletosOnline\BB\IntegracaoBB;
// use BoletosOnline\BB\Boleto;
// use BoletosOnline\BB\Desconto;
// use BoletosOnline\BB\Juros;
// use BoletosOnline\BB\Multa;
// use BoletosOnline\BB\Pagador;

// $pagador = new Pagador();

// $pagador->setTipoInscricao(1)
// ->setNumeroInscricao(46564612885)
// ->setNome('Rafael Henrique Gomes de Morais')
// ->setBairro('Distrito de Potunduva')
// ->setCidade('Jaú')
// ->setUf('SP')
// ->setCep(17220133)
// ->setEndereco('Rua Marino Tomazini, 440');

// $boleto = new Boleto();

// $emissao = new \DateTime();
// $vencimento = new \DateTime();
// $quinze_dias = new DateInterval('P15D');
// $vencimento->add($quinze_dias);

// $boleto->setNumeroConvenio(3128557)
//     ->setNumeroCarteira(17)
//     ->setNumeroVariacaoCarteira(35)
//     ->setCodigoModalidade(1)
//     ->setDataEmissao($emissao)
//     ->setDataVencimento($vencimento)
//     ->setValorOriginal(100.00)
//     // ->setDesconto((new Desconto())->setTipo(0))
//     // ->setJuros((new Juros())->setTipo(0))
//     // ->setMulta((new Multa())->setTipo(0))
//     ->setCodigoAceite('S')
//     ->setCodigoTipoTitulo(2)
//     // ->setDescricaoTipoTitulo('Recibo')
//     // ->setIndicadorAceiteTituloVencido('N')
//     ->setIndicadorPermissaoRecebimentoParcial('N')
//     ->setNumeroTituloCliente('0000019999')
//     // ->setMensagemBloquetoOcorrencia('Pagamento disponível até a data de vencimento')
//     ->setPagador($pagador);
//     // ->setIndicadorPix('S');

// $integracao = new IntegracaoBB();

// $retorno = $integracao->registraBoleto($boleto);
// var_dump($retorno);

var_dump(registra_boleto_bb('d27b077904ffaba0136fe17d40050f56b911a5b7', 'eyJpZCI6Ijk0OWM2ZDgtMDQ5IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjIyNTczLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0', 'eyJpZCI6IjM3YjE5MmEtOGU5Ny00NTRiLThhYjQtNjkzYzU5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyMjU3Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6ImhvbW9sb2dhY2FvIiwiaWF0IjoxNjMyMzIxMjI3Nzc1fQ', 1, 46564612885, 'Rafael Henrique Gomes de Morais', 'Distrito de Potunduva', 'Jaú', 'SP', 12345678, 'Rua Sem Nome, 123',  3128557, 17, 35, 1, new DateTime('2022-09-25'), 100.00, 'S', 2, 'N', '0000019999', 'N', 'Mensagem de Teste'));