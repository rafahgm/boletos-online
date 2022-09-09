<?php

namespace BoletosOnline\BB;

class Boleto implements \JsonSerializable
{
    /**
     * Número do convênio de Cobrança do Cliente. Identificador determinado pelo sistema Cobrança para controlar a emissão de boletos, 
     * liquidação, crédito de valores ao Beneficiário e intercâmbio de dados com o cliente.
     * @var int $numeroConvenio
     */
    private $numeroConvenio;

    /**
     * Características do serviço de boleto bancário e como ele deve ser tratado pelo banco.
     * @var int $numeroCarteira
     */
    private $numeroCarteira;

    /**
     * Número da variação da carteira do convênio de cobrança.
     * @var int $numeroVariacaoCarteira
     */
    private $numeroVariacaoCarteira;

    /**
     * Identifica a característica dos boletos dentro das modalidades de cobrança existentes no banco.
     * Domínio:
     * 01 - SIMPLES;
     * 04 - VINCULADA
     * @var int $codigoModalidade
     */
    private $codigoModalidade;

    /**
     * Data de emissão do boleto.
     * @var \DateTime $dataEmissao
     */
    private $dataEmissao;

    /**
     * Data de vencimento do boleto.
     * @var \DateTime $dataVencimento 
     */
    private $dataVencimento;

    /**
     * Valor de cobrança > 0.00, emitido em Real. Valor do boleto no registro. 
     * Deve ser maior que a soma dos campos “VALOR DO DESCONTO DO TÍTULO” e “VALOR DO ABATIMENTO DO TÍTULO”, se informados. 
     * Informação não passível de alteração após a criação. No caso de emissão com valor equivocado, sugerimos cancelar e emitir novo boleto.
     * @var float $valor
     */
    private $valor;

    /**
     * Valor de dedução do boleto >= 0.00.
     * @var float valorAbatimento
     */
    private $valorAbatimento;

    /**
     * Quantos dias após a data de vencimento do boleto para iniciar o processo de cobrança através de protesto. (valor inteiro >= 0).
     * @var int $quantidadeDiasProtesto
     */
    private $quantidadeDiasProtesto;

    /**
     * Quantos dias após a data de vencimento do boleto para iniciar o processo de negativação através da opção escolhida no campo orgaoNegativador. 
     * (valor inteiro >= 0).
     * @var int $quantidadeDiasNegativacao
     */
    private $quantidadeDiasNegativacao;

    /**
     * Código do Órgão Negativador.
     * Domínio: 10 - SERASA
     * @var int $orgaoNegativador
     */
    private $orgaoNegativador;

    /**
     * Indicador de que o boleto pode ou não ser recebido após o vencimento. Campo não obrigatório

     * Se não informado, será assumido a informação de limite de recebimento que está definida no convênio.

     * Quando informado "S" em conjunto com o campo "numeroDiasLimiteRecebimento", será definido a quantidade de dias (corridos) 
     * que este boleto ficará disponível para pagamento após seu vencimento. 
     * Obs.: Se definido "S" e o campo "numeroDiasLimiteRecebimento" ficar com valor zero também será assumido a informação de limite de recebimento que está definida no convênio.
     *
     * Quando informado "N", fica definindo que o boleto NÃO permite pagamento em atraso, portanto só aceitará pagamento até a data do vencimento ou o próximo dia útil, quando o vencimento ocorrer em dia não útil.
     *
     * Quando informado qualquer valor diferente de "S" ou "N" será assumido a informação de limite de recebimento que está definida no convênio.
     * @var string $indicadorAceiteTituloVencido
     */
    private $indicadorAceiteTituloVencido;

    /**
     * Número de dias limite para recebimento. Informar valor inteiro > 0.
     * @var int numeroDiasLimiteRecebimento
     */
    private $numeroDiasLimiteRecebimento;

    /**
     * Código para identificar se o boleto de cobrança foi aceito (reconhecimento da dívida pelo Pagador).
     * Domínios: A - ACEITE N - NAO ACEITE
     * @var string $codigoAceite
     */
    private $codigoAceite;

