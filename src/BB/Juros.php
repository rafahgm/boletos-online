<?php

namespace BoletosOnline\BB;

class Juros
{

    /**
     * Código utilizado pela FEBRABAN para identificar o tipo de taxa de juros.
     * Domínios:
     * 0 - DISPENSAR; 
     * 1 - VALOR DIA ATRASO; 
     * 2 - TAXA MENSAL; 
     * 3 - ISENTO.
     * @var int $tipo
     */
    private $tipo;

    /**
     * Se tipo = 2, definir uma porcentagem de juros >= 0.00 (formato decimal separado por ".").
     * @var float $porcentagem;
     */
    private $porcentagem;

    /**
     * Se tipo = 1, definir um valor de juros >= 0.00 (formato decimal separado por ".").
     * @var float $valor
     */
    private $valor;


    /**
     * Get $tipo
     *
     * @return  int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set $tipo
     * Domínios:
     * 0 - DISPENSAR; 
     * 1 - VALOR DIA ATRASO; 
     * 2 - TAXA MENSAL; 
     * 3 - ISENTO.
     * @param  int  $tipo  $tipo
     *
     * @return  self
     */
    public function setTipo(int $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get $porcentagem;
     *
     * @return  float
     */
    public function getPorcentagem()
    {
        return $this->porcentagem;
    }

    /**
     * Set $porcentagem;
     *
     * @param  float  $porcentagem  $porcentagem;
     *
     * @return  self
     */
    public function setPorcentagem(float $porcentagem)
    {
        $this->porcentagem = $porcentagem;

        return $this;
    }

    /**
     * Get $valor
     *
     * @return  float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set $valor
     *
     * @param  float  $valor  $valor
     *
     * @return  self
     */
    public function setValor(float $valor)
    {
        $this->valor = $valor;

        return $this;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        return array_filter($vars, function($value) {return  !is_null($value); });
    }
}
