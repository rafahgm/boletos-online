<?php

namespace BoletosOnline\BB;

class Desconto {

    /**
     * Como o desconto será concedido, inteiro >= 0. 
     * Domínios: 
     * 0 - SEM DESCONTO; 
     * 1 - VLR FIXO ATE A DATA INFORMADA; 
     * 2 - PERCENTUAL ATE A DATA INFORMADA; 
     * 3 - DESCONTO POR DIA DE ANTECIPACAO.
     * @var int $tipo
     */
    private $tipo;

    /**
     * Se tipo > 0, Definir uma data de expiração do desconto, no formato "dd.mm.aaaa".
     * @var \DateTime $dataExpiracao
     */
    private $dataExpiracao;

    /**
     * Se tipo = 2, definir uma porcentagem de desconto >= 0.00 (formato decimal separado por ".").
     * @var float $porcentagem
     */
    private $porcentagem;

    /**
     * Se tipo = 1, definir um valor de desconto >= 0.00 (formato decimal separado por ".").
     * @var float $valor
     */
    private $valor;

    /**
     * Get como o desconto será concedido, inteiro >= 0.
     * @return int
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set como o desconto será concedido, inteiro >= 0.
     * 
     * @param int $tipo 
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get $dataExpiracao
     *
     * @return  \DateTime
     */ 
    public function getDataExpiracao()
    {
        return $this->dataExpiracao;
    }

    /**
     * Set $dataExpiracao
     *
     * @param  \DateTime  $dataExpiracao  $dataExpiracao
     *
     * @return  self
     */ 
    public function setDataExpiracao(\DateTime $dataExpiracao)
    {
        $this->dataExpiracao = $dataExpiracao;

        return $this;
    }

    /**
     * Get $porcentagem
     *
     * @return  float
     */ 
    public function getPorcentagem()
    {
        return $this->porcentagem;
    }

    /**
     * Set $porcentagem
     *
     * @param  float  $porcentagem  $porcentagem
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