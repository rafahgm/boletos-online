<?php

namespace ConsirInformatica\BoletosOnline;

use DateTime;
use Exception;

class Desconto
{

    /**
     * Data limite do desconto do título 
     * @var DateTime $data
     */
    public $data;

    /**
     * Valor do desconto
     * @var float $valor
     */
    public $valor;

    /**
     * Percentual (valor) do desconto
     * @var float $percentual
     */
    public $percentual;

    /**
     * Construtor da Multa. Se for passar um percentual definir valor como 0 ex: Multa(DATA, 0, 0.05)
     * @param DateTime $data
     * @param float $valor
     * @param float $percentual
     */
    public function __construct($data, $valor, $percentual = 0)
    {
        if (!$data) {
            throw new Exception('uma DATA deve ser definida para o desconto');
        }

        if ($valor && $percentual && $valor !== 0) {
            throw new Exception('se PERCENTUAL for utilizado VALOR deve ser 0');
        }

        if (!$valor && !$percentual) {
            throw new Exception('pelo menos um VALOR ou um PERCENTUAL deve ser fornecido');
        }

        $this->data = $data;
        $this->valor = $valor;
        $this->percentual;
    }

    public function toArray() {
        $returnArray['DATA'] = $this->data->format('Y-m-d');

        

        return $returnArray;
    }
}