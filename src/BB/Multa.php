<?php

namespace BoletosOnline\BB;

class Multa
{

    /**
     * Como a multa será concedida, inteiro >= 0.
     *
     * 0 - DISPENSAR;
     * 1 - VALOR DIA ATRASO;
     * 2 - TAXA MENSAL;
     * 3 - ISENTO.
     * @var int $tipo
     */
    private $tipo;
   
    /**
     * Se tipo > 0, Definir uma data de multa, no formato "dd.mm.aaaa"
     * @var \DateTime $data;
     */
    private $data;

    /**
     * Se tipo = 2, definir porcentagem >= 0.00 (formato decimal separado por ".").
     * @var float $porcentagem;
     */
    private $porcentagem;


    /**
     * Se tipo = 1, definir valor do juros >= 0.00 (formato decimal separado por ".")..
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
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get $data;
     *
     * @return  \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set $data;
     *
     * @param  \DateTime  $data  $data;
     *
     * @return  self
     */
    public function setData(\DateTime $data)
    {
        $this->data = $data;

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
    public function setPorcentagem($porcentagem)
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
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        return array_filter($vars, function($value) {return  !is_null($value); });
    }
}
