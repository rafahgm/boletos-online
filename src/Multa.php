<?php

namespace BoletosOnline;

use Exception;
use DateTime;

class Multa
{

    /**
     * Data a partir de qual a multa deverá ser cobrada
     * @var DateTime $data
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
     * Construtor da Multa. Se for passar um percentual definir valor como 0 ex: Multa(DATA, 0, 0.05)
     * @param DateTime|null $data
     * @param float $valor
     * @param float $percentual
     */
    public function __construct($data, $valor, $percentual = 0)
    {
        if (!$data) {
            throw new Exception('uma DATA deve ser definida para a multa');
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

        if ($this->valor === 0 && $this->percentual){
            $returnArray['PERCENTUAL'] = $this->percentual;
        }else {
            $returnArray['VALOR'] = $this->valor;
        }

        return $returnArray;
    }
}