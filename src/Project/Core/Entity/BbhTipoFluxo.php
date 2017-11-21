<?php

namespace Project\Core\Entity;

/**
 * BbhTipoFluxo
 */
class BbhTipoFluxo
{
    /**
     * @var integer
     */
    private $bbhTipFluCodigo;

    /**
     * @var string
     */
    private $bbhTipFluIdentificacao;

    /**
     * @var string
     */
    private $bbhTipFluNome;

    /**
     * @var integer
     */
    private $bbhTipFluCodigoPai;

    /**
     * @var string
     */
    private $bbhTipFluObservacao;


    /**
     * Get bbhTipFluCodigo
     *
     * @return integer
     */
    public function getBbhTipFluCodigo()
    {
        return $this->bbhTipFluCodigo;
    }

    /**
     * Set bbhTipFluIdentificacao
     *
     * @param string $bbhTipFluIdentificacao
     *
     * @return BbhTipoFluxo
     */
    public function setBbhTipFluIdentificacao($bbhTipFluIdentificacao)
    {
        $this->bbhTipFluIdentificacao = $bbhTipFluIdentificacao;

        return $this;
    }

    /**
     * Get bbhTipFluIdentificacao
     *
     * @return string
     */
    public function getBbhTipFluIdentificacao()
    {
        return $this->bbhTipFluIdentificacao;
    }

    /**
     * Set bbhTipFluNome
     *
     * @param string $bbhTipFluNome
     *
     * @return BbhTipoFluxo
     */
    public function setBbhTipFluNome($bbhTipFluNome)
    {
        $this->bbhTipFluNome = $bbhTipFluNome;

        return $this;
    }

    /**
     * Get bbhTipFluNome
     *
     * @return string
     */
    public function getBbhTipFluNome()
    {
        return $this->bbhTipFluNome;
    }

    /**
     * Set bbhTipFluCodigoPai
     *
     * @param integer $bbhTipFluCodigoPai
     *
     * @return BbhTipoFluxo
     */
    public function setBbhTipFluCodigoPai($bbhTipFluCodigoPai)
    {
        $this->bbhTipFluCodigoPai = $bbhTipFluCodigoPai;

        return $this;
    }

    /**
     * Get bbhTipFluCodigoPai
     *
     * @return integer
     */
    public function getBbhTipFluCodigoPai()
    {
        return $this->bbhTipFluCodigoPai;
    }

    /**
     * Set bbhTipFluObservacao
     *
     * @param string $bbhTipFluObservacao
     *
     * @return BbhTipoFluxo
     */
    public function setBbhTipFluObservacao($bbhTipFluObservacao)
    {
        $this->bbhTipFluObservacao = $bbhTipFluObservacao;

        return $this;
    }

    /**
     * Get bbhTipFluObservacao
     *
     * @return string
     */
    public function getBbhTipFluObservacao()
    {
        return $this->bbhTipFluObservacao;
    }
}

