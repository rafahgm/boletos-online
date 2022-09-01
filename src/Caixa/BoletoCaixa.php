<?php

namespace ConsirInformatica\BoletosOnline\Caixa;

use ConsirInformatica\BoletosOnline\Beneficiario;
use ConsirInformatica\BoletosOnline\Juros;
use ConsirInformatica\BoletosOnline\PosVencimento;
use ConsirInformatica\BoletosOnline\Pagador;
use ConsirInformatica\BoletosOnline\Desconto;
use ConsirInformatica\BoletosOnline\Multa;

class BoletoCaixa
{
    #region Declarações

    /**
     * Beneficario do Boleto
     * @var Beneficiario $beneficiario
     */
    public $beneficiario;

    /**
     * Número da agência de relacionamento
     * @var string $unidade
     */
    public $unidade;


    /**
     * Nosso número
     * @var string $nossoNumero
     */
    public $nossoNumero;

    /**
     * Numero do documento
     * @var string $numeroDocumento
     */
    public $numeroDocumento;

    /**
     * Data de vencimento
     * @var \DateTime $dataVencimento
     */
    public $dataVencimento;

    /**
     * Valor nominal do boleto
     * @var float $valor
     */
    public $valor;

    /**
     * Juros mora
     * @var Juros $tipoJuros
     */
    public $juros;


    /**
     * Valor abatimento
     * @var float $abatimento
     */
    public $abatimento;

    /**
     * Ação Pós vencimento
     * @var PosVencimento $posVencimento;
     */
    public $posVencimento;

    /**
     * Pagador do boleto
     * @var Pagador $pagador
     */
    public $pagador;

    /**
     * Multa a ser cobrada
     * @var Multa $multa
     */
    public $multa;

    /**
     * Descontos a serem graciados (até 3)
     * @var Desconto[] $descontos
     */
    public $descontos;

    /**
     * Identificação interna do boleto pela empresa
     * @var string $identificacaoEmpresa
     */
    public $identificacaoEmpresa;

    /**
     * Mensagens na Ficha de Compensação (até 2 linhas, até 40 caracteres por linha)
     * @var string[] $mensagensCompensacao
     */
    public $mensagensCompensacao;

    /**
     * Mensagens no Recibo Pagador (até 4 linhas, até 40 caracteres por linha)
     * @var string[] $mensagensPagador
     */
    public $mensagensPagador;

    /**
     * Identificar valor máximo e minimo para pagamento
     * @var float $valorMinimo
     * @var float $valorMaximo
     */
    public $valorMinimo;
    public $valorMaximo;


    /**
     * Identificar percentual máximo e minimo para pagamento
     * @var float $percentualMinimo
     * @var float $percentualMaximo
     */
    public $percentualMinimo;
    public $percentualMaximo;
    #endregion
}