    /**
     * Código para identificar o tipo de boleto de cobrança.
     *
     * Domínios: 
     * 1- CHEQUE 
     * 2- DUPLICATA MERCANTIL 
     * 3- DUPLICATA MTIL POR INDICACAO 
     * 4- DUPLICATA DE SERVICO 
     * 5- DUPLICATA DE SRVC P/INDICACAO 
     * 6- DUPLICATA RURAL 
     * 7- LETRA DE CAMBIO 
     * 8- NOTA DE CREDITO COMERCIAL 
     * 9- NOTA DE CREDITO A EXPORTACAO 
     * 10- NOTA DE CREDITO INDULTRIAL 
     * 11- NOTA DE CREDITO RURAL 
     * 12- NOTA PROMISSORIA 
     * 13- NOTA PROMISSORIA RURAL 
     * 14- TRIPLICATA MERCANTIL 
     * 15- TRIPLICATA DE SERVICO 
     * 16- NOTA DE SEGURO 
     * 17- RECIBO 
     * 18- FATURA 
     * 19- NOTA DE DEBITO 
     * 20- APOLICE DE SEGURO 
     * 21- MENSALIDADE ESCOLAR 
     * 22- PARCELA DE CONSORCIO 
     * 23- DIVIDA ATIVA DA UNIAO 
     * 24- DIVIDA ATIVA DE ESTADO 
     * 25- DIVIDA ATIVA DE MUNICIPIO 
     * 31- CARTAO DE CREDITO 
     * 32- BOLETO PROPOSTA 
     * 33- BOLETO APORTE 
     * 99- OUTROS.
     * @var int $codigoTipoTitulo
     */
    private $codigoTipoTitulo;

    /**
     * Descrição do tipo de boleto.
     * @var string $descricaoTipoTitulo
     */
    private $descricaoTipoTitulo;

    /**
     * Código para identificação da autorização de pagamento parcial do boleto.
     * Domínios: S - SIM N - NÃO
     * @var string $indicadorPermissaoRecebimentoParcial
     */
    private $indicadorPermissaoRecebimentoParcial;

    /**
     * Número de identificação do boleto (correspondente ao SEU NÚMERO), no formato STRING (Limitado a 15 caracteres - Letras Maiúsculas).
     * @var string $numeroTituloBeneficiario
     */
    private $numeroTituloBeneficiario;

    /**
     * Informações adicionais sobre o beneficiário.
     * @var string $campoUtilizacaoBeneficiario
     */
    private $campoUtilizacaoBeneficiario;

    /**
     * Número de identificação do boleto (correspondente ao NOSSO NÚMERO), no formato STRING, com 20 dígitos, que deverá ser formatado da seguinte forma: 
     * “000” + (número do convênio com 7 dígitos) + (10 algarismos - se necessário, completar com zeros à esquerda).
     * @var string $numeroTituloCliente
     */
    private $numeroTituloCliente;

    /**
     * Mensagem definida pelo beneficiário para ser impressa no boleto. (Limitado a 30 caracteres)
     * @var string $mensagemBloquetoOcorrencia
     */
    private $mensagemBloquetoOcorrencia;

    /**
     * Define a ausência ou a forma como será concedido o desconto para o Título de Cobrança.
     * @var Desconto $desconto
     */
    private $desconto;

    /**
     * @var Desconto $segundoDesconto
     */
    private $segundoDesconto;

    /**
     * @var Desconto $terceiroDesconto
     */
    private $terceiroDesconto;

    /**
     * @var Juros $jurosMora
     */
    private $juros;

    /**
     * @var Multa $multa;
     */
    private $multa;

    /**
     * @var Pagador $pagador;
     */
    private $pagador;

    /**
     * @var Beneficiario $beneficiarioFinal
     */
    private $beneficiarioFinal;

    /**
     * Código para informar se o boleto terá um QRCode Pix atrelado. Se informado caracter inválido, assumirá 'N'.
     * Domínios: 
     * 'S' - QRCODE DINAMICO;
     * 'N' - SEM PIX;
     * OUTRO - SEM PIX
     * @var string $indicadorPix
     */
    private $indicadorPix;

    /**
     * Get $numeroConvenio
     * Número do convênio de Cobrança do Cliente. Identificador determinado pelo sistema Cobrança para controlar a emissão de boletos, 
     * liquidação, crédito de valores ao Beneficiário e intercâmbio de dados com o cliente.
     * @return  int
     */
    public function getNumeroConvenio()
    {
        return $this->numeroConvenio;
    }

