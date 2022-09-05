<?php

require_once('./vendor/autoload.php');

use Dotenv\Dotenv;

// Inicialização do dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Exemplo de uso
 */


use BoletosOnline\BB\IntegracaoBB;

$integracao = new IntegracaoBB();
$integracao->obterToken();
