<?php

namespace BoletosOnline\BB;

use BoletosOnline\Ambiente;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class IntegracaoBB
{
    static private $urls = array(
        Ambiente::PRODUCAO => array(
            'token' => 'https://oauth.bb.com.br/oauth/token',
            'registro' => 'https://cobranca.bb.com.br:7101/registrarBoleto'
        ),
        Ambiente::DESENVOLVIMENTO => array(
            'token' => 'https://oauth.sandbox.bb.com.br/oauth/token',
            'registro' => 'https://cobranca.homologa.bb.com.br:7101/registrarBoleto'
        )
    );


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

    public function obterToken()
    {
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

            
            if($response->getBody()) {
                // Sucesso
                $json_response = json_decode($response->getBody(), true);

                if($json_response['access_token']) {
                    
                }
            }

        }catch(ClientException $clientException) {
            var_dump($clientException->getMessage());
        }
    }
}
