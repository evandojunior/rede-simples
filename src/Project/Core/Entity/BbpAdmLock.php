<?php

namespace Project\Core\Entity;

/**
 * BbpAdmLock
 */
class BbpAdmLock
{
    /**
     * @var integer
     */
    private $bbpAdmLocCodigo;

    /**
     * @var string
     */
    private $bbpAdmLocNome;

    /**
     * @var string
     */
    private $bbpAdmLocArquivo;

    /**
     * @var string
     */
    private $bbpAdmLocObservacao;

    /**
     * @var string
     */
    private $bbpAdmLocDiretorio;

    /**
     * @var string
     */
    private $bbpAdmLocAtivo = '1';

    /**
     * @var string
     */
    private $bbpAdmLocIcone;


    /**
     * Get bbpAdmLocCodigo
     *
     * @return integer
     */
    public function getBbpAdmLocCodigo()
    {
        return $this->bbpAdmLocCodigo;
    }

    /**
     * Set bbpAdmLocNome
     *
     * @param string $bbpAdmLocNome
     *
     * @return BbpAdmLock
     */
    public function setBbpAdmLocNome($bbpAdmLocNome)
    {
        $this->bbpAdmLocNome = $bbpAdmLocNome;

        return $this;
    }

    /**
     * Get bbpAdmLocNome
     *
     * @return string
     */
    public function getBbpAdmLocNome()
    {
        return $this->bbpAdmLocNome;
    }

    /**
     * Set bbpAdmLocArquivo
     *
     * @param string $bbpAdmLocArquivo
     *
     * @return BbpAdmLock
     */
    public function setBbpAdmLocArquivo($bbpAdmLocArquivo)
    {
        $this->bbpAdmLocArquivo = $bbpAdmLocArquivo;

        return $this;
    }

    /**
     * Get bbpAdmLocArquivo
     *
     * @return string
     */
    public function getBbpAdmLocArquivo()
    {
        return $this->bbpAdmLocArquivo;
    }

    /**
     * Set bbpAdmLocObservacao
     *
     * @param string $bbpAdmLocObservacao
     *
     * @return BbpAdmLock
     */
    public function setBbpAdmLocObservacao($bbpAdmLocObservacao)
    {
        $this->bbpAdmLocObservacao = $bbpAdmLocObservacao;

        return $this;
    }

    /**
     * Get bbpAdmLocObservacao
     *
     * @return string
     */
    public function getBbpAdmLocObservacao()
    {
        return $this->bbpAdmLocObservacao;
    }

    /**
     * Set bbpAdmLocDiretorio
     *
     * @param string $bbpAdmLocDiretorio
     *
     * @return BbpAdmLock
     */
    public function setBbpAdmLocDiretorio($bbpAdmLocDiretorio)
    {
        $this->bbpAdmLocDiretorio = $bbpAdmLocDiretorio;

        return $this;
    }

    /**
     * Get bbpAdmLocDiretorio
     *
     * @return string
     */
    public function getBbpAdmLocDiretorio()
    {
        return $this->bbpAdmLocDiretorio;
    }

    /**
     * Set bbpAdmLocAtivo
     *
     * @param string $bbpAdmLocAtivo
     *
     * @return BbpAdmLock
     */
    public function setBbpAdmLocAtivo($bbpAdmLocAtivo)
    {
        $this->bbpAdmLocAtivo = $bbpAdmLocAtivo;

        return $this;
    }

    /**
     * Get bbpAdmLocAtivo
     *
     * @return string
     */
    public function getBbpAdmLocAtivo()
    {
        return $this->bbpAdmLocAtivo;
    }

    /**
     * Set bbpAdmLocIcone
     *
     * @param string $bbpAdmLocIcone
     *
     * @return BbpAdmLock
     */
    public function setBbpAdmLocIcone($bbpAdmLocIcone)
    {
        $this->bbpAdmLocIcone = $bbpAdmLocIcone;

        return $this;
    }

    /**
     * Get bbpAdmLocIcone
     *
     * @return string
     */
    public function getBbpAdmLocIcone()
    {
        return $this->bbpAdmLocIcone;
    }
}

