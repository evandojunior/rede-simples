<?php

namespace Project\Core\Entity;

/**
 * BbhArquivo
 */
class BbhArquivo
{
    /**
     * @var integer
     */
    private $bbhArqCodigo;

    /**
     * @var string
     */
    private $bbhArqLocalizacao;

    /**
     * @var \DateTime
     */
    private $bbhArqDataModificado;

    /**
     * @var integer
     */
    private $bbhArqVersao;

    /**
     * @var integer
     */
    private $bbhArqCompartilhado = '0';

    /**
     * @var string
     */
    private $bbhArqNome;

    /**
     * @var string
     */
    private $bbhArqTipo;

    /**
     * @var string
     */
    private $bbhArqTitulo;

    /**
     * @var string
     */
    private $bbhArqAutor;

    /**
     * @var string
     */
    private $bbhArqDescricao;

    /**
     * @var string
     */
    private $bbhArqNomeLogico;

    /**
     * @var string
     */
    private $bbhArqMime;

    /**
     * @var string
     */
    private $bbhArqPublico = '0';

    /**
     * @var string
     */
    private $bbhArqObsPublico;

    /**
     * @var \Project\Core\Entity\BbhFluxo
     */
    private $bbhFluCodigo;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigo;


    /**
     * Get bbhArqCodigo
     *
     * @return integer
     */
    public function getBbhArqCodigo()
    {
        return $this->bbhArqCodigo;
    }

    /**
     * Set bbhArqLocalizacao
     *
     * @param string $bbhArqLocalizacao
     *
     * @return BbhArquivo
     */
    public function setBbhArqLocalizacao($bbhArqLocalizacao)
    {
        $this->bbhArqLocalizacao = $bbhArqLocalizacao;

        return $this;
    }

    /**
     * Get bbhArqLocalizacao
     *
     * @return string
     */
    public function getBbhArqLocalizacao()
    {
        return $this->bbhArqLocalizacao;
    }

    /**
     * Set bbhArqDataModificado
     *
     * @param \DateTime $bbhArqDataModificado
     *
     * @return BbhArquivo
     */
    public function setBbhArqDataModificado($bbhArqDataModificado)
    {
        $this->bbhArqDataModificado = $bbhArqDataModificado;

        return $this;
    }

    /**
     * Get bbhArqDataModificado
     *
     * @return \DateTime
     */
    public function getBbhArqDataModificado()
    {
        return $this->bbhArqDataModificado;
    }

    /**
     * Set bbhArqVersao
     *
     * @param integer $bbhArqVersao
     *
     * @return BbhArquivo
     */
    public function setBbhArqVersao($bbhArqVersao)
    {
        $this->bbhArqVersao = $bbhArqVersao;

        return $this;
    }

    /**
     * Get bbhArqVersao
     *
     * @return integer
     */
    public function getBbhArqVersao()
    {
        return $this->bbhArqVersao;
    }

    /**
     * Set bbhArqCompartilhado
     *
     * @param integer $bbhArqCompartilhado
     *
     * @return BbhArquivo
     */
    public function setBbhArqCompartilhado($bbhArqCompartilhado)
    {
        $this->bbhArqCompartilhado = $bbhArqCompartilhado;

        return $this;
    }

    /**
     * Get bbhArqCompartilhado
     *
     * @return integer
     */
    public function getBbhArqCompartilhado()
    {
        return $this->bbhArqCompartilhado;
    }

    /**
     * Set bbhArqNome
     *
     * @param string $bbhArqNome
     *
     * @return BbhArquivo
     */
    public function setBbhArqNome($bbhArqNome)
    {
        $this->bbhArqNome = $bbhArqNome;

        return $this;
    }

    /**
     * Get bbhArqNome
     *
     * @return string
     */
    public function getBbhArqNome()
    {
        return $this->bbhArqNome;
    }

