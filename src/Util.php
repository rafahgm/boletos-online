<?php

namespace ConsirInformatica\BoletosOnline;

class Util {
    /**
     * @param string|int|float $valor
     * @param int $tamanho
     * @return string
     */
    public static function padZero($valor, $tamanho) {
        return str_pad($valor, $tamanho, '0', STR_PAD_LEFT);
    }
}