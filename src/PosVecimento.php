<?php

namespace ConsirInformatica\BoletosOnline;

class PosVencimento
{
    const PROTESTAR = 'PROTESTAR';
    const DEVOLVER = 'DEVOLVER';

    /**
     * Acao a ser tomada após vencimento
     * @var string $acao
     */
    public $acao;

    /**
     * Offset de dias para tomar essa açao após vencimento
     * @var int $numeroDias
     */
    public $numeroDias;

    /**
     * @param string $acao
     * @param int $numeroDias
     */
    public function __construct($acao, $numeroDias = 30)
    {
        $this->acao = $acao;
        $this->numeroDias = $numeroDias;
    }

    public function toArray()
    {
        $returnArray = array('ACAO' => $this->acao);

        if ($this->numeroDias) {
            $returnArray['NUMERO_DIAS'] = Util::padZero($this->numeroDias, 2);
        }

        return $returnArray;
    }
}