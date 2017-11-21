<?php

namespace Project\Core\Entity;

/**
 * BbhIndicio
 */
class BbhIndicio
{
    /**
     * @var integer
     */
    private $bbhIndCodigo;

    /**
     * @var integer
     */
    private $bbhTipCodigo;

    /**
     * @var integer
     */
    private $bbhUsuCodigo;

    /**
     * @var \DateTime
     */
    private $bbhIndCadastro;

    /**
     * @var string
     */
    private $bbhIndUnidade;

    /**
     * @var string
     */
    private $bbhIndTitulo;

    /**
     * @var string
     */
    private $bbhIndReferencia;

    /**
     * @var integer
     */
    private $bbhIndQuantidade;

    /**
     * @var float
     */
    private $bbhIndValorUnitario;

    /**
     * @var float
     */
    private $bbhIndValorTotal;

    /**
     * @var string
     */
    private $bbhIndConfiabilidadeFonte;

    /**
     * @var integer
     */
    private $bbhIndVeracidadeInformacao;

    /**
     * @var string
     */
    private $bbhIndFonteInformacao;

    /**
     * @var integer
     */
    private $bbhIndSigilo = '-1';

    /**
     * @var \Project\Core\Entity\BbhProtocolos
     */
    private $bbhProCodigo;


    /**
     * Get bbhIndCodigo
     *
     * @return integer
     */
    public function getBbhIndCodigo()
    {
        return $this->bbhIndCodigo;
    }

    /**
     * Set bbhTipCodigo
     *
     * @param integer $bbhTipCodigo
     *
     * @return BbhIndicio
     */
    public function setBbhTipCodigo($bbhTipCodigo)
    {
        $this->bbhTipCodigo = $bbhTipCodigo;

        return $this;
    }

    /**
     * Get bbhTipCodigo
     *
     * @return integer
     */
    public function getBbhTipCodigo()
    {
        return $this->bbhTipCodigo;
    }

    /**
     * Set bbhUsuCodigo
     *
     * @param integer $bbhUsuCodigo
     *
     * @return BbhIndicio
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
     * Set bbhIndCadastro
     *
     * @param \DateTime $bbhIndCadastro
     *
     * @return BbhIndicio
     */
    public function setBbhIndCadastro($bbhIndCadastro)
    {
        $this->bbhIndCadastro = $bbhIndCadastro;

        return $this;
    }

    /**
     * Get bbhIndCadastro
     *
     * @return \DateTime
     */
    public function getBbhIndCadastro()
    {
        return $this->bbhIndCadastro;
    }

    /**
     * Set bbhIndUnidade
     *
     * @param string $bbhIndUnidade
     *
     * @return BbhIndicio
     */
    public function setBbhIndUnidade($bbhIndUnidade)
    {
        $this->bbhIndUnidade = $bbhIndUnidade;

        return $this;
    }

    /**
     * Get bbhIndUnidade
     *
     * @return string
     */
    public function getBbhIndUnidade()
    {
        return $this->bbhIndUnidade;
    }

    /**
     * Set bbhIndTitulo
     *
     * @param string $bbhIndTitulo
     *
     * @return BbhIndicio
     */
    public function setBbhIndTitulo($bbhIndTitulo)
    {
        $this->bbhIndTitulo = $bbhIndTitulo;

        return $this;
    }

    /**
     * Get bbhIndTitulo
     *
     * @return string
     */
    public function getBbhIndTitulo()
    {
        return $this->bbhIndTitulo;
    }

    /**
     * Set bbhIndReferencia
     *
     * @param string $bbhIndReferencia
     *
     * @return BbhIndicio
     */
    public function setBbhIndReferencia($bbhIndReferencia)
    {
        $this->bbhIndReferencia = $bbhIndReferencia;

        return $this;
    }

    /**
     * Get bbhIndReferencia
     *
     * @return string
     */
    public function getBbhIndReferencia()
    {
        return $this->bbhIndReferencia;
    }

    /**
     * Set bbhIndQuantidade
     *
     * @param integer $bbhIndQuantidade
     *
     * @return BbhIndicio
     */
    public function setBbhIndQuantidade($bbhIndQuantidade)
    {
        $this->bbhIndQuantidade = $bbhIndQuantidade;

        return $this;
    }

