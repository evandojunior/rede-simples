<?php

namespace Project\Core\Entity;

/**
 * BbhProtocolos
 */
class BbhProtocolos
{
    const STATUS_PROTOCOLADO = '1';
    const STATUS_RECEBIDO = '2';
    const STATUS_DIGITALIZADO = '3';
    const STATUS_DISTRIBUIDO = '4';
    const STATUS_CONCLUIDO = '5';
    const STATUS_INDEFERIDO = '6';
    const STATUS_AGUARDANDO = '7';

    /**
     * @var integer
     */
    private $bbhProCodigo;

    /**
     * @var string
     */
    private $bbhProTitulo;

    /**
     * @var string
     */
    private $bbhProDescricao;

    /**
     * @var string
     */
    private $bbhProObs;

    /**
     * @var \DateTime
     */
    private $bbhProMomento = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $bbhProIdentificacao;

    /**
     * @var string
     */
    private $bbhProEmail;

    /**
     * @var string
     */
    private $bbhProSenha;

    /**
     * @var string
     */
    private $bbhProStatus;

    /**
     * @var \DateTime
     */
    private $bbhProData;

    /**
     * @var string
     */
    private $bbhProRecebido;

    /**
     * @var \DateTime
     */
    private $bbhProDtRecebido;

    /**
     * @var string
     */
    private $bbhProFlagrante = '0';

    /**
     * @var string
     */
    private $bbhProAutoridade;

    /**
     * @var integer
     */
    private $bbhFluPai;

    /**
     * @var integer
     */
    private $bbhUsuCodigo;

    /**
     * @var \Project\Core\Entity\BbhFluxo
     */
    private $bbhFluCodigo;

    /**
     * @var \Project\Core\Entity\BbhDepartamento
     */
    private $bbhDepCodigo;


    /**
     * Get bbhProCodigo
     *
     * @return integer
     */
    public function getBbhProCodigo()
    {
        return $this->bbhProCodigo;
    }

    /**
     * Set bbhProTitulo
     *
     * @param string $bbhProTitulo
     *
     * @return BbhProtocolos
     */
    public function setBbhProTitulo($bbhProTitulo)
    {
        $this->bbhProTitulo = $bbhProTitulo;

        return $this;
    }

    /**
     * Get bbhProTitulo
     *
     * @return string
     */
    public function getBbhProTitulo()
    {
        return $this->bbhProTitulo;
    }

    /**
     * Set bbhProDescricao
     *
     * @param string $bbhProDescricao
     *
     * @return BbhProtocolos
     */
    public function setBbhProDescricao($bbhProDescricao)
    {
        $this->bbhProDescricao = $bbhProDescricao;

        return $this;
    }

    /**
     * Get bbhProDescricao
     *
     * @return string
     */
    public function getBbhProDescricao()
    {
        return $this->bbhProDescricao;
    }

    /**
     * Set bbhProObs
     *
     * @param string $bbhProObs
     *
     * @return BbhProtocolos
     */
    public function setBbhProObs($bbhProObs)
    {
        $this->bbhProObs = $bbhProObs;

        return $this;
    }

    /**
     * Get bbhProObs
     *
     * @return string
     */
    public function getBbhProObs()
    {
        return $this->bbhProObs;
    }

    /**
     * Set bbhProMomento
     *
     * @param \DateTime $bbhProMomento
     *
     * @return BbhProtocolos
     */
    public function setBbhProMomento($bbhProMomento)
    {
        $this->bbhProMomento = $bbhProMomento;

        return $this;
    }

    /**
     * Get bbhProMomento
     *
     * @return \DateTime
     */
    public function getBbhProMomento()
    {
        return $this->bbhProMomento;
    }

    /**
     * Set bbhProIdentificacao
     *
     * @param string $bbhProIdentificacao
     *
     * @return BbhProtocolos
     */
    public function setBbhProIdentificacao($bbhProIdentificacao)
    {
        $this->bbhProIdentificacao = $bbhProIdentificacao;

        return $this;
    }

    /**
     * Get bbhProIdentificacao
     *
     * @return string
     */
    public function getBbhProIdentificacao()
    {
        return $this->bbhProIdentificacao;
    }

    /**
     * Set bbhProEmail
     *
     * @param string $bbhProEmail
     *
     * @return BbhProtocolos
     */
    public function setBbhProEmail($bbhProEmail)
    {
        $this->bbhProEmail = $bbhProEmail;

        return $this;
    }

    /**
     * Get bbhProEmail
     *
     * @return string
     */
    public function getBbhProEmail()
    {
        return $this->bbhProEmail;
    }

    /**
     * Set bbhProSenha
     *
     * @param string $bbhProSenha
     *
     * @return BbhProtocolos
     */
    public function setBbhProSenha($bbhProSenha)
    {
        $this->bbhProSenha = $bbhProSenha;

        return $this;
    }

    /**
     * Get bbhProSenha
     *
     * @return string
     */
    public function getBbhProSenha()
    {
        return $this->bbhProSenha;
    }

    /**
     * Set bbhProStatus
     *
     * @param string $bbhProStatus
     *
     * @return BbhProtocolos
     */
    public function setBbhProStatus($bbhProStatus)
    {
        $this->bbhProStatus = $bbhProStatus;

        return $this;
    }

