<?php

namespace Project\Core\Entity;

/**
 * BbhRelatorio
 */
class BbhRelatorio
{
    /**
     * @var integer
     */
    private $bbhRelCodigo;

    /**
     * @var \DateTime
     */
    private $bbhRelDataCriacao;

    /**
     * @var string
     */
    private $bbhRelArquivo;

    /**
     * @var string
     */
    private $bbhRelObservacao;

    /**
     * @var integer
     */
    private $bbhRelFinalizado = '0';

    /**
     * @var string
     */
    private $bbhRelTitulo;

    /**
     * @var integer
     */
    private $bbhUsuCodigo;

    /**
     * @var string
     */
    private $bbhRelPdf = '0';

    /**
     * @var string
     */
    private $bbhRelAss = '0';

    /**
     * @var string
     */
    private $bbhRelNmarquivo;

    /**
     * @var string
     */
    private $bbhRelCaminho;

    /**
     * @var string
     */
    private $bbhRelProtegido = '0';

    /**
     * @var \Project\Core\Entity\BbhAtividade
     */
    private $bbhAtiCodigo;


    /**
     * Get bbhRelCodigo
     *
     * @return integer
     */
    public function getBbhRelCodigo()
    {
        return $this->bbhRelCodigo;
    }

    /**
     * Set bbhRelDataCriacao
     *
     * @param \DateTime $bbhRelDataCriacao
     *
     * @return BbhRelatorio
     */
    public function setBbhRelDataCriacao($bbhRelDataCriacao)
    {
        $this->bbhRelDataCriacao = $bbhRelDataCriacao;

        return $this;
    }

    /**
     * Get bbhRelDataCriacao
     *
     * @return \DateTime
     */
    public function getBbhRelDataCriacao()
    {
        return $this->bbhRelDataCriacao;
    }

    /**
     * Set bbhRelArquivo
     *
     * @param string $bbhRelArquivo
     *
     * @return BbhRelatorio
     */
    public function setBbhRelArquivo($bbhRelArquivo)
    {
        $this->bbhRelArquivo = $bbhRelArquivo;

        return $this;
    }

    /**
     * Get bbhRelArquivo
     *
     * @return string
     */
    public function getBbhRelArquivo()
    {
        return $this->bbhRelArquivo;
    }

    /**
     * Set bbhRelObservacao
     *
     * @param string $bbhRelObservacao
     *
     * @return BbhRelatorio
     */
    public function setBbhRelObservacao($bbhRelObservacao)
    {
        $this->bbhRelObservacao = $bbhRelObservacao;

        return $this;
    }

    /**
     * Get bbhRelObservacao
     *
     * @return string
     */
    public function getBbhRelObservacao()
    {
        return $this->bbhRelObservacao;
    }

    /**
     * Set bbhRelFinalizado
     *
     * @param integer $bbhRelFinalizado
     *
     * @return BbhRelatorio
     */
    public function setBbhRelFinalizado($bbhRelFinalizado)
    {
        $this->bbhRelFinalizado = $bbhRelFinalizado;

        return $this;
    }

    /**
     * Get bbhRelFinalizado
     *
     * @return integer
     */
    public function getBbhRelFinalizado()
    {
        return $this->bbhRelFinalizado;
    }

    /**
     * Set bbhRelTitulo
     *
     * @param string $bbhRelTitulo
     *
     * @return BbhRelatorio
     */
    public function setBbhRelTitulo($bbhRelTitulo)
    {
        $this->bbhRelTitulo = $bbhRelTitulo;

        return $this;
    }

    /**
     * Get bbhRelTitulo
     *
     * @return string
     */
    public function getBbhRelTitulo()
    {
        return $this->bbhRelTitulo;
    }

    /**
     * Set bbhUsuCodigo
     *
     * @param integer $bbhUsuCodigo
     *
     * @return BbhRelatorio
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
     * Set bbhRelPdf
     *
     * @param string $bbhRelPdf
     *
     * @return BbhRelatorio
     */
    public function setBbhRelPdf($bbhRelPdf)
    {
        $this->bbhRelPdf = $bbhRelPdf;

        return $this;
    }

    /**
     * Get bbhRelPdf
     *
     * @return string
     */
    public function getBbhRelPdf()
    {
        return $this->bbhRelPdf;
    }

    /**
     * Set bbhRelAss
     *
     * @param string $bbhRelAss
     *
     * @return BbhRelatorio
     */
    public function setBbhRelAss($bbhRelAss)
    {
        $this->bbhRelAss = $bbhRelAss;

        return $this;
    }

    /**
     * Get bbhRelAss
     *
     * @return string
     */
    public function getBbhRelAss()
    {
        return $this->bbhRelAss;
    }

    /**
     * Set bbhRelNmarquivo
     *
     * @param string $bbhRelNmarquivo
     *
     * @return BbhRelatorio
     */
    public function setBbhRelNmarquivo($bbhRelNmarquivo)
    {
        $this->bbhRelNmarquivo = $bbhRelNmarquivo;

        return $this;
    }

    /**
     * Get bbhRelNmarquivo
     *
     * @return string
     */
    public function getBbhRelNmarquivo()
    {
        return $this->bbhRelNmarquivo;
    }

    /**
     * Set bbhRelCaminho
     *
     * @param string $bbhRelCaminho
     *
     * @return BbhRelatorio
     */
    public function setBbhRelCaminho($bbhRelCaminho)
    {
        $this->bbhRelCaminho = $bbhRelCaminho;

        return $this;
    }

    /**
     * Get bbhRelCaminho
     *
     * @return string
     */
    public function getBbhRelCaminho()
    {
        return $this->bbhRelCaminho;
    }

    /**
     * Set bbhRelProtegido
     *
     * @param string $bbhRelProtegido
     *
     * @return BbhRelatorio
     */
    public function setBbhRelProtegido($bbhRelProtegido)
    {
        $this->bbhRelProtegido = $bbhRelProtegido;

        return $this;
    }

    /**
     * Get bbhRelProtegido
     *
     * @return string
     */
    public function getBbhRelProtegido()
    {
        return $this->bbhRelProtegido;
    }

    /**
     * Set bbhAtiCodigo
     *
     * @param \Project\Core\Entity\BbhAtividade $bbhAtiCodigo
     *
     * @return BbhRelatorio
     */
    public function setBbhAtiCodigo(\Project\Core\Entity\BbhAtividade $bbhAtiCodigo = null)
    {
        $this->bbhAtiCodigo = $bbhAtiCodigo;

        return $this;
    }

    /**
     * Get bbhAtiCodigo
     *
     * @return \Project\Core\Entity\BbhAtividade
     */
    public function getBbhAtiCodigo()
    {
        return $this->bbhAtiCodigo;
    }
}

