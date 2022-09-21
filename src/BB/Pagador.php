<?php

namespace BoletosOnline\BB;

class Pagador {
    /**
     * Código que identifica o tipo de inscrição do Pagador.
     * 
     * Domínios:
     * 1 - CPF;
     * 2 - CNPJ
     * @var int $tipoInscricao
     */
    private $tipoInscricao;

    /**
     * Número de inscrição do pagador. Para o tipo = 1, informar numero do CPF. Para o tipo = 2, informar numero do CNPJ.
     * @var int $numeroInscricao
     */
    private $numeroInscricao;

    /**
     * Nome do pagador.
    * @var string $nome
     */
    private $nome;

    /**
     * Endereço do pagador.
     * @var string $endereco
     */
    private $endereco;

    /**
     * Código postal do pagador.
     * @var int $cep
     */
    private $cep;

    /**
     * Cidade do pagador.
     * @var string $cidade
     */
    private $cidade;

    /**
     * Bairro do pagador.
     * @var string $bairro
     */
    private $bairro;

    /**
     * Sigla do unidade federativa em que o pagador vive.
     * @var string $uf
     */
    private $uf;

    /**
     * Número de telefone do pagador.
     * @var string $telefone
     */
    private $telefone;

    

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
     * Domínios:
     * 1 - CPF;
     * 2 - CNPJ
     * 
     * @param  int  $tipoInscricao  $tipoInscricao
     *
     * @return  self
     */ 
    public function setTipoInscricao($tipoInscricao)
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
    public function setNumeroInscricao($numeroInscricao)
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
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get $endereco
     *
     * @return  string
     */ 
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set $endereco
     *
     * @param  string  $endereco  $endereco
     *
     * @return  self
     */ 
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get $cep
     *
     * @return  int
     */ 
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set $cep
     *
     * @param  int  $cep  $cep
     *
     * @return  self
     */ 
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get $cidade
     *
     * @return  string
     */ 
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set $cidade
     *
     * @param  string  $cidade  $cidade
     *
     * @return  self
     */ 
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get $bairro
     *
     * @return  string
     */ 
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set $bairro
     *
     * @param  string  $bairro  $bairro
     *
     * @return  self
     */ 
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get $uf
     *
     * @return  string
     */ 
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Set $uf
     *
     * @param  string  $uf  $uf
     *
     * @return  self
     */ 
    public function setUf($uf)
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get $telefone
     *
     * @return  string
     */ 
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set $telefone
     *
     * @param  string  $telefone  $telefone
     *
     * @return  self
     */ 
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        return array_filter($vars, function($value) {return  !is_null($value); });
    }
}