    /**
     * Get bbhProStatus
     *
     * @return string
     */
    public function getBbhProStatus()
    {
        return $this->bbhProStatus;
    }

    /**
     * Set bbhProData
     *
     * @param \DateTime $bbhProData
     *
     * @return BbhProtocolos
     */
    public function setBbhProData($bbhProData)
    {
        $this->bbhProData = $bbhProData;

        return $this;
    }

    /**
     * Get bbhProData
     *
     * @return \DateTime
     */
    public function getBbhProData()
    {
        return $this->bbhProData;
    }

    /**
     * Set bbhProRecebido
     *
     * @param string $bbhProRecebido
     *
     * @return BbhProtocolos
     */
    public function setBbhProRecebido($bbhProRecebido)
    {
        $this->bbhProRecebido = $bbhProRecebido;

        return $this;
    }

    /**
     * Get bbhProRecebido
     *
     * @return string
     */
    public function getBbhProRecebido()
    {
        return $this->bbhProRecebido;
    }

    /**
     * Set bbhProDtRecebido
     *
     * @param \DateTime $bbhProDtRecebido
     *
     * @return BbhProtocolos
     */
    public function setBbhProDtRecebido($bbhProDtRecebido)
    {
        $this->bbhProDtRecebido = $bbhProDtRecebido;

        return $this;
    }

    /**
     * Get bbhProDtRecebido
     *
     * @return \DateTime
     */
    public function getBbhProDtRecebido()
    {
        return $this->bbhProDtRecebido;
    }

    /**
     * Set bbhProFlagrante
     *
     * @param string $bbhProFlagrante
     *
     * @return BbhProtocolos
     */
    public function setBbhProFlagrante($bbhProFlagrante)
    {
        $this->bbhProFlagrante = $bbhProFlagrante;

        return $this;
    }

    /**
     * Get bbhProFlagrante
     *
     * @return string
     */
    public function getBbhProFlagrante()
    {
        return $this->bbhProFlagrante;
    }

    /**
     * Set bbhProAutoridade
     *
     * @param string $bbhProAutoridade
     *
     * @return BbhProtocolos
     */
    public function setBbhProAutoridade($bbhProAutoridade)
    {
        $this->bbhProAutoridade = $bbhProAutoridade;

        return $this;
    }

    /**
     * Get bbhProAutoridade
     *
     * @return string
     */
    public function getBbhProAutoridade()
    {
        return $this->bbhProAutoridade;
    }

    /**
     * Set bbhFluPai
     *
     * @param integer $bbhFluPai
     *
     * @return BbhProtocolos
     */
    public function setBbhFluPai($bbhFluPai)
    {
        $this->bbhFluPai = $bbhFluPai;

        return $this;
    }

    /**
     * Get bbhFluPai
     *
     * @return integer
     */
    public function getBbhFluPai()
    {
        return $this->bbhFluPai;
    }

    /**
     * Set bbhUsuCodigo
     *
     * @param integer $bbhUsuCodigo
     *
     * @return BbhProtocolos
     */
    public function setBbhUsuCodigo($bbhUsuCodigo)
    {
        $this->bbhUsuCodigo = $bbhUsuCodigo;

        return $this;
    }

    /**
     * Get bbhUsuCodigo
     *
     * @return integer
     */
    public function getBbhUsuCodigo()
    {
        return $this->bbhUsuCodigo;
    }

    /**
     * Set bbhFluCodigo
     *
     * @param \Project\Core\Entity\BbhFluxo $bbhFluCodigo
     *
     * @return BbhProtocolos
     */
    public function setBbhFluCodigo(\Project\Core\Entity\BbhFluxo $bbhFluCodigo = null)
    {
        $this->bbhFluCodigo = $bbhFluCodigo;

        return $this;
    }

    /**
     * Get bbhFluCodigo
     *
     * @return \Project\Core\Entity\BbhFluxo
     */
    public function getBbhFluCodigo()
    {
        return $this->bbhFluCodigo;
    }

    /**
     * Set bbhDepCodigo
     *
     * @param \Project\Core\Entity\BbhDepartamento $bbhDepCodigo
     *
     * @return BbhProtocolos
     */
    public function setBbhDepCodigo(\Project\Core\Entity\BbhDepartamento $bbhDepCodigo = null)
    {
        $this->bbhDepCodigo = $bbhDepCodigo;

        return $this;
    }

    /**
     * Get bbhDepCodigo
     *
     * @return \Project\Core\Entity\BbhDepartamento
     */
    public function getBbhDepCodigo()
    {
        return $this->bbhDepCodigo;
    }

    /**
     * @return array
     */
    public static function getStatusAvailable()
    {
        return [
            self::STATUS_PROTOCOLADO => 'Protocolado',
            self::STATUS_RECEBIDO => 'Recebido',
            self::STATUS_DIGITALIZADO => 'Digitalizado',
            self::STATUS_DISTRIBUIDO => 'Distribuído',
            self::STATUS_CONCLUIDO => 'Concluído',
            self::STATUS_INDEFERIDO => 'Indeferido',
            self::STATUS_AGUARDANDO => 'Aguardando',
        ];
    }
}

