<?php

namespace BoletosOnline;

use DateTime;

class Juros
{
    const VALOR_POR_DIA = 'VALOR_POR_DIA';
    const TAXA_MENSAL = 'TAXA_MENSAL';
    const ISENTO = 'ISENTO';

    /**
     * Define o tipo de pagamento de juros de mora
     * @var string $tipo 
     */
    public $tipo;

    /**
     * Data indicativa do início da cobrança de Juros de Mora
     * @var DateTime|null $data
     */
    public $data;

    /**
     * Valor da multa
     * @var float $valor
     */
    public $valor;

    /**
     * Percentual (valor) da multa
     * @var float $percentual
     */
    public $percentual;

    /**
     * @param string $tipo
     * @param DateTime|null $data
     * @param float $valor
     * @param float $percentual
     */
    public function __construct($tipo, $data, $valor, $percentual = 0)
    {
        $this->tipo = $tipo;
        $this->data = $data;
        $this->valor = $valor;
        $this->percentual = $percentual;
    }


    public function toArray()
    {
        $returnArray = array(
            'TIPO' => $this->tipo,
        );

        if ($this->data) {
            $returnArray['DATA'] = $this->data->format('Y-m-d');
        }

        if ($this->valor) {
            $returnArray['VALOR'] = sprintf('%0.2f', $this->valor);
        } else if ($this->percentual) {
            $returnArray['PERCENTUAL'] = sprintf('%0.2f', $this->percentual);
        } else {
            $returnArray['VALOR'] = '0.00';
        }

        return $returnArray;
    }
}