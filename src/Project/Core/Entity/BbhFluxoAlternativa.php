<?php

namespace Project\Core\Entity;

/**
 * BbhFluxoAlternativa
 */
class BbhFluxoAlternativa
{
    /**
     * @var integer
     */
    private $bbhFluAltCodigo;

    /**
     * @var string
     */
    private $bbhFluAltTitulo;

    /**
     * @var string
     */
    private $bbhFluObservacao;

    /**
     * @var integer
     */
    private $bbhAtividadePredileta;

    /**
     * @var string
     */
    private $bbhFluAltIcone = '4.gif';

    /**
     * @var integer
     */
    private $bbhModAtiOrdem;

    /**
     * @var \Project\Core\Entity\BbhModeloAtividade
     */
    private $bbhModAtiCodigo;

    /**
     * @var \Project\Core\Entity\BbhModeloFluxo
     */
    private $bbhModFluCodigo;


    /**
     * Get bbhFluAltCodigo
     *
     * @return integer
     */
    public function getBbhFluAltCodigo()
    {
        return $this->bbhFluAltCodigo;
    }

    /**
     * Set bbhFluAltTitulo
     *
     * @param string $bbhFluAltTitulo
     *
     * @return BbhFluxoAlternativa
     */
    public function setBbhFluAltTitulo($bbhFluAltTitulo)
    {
        $this->bbhFluAltTitulo = $bbhFluAltTitulo;

        return $this;
    }

    /**
     * Get bbhFluAltTitulo
     *
     * @return string
     */
    public function getBbhFluAltTitulo()
    {
        return $this->bbhFluAltTitulo;
    }

    /**
     * Set bbhFluObservacao
     *
     * @param string $bbhFluObservacao
     *
     * @return BbhFluxoAlternativa
     */
    public function setBbhFluObservacao($bbhFluObservacao)
    {
        $this->bbhFluObservacao = $bbhFluObservacao;

        return $this;
    }

    /**
     * Get bbhFluObservacao
     *
     * @return string
     */
    public function getBbhFluObservacao()
    {
        return $this->bbhFluObservacao;
    }

    /**
     * Set bbhAtividadePredileta
     *
     * @param integer $bbhAtividadePredileta
     *
     * @return BbhFluxoAlternativa
     */
    public function setBbhAtividadePredileta($bbhAtividadePredileta)
    {
        $this->bbhAtividadePredileta = $bbhAtividadePredileta;

        return $this;
    }

    /**
     * Get bbhAtividadePredileta
     *
     * @return integer
     */
    public function getBbhAtividadePredileta()
    {
        return $this->bbhAtividadePredileta;
    }

    /**
     * Set bbhFluAltIcone
     *
     * @param string $bbhFluAltIcone
     *
     * @return BbhFluxoAlternativa
     */
    public function setBbhFluAltIcone($bbhFluAltIcone)
    {
        $this->bbhFluAltIcone = $bbhFluAltIcone;

        return $this;
    }

    /**
     * Get bbhFluAltIcone
     *
     * @return string
     */
    public function getBbhFluAltIcone()
    {
        return $this->bbhFluAltIcone;
    }

    /**
     * Set bbhModAtiOrdem
     *
     * @param integer $bbhModAtiOrdem
     *
     * @return BbhFluxoAlternativa
     */
    public function setBbhModAtiOrdem($bbhModAtiOrdem)
    {
        $this->bbhModAtiOrdem = $bbhModAtiOrdem;

        return $this;
    }

    /**
     * Get bbhModAtiOrdem
     *
     * @return integer
     */
    public function getBbhModAtiOrdem()
    {
        return $this->bbhModAtiOrdem;
    }

    /**
     * Set bbhModAtiCodigo
     *
     * @param \Project\Core\Entity\BbhModeloAtividade $bbhModAtiCodigo
     *
     * @return BbhFluxoAlternativa
     */
    public function setBbhModAtiCodigo(\Project\Core\Entity\BbhModeloAtividade $bbhModAtiCodigo = null)
    {
        $this->bbhModAtiCodigo = $bbhModAtiCodigo;

        return $this;
    }

    /**
     * Get bbhModAtiCodigo
     *
     * @return \Project\Core\Entity\BbhModeloAtividade
     */
    public function getBbhModAtiCodigo()
    {
        return $this->bbhModAtiCodigo;
    }

    /**
     * Set bbhModFluCodigo
     *
     * @param \Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo
     *
     * @return BbhFluxoAlternativa
     */
    public function setBbhModFluCodigo(\Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo = null)
    {
        $this->bbhModFluCodigo = $bbhModFluCodigo;

        return $this;
    }

    /**
     * Get bbhModFluCodigo
     *
     * @return \Project\Core\Entity\BbhModeloFluxo
     */
    public function getBbhModFluCodigo()
    {
        return $this->bbhModFluCodigo;
    }
}

