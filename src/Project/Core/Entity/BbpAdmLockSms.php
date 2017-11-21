<?php

namespace Project\Core\Entity;

/**
 * BbpAdmLockSms
 */
class BbpAdmLockSms
{
    /**
     * @var integer
     */
    private $bbpAdmLockSmsCodigo;

    /**
     * @var string
     */
    private $bbpAdmLockSmsNome;

    /**
     * @var string
     */
    private $bbpAdmLockSmsEmail;

    /**
     * @var string
     */
    private $bbpAdmLockSmsChave = '0';

    /**
     * @var string
     */
    private $bbpAdmLockSmsCelular;

    /**
     * @var string
     */
    private $bbpAdmLockSmsObservacao;

    /**
     * @var \DateTime
     */
    private $bbpAdmLockSmsAcesso;


    /**
     * Get bbpAdmLockSmsCodigo
     *
     * @return integer
     */
    public function getBbpAdmLockSmsCodigo()
    {
        return $this->bbpAdmLockSmsCodigo;
    }

    /**
     * Set bbpAdmLockSmsNome
     *
     * @param string $bbpAdmLockSmsNome
     *
     * @return BbpAdmLockSms
     */
    public function setBbpAdmLockSmsNome($bbpAdmLockSmsNome)
    {
        $this->bbpAdmLockSmsNome = $bbpAdmLockSmsNome;

        return $this;
    }

    /**
     * Get bbpAdmLockSmsNome
     *
     * @return string
     */
    public function getBbpAdmLockSmsNome()
    {
        return $this->bbpAdmLockSmsNome;
    }

    /**
     * Set bbpAdmLockSmsEmail
     *
     * @param string $bbpAdmLockSmsEmail
     *
     * @return BbpAdmLockSms
     */
    public function setBbpAdmLockSmsEmail($bbpAdmLockSmsEmail)
    {
        $this->bbpAdmLockSmsEmail = $bbpAdmLockSmsEmail;

        return $this;
    }

    /**
     * Get bbpAdmLockSmsEmail
     *
     * @return string
     */
    public function getBbpAdmLockSmsEmail()
    {
        return $this->bbpAdmLockSmsEmail;
    }

    /**
     * Set bbpAdmLockSmsChave
     *
     * @param string $bbpAdmLockSmsChave
     *
     * @return BbpAdmLockSms
     */
    public function setBbpAdmLockSmsChave($bbpAdmLockSmsChave)
    {
        $this->bbpAdmLockSmsChave = $bbpAdmLockSmsChave;

        return $this;
    }

    /**
     * Get bbpAdmLockSmsChave
     *
     * @return string
     */
    public function getBbpAdmLockSmsChave()
    {
        return $this->bbpAdmLockSmsChave;
    }

    /**
     * Set bbpAdmLockSmsCelular
     *
     * @param string $bbpAdmLockSmsCelular
     *
     * @return BbpAdmLockSms
     */
    public function setBbpAdmLockSmsCelular($bbpAdmLockSmsCelular)
    {
        $this->bbpAdmLockSmsCelular = $bbpAdmLockSmsCelular;

        return $this;
    }

    /**
     * Get bbpAdmLockSmsCelular
     *
     * @return string
     */
    public function getBbpAdmLockSmsCelular()
    {
        return $this->bbpAdmLockSmsCelular;
    }

    /**
     * Set bbpAdmLockSmsObservacao
     *
     * @param string $bbpAdmLockSmsObservacao
     *
     * @return BbpAdmLockSms
     */
    public function setBbpAdmLockSmsObservacao($bbpAdmLockSmsObservacao)
    {
        $this->bbpAdmLockSmsObservacao = $bbpAdmLockSmsObservacao;

        return $this;
    }

    /**
     * Get bbpAdmLockSmsObservacao
     *
     * @return string
     */
    public function getBbpAdmLockSmsObservacao()
    {
        return $this->bbpAdmLockSmsObservacao;
    }

    /**
     * Set bbpAdmLockSmsAcesso
     *
     * @param \DateTime $bbpAdmLockSmsAcesso
     *
     * @return BbpAdmLockSms
     */
    public function setBbpAdmLockSmsAcesso($bbpAdmLockSmsAcesso)
    {
        $this->bbpAdmLockSmsAcesso = $bbpAdmLockSmsAcesso;

        return $this;
    }

    /**
     * Get bbpAdmLockSmsAcesso
     *
     * @return \DateTime
     */
    public function getBbpAdmLockSmsAcesso()
    {
        return $this->bbpAdmLockSmsAcesso;
    }
}

