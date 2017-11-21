<?php

namespace Project\Core\Entity;

/**
 * BbhCampoDetalhamentoFluxo
 */
class BbhCampoDetalhamentoFluxo
{
    /**
     * @var integer
     */
    private $bbhCamDetFluCodigo;

    /**
     * @var string
     */
    private $bbhCamDetFluNome;

    /**
     * @var string
     */
    private $bbhCamDetFluTitulo;

    /**
     * @var string
     */
    private $bbhCamDetFluTipo;

    /**
     * @var string
     */
    private $bbhCamDetFluCuringa;

    /**
     * @var string
     */
    private $bbhCamDetFluDescricao;

    /**
     * @var string
     */
    private $bbhCamDetFluTamanho;

    /**
     * @var string
     */
    private $bbhCamDetFluDefault;

    /**
     * @var string
     */
    private $bbhCamDetFluDisponivel = '1';

    /**
     * @var string
     */
    private $bbhCamDetFluPreencherInicio = '1';

    /**
     * @var string
     */
    private $bbhCamDetFluObrigatorio = '1';

    /**
     * @var \Project\Core\Entity\BbhDetalhamentoFluxo
     */
    private $bbhDetFluCodigo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bbhModAtiCodigo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bbhModAtiCodigo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get bbhCamDetFluCodigo
     *
     * @return integer
     */
    public function getBbhCamDetFluCodigo()
    {
        return $this->bbhCamDetFluCodigo;
    }

    /**
     * Set bbhCamDetFluNome
     *
     * @param string $bbhCamDetFluNome
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluNome($bbhCamDetFluNome)
    {
        $this->bbhCamDetFluNome = $bbhCamDetFluNome;

        return $this;
    }

    /**
     * Get bbhCamDetFluNome
     *
     * @return string
     */
    public function getBbhCamDetFluNome()
    {
        return $this->bbhCamDetFluNome;
    }

    /**
     * Set bbhCamDetFluTitulo
     *
     * @param string $bbhCamDetFluTitulo
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluTitulo($bbhCamDetFluTitulo)
    {
        $this->bbhCamDetFluTitulo = $bbhCamDetFluTitulo;

        return $this;
    }

    /**
     * Get bbhCamDetFluTitulo
     *
     * @return string
     */
    public function getBbhCamDetFluTitulo()
    {
        return $this->bbhCamDetFluTitulo;
    }

    /**
     * Set bbhCamDetFluTipo
     *
     * @param string $bbhCamDetFluTipo
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluTipo($bbhCamDetFluTipo)
    {
        $this->bbhCamDetFluTipo = $bbhCamDetFluTipo;

        return $this;
    }

    /**
     * Get bbhCamDetFluTipo
     *
     * @return string
     */
    public function getBbhCamDetFluTipo()
    {
        return $this->bbhCamDetFluTipo;
    }

    /**
     * Set bbhCamDetFluCuringa
     *
     * @param string $bbhCamDetFluCuringa
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluCuringa($bbhCamDetFluCuringa)
    {
        $this->bbhCamDetFluCuringa = $bbhCamDetFluCuringa;

        return $this;
    }

    /**
     * Get bbhCamDetFluCuringa
     *
     * @return string
     */
    public function getBbhCamDetFluCuringa()
    {
        return $this->bbhCamDetFluCuringa;
    }

    /**
     * Set bbhCamDetFluDescricao
     *
     * @param string $bbhCamDetFluDescricao
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluDescricao($bbhCamDetFluDescricao)
    {
        $this->bbhCamDetFluDescricao = $bbhCamDetFluDescricao;

        return $this;
    }

    /**
     * Get bbhCamDetFluDescricao
     *
     * @return string
     */
    public function getBbhCamDetFluDescricao()
    {
        return $this->bbhCamDetFluDescricao;
    }

