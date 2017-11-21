<?php

namespace Project\Core\Entity;

/**
 * BbpAdmAutenticacao
 */
class BbpAdmAutenticacao
{
    /**
     * @var integer
     */
    private $bbpAdmAutCodigo;

    /**
     * @var string
     */
    private $bbpAdmAutUsuario;

    /**
     * @var string
     */
    private $bbpAdmAutSenha;

    /**
     * @var string
     */
    private $bbpAdmAutIp;

    /**
     * @var \DateTime
     */
    private $bbpAdmAcesso = '0000-00-00 00:00:00';

    /**
     * @var integer
     */
    private $bbpAdmNivel = '774';

    /**
     * @var string
     */
    private $bbpAdmUser = '0';


    /**
     * Get bbpAdmAutCodigo
     *
     * @return integer
     */
    public function getBbpAdmAutCodigo()
    {
        return $this->bbpAdmAutCodigo;
    }

    /**
     * Set bbpAdmAutUsuario
     *
     * @param string $bbpAdmAutUsuario
     *
     * @return BbpAdmAutenticacao
     */
    public function setBbpAdmAutUsuario($bbpAdmAutUsuario)
    {
        $this->bbpAdmAutUsuario = $bbpAdmAutUsuario;

        return $this;
    }

    /**
     * Get bbpAdmAutUsuario
     *
     * @return string
     */
    public function getBbpAdmAutUsuario()
    {
        return $this->bbpAdmAutUsuario;
    }

    /**
     * Set bbpAdmAutSenha
     *
     * @param string $bbpAdmAutSenha
     *
     * @return BbpAdmAutenticacao
     */
    public function setBbpAdmAutSenha($bbpAdmAutSenha)
    {
        $this->bbpAdmAutSenha = $bbpAdmAutSenha;

        return $this;
    }

    /**
     * Get bbpAdmAutSenha
     *
     * @return string
     */
    public function getBbpAdmAutSenha()
    {
        return $this->bbpAdmAutSenha;
    }

    /**
     * Set bbpAdmAutIp
     *
     * @param string $bbpAdmAutIp
     *
     * @return BbpAdmAutenticacao
     */
    public function setBbpAdmAutIp($bbpAdmAutIp)
    {
        $this->bbpAdmAutIp = $bbpAdmAutIp;

        return $this;
    }

    /**
     * Get bbpAdmAutIp
     *
     * @return string
     */
    public function getBbpAdmAutIp()
    {
        return $this->bbpAdmAutIp;
    }

    /**
     * Set bbpAdmAcesso
     *
     * @param \DateTime $bbpAdmAcesso
     *
     * @return BbpAdmAutenticacao
     */
    public function setBbpAdmAcesso($bbpAdmAcesso)
    {
        $this->bbpAdmAcesso = $bbpAdmAcesso;

        return $this;
    }

    /**
     * Get bbpAdmAcesso
     *
     * @return \DateTime
     */
    public function getBbpAdmAcesso()
    {
        return $this->bbpAdmAcesso;
    }

    /**
     * Set bbpAdmNivel
     *
     * @param integer $bbpAdmNivel
     *
     * @return BbpAdmAutenticacao
     */
    public function setBbpAdmNivel($bbpAdmNivel)
    {
        $this->bbpAdmNivel = $bbpAdmNivel;

        return $this;
    }

    /**
     * Get bbpAdmNivel
     *
     * @return integer
     */
    public function getBbpAdmNivel()
    {
        return $this->bbpAdmNivel;
    }

    /**
     * Set bbpAdmUser
     *
     * @param string $bbpAdmUser
     *
     * @return BbpAdmAutenticacao
     */
    public function setBbpAdmUser($bbpAdmUser)
    {
        $this->bbpAdmUser = $bbpAdmUser;

        return $this;
    }

    /**
     * Get bbpAdmUser
     *
     * @return string
     */
    public function getBbpAdmUser()
    {
        return $this->bbpAdmUser;
    }
}

