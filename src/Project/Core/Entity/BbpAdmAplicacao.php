<?php

namespace Project\Core\Entity;

/**
 * BbpAdmAplicacao
 */
class BbpAdmAplicacao
{
    /**
     * @var integer
     */
    private $bbpAdmAplCodigo;

    /**
     * @var string
     */
    private $bbpAdmAplNome;

    /**
     * @var string
     */
    private $bbpAdmAplApelido;

    /**
     * @var string
     */
    private $bbpAdmAplObservacao;

    /**
     * @var string
     */
    private $bbpAdmAplUrl;

    /**
     * @var string
     */
    private $bbpAdmAplAtivo = '1';

    /**
     * @var string
     */
    private $bbpAdmAplIcone;


    /**
     * Get bbpAdmAplCodigo
     *
     * @return integer
     */
    public function getBbpAdmAplCodigo()
    {
        return $this->bbpAdmAplCodigo;
    }

    /**
     * Set bbpAdmAplNome
     *
     * @param string $bbpAdmAplNome
     *
     * @return BbpAdmAplicacao
     */
    public function setBbpAdmAplNome($bbpAdmAplNome)
    {
        $this->bbpAdmAplNome = $bbpAdmAplNome;

        return $this;
    }

    /**
     * Get bbpAdmAplNome
     *
     * @return string
     */
    public function getBbpAdmAplNome()
    {
        return $this->bbpAdmAplNome;
    }

    /**
     * Set bbpAdmAplApelido
     *
     * @param string $bbpAdmAplApelido
     *
     * @return BbpAdmAplicacao
     */
    public function setBbpAdmAplApelido($bbpAdmAplApelido)
    {
        $this->bbpAdmAplApelido = $bbpAdmAplApelido;

        return $this;
    }

    /**
     * Get bbpAdmAplApelido
     *
     * @return string
     */
    public function getBbpAdmAplApelido()
    {
        return $this->bbpAdmAplApelido;
    }

    /**
     * Set bbpAdmAplObservacao
     *
     * @param string $bbpAdmAplObservacao
     *
     * @return BbpAdmAplicacao
     */
    public function setBbpAdmAplObservacao($bbpAdmAplObservacao)
    {
        $this->bbpAdmAplObservacao = $bbpAdmAplObservacao;

        return $this;
    }

    /**
     * Get bbpAdmAplObservacao
     *
     * @return string
     */
    public function getBbpAdmAplObservacao()
    {
        return $this->bbpAdmAplObservacao;
    }

    /**
     * Set bbpAdmAplUrl
     *
     * @param string $bbpAdmAplUrl
     *
     * @return BbpAdmAplicacao
     */
    public function setBbpAdmAplUrl($bbpAdmAplUrl)
    {
        $this->bbpAdmAplUrl = $bbpAdmAplUrl;

        return $this;
    }

    /**
     * Get bbpAdmAplUrl
     *
     * @return string
     */
    public function getBbpAdmAplUrl()
    {
        return $this->bbpAdmAplUrl;
    }

    /**
     * Set bbpAdmAplAtivo
     *
     * @param string $bbpAdmAplAtivo
     *
     * @return BbpAdmAplicacao
     */
    public function setBbpAdmAplAtivo($bbpAdmAplAtivo)
    {
        $this->bbpAdmAplAtivo = $bbpAdmAplAtivo;

        return $this;
    }

    /**
     * Get bbpAdmAplAtivo
     *
     * @return string
     */
    public function getBbpAdmAplAtivo()
    {
        return $this->bbpAdmAplAtivo;
    }

    /**
     * Set bbpAdmAplIcone
     *
     * @param string $bbpAdmAplIcone
     *
     * @return BbpAdmAplicacao
     */
    public function setBbpAdmAplIcone($bbpAdmAplIcone)
    {
        $this->bbpAdmAplIcone = $bbpAdmAplIcone;

        return $this;
    }

    /**
     * Get bbpAdmAplIcone
     *
     * @return string
     */
    public function getBbpAdmAplIcone()
    {
        return $this->bbpAdmAplIcone;
    }
}

