<?php

namespace BoletosOnline;


class Ambiente {
    const PRODUCAO = 'PRODUCAO';
    const DESENVOLVIMENTO = 'DESENVOLVIMENTO';

    /**
     * Verifica em qual ambeiente se encontra a aplicação
     * @return string
     */
    static public function getAmbiente() {
        return $_ENV['AMBIENTE'] === self::PRODUCAO ? self::PRODUCAO : self::DESENVOLVIMENTO;
    } 
}