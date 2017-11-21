<?php

namespace Project\Core\Entity;

/**
 * BbhModeloAtividade
 */
class BbhModeloAtividade
{
    /**
     * @var integer
     */
    private $bbhModAtiCodigo;

    /**
     * @var string
     */
    private $bbhModAtiNome;

    /**
     * @var string
     */
    private $bbhModAtiObservacao;

    /**
     * @var integer
     */
    private $bbhModAtiDuracao;

    /**
     * @var integer
     */
    private $bbhModAtiInicio;

    /**
     * @var integer
     */
    private $bbhModAtiOrdem;

    /**
     * @var integer
     */
    private $bbhModAtiAtribuicao;

    /**
     * @var integer
     */
    private $bbhModAtiMecanismo = '0';

    /**
     * @var string
     */
    private $bbhModAtiIcone = '3.gif';

    /**
     * @var string
     */
    private $bbhModAtiinicio = '0';

    /**
     * @var string
     */
    private $bbhModAtifim = '0';

    /**
     * @var string
     */
    private $bbhModAtiRelatorio = '0';

    /**
     * @var \Project\Core\Entity\BbhPerfil
     */
    private $bbhPerCodigo;

    /**
     * @var \Project\Core\Entity\BbhModeloFluxo
     */
    private $bbhModFluCodigo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bbhCamDetFluCodigo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bbhCamDetFluCodigo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get bbhModAtiCodigo
     *
     * @return integer
     */
    public function getBbhModAtiCodigo()
    {
        return $this->bbhModAtiCodigo;
    }

    /**
     * Set bbhModAtiNome
     *
     * @param string $bbhModAtiNome
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiNome($bbhModAtiNome)
    {
        $this->bbhModAtiNome = $bbhModAtiNome;

        return $this;
    }

    /**
     * Get bbhModAtiNome
     *
     * @return string
     */
    public function getBbhModAtiNome()
    {
        return $this->bbhModAtiNome;
    }

    /**
     * Set bbhModAtiObservacao
     *
     * @param string $bbhModAtiObservacao
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiObservacao($bbhModAtiObservacao)
    {
        $this->bbhModAtiObservacao = $bbhModAtiObservacao;

        return $this;
    }

    /**
     * Get bbhModAtiObservacao
     *
     * @return string
     */
    public function getBbhModAtiObservacao()
    {
        return $this->bbhModAtiObservacao;
    }

    /**
     * Set bbhModAtiDuracao
     *
     * @param integer $bbhModAtiDuracao
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiDuracao($bbhModAtiDuracao)
    {
        $this->bbhModAtiDuracao = $bbhModAtiDuracao;

        return $this;
    }

    /**
     * Get bbhModAtiDuracao
     *
     * @return integer
     */
    public function getBbhModAtiDuracao()
    {
        return $this->bbhModAtiDuracao;
    }

    /**
     * Set bbhModAtiInicio
     *
     * @param integer $bbhModAtiInicio
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiInicio($bbhModAtiInicio)
    {
        $this->bbhModAtiInicio = $bbhModAtiInicio;

        return $this;
    }

    /**
     * Get bbhModAtiInicio
     *
     * @return integer
     */
    public function getBbhModAtiInicio()
    {
        return $this->bbhModAtiInicio;
    }

    /**
     * Set bbhModAtiOrdem
     *
     * @param integer $bbhModAtiOrdem
     *
     * @return BbhModeloAtividade
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
     * Set bbhModAtiAtribuicao
     *
     * @param integer $bbhModAtiAtribuicao
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiAtribuicao($bbhModAtiAtribuicao)
    {
        $this->bbhModAtiAtribuicao = $bbhModAtiAtribuicao;

        return $this;
    }

    /**
     * Get bbhModAtiAtribuicao
     *
     * @return integer
     */
    public function getBbhModAtiAtribuicao()
    {
        return $this->bbhModAtiAtribuicao;
    }

    /**
     * Set bbhModAtiMecanismo
     *
     * @param integer $bbhModAtiMecanismo
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiMecanismo($bbhModAtiMecanismo)
    {
        $this->bbhModAtiMecanismo = $bbhModAtiMecanismo;

        return $this;
    }

    /**
     * Get bbhModAtiMecanismo
     *
     * @return integer
     */
    public function getBbhModAtiMecanismo()
    {
        return $this->bbhModAtiMecanismo;
    }

    /**
     * Set bbhModAtiIcone
     *
     * @param string $bbhModAtiIcone
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiIcone($bbhModAtiIcone)
    {
        $this->bbhModAtiIcone = $bbhModAtiIcone;

        return $this;
    }

    /**
     * Get bbhModAtiIcone
     *
     * @return string
     */
    public function getBbhModAtiIcone()
    {
        return $this->bbhModAtiIcone;
    }

    /**
     * Set bbhModAtifim
     *
     * @param string $bbhModAtifim
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtifim($bbhModAtifim)
    {
        $this->bbhModAtifim = $bbhModAtifim;

        return $this;
    }

    /**
     * Get bbhModAtifim
     *
     * @return string
     */
    public function getBbhModAtifim()
    {
        return $this->bbhModAtifim;
    }

    /**
     * Set bbhModAtiRelatorio
     *
     * @param string $bbhModAtiRelatorio
     *
     * @return BbhModeloAtividade
     */
    public function setBbhModAtiRelatorio($bbhModAtiRelatorio)
    {
        $this->bbhModAtiRelatorio = $bbhModAtiRelatorio;

        return $this;
    }

    /**
     * Get bbhModAtiRelatorio
     *
     * @return string
     */
    public function getBbhModAtiRelatorio()
    {
        return $this->bbhModAtiRelatorio;
    }

    /**
     * Set bbhPerCodigo
     *
     * @param \Project\Core\Entity\BbhPerfil $bbhPerCodigo
     *
     * @return BbhModeloAtividade
     */
    public function setBbhPerCodigo(\Project\Core\Entity\BbhPerfil $bbhPerCodigo = null)
    {
        $this->bbhPerCodigo = $bbhPerCodigo;

        return $this;
    }

    /**
     * Get bbhPerCodigo
     *
     * @return \Project\Core\Entity\BbhPerfil
     */
    public function getBbhPerCodigo()
    {
        return $this->bbhPerCodigo;
    }

    /**
     * Set bbhModFluCodigo
     *
     * @param \Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo
     *
     * @return BbhModeloAtividade
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

    /**
     * Add bbhCamDetFluCodigo
     *
     * @param \Project\Core\Entity\BbhCampoDetalhamentoFluxo $bbhCamDetFluCodigo
     *
     * @return BbhModeloAtividade
     */
    public function addBbhCamDetFluCodigo(\Project\Core\Entity\BbhCampoDetalhamentoFluxo $bbhCamDetFluCodigo)
    {
        $this->bbhCamDetFluCodigo[] = $bbhCamDetFluCodigo;

        return $this;
    }

    /**
     * Remove bbhCamDetFluCodigo
     *
     * @param \Project\Core\Entity\BbhCampoDetalhamentoFluxo $bbhCamDetFluCodigo
     */
    public function removeBbhCamDetFluCodigo(\Project\Core\Entity\BbhCampoDetalhamentoFluxo $bbhCamDetFluCodigo)
    {
        $this->bbhCamDetFluCodigo->removeElement($bbhCamDetFluCodigo);
    }

    /**
     * Get bbhCamDetFluCodigo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBbhCamDetFluCodigo()
    {
        return $this->bbhCamDetFluCodigo;
    }
}