    /**
     * Get bbhIndQuantidade
     *
     * @return integer
     */
    public function getBbhIndQuantidade()
    {
        return $this->bbhIndQuantidade;
    }

    /**
     * Set bbhIndValorUnitario
     *
     * @param float $bbhIndValorUnitario
     *
     * @return BbhIndicio
     */
    public function setBbhIndValorUnitario($bbhIndValorUnitario)
    {
        $this->bbhIndValorUnitario = $bbhIndValorUnitario;

        return $this;
    }

    /**
     * Get bbhIndValorUnitario
     *
     * @return float
     */
    public function getBbhIndValorUnitario()
    {
        return $this->bbhIndValorUnitario;
    }

    /**
     * Set bbhIndValorTotal
     *
     * @param float $bbhIndValorTotal
     *
     * @return BbhIndicio
     */
    public function setBbhIndValorTotal($bbhIndValorTotal)
    {
        $this->bbhIndValorTotal = $bbhIndValorTotal;

        return $this;
    }

    /**
     * Get bbhIndValorTotal
     *
     * @return float
     */
    public function getBbhIndValorTotal()
    {
        return $this->bbhIndValorTotal;
    }

    /**
     * Set bbhIndConfiabilidadeFonte
     *
     * @param string $bbhIndConfiabilidadeFonte
     *
     * @return BbhIndicio
     */
    public function setBbhIndConfiabilidadeFonte($bbhIndConfiabilidadeFonte)
    {
        $this->bbhIndConfiabilidadeFonte = $bbhIndConfiabilidadeFonte;

        return $this;
    }

    /**
     * Get bbhIndConfiabilidadeFonte
     *
     * @return string
     */
    public function getBbhIndConfiabilidadeFonte()
    {
        return $this->bbhIndConfiabilidadeFonte;
    }

    /**
     * Set bbhIndVeracidadeInformacao
     *
     * @param integer $bbhIndVeracidadeInformacao
     *
     * @return BbhIndicio
     */
    public function setBbhIndVeracidadeInformacao($bbhIndVeracidadeInformacao)
    {
        $this->bbhIndVeracidadeInformacao = $bbhIndVeracidadeInformacao;

        return $this;
    }

    /**
     * Get bbhIndVeracidadeInformacao
     *
     * @return integer
     */
    public function getBbhIndVeracidadeInformacao()
    {
        return $this->bbhIndVeracidadeInformacao;
    }

    /**
     * Set bbhIndFonteInformacao
     *
     * @param string $bbhIndFonteInformacao
     *
     * @return BbhIndicio
     */
    public function setBbhIndFonteInformacao($bbhIndFonteInformacao)
    {
        $this->bbhIndFonteInformacao = $bbhIndFonteInformacao;

        return $this;
    }

    /**
     * Get bbhIndFonteInformacao
     *
     * @return string
     */
    public function getBbhIndFonteInformacao()
    {
        return $this->bbhIndFonteInformacao;
    }

    /**
     * Set bbhIndSigilo
     *
     * @param integer $bbhIndSigilo
     *
     * @return BbhIndicio
     */
    public function setBbhIndSigilo($bbhIndSigilo)
    {
        $this->bbhIndSigilo = $bbhIndSigilo;

        return $this;
    }

    /**
     * Get bbhIndSigilo
     *
     * @return integer
     */
    public function getBbhIndSigilo()
    {
        return $this->bbhIndSigilo;
    }

    /**
     * Set bbhProCodigo
     *
     * @param \Project\Core\Entity\BbhProtocolos $bbhProCodigo
     *
     * @return BbhIndicio
     */
    public function setBbhProCodigo(\Project\Core\Entity\BbhProtocolos $bbhProCodigo = null)
    {
        $this->bbhProCodigo = $bbhProCodigo;

        return $this;
    }

    /**
     * Get bbhProCodigo
     *
     * @return \Project\Core\Entity\BbhProtocolos
     */
    public function getBbhProCodigo()
    {
        return $this->bbhProCodigo;
    }
}

