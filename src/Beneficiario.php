<?php

namespace ConsirInformatica\BoletosOnline;

class Beneficiario
{
    /**
     * CNPJ do beneficario
     * @var string $cnpj
     */
    public $cnpj;

    /**
     * Código do Beneficário
     * @var string $codigo
     */
    public $codigo;

    /**
     * @param string $cnpj
     * @param string $codigo
     */
    public function __construct($cnpj, $codigo)
    {
        $this->cnpj = $cnpj;

        $this->codigo = Util::padZero($codigo, 7);
    }
}
