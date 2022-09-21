<?php

namespace BoletosOnline\BB;

use BoletosOnline\Ambiente;
use Exception;
use Guzzle\Http\Client;

use Guzzle\Http\Exception\ClientErrorResponseException;


class IntegracaoBB
{
    static private $urls = array(
        'PRODUCAO' => array(
            'token' => 'https://oauth.bb.com.br/oauth/token',
            'registro' => 'https://api.bb.com.br/cobrancas/v2/boletos'
        ),
        'DESENVOLVIMENTO' => array(
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
    static private $pastaCache;
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
     * @var string $devAppKey
     */
    private $devAppKey;

    /**
     * Cliente HTTP para requisições
     * @var \GuzzleHttp\Client $httpClient
     */
    private $httpClient;


    public function __construct($developer_application_key = null, $client_id = null, $client_secret = null)
    {
        self::$pastaCache = dirname(__FILE__) . '/cache';

        $this->httpClient = new Client();

        $this->httpClient->setSslVerification(false);

        // Verifica ambeiente
        $this->ambiente = Ambiente::DESENVOLVIMENTO;

        $this->devAppKey = $developer_application_key;
        $this->clientID = $client_id;
        $this->secret = $client_secret;
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
    public function obterToken()
    {
        try{
            $request = $this->httpClient->post(
                self::$urls[$this->ambiente]['token'],
                array(
                    'Authorization' => $this->getAuthorizationHeader(),
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ),
                'grant_type=client_credentials&scope=cobrancas.boletos-requisicao'
            );


            $response = $request->send();

            $json_response = json_decode($response->getBody(), true);
            if ($json_response) {
                // Sucesso
                if ($json_response['access_token']) return $json_response['token_type'] . ' ' . $json_response['access_token'];
            }
        } catch (ClientErrorResponseException $e) {
            $error = json_decode($e->getResponse()->getBody(), true);
            var_dump($error);
        }
    }

    /**
     * Registra boleto
     * 
     * @param Boleto $boleto
     */
    public function registraBoleto(Boleto $boleto)
    {

        $token = $this->obterToken();
        $payload = json_encode($boleto->toArray());
        try {
            $request = $this->httpClient->post(
                self::$urls[$this->ambiente]['registro'] . '?gw-dev-app-key='.$this->devAppKey,
                array(
                    'Authorization' => $token,
                    'Content-Type' => 'application/json'
                ),
                $payload
            );



            $response = $request->send();

            $json_response = json_decode($response->getBody(), true);
            if ($json_response) {
                return $json_response;
            }
        } catch (ClientErrorResponseException $e) {
            $error = json_decode($e->getResponse()->getBody(), true);
            var_dump($error);
            var_dump($e->getMessage());
            // throw new \Exception('Erro na requisição do registro: ' . $error['message'] . '||' . $e->getMessage());
        }
    }
}
