<?php

namespace Project\Core\Entity;

/**
 * BbpAdmLockAssinatura
 */
class BbpAdmLockAssinatura
{
    /**
     * @var integer
     */
    private $bbpAdmLockAssCodigo;

    /**
     * @var string
     */
    private $bbpAdmLockAssNome;

    /**
     * @var string
     */
    private $bbpAdmLockAssEmail = '';

    /**
     * @var integer
     */
    private $bbpAdmLockAssCpf = '0';

    /**
     * @var \DateTime
     */
    private $bbpAdmLockAssAcesso = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $bbpAdmLockAssObs;


    /**
     * Get bbpAdmLockAssCodigo
     *
     * @return integer
     */
    public function getBbpAdmLockAssCodigo()
    {
        return $this->bbpAdmLockAssCodigo;
    }

    /**
     * Set bbpAdmLockAssNome
     *
     * @param string $bbpAdmLockAssNome
     *
     * @return BbpAdmLockAssinatura
     */
    public function setBbpAdmLockAssNome($bbpAdmLockAssNome)
    {
        $this->bbpAdmLockAssNome = $bbpAdmLockAssNome;

        return $this;
    }

    /**
     * Get bbpAdmLockAssNome
     *
     * @return string
     */
    public function getBbpAdmLockAssNome()
    {
        return $this->bbpAdmLockAssNome;
    }

    /**
     * Set bbpAdmLockAssEmail
     *
     * @param string $bbpAdmLockAssEmail
     *
     * @return BbpAdmLockAssinatura
     */
    public function setBbpAdmLockAssEmail($bbpAdmLockAssEmail)
    {
        $this->bbpAdmLockAssEmail = $bbpAdmLockAssEmail;

        return $this;
    }

    /**
     * Get bbpAdmLockAssEmail
     *
     * @return string
     */
    public function getBbpAdmLockAssEmail()
    {
        return $this->bbpAdmLockAssEmail;
    }

    /**
     * Set bbpAdmLockAssCpf
     *
     * @param integer $bbpAdmLockAssCpf
     *
     * @return BbpAdmLockAssinatura
     */
    public function setBbpAdmLockAssCpf($bbpAdmLockAssCpf)
    {
        $this->bbpAdmLockAssCpf = $bbpAdmLockAssCpf;

        return $this;
    }

    /**
     * Get bbpAdmLockAssCpf
     *
     * @return integer
     */
    public function getBbpAdmLockAssCpf()
    {
        return $this->bbpAdmLockAssCpf;
    }

    /**
     * Set bbpAdmLockAssAcesso
     *
     * @param \DateTime $bbpAdmLockAssAcesso
     *
     * @return BbpAdmLockAssinatura
     */
    public function setBbpAdmLockAssAcesso($bbpAdmLockAssAcesso)
    {
        $this->bbpAdmLockAssAcesso = $bbpAdmLockAssAcesso;

        return $this;
    }

    /**
     * Get bbpAdmLockAssAcesso
     *
     * @return \DateTime
     */
    public function getBbpAdmLockAssAcesso()
    {
        return $this->bbpAdmLockAssAcesso;
    }

    /**
     * Set bbpAdmLockAssObs
     *
     * @param string $bbpAdmLockAssObs
     *
     * @return BbpAdmLockAssinatura
     */
    public function setBbpAdmLockAssObs($bbpAdmLockAssObs)
    {
        $this->bbpAdmLockAssObs = $bbpAdmLockAssObs;

        return $this;
    }

    /**
     * Get bbpAdmLockAssObs
     *
     * @return string
     */
    public function getBbpAdmLockAssObs()
    {
        return $this->bbpAdmLockAssObs;
    }
}

