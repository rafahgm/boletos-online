<?php

namespace BoletosOnline\BB;

use BoletosOnline\Ambiente;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class IntegracaoBB
{
    static private $urls = array(
        Ambiente::PRODUCAO => array(
            'token' => 'https://oauth.bb.com.br/oauth/token',
            'registro' => 'https://api.bb.com.br/cobrancas/v2/boletos'
        ),
        Ambiente::DESENVOLVIMENTO => array(
            'token' => 'https://oauth.hm.bb.com.br/oauth/token',
            'registro' => 'https://api.hm.bb.com.br/cobrancas/v2/boletos'
        )
    );


    /**
     * Tempo de expiração do token
     * @var float $tokenTtl
     */
    static private $tokenTtl = 600;

    /**
     * Caminho para o diretorio de cache dos tokens
     * @var string $pastaCache
     */
    static private $pastaCache = __DIR__ . '/cache';

    /**
     * Último token obtido
     * @var string $tokenEmCache
     */
    private $tokenEmCache;

    /**
     * Ambiente da Aplicação PRODUÇÃO OU DESENVOLVIMENTO
     */
    private $ambiente;

    /**
     * ClientID do Banco do Brasil
     * @var string $clienteID
     */
    private $clientID;

    /**
     * Secret do Banco do Brasil
     * @var string $secret
     */
    private $secret;

    /**
     * Cliente HTTP para requisições
     * @var \GuzzleHttp\Client $httpClient
     */
    private $httpClient;


    public function __construct()
    {

        $this->httpClient = new Client([
            'timeout' => 2.0
        ]);

        // Verifica ambeiente
        $this->ambiente = Ambiente::getAmbiente();

        if ($this->ambiente === Ambiente::DESENVOLVIMENTO) {
            $this->clientID = 'eyJpZCI6Ijk0OWM2ZDgtMDQ5IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjIyNTczLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
            $this->secret = 'eyJpZCI6IjM3YjE5MmEtOGU5Ny00NTRiLThhYjQtNjkzYzU5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyMjU3Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6ImhvbW9sb2dhY2FvIiwiaWF0IjoxNjMyMzIxMjI3Nzc1fQ';
        }
    }

    private function getAuthorizationHeader()
    {
        return 'Basic ' . base64_encode($this->clientID . ':' . $this->secret);
    }

    /**
     * Obtem um token do BB
     * @throws \Exception
     * @return string
     */
    public function obterToken($usar_cache = false)
    {

        if ($this->tokenEmCache && $usar_cache) return $this->tokenEmCache['access_token'];

        // Cria pasta para o cache caso não exista
        if(!file_exists(self::$pastaCache))
            mkdir(self::$pastaCache, 0775, true);
        $caminho_arquivo_cache = self::$pastaCache . '/bb_token_cache_' . md5($this->clientID);

        if ($usar_cache) {
            // Se o arquivo existir, retorna o timestamp da última modificação
            $ultima_modificacao = filemtime($caminho_arquivo_cache);

            if ($ultima_modificacao && $ultima_modificacao + self::$tokenTtl > time()) {
                // Tenta abrir o arquivo
                $arquivo = fopen($caminho_arquivo_cache, 'r');

                if ($arquivo) {
                    // Trava o arquivo enquanto é lido
                    flock($arquivo, LOCK_SH);

                    $token = '';

                    do
                        $token .= fread($arquivo, 1024);
                    while (!feof($arquivo));

                    fclose($arquivo);


                    // retorna o token
                    $this->tokenEmCache = array(
                        'token' => $token,
                        'cache' => true
                    );
                    return $token;
                }
            }
        }

        try {
            // Envia requisição para o access token
            $response = $this->httpClient->post(self::$urls[$this->ambiente]['token'], [
                'headers'  => [
                    'Authorization' => $this->getAuthorizationHeader(),
                    'Cache-Control' => 'no-cache'
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'scope' => 'cobrancas.boletos-requisicao'
                ]
            ]);

            $json_response = json_decode($response->getBody(), true);
            if ($json_response) {
                // Sucesso
                if ($json_response['access_token']) {
                    // Armazena o token em cache
                    $arquivo = fopen($caminho_arquivo_cache, 'w+');

                    if ($arquivo) {
                        flock($arquivo, LOCK_SH);

                        // apaga todo o conteúdo do arquivo
                        ftruncate($arquivo, 0);

                        // escreve o token no arquivo
                        fwrite($arquivo, $json_response['access_token']);

                        fclose($arquivo);
                    }
                }

                $this->tokenEmCache = array(
                    'token' => $json_response['access_token'],
                    'cache' => false
                );
                return $json_response['access_token'];
            } else {
                throw new \Exception('Erro ao obter token: ' . $json_response['error_description']);
            }
        } catch (GuzzleException $exception) {
            throw new \Exception('Erro na requisição do token: ' . $exception->getMessage());
        }
    }

    /**
     * Registra boleto
     * 
     * @param Boleto $boleto
     */
    public function registraBoleto(Boleto $boleto) {

        $token = $this->obterToken();
        $payload = json_encode($boleto);

        var_dump(json_decode($payload, true));
        // die();
        try {
            $response = $this->httpClient->post(self::$urls[$this->ambiente]['registro'], [
                'query' => ['gw-dev-app-key' => 'd27b077904ffaba0136fe17d40050f56b911a5b7'],
                'headers'  => [
                    'Authorization' => 'Bearer ' . $token,
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'application/json'
                ],
                'body' => $payload
            ]);

            $json_response = json_decode($response->getBody(), true);
            if($json_response) {
                var_dump($json_response);
            }

        }catch(\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
