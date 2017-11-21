<?php

namespace Project\Core\Entity;

/**
 * BbhSetup
 */
class BbhSetup
{
    /**
     * @var integer
     */
    private $bbhSetCodigo;

    /**
     * @var string
     */
    private $bbhSetEmailOrigem;

    /**
     * @var string
     */
    private $bbhSetTituloOrigem;

    /**
     * @var string
     */
    private $bbhSetAssunto;

    /**
     * @var string
     */
    private $bbhSetUsuario;

    /**
     * @var string
     */
    private $bbhSetSenha;

    /**
     * @var string
     */
    private $bbhSetSmtp;


    /**
     * Get bbhSetCodigo
     *
     * @return integer
     */
    public function getBbhSetCodigo()
    {
        return $this->bbhSetCodigo;
    }

    /**
     * Set bbhSetEmailOrigem
     *
     * @param string $bbhSetEmailOrigem
     *
     * @return BbhSetup
     */
    public function setBbhSetEmailOrigem($bbhSetEmailOrigem)
    {
        $this->bbhSetEmailOrigem = $bbhSetEmailOrigem;

        return $this;
    }

    /**
     * Get bbhSetEmailOrigem
     *
     * @return string
     */
    public function getBbhSetEmailOrigem()
    {
        return $this->bbhSetEmailOrigem;
    }

    /**
     * Set bbhSetTituloOrigem
     *
     * @param string $bbhSetTituloOrigem
     *
     * @return BbhSetup
     */
    public function setBbhSetTituloOrigem($bbhSetTituloOrigem)
    {
        $this->bbhSetTituloOrigem = $bbhSetTituloOrigem;

        return $this;
    }

    /**
     * Get bbhSetTituloOrigem
     *
     * @return string
     */
    public function getBbhSetTituloOrigem()
    {
        return $this->bbhSetTituloOrigem;
    }

    /**
     * Set bbhSetAssunto
     *
     * @param string $bbhSetAssunto
     *
     * @return BbhSetup
     */
    public function setBbhSetAssunto($bbhSetAssunto)
    {
        $this->bbhSetAssunto = $bbhSetAssunto;

        return $this;
    }

    /**
     * Get bbhSetAssunto
     *
     * @return string
     */
    public function getBbhSetAssunto()
    {
        return $this->bbhSetAssunto;
    }

    /**
     * Set bbhSetUsuario
     *
     * @param string $bbhSetUsuario
     *
     * @return BbhSetup
     */
    public function setBbhSetUsuario($bbhSetUsuario)
    {
        $this->bbhSetUsuario = $bbhSetUsuario;

        return $this;
    }

    /**
     * Get bbhSetUsuario
     *
     * @return string
     */
    public function getBbhSetUsuario()
    {
        return $this->bbhSetUsuario;
    }

    /**
     * Set bbhSetSenha
     *
     * @param string $bbhSetSenha
     *
     * @return BbhSetup
     */
    public function setBbhSetSenha($bbhSetSenha)
    {
        $this->bbhSetSenha = $bbhSetSenha;

        return $this;
    }

    /**
     * Get bbhSetSenha
     *
     * @return string
     */
    public function getBbhSetSenha()
    {
        return $this->bbhSetSenha;
    }

    /**
     * Set bbhSetSmtp
     *
     * @param string $bbhSetSmtp
     *
     * @return BbhSetup
     */
    public function setBbhSetSmtp($bbhSetSmtp)
    {
        $this->bbhSetSmtp = $bbhSetSmtp;

        return $this;
    }

    /**
     * Get bbhSetSmtp
     *
     * @return string
     */
    public function getBbhSetSmtp()
    {
        return $this->bbhSetSmtp;
    }
}