    /**
     * Set $numeroConvenio
     * Número do convênio de Cobrança do Cliente. Identificador determinado pelo sistema Cobrança para controlar a emissão de boletos, 
     * liquidação, crédito de valores ao Beneficiário e intercâmbio de dados com o cliente.
     * @param  int  $numeroConvenio  $numeroConvenio
     *
     * @return  self
     */
    public function setNumeroConvenio(int $numeroConvenio)
    {
        $this->numeroConvenio = $numeroConvenio;

        return $this;
    }

    /**
     * Get $numeroCarteira
     * Características do serviço de boleto bancário e como ele deve ser tratado pelo banco.
     * @return  int
     */
    public function getNumeroCarteira()
    {
        return $this->numeroCarteira;
    }

    /**
     * Set $numeroCarteira
     * Características do serviço de boleto bancário e como ele deve ser tratado pelo banco.
     * @param  int  $numeroCarteira  $numeroCarteira
     *
     * @return  self
     */
    public function setNumeroCarteira(int $numeroCarteira)
    {
        $this->numeroCarteira = $numeroCarteira;

        return $this;
    }

    /**
     * Get $numeroVariacaoCarteira
     * Número da variação da carteira do convênio de cobrança.
     * @return  int
     */
    public function getNumeroVariacaoCarteira()
    {
        return $this->numeroVariacaoCarteira;
    }

    /**
     * Set $numeroVariacaoCarteira
     * Número da variação da carteira do convênio de cobrança.
     * @param  int  $numeroVariacaoCarteira  $numeroVariacaoCarteira
     *
     * @return  self
     */
    public function setNumeroVariacaoCarteira(int $numeroVariacaoCarteira)
    {
        $this->numeroVariacaoCarteira = $numeroVariacaoCarteira;

        return $this;
    }

    /**
     * Get $codigoModalidade
     * Identifica a característica dos boletos dentro das modalidades de cobrança existentes no banco.
     * Domínio:
     * 01 - SIMPLES;
     * 04 - VINCULADA
     * @return  int
     */
    public function getCodigoModalidade()
    {
        return $this->codigoModalidade;
    }

    /**
     * Set $codigoModalidade
     * Identifica a característica dos boletos dentro das modalidades de cobrança existentes no banco.
     * Domínio:
     * 01 - SIMPLES;
     * 04 - VINCULADA
     * @param  int  $codigoModalidade  $codigoModalidade
     *
     * @return  self
     */
    public function setCodigoModalidade(int $codigoModalidade)
    {
        $this->codigoModalidade = $codigoModalidade;

        return $this;
    }

    /**
     * Get $dataEmissao
     * Data de emissão do boleto.
     * @return  \DateTime
     */
    public function getDataEmissao()
    {
        return $this->dataEmissao;
    }

    /**
     * Set $dataEmissao
     * Data de emissão do boleto.
     * @param  \DateTime  $dataEmissao  $dataEmissao
     *
     * @return  self
     */
    public function setDataEmissao(\DateTime $dataEmissao)
    {
        $this->dataEmissao = $dataEmissao;

        return $this;
    }

    /**
     * Get $dataVencimento
     * Data de vencimento do boleto.
     * @return  \DateTime
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Set $dataVencimento
     * Data de vencimento do boleto.
     * @param  \DateTime  $dataVencimento  $dataVencimento
     *
     * @return  self
     */
    public function setDataVencimento(\DateTime $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;

        return $this;
    }

