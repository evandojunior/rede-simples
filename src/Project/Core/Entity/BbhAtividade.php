<?php

namespace Project\Core\Entity;

/**
 * BbhAtividade
 */
class BbhAtividade
{
    /**
     * @var integer
     */
    private $bbhAtiCodigo;

    /**
     * @var string
     */
    private $bbhAtiObservacao;

    /**
     * @var \DateTime
     */
    private $bbhAtiInicioPrevisto;

    /**
     * @var \DateTime
     */
    private $bbhAtiFinalPrevisto;

    /**
     * @var \DateTime
     */
    private $bbhAtiInicioReal;

    /**
     * @var \DateTime
     */
    private $bbhAtiFinalReal;

    /**
     * @var string
     */
    private $bbhAtiAndamento;

    /**
     * @var \Project\Core\Entity\BbhFluxo
     */
    private $bbhAlternativaFluxo;

    /**
     * @var \Project\Core\Entity\BbhFluxo
     */
    private $bbhFluCodigo;

    /**
     * @var \Project\Core\Entity\BbhModeloAtividade
     */
    private $bbhModAtiCodigo;

    /**
     * @var \Project\Core\Entity\BbhStatusAtividade
     */
    private $bbhStaAtiCodigo;

    /**
     * @var \Project\Core\Entity\BbhFluxoAlternativa
     */
    private $bbhFluAltCodigo;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigo;


    /**
     * Get bbhAtiCodigo
     *
     * @return integer
     */
    public function getBbhAtiCodigo()
    {
        return $this->bbhAtiCodigo;
    }

    /**
     * Set bbhAtiObservacao
     *
     * @param string $bbhAtiObservacao
     *
     * @return BbhAtividade
     */
    public function setBbhAtiObservacao($bbhAtiObservacao)
    {
        $this->bbhAtiObservacao = $bbhAtiObservacao;

        return $this;
    }

    /**
     * Get bbhAtiObservacao
     *
     * @return string
     */
    public function getBbhAtiObservacao()
    {
        return $this->bbhAtiObservacao;
    }

    /**
     * Set bbhAtiInicioPrevisto
     *
     * @param \DateTime $bbhAtiInicioPrevisto
     *
     * @return BbhAtividade
     */
    public function setBbhAtiInicioPrevisto($bbhAtiInicioPrevisto)
    {
        $this->bbhAtiInicioPrevisto = $bbhAtiInicioPrevisto;

        return $this;
    }

    /**
     * Get bbhAtiInicioPrevisto
     *
     * @return \DateTime
     */
    public function getBbhAtiInicioPrevisto()
    {
        return $this->bbhAtiInicioPrevisto;
    }

    /**
     * Set bbhAtiFinalPrevisto
     *
     * @param \DateTime $bbhAtiFinalPrevisto
     *
     * @return BbhAtividade
     */
    public function setBbhAtiFinalPrevisto($bbhAtiFinalPrevisto)
    {
        $this->bbhAtiFinalPrevisto = $bbhAtiFinalPrevisto;

        return $this;
    }

    /**
     * Get bbhAtiFinalPrevisto
     *
     * @return \DateTime
     */
    public function getBbhAtiFinalPrevisto()
    {
        return $this->bbhAtiFinalPrevisto;
    }

    /**
     * Set bbhAtiInicioReal
     *
     * @param \DateTime $bbhAtiInicioReal
     *
     * @return BbhAtividade
     */
    public function setBbhAtiInicioReal($bbhAtiInicioReal)
    {
        $this->bbhAtiInicioReal = $bbhAtiInicioReal;

        return $this;
    }

    /**
     * Get bbhAtiInicioReal
     *
     * @return \DateTime
     */
    public function getBbhAtiInicioReal()
    {
        return $this->bbhAtiInicioReal;
    }

