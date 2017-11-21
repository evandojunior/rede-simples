<?php

namespace Project\Core\Entity;

/**
 * BbhModeloFluxo
 */
class BbhModeloFluxo
{
    /**
     * @var integer
     */
    private $bbhModFluCodigo;

    /**
     * @var string
     */
    private $bbhModFluNome;

    /**
     * @var string
     */
    private $bbhModFluObservacao;

    /**
     * @var string
     */
    private $bbhModFluSub = '0';

    /**
     * @var \Project\Core\Entity\BbhTipoFluxo
     */
    private $bbhTipFluCodigo;


    /**
     * Set bbhModFluCodigo
     *
     * @return integer
     */
    public function setBbhModFluCodigo($bbhModFluCodigo)
    {
        $this->bbhModFluCodigo = $bbhModFluCodigo;
    }


    /**
     * Get bbhModFluCodigo
     *
     * @return integer
     */
    public function getBbhModFluCodigo()
    {
        return $this->bbhModFluCodigo;
    }

    /**
     * Set bbhModFluNome
     *
     * @param string $bbhModFluNome
     *
     * @return BbhModeloFluxo
     */
    public function setBbhModFluNome($bbhModFluNome)
    {
        $this->bbhModFluNome = $bbhModFluNome;

        return $this;
    }

    /**
     * Get bbhModFluNome
     *
     * @return string
     */
    public function getBbhModFluNome()
    {
        return $this->bbhModFluNome;
    }

    /**
     * Set bbhModFluObservacao
     *
     * @param string $bbhModFluObservacao
     *
     * @return BbhModeloFluxo
     */
    public function setBbhModFluObservacao($bbhModFluObservacao)
    {
        $this->bbhModFluObservacao = $bbhModFluObservacao;

        return $this;
    }

    /**
     * Get bbhModFluObservacao
     *
     * @return string
     */
    public function getBbhModFluObservacao()
    {
        return $this->bbhModFluObservacao;
    }

    /**
     * Set bbhModFluSub
     *
     * @param string $bbhModFluSub
     *
     * @return BbhModeloFluxo
     */
    public function setBbhModFluSub($bbhModFluSub)
    {
        $this->bbhModFluSub = $bbhModFluSub;

        return $this;
    }

    /**
     * Get bbhModFluSub
     *
     * @return string
     */
    public function getBbhModFluSub()
    {
        return $this->bbhModFluSub;
    }

    /**
     * Set bbhTipFluCodigo
     *
     * @param \Project\Core\Entity\BbhTipoFluxo $bbhTipFluCodigo
     *
     * @return BbhModeloFluxo
     */
    public function setBbhTipFluCodigo(\Project\Core\Entity\BbhTipoFluxo $bbhTipFluCodigo = null)
    {
        $this->bbhTipFluCodigo = $bbhTipFluCodigo;

        return $this;
    }

    /**
     * Get bbhTipFluCodigo
     *
     * @return \Project\Core\Entity\BbhTipoFluxo
     */
    public function getBbhTipFluCodigo()
    {
        return $this->bbhTipFluCodigo;
    }
}

