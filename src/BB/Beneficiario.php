<?php

namespace BoletosOnline\BB;

class Beneficiario
{
    /**
     * Código que identifica o tipo de inscrição do beneficiário final.
     * Domínios:
     * 1 - CPF;
     * 2 - CNPJ
     * @var int $tipoInscricao
     */
    private $tipoInscricao;

    /**
     * Número de registro do beneficiário final. Para o tipo = 1, informar numero do CPF. Para o tipo = 2, informar numero do CNPJ.
     * @var int $numeroInscricao
     */
    private $numeroInscricao;

    /**
     * Nome do beneficiário final
     * @var string $nome
     */
    private $nome;

    

    /**
     * Get $tipoInscricao
     *
     * @return  int
     */ 
    public function getTipoInscricao()
    {
        return $this->tipoInscricao;
    }

    /**
     * Set $tipoInscricao
     *
     * @param  int  $tipoInscricao  $tipoInscricao
     *
     * @return  self
     */ 
    public function setTipoInscricao(int $tipoInscricao)
    {
        $this->tipoInscricao = $tipoInscricao;

        return $this;
    }

    /**
     * Get $numeroInscricao
     *
     * @return  int
     */ 
    public function getNumeroInscricao()
    {
        return $this->numeroInscricao;
    }

    /**
     * Set $numeroInscricao
     *
     * @param  int  $numeroInscricao  $numeroInscricao
     *
     * @return  self
     */ 
    public function setNumeroInscricao(int $numeroInscricao)
    {
        $this->numeroInscricao = $numeroInscricao;

        return $this;
    }

    /**
     * Get $nome
     *
     * @return  string
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set $nome
     *
     * @param  string  $nome  $nome
     *
     * @return  self
     */ 
    public function setNome(string $nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        return array_filter($vars, function($value) {return  !is_null($value); });
    }
}