    /**
     * Set bbhAtiFinalReal
     *
     * @param \DateTime $bbhAtiFinalReal
     *
     * @return BbhAtividade
     */
    public function setBbhAtiFinalReal($bbhAtiFinalReal)
    {
        $this->bbhAtiFinalReal = $bbhAtiFinalReal;

        return $this;
    }

    /**
     * Get bbhAtiFinalReal
     *
     * @return \DateTime
     */
    public function getBbhAtiFinalReal()
    {
        return $this->bbhAtiFinalReal;
    }

    /**
     * Set bbhAtiAndamento
     *
     * @param string $bbhAtiAndamento
     *
     * @return BbhAtividade
     */
    public function setBbhAtiAndamento($bbhAtiAndamento)
    {
        $this->bbhAtiAndamento = $bbhAtiAndamento;

        return $this;
    }

    /**
     * Get bbhAtiAndamento
     *
     * @return string
     */
    public function getBbhAtiAndamento()
    {
        return $this->bbhAtiAndamento;
    }

    /**
     * Set bbhAlternativaFluxo
     *
     * @param \Project\Core\Entity\BbhFluxo $bbhAlternativaFluxo
     *
     * @return BbhAtividade
     */
    public function setBbhAlternativaFluxo(\Project\Core\Entity\BbhFluxo $bbhAlternativaFluxo = null)
    {
        $this->bbhAlternativaFluxo = $bbhAlternativaFluxo;

        return $this;
    }

    /**
     * Get bbhAlternativaFluxo
     *
     * @return \Project\Core\Entity\BbhFluxo
     */
    public function getBbhAlternativaFluxo()
    {
        return $this->bbhAlternativaFluxo;
    }

    /**
     * Set bbhFluCodigo
     *
     * @param \Project\Core\Entity\BbhFluxo $bbhFluCodigo
     *
     * @return BbhAtividade
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
     * Set bbhModAtiCodigo
     *
     * @param \Project\Core\Entity\BbhModeloAtividade $bbhModAtiCodigo
     *
     * @return BbhAtividade
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
     * Set bbhStaAtiCodigo
     *
     * @param \Project\Core\Entity\BbhStatusAtividade $bbhStaAtiCodigo
     *
     * @return BbhAtividade
     */
    public function setBbhStaAtiCodigo(\Project\Core\Entity\BbhStatusAtividade $bbhStaAtiCodigo = null)
    {
        $this->bbhStaAtiCodigo = $bbhStaAtiCodigo;

        return $this;
    }

    /**
     * Get bbhStaAtiCodigo
     *
     * @return \Project\Core\Entity\BbhStatusAtividade
     */
    public function getBbhStaAtiCodigo()
    {
        return $this->bbhStaAtiCodigo;
    }

    /**
     * Set bbhFluAltCodigo
     *
     * @param \Project\Core\Entity\BbhFluxoAlternativa $bbhFluAltCodigo
     *
     * @return BbhAtividade
     */
    public function setBbhFluAltCodigo(\Project\Core\Entity\BbhFluxoAlternativa $bbhFluAltCodigo = null)
    {
        $this->bbhFluAltCodigo = $bbhFluAltCodigo;

        return $this;
    }

    /**
     * Get bbhFluAltCodigo
     *
     * @return \Project\Core\Entity\BbhFluxoAlternativa
     */
    public function getBbhFluAltCodigo()
    {
        return $this->bbhFluAltCodigo;
    }

    /**
     * Set bbhUsuCodigo
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigo
     *
     * @return BbhAtividade
     */
    public function setBbhUsuCodigo(\Project\Core\Entity\BbhUsuario $bbhUsuCodigo = null)
    {
        $this->bbhUsuCodigo = $bbhUsuCodigo;

        return $this;
    }

    /**
     * Get bbhUsuCodigo
     *
     * @return \Project\Core\Entity\BbhUsuario
     */
    public function getBbhUsuCodigo()
    {
        return $this->bbhUsuCodigo;
    }
}