    /**
     * Set bbhArqTipo
     *
     * @param string $bbhArqTipo
     *
     * @return BbhArquivo
     */
    public function setBbhArqTipo($bbhArqTipo)
    {
        $this->bbhArqTipo = $bbhArqTipo;

        return $this;
    }

    /**
     * Get bbhArqTipo
     *
     * @return string
     */
    public function getBbhArqTipo()
    {
        return $this->bbhArqTipo;
    }

    /**
     * Set bbhArqTitulo
     *
     * @param string $bbhArqTitulo
     *
     * @return BbhArquivo
     */
    public function setBbhArqTitulo($bbhArqTitulo)
    {
        $this->bbhArqTitulo = $bbhArqTitulo;

        return $this;
    }

    /**
     * Get bbhArqTitulo
     *
     * @return string
     */
    public function getBbhArqTitulo()
    {
        return $this->bbhArqTitulo;
    }

    /**
     * Set bbhArqAutor
     *
     * @param string $bbhArqAutor
     *
     * @return BbhArquivo
     */
    public function setBbhArqAutor($bbhArqAutor)
    {
        $this->bbhArqAutor = $bbhArqAutor;

        return $this;
    }

    /**
     * Get bbhArqAutor
     *
     * @return string
     */
    public function getBbhArqAutor()
    {
        return $this->bbhArqAutor;
    }

    /**
     * Set bbhArqDescricao
     *
     * @param string $bbhArqDescricao
     *
     * @return BbhArquivo
     */
    public function setBbhArqDescricao($bbhArqDescricao)
    {
        $this->bbhArqDescricao = $bbhArqDescricao;

        return $this;
    }

    /**
     * Get bbhArqDescricao
     *
     * @return string
     */
    public function getBbhArqDescricao()
    {
        return $this->bbhArqDescricao;
    }

    /**
     * Set bbhArqNomeLogico
     *
     * @param string $bbhArqNomeLogico
     *
     * @return BbhArquivo
     */
    public function setBbhArqNomeLogico($bbhArqNomeLogico)
    {
        $this->bbhArqNomeLogico = $bbhArqNomeLogico;

        return $this;
    }

    /**
     * Get bbhArqNomeLogico
     *
     * @return string
     */
    public function getBbhArqNomeLogico()
    {
        return $this->bbhArqNomeLogico;
    }

    /**
     * Set bbhArqMime
     *
     * @param string $bbhArqMime
     *
     * @return BbhArquivo
     */
    public function setBbhArqMime($bbhArqMime)
    {
        $this->bbhArqMime = $bbhArqMime;

        return $this;
    }

    /**
     * Get bbhArqMime
     *
     * @return string
     */
    public function getBbhArqMime()
    {
        return $this->bbhArqMime;
    }

    /**
     * Set bbhArqPublico
     *
     * @param string $bbhArqPublico
     *
     * @return BbhArquivo
     */
    public function setBbhArqPublico($bbhArqPublico)
    {
        $this->bbhArqPublico = $bbhArqPublico;

        return $this;
    }

    /**
     * Get bbhArqPublico
     *
     * @return string
     */
    public function getBbhArqPublico()
    {
        return $this->bbhArqPublico;
    }

    /**
     * Set bbhArqObsPublico
     *
     * @param string $bbhArqObsPublico
     *
     * @return BbhArquivo
     */
    public function setBbhArqObsPublico($bbhArqObsPublico)
    {
        $this->bbhArqObsPublico = $bbhArqObsPublico;

        return $this;
    }

    /**
     * Get bbhArqObsPublico
     *
     * @return string
     */
    public function getBbhArqObsPublico()
    {
        return $this->bbhArqObsPublico;
    }

    /**
     * Set bbhFluCodigo
     *
     * @param \Project\Core\Entity\BbhFluxo $bbhFluCodigo
     *
     * @return BbhArquivo
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
     * Set bbhUsuCodigo
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigo
     *
     * @return BbhArquivo
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

