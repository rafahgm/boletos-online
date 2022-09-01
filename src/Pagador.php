<?php

namespace ConsirInformatica\BoletosOnline;

class Pagador
{

    #region Declarações
    /**
     * CPF do Pagador (Sem máscara)
     * @var string $cpf
     */
    public $cpf;
    
    /**
     * Nome
     * @var string $nome
     */
    public $nome;

    /**
     * CNPJ do Pagador (Sem máscara)
     * @var string $cnpj
     */
    public $cnpj;

    /**
     * Razão Social do Pagador
     * @var string $razaoSocial
     */
    public $razaoSocial;

    /**
     * Logradouro do Pagador
     * @var string $logradouro
     */
    public $logradouro;

    /**
     * Bairro do Pagador
     * @var string $endereco
     */
    public $bairro;

    /**
     * Cidade do Pagador
     * @var string $cidade
     */
    public $cidade;

    /**
     * UF do Pagador
     * @var string $uf
     */
    public $uf;

    /**
     * CEP do Pagador
     * @var string cep
     */
    public $cep;

    public function toArray() {
        $returnArray = array();

        if($this->cpf) {
            $returnArray['CPF'] = $this->cpf;
            $returnArray['NOME'] = $this->nome;
        }else {
            $returnArray['CNPJ'] = str_replace(['.', '-', '/'], '', $this->cnpj);
            $returnArray['RAZAO_SOCIAL'] = $this->razaoSocial;
        }

        $returnArray['ENDERECO'] = array(
            'LOGRADOURO' => substr($this->logradouro, 0, 40),
            'BAIRRO' => substr($this->bairro, 0, 15),
            'CIDADE' => substr($this->cidade, 0, 150),
            'UF' => $this->uf,
            'CEP' => str_replace(['.', '-'], '', $this->cep)
        );

        return $returnArray;
    }
}