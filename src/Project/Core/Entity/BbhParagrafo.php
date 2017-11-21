<?php

namespace Project\Core\Entity;

/**
 * BbhParagrafo
 */
class BbhParagrafo
{
    /**
     * @var integer
     */
    private $bbhParCodigo;

    /**
     * @var string
     */
    private $bbhParTitulo;

    /**
     * @var string
     */
    private $bbhParParagrafo;

    /**
     * @var integer
     */
    private $bbhModParCodigo;

    /**
     * @var integer
     */
    private $bbhParOrdem;

    /**
     * @var \DateTime
     */
    private $bbhParMomento;

    /**
     * @var string
     */
    private $bbhParAutor;

    /**
     * @var string
     */
    private $bbhParArquivo;

    /**
     * @var string
     */
    private $bbhParNmarquivo;

    /**
     * @var string
     */
    private $bbhParLegenda;

    /**
     * @var string
     */
    private $bbhParTipoAnexo;

    /**
     * @var \Project\Core\Entity\BbhRelatorio
     */
    private $bbhRelCodigo;


    /**
     * Get bbhParCodigo
     *
     * @return integer
     */
    public function getBbhParCodigo()
    {
        return $this->bbhParCodigo;
    }

    /**
     * Set bbhParTitulo
     *
     * @param string $bbhParTitulo
     *
     * @return BbhParagrafo
     */
    public function setBbhParTitulo($bbhParTitulo)
    {
        $this->bbhParTitulo = $bbhParTitulo;

        return $this;
    }

    /**
     * Get bbhParTitulo
     *
     * @return string
     */
    public function getBbhParTitulo()
    {
        return $this->bbhParTitulo;
    }

    /**
     * Set bbhParParagrafo
     *
     * @param string $bbhParParagrafo
     *
     * @return BbhParagrafo
     */
    public function setBbhParParagrafo($bbhParParagrafo)
    {
        $this->bbhParParagrafo = $bbhParParagrafo;

        return $this;
    }

    /**
     * Get bbhParParagrafo
     *
     * @return string
     */
    public function getBbhParParagrafo()
    {
        return $this->bbhParParagrafo;
    }

    /**
     * Set bbhModParCodigo
     *
     * @param integer $bbhModParCodigo
     *
     * @return BbhParagrafo
     */
    public function setBbhModParCodigo($bbhModParCodigo)
    {
        $this->bbhModParCodigo = $bbhModParCodigo;

        return $this;
    }

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
     * Set bbhParOrdem
     *
     * @param integer $bbhParOrdem
     *
     * @return BbhParagrafo
     */
    public function setBbhParOrdem($bbhParOrdem)
    {
        $this->bbhParOrdem = $bbhParOrdem;

        return $this;
    }

    /**
     * Get bbhParOrdem
     *
     * @return integer
     */
    public function getBbhParOrdem()
    {
        return $this->bbhParOrdem;
    }

    /**
     * Set bbhParMomento
     *
     * @param \DateTime $bbhParMomento
     *
     * @return BbhParagrafo
     */
    public function setBbhParMomento($bbhParMomento)
    {
        $this->bbhParMomento = $bbhParMomento;

        return $this;
    }

    /**
     * Get bbhParMomento
     *
     * @return \DateTime
     */
    public function getBbhParMomento()
    {
        return $this->bbhParMomento;
    }

    /**
     * Set bbhParAutor
     *
     * @param string $bbhParAutor
     *
     * @return BbhParagrafo
     */
    public function setBbhParAutor($bbhParAutor)
    {
        $this->bbhParAutor = $bbhParAutor;

        return $this;
    }

    /**
     * Get bbhParAutor
     *
     * @return string
     */
    public function getBbhParAutor()
    {
        return $this->bbhParAutor;
    }

    /**
     * Set bbhParArquivo
     *
     * @param string $bbhParArquivo
     *
     * @return BbhParagrafo
     */
    public function setBbhParArquivo($bbhParArquivo)
    {
        $this->bbhParArquivo = $bbhParArquivo;

        return $this;
    }

    /**
     * Get bbhParArquivo
     *
     * @return string
     */
    public function getBbhParArquivo()
    {
        return $this->bbhParArquivo;
    }

    /**
     * Set bbhParNmarquivo
     *
     * @param string $bbhParNmarquivo
     *
     * @return BbhParagrafo
     */
    public function setBbhParNmarquivo($bbhParNmarquivo)
    {
        $this->bbhParNmarquivo = $bbhParNmarquivo;

        return $this;
    }

    /**
     * Get bbhParNmarquivo
     *
     * @return string
     */
    public function getBbhParNmarquivo()
    {
        return $this->bbhParNmarquivo;
    }

    /**
     * Set bbhParLegenda
     *
     * @param string $bbhParLegenda
     *
     * @return BbhParagrafo
     */
    public function setBbhParLegenda($bbhParLegenda)
    {
        $this->bbhParLegenda = $bbhParLegenda;

        return $this;
    }

    /**
     * Get bbhParLegenda
     *
     * @return string
     */
    public function getBbhParLegenda()
    {
        return $this->bbhParLegenda;
    }

    /**
     * Set bbhParTipoAnexo
     *
     * @param string $bbhParTipoAnexo
     *
     * @return BbhParagrafo
     */
    public function setBbhParTipoAnexo($bbhParTipoAnexo)
    {
        $this->bbhParTipoAnexo = $bbhParTipoAnexo;

        return $this;
    }

    /**
     * Get bbhParTipoAnexo
     *
     * @return string
     */
    public function getBbhParTipoAnexo()
    {
        return $this->bbhParTipoAnexo;
    }

    /**
     * Set bbhRelCodigo
     *
     * @param \Project\Core\Entity\BbhRelatorio $bbhRelCodigo
     *
     * @return BbhParagrafo
     */
    public function setBbhRelCodigo(\Project\Core\Entity\BbhRelatorio $bbhRelCodigo = null)
    {
        $this->bbhRelCodigo = $bbhRelCodigo;

        return $this;
    }

    /**
     * Get bbhRelCodigo
     *
     * @return \Project\Core\Entity\BbhRelatorio
     */
    public function getBbhRelCodigo()
    {
        return $this->bbhRelCodigo;
    }
}