    /**
     * Get $valor
     * Valor de cobrança > 0.00, emitido em Real. Valor do boleto no registro. 
     * Deve ser maior que a soma dos campos “VALOR DO DESCONTO DO TÍTULO” e “VALOR DO ABATIMENTO DO TÍTULO”, se informados. 
     * Informação não passível de alteração após a criação. No caso de emissão com valor equivocado, sugerimos cancelar e emitir novo boleto.
     * @return  float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set $valor
     * Valor de cobrança > 0.00, emitido em Real. Valor do boleto no registro. 
     * Deve ser maior que a soma dos campos “VALOR DO DESCONTO DO TÍTULO” e “VALOR DO ABATIMENTO DO TÍTULO”, se informados. 
     * Informação não passível de alteração após a criação. No caso de emissão com valor equivocado, sugerimos cancelar e emitir novo boleto.
     * @param  float  $valor  $valor
     *
     * @return  self
     */
    public function setValor(float $valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valorAbatimento
     * Valor de dedução do boleto >= 0.00.
     * @return  float
     */
    public function getValorAbatimento()
    {
        return $this->valorAbatimento;
    }

    /**
     * Set valorAbatimento
     * Valor de dedução do boleto >= 0.00.
     * @param  float  $valorAbatimento  valorAbatimento
     *
     * @return  self
     */
    public function setValorAbatimento(float $valorAbatimento)
    {
        $this->valorAbatimento = $valorAbatimento;

        return $this;
    }

    /**
     * Get $quantidadeDiasProtesto
     * Quantos dias após a data de vencimento do boleto para iniciar o processo de cobrança através de protesto. (valor inteiro >= 0).
     * @return  int
     */
    public function getQuantidadeDiasProtesto()
    {
        return $this->quantidadeDiasProtesto;
    }

    /**
     * Set $quantidadeDiasProtesto
     * Quantos dias após a data de vencimento do boleto para iniciar o processo de cobrança através de protesto. (valor inteiro >= 0).
     * @param  int  $quantidadeDiasProtesto  $quantidadeDiasProtesto
     *
     * @return  self
     */
    public function setQuantidadeDiasProtesto(int $quantidadeDiasProtesto)
    {
        $this->quantidadeDiasProtesto = $quantidadeDiasProtesto;

        return $this;
    }

    /**
     * Get $quantidadeDiasNegativacao
     * Quantos dias após a data de vencimento do boleto para iniciar o processo de negativação através da opção escolhida no campo orgaoNegativador. 
     * (valor inteiro >= 0).
     * @return  int
     */
    public function getQuantidadeDiasNegativacao()
    {
        return $this->quantidadeDiasNegativacao;
    }

    /**
     * Set $quantidadeDiasNegativacao
     * Quantos dias após a data de vencimento do boleto para iniciar o processo de negativação através da opção escolhida no campo orgaoNegativador. 
     * (valor inteiro >= 0).
     * @param  int  $quantidadeDiasNegativacao  $quantidadeDiasNegativacao
     *
     * @return  self
     */
    public function setQuantidadeDiasNegativacao(int $quantidadeDiasNegativacao)
    {
        $this->quantidadeDiasNegativacao = $quantidadeDiasNegativacao;

        return $this;
    }

    /**
     * Get $orgaoNegativador
     * Código do Órgão Negativador.
     * Domínio: 10 - SERASA
     * @return  int
     */
    public function getOrgaoNegativador()
    {
        return $this->orgaoNegativador;
    }

    /**
     * Set $orgaoNegativador
     * Código do Órgão Negativador.
     * Domínio: 10 - SERASA
     * @param  int  $orgaoNegativador  $orgaoNegativador
     *
     * @return  self
     */
    public function setOrgaoNegativador(int $orgaoNegativador)
    {
        $this->orgaoNegativador = $orgaoNegativador;

        return $this;
    }

    /**
     * Get $indicadorAceiteTituloVencido
     *
     * @return  string
     */
    public function getIndicadorAceiteTituloVencido()
    {
        return $this->indicadorAceiteTituloVencido;
    }

    /**
     * Set $indicadorAceiteTituloVencido
     *
     * @param  string  $indicadorAceiteTituloVencido  $indicadorAceiteTituloVencido
     *
     * @return  self
     */
    public function setIndicadorAceiteTituloVencido(string $indicadorAceiteTituloVencido)
    {
        $this->indicadorAceiteTituloVencido = $indicadorAceiteTituloVencido;

        return $this;
    }

    /**
     * Get numeroDiasLimiteRecebimento
     *
     * @return  int
     */
    public function getNumeroDiasLimiteRecebimento()
    {
        return $this->numeroDiasLimiteRecebimento;
    }

    /**
     * Set numeroDiasLimiteRecebimento
     *
     * @param  int  $numeroDiasLimiteRecebimento  numeroDiasLimiteRecebimento
     *
     * @return  self
     */
    public function setNumeroDiasLimiteRecebimento(int $numeroDiasLimiteRecebimento)
    {
        $this->numeroDiasLimiteRecebimento = $numeroDiasLimiteRecebimento;

        return $this;
    }

    /**
     * Get $codigoAceite
     *
     * @return  string
     */
    public function getCodigoAceite()
    {
        return $this->codigoAceite;
    }

    /**
     * Set $codigoAceite
     *
     * @param  string  $codigoAceite  $codigoAceite
     *
     * @return  self
     */
    public function setCodigoAceite(string $codigoAceite)
    {
        $this->codigoAceite = $codigoAceite;

        return $this;
    }

    /**
     * Get $codigoTipoTitulo
     *
     * @return  int
     */
    public function getCodigoTipoTitulo()
    {
        return $this->codigoTipoTitulo;
    }

    /**
     * Set $codigoTipoTitulo
     *
     * @param  int  $codigoTipoTitulo  $codigoTipoTitulo
     *
     * @return  self
     */
    public function setCodigoTipoTitulo(int $codigoTipoTitulo)
    {
        $this->codigoTipoTitulo = $codigoTipoTitulo;

        return $this;
    }

    /**
     * Get $descricaoTipoTitulo
     *
     * @return  string
     */
    public function getDescricaoTipoTitulo()
    {
        return $this->descricaoTipoTitulo;
    }

    /**
     * Set $descricaoTipoTitulo
     *
     * @param  string  $descricaoTipoTitulo  $descricaoTipoTitulo
     *
     * @return  self
     */
    public function setDescricaoTipoTitulo(string $descricaoTipoTitulo)
    {
        $this->descricaoTipoTitulo = $descricaoTipoTitulo;

        return $this;
    }

    /**
     * Get $indicadorPermissaoRecebimentoParcial
     *
     * @return  string
     */
    public function getIndicadorPermissaoRecebimentoParcial()
    {
        return $this->indicadorPermissaoRecebimentoParcial;
    }

    /**
     * Set $indicadorPermissaoRecebimentoParcial
     *
     * @param  string  $indicadorPermissaoRecebimentoParcial  $indicadorPermissaoRecebimentoParcial
     *
     * @return  self
     */
    public function setIndicadorPermissaoRecebimentoParcial(string $indicadorPermissaoRecebimentoParcial)
    {
        $this->indicadorPermissaoRecebimentoParcial = $indicadorPermissaoRecebimentoParcial;

        return $this;
    }

    /**
     * Get $numeroTituloBeneficiario
     *
     * @return  string
     */
    public function getNumeroTituloBeneficiario()
    {
        return $this->numeroTituloBeneficiario;
    }

    /**
     * Set $numeroTituloBeneficiario
     *
     * @param  string  $numeroTituloBeneficiario  $numeroTituloBeneficiario
     *
     * @return  self
     */
    public function setNumeroTituloBeneficiario(string $numeroTituloBeneficiario)
    {
        $this->numeroTituloBeneficiario = $numeroTituloBeneficiario;

        return $this;
    }

    /**
     * Get $campoUtilizacaoBeneficiario
     *
     * @return  string
     */
    public function getCampoUtilizacaoBeneficiario()
    {
        return $this->campoUtilizacaoBeneficiario;
    }

    /**
     * Set $campoUtilizacaoBeneficiario
     *
     * @param  string  $campoUtilizacaoBeneficiario  $campoUtilizacaoBeneficiario
     *
     * @return  self
     */
    public function setCampoUtilizacaoBeneficiario(string $campoUtilizacaoBeneficiario)
    {
        $this->campoUtilizacaoBeneficiario = $campoUtilizacaoBeneficiario;

        return $this;
    }

    /**
     * Get $numeroTituloCliente
     *
     * @return  string
     */
    public function getNumeroTituloCliente()
    {
        return $this->numeroTituloCliente;
    }

    /**
     * Set $numeroTituloCliente
     *
     * @param  string  $numeroTituloCliente  $numeroTituloCliente
     *
     * @return  self
     */
    public function setNumeroTituloCliente(string $numeroTituloCliente)
    {
        $this->numeroTituloCliente = '000' . $this->getNumeroConvenio() . $numeroTituloCliente;

        return $this;
    }

    /**
     * Get $mensagemBloquetoOcorrencia
     *
     * @return  string
     */
    public function getMensagemBloquetoOcorrencia()
    {
        return $this->mensagemBloquetoOcorrencia;
    }

    /**
     * Set $mensagemBloquetoOcorrencia
     *
     * @param  string  $mensagemBloquetoOcorrencia  $mensagemBloquetoOcorrencia
     *
     * @return  self
     */
    public function setMensagemBloquetoOcorrencia(string $mensagemBloquetoOcorrencia)
    {
        $this->mensagemBloquetoOcorrencia = $mensagemBloquetoOcorrencia;

        return $this;
    }

    /**
     * Get $desconto
     *
     * @return  Desconto
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * Set $desconto
     *
     * @param  Desconto  $desconto  $desconto
     *
     * @return  self
     */
    public function setDesconto(Desconto $desconto)
    {
        $this->desconto = $desconto;

        return $this;
    }

    /**
     * Get $segundoDesconto
     *
     * @return  Desconto
     */
    public function getSegundoDesconto()
    {
        return $this->segundoDesconto;
    }

    /**
     * Set $segundoDesconto
     *
     * @param  Desconto  $segundoDesconto  $segundoDesconto
     *
     * @return  self
     */
    public function setSegundoDesconto(Desconto $segundoDesconto)
    {
        $this->segundoDesconto = $segundoDesconto;

        return $this;
    }

    /**
     * Get $terceiroDesconto
     *
     * @return  Desconto
     */
    public function getTerceiroDesconto()
    {
        return $this->terceiroDesconto;
    }

    /**
     * Set $terceiroDesconto
     *
     * @param  Desconto  $terceiroDesconto  $terceiroDesconto
     *
     * @return  self
     */
    public function setTerceiroDesconto(Desconto $terceiroDesconto)
    {
        $this->terceiroDesconto = $terceiroDesconto;

        return $this;
    }

    /**
     * Get $jurosMora
     *
     * @return  Juros
     */
    public function getJuros()
    {
        return $this->juros;
    }

    /**
     * Set $jurosMora
     *
     * @param  Juros  $juros  $jurosMora
     *
     * @return  self
     */
    public function setJuros(Juros $juros)
    {
        $this->juros = $juros;

        return $this;
    }

    /**
     * Get $multa;
     *
     * @return  Multa
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * Set $multa;
     *
     * @param  Multa  $multa  $multa;
     *
     * @return  self
     */
    public function setMulta(Multa $multa)
    {
        $this->multa = $multa;

        return $this;
    }

    /**
     * Get $pagador;
     *
     * @return  Pagador
     */
    public function getPagador()
    {
        return $this->pagador;
    }

    /**
     * Set $pagador;
     *
     * @param  Pagador  $pagador  $pagador;
     *
     * @return  self
     */
    public function setPagador(Pagador $pagador)
    {
        $this->pagador = $pagador;

        return $this;
    }

    /**
     * Get $beneficiarioFinal
     *
     * @return  Beneficiario
     */
    public function getBeneficiarioFinal()
    {
        return $this->beneficiarioFinal;
    }

    /**
     * Set $beneficiarioFinal
     *
     * @param  Beneficiario  $beneficiarioFinal  $beneficiarioFinal
     *
     * @return  self
     */
    public function setBeneficiarioFinal(Beneficiario $beneficiarioFinal)
    {
        $this->beneficiarioFinal = $beneficiarioFinal;

        return $this;
    }

    /**
     * Get $indicadorPix
     *
     * @return  string
     */
    public function getIndicadorPix()
    {
        return $this->indicadorPix;
    }

    /**
     * Set $indicadorPix
     *
     * @param  string  $indicadorPix  $indicadorPix
     *
     * @return  self
     */
    public function setIndicadorPix(string $indicadorPix)
    {
        $this->indicadorPix = $indicadorPix;

        return $this;
    }

    public function toArray() {
        
    }

    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);
        
        foreach($vars as $index => $value) {
            // Remove propriedades null
            if($value === null) {
                unset($vars[$index]);
            }

            if($value instanceof \DateTime) {
                $vars[$index] = $value->format('d.m.Y');
            }else if(is_object($value)){
                $vars[$index] = $value->toArray();
            }
        }
        
        return $vars;
    }
}
