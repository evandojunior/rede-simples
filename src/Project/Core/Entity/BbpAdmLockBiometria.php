<?php

namespace Project\Core\Entity;

/**
 * BbpAdmLockBiometria
 */
class BbpAdmLockBiometria
{
    /**
     * @var integer
     */
    private $bbpAdmLockBioCodigo;

    /**
     * @var string
     */
    private $bbpAdmLockBioNome;

    /**
     * @var string
     */
    private $bbpAdmLockBioEmail;

    /**
     * @var string
     */
    private $bbpAdmLockBioChave;

    /**
     * @var string
     */
    private $bbpAdmLockBioObs;

    /**
     * @var \DateTime
     */
    private $bbpAdmLockBioAcesso = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $bbhAdmLockBioImagem;

    /**
     * @var integer
     */
    private $bbpAdmLocCodigo;


    /**
     * Get bbpAdmLockBioCodigo
     *
     * @return integer
     */
    public function getBbpAdmLockBioCodigo()
    {
        return $this->bbpAdmLockBioCodigo;
    }

    /**
     * Set bbpAdmLockBioNome
     *
     * @param string $bbpAdmLockBioNome
     *
     * @return BbpAdmLockBiometria
     */
    public function setBbpAdmLockBioNome($bbpAdmLockBioNome)
    {
        $this->bbpAdmLockBioNome = $bbpAdmLockBioNome;

        return $this;
    }

    /**
     * Get bbpAdmLockBioNome
     *
     * @return string
     */
    public function getBbpAdmLockBioNome()
    {
        return $this->bbpAdmLockBioNome;
    }

    /**
     * Set bbpAdmLockBioEmail
     *
     * @param string $bbpAdmLockBioEmail
     *
     * @return BbpAdmLockBiometria
     */
    public function setBbpAdmLockBioEmail($bbpAdmLockBioEmail)
    {
        $this->bbpAdmLockBioEmail = $bbpAdmLockBioEmail;

        return $this;
    }

    /**
     * Get bbpAdmLockBioEmail
     *
     * @return string
     */
    public function getBbpAdmLockBioEmail()
    {
        return $this->bbpAdmLockBioEmail;
    }

    /**
     * Set bbpAdmLockBioChave
     *
     * @param string $bbpAdmLockBioChave
     *
     * @return BbpAdmLockBiometria
     */
    public function setBbpAdmLockBioChave($bbpAdmLockBioChave)
    {
        $this->bbpAdmLockBioChave = $bbpAdmLockBioChave;

        return $this;
    }

    /**
     * Get bbpAdmLockBioChave
     *
     * @return string
     */
    public function getBbpAdmLockBioChave()
    {
        return $this->bbpAdmLockBioChave;
    }

    /**
     * Set bbpAdmLockBioObs
     *
     * @param string $bbpAdmLockBioObs
     *
     * @return BbpAdmLockBiometria
     */
    public function setBbpAdmLockBioObs($bbpAdmLockBioObs)
    {
        $this->bbpAdmLockBioObs = $bbpAdmLockBioObs;

        return $this;
    }

    /**
     * Get bbpAdmLockBioObs
     *
     * @return string
     */
    public function getBbpAdmLockBioObs()
    {
        return $this->bbpAdmLockBioObs;
    }

    /**
     * Set bbpAdmLockBioAcesso
     *
     * @param \DateTime $bbpAdmLockBioAcesso
     *
     * @return BbpAdmLockBiometria
     */
    public function setBbpAdmLockBioAcesso($bbpAdmLockBioAcesso)
    {
        $this->bbpAdmLockBioAcesso = $bbpAdmLockBioAcesso;

        return $this;
    }

    /**
     * Get bbpAdmLockBioAcesso
     *
     * @return \DateTime
     */
    public function getBbpAdmLockBioAcesso()
    {
        return $this->bbpAdmLockBioAcesso;
    }

    /**
     * Set bbhAdmLockBioImagem
     *
     * @param string $bbhAdmLockBioImagem
     *
     * @return BbpAdmLockBiometria
     */
    public function setBbhAdmLockBioImagem($bbhAdmLockBioImagem)
    {
        $this->bbhAdmLockBioImagem = $bbhAdmLockBioImagem;

        return $this;
    }

    /**
     * Get bbhAdmLockBioImagem
     *
     * @return string
     */
    public function getBbhAdmLockBioImagem()
    {
        return $this->bbhAdmLockBioImagem;
    }

    /**
     * Set bbpAdmLocCodigo
     *
     * @param integer $bbpAdmLocCodigo
     *
     * @return BbpAdmLockBiometria
     */
    public function setBbpAdmLocCodigo($bbpAdmLocCodigo)
    {
        $this->bbpAdmLocCodigo = $bbpAdmLocCodigo;

        return $this;
    }

    /**
     * Get bbpAdmLocCodigo
     *
     * @return integer
     */
    public function getBbpAdmLocCodigo()
    {
        return $this->bbpAdmLocCodigo;
    }
}