    /**
     * Set bbhCamDetFluTamanho
     *
     * @param string $bbhCamDetFluTamanho
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluTamanho($bbhCamDetFluTamanho)
    {
        $this->bbhCamDetFluTamanho = $bbhCamDetFluTamanho;

        return $this;
    }

    /**
     * Get bbhCamDetFluTamanho
     *
     * @return string
     */
    public function getBbhCamDetFluTamanho()
    {
        return $this->bbhCamDetFluTamanho;
    }

    /**
     * Set bbhCamDetFluDefault
     *
     * @param string $bbhCamDetFluDefault
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluDefault($bbhCamDetFluDefault)
    {
        $this->bbhCamDetFluDefault = $bbhCamDetFluDefault;

        return $this;
    }

    /**
     * Get bbhCamDetFluDefault
     *
     * @return string
     */
    public function getBbhCamDetFluDefault()
    {
        return $this->bbhCamDetFluDefault;
    }

    /**
     * Set bbhCamDetFluDisponivel
     *
     * @param string $bbhCamDetFluDisponivel
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluDisponivel($bbhCamDetFluDisponivel)
    {
        $this->bbhCamDetFluDisponivel = $bbhCamDetFluDisponivel;

        return $this;
    }

    /**
     * Get bbhCamDetFluDisponivel
     *
     * @return string
     */
    public function getBbhCamDetFluDisponivel()
    {
        return $this->bbhCamDetFluDisponivel;
    }

    /**
     * Set bbhCamDetFluPreencherInicio
     *
     * @param string $bbhCamDetFluPreencherInicio
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhCamDetFluPreencherInicio($bbhCamDetFluPreencherInicio)
    {
        $this->bbhCamDetFluPreencherInicio = $bbhCamDetFluPreencherInicio;

        return $this;
    }

    /**
     * Get bbhCamDetFluPreencherInicio
     *
     * @return string
     */
    public function getBbhCamDetFluPreencherInicio()
    {
        return $this->bbhCamDetFluPreencherInicio;
    }

    /**
     * Set bbhDetFluCodigo
     *
     * @param \Project\Core\Entity\BbhDetalhamentoFluxo $bbhDetFluCodigo
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function setBbhDetFluCodigo(\Project\Core\Entity\BbhDetalhamentoFluxo $bbhDetFluCodigo = null)
    {
        $this->bbhDetFluCodigo = $bbhDetFluCodigo;

        return $this;
    }

    /**
     * Get bbhDetFluCodigo
     *
     * @return \Project\Core\Entity\BbhDetalhamentoFluxo
     */
    public function getBbhDetFluCodigo()
    {
        return $this->bbhDetFluCodigo;
    }

    /**
     * Add bbhModAtiCodigo
     *
     * @param \Project\Core\Entity\BbhModeloAtividade $bbhModAtiCodigo
     *
     * @return BbhCampoDetalhamentoFluxo
     */
    public function addBbhModAtiCodigo(\Project\Core\Entity\BbhModeloAtividade $bbhModAtiCodigo)
    {
        $this->bbhModAtiCodigo[] = $bbhModAtiCodigo;

        return $this;
    }

    /**
     * Remove bbhModAtiCodigo
     *
     * @param \Project\Core\Entity\BbhModeloAtividade $bbhModAtiCodigo
     */
    public function removeBbhModAtiCodigo(\Project\Core\Entity\BbhModeloAtividade $bbhModAtiCodigo)
    {
        $this->bbhModAtiCodigo->removeElement($bbhModAtiCodigo);
    }

    /**
     * Get bbhModAtiCodigo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBbhModAtiCodigo()
    {
        return $this->bbhModAtiCodigo;
    }

    /**
     * @return string
     */
    public function getBbhCamDetFluObrigatorio()
    {
        return $this->bbhCamDetFluObrigatorio;
    }

    /**
     * @param string $bbhCamDetFluObrigatorio
     */
    public function setBbhCamDetFluObrigatorio($bbhCamDetFluObrigatorio)
    {
        $this->bbhCamDetFluObrigatorio = $bbhCamDetFluObrigatorio;
    }
}

