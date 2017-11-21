<?php

namespace Project\Core\Entity;

/**
 * BbhModeloParagrafo
 */
class BbhModeloParagrafo
{
    /**
     * @var integer
     */
    private $bbhModParCodigo;

    /**
     * @var string
     */
    private $bbhModParNome;

    /**
     * @var string
     */
    private $bbhModParTitulo;

    /**
     * @var string
     */
    private $bbhModParParagrafo;

    /**
     * @var string
     */
    private $bbhModParPrivado = '0';

    /**
     * @var integer
     */
    private $bbhUsuAutor;

    /**
     * @var integer
     */
    private $bbhAdmCodigo;

    /**
     * @var \DateTime
     */
    private $bbhModParMomento = '0000-00-00 00:00:00';

    /**
     * @var \Project\Core\Entity\BbhModeloFluxo
     */
    private $bbhModFluCodigo;


    /**
     * Get bbhModParCodigo
     *
     * @return integer
     */
    public function getBbhModParCodigo()
    {
        return $this->bbhModParCodigo;
    }

    /**
     * Set bbhModParNome
     *
     * @param string $bbhModParNome
     *
     * @return BbhModeloParagrafo
     */
    public function setBbhModParNome($bbhModParNome)
    {
        $this->bbhModParNome = $bbhModParNome;

        return $this;
    }

    /**
     * Get bbhModParNome
     *
     * @return string
     */
    public function getBbhModParNome()
    {
        return $this->bbhModParNome;
    }

    /**
     * Set bbhModParTitulo
     *
     * @param string $bbhModParTitulo
     *
     * @return BbhModeloParagrafo
     */
    public function setBbhModParTitulo($bbhModParTitulo)
    {
        $this->bbhModParTitulo = $bbhModParTitulo;

        return $this;
    }

    /**
     * Get bbhModParTitulo
     *
     * @return string
     */
    public function getBbhModParTitulo()
    {
        return $this->bbhModParTitulo;
    }

    /**
     * Set bbhModParParagrafo
     *
     * @param string $bbhModParParagrafo
     *
     * @return BbhModeloParagrafo
     */
    public function setBbhModParParagrafo($bbhModParParagrafo)
    {
        $this->bbhModParParagrafo = $bbhModParParagrafo;

        return $this;
    }

    /**
     * Get bbhModParParagrafo
     *
     * @return string
     */
    public function getBbhModParParagrafo()
    {
        return $this->bbhModParParagrafo;
    }

    /**
     * Set bbhModParPrivado
     *
     * @param string $bbhModParPrivado
     *
     * @return BbhModeloParagrafo
     */
    public function setBbhModParPrivado($bbhModParPrivado)
    {
        $this->bbhModParPrivado = $bbhModParPrivado;

        return $this;
    }

    /**
     * Get bbhModParPrivado
     *
     * @return string
     */
    public function getBbhModParPrivado()
    {
        return $this->bbhModParPrivado;
    }

    /**
     * Set bbhUsuAutor
     *
     * @param integer $bbhUsuAutor
     *
     * @return BbhModeloParagrafo
     */
    public function setBbhUsuAutor($bbhUsuAutor)
    {
        $this->bbhUsuAutor = $bbhUsuAutor;

        return $this;
    }

    /**
     * Get bbhUsuAutor
     *
     * @return integer
     */
    public function getBbhUsuAutor()
    {
        return $this->bbhUsuAutor;
    }

    /**
     * Set bbhAdmCodigo
     *
     * @param integer $bbhAdmCodigo
     *
     * @return BbhModeloParagrafo
     */
    public function setBbhAdmCodigo($bbhAdmCodigo)
    {
        $this->bbhAdmCodigo = $bbhAdmCodigo;

        return $this;
    }

    /**
     * Get bbhAdmCodigo
     *
     * @return integer
     */
    public function getBbhAdmCodigo()
    {
        return $this->bbhAdmCodigo;
    }

    /**
     * Set bbhModParMomento
     *
     * @param \DateTime $bbhModParMomento
     *
     * @return BbhModeloParagrafo
     */
    public function setBbhModParMomento($bbhModParMomento)
    {
        $this->bbhModParMomento = $bbhModParMomento;

        return $this;
    }

    /**
     * Get bbhModParMomento
     *
     * @return \DateTime
     */
    public function getBbhModParMomento()
    {
        return $this->bbhModParMomento;
    }

    /**
     * Set bbhModFluCodigo
     *
     * @param \Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo
     *
     * @return BbhModeloParagrafo
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

