<?php

namespace Project\Core\Entity;

/**
 * BbpAdmLockLoginsenha
 */
class BbpAdmLockLoginsenha
{
    /**
     * @var integer
     */
    private $bbpAdmLockLogCodigo;

    /**
     * @var string
     */
    private $bbpAdmLockLogNome;

    /**
     * @var string
     */
    private $bbpAdmLockLogEmail = '';

    /**
     * @var string
     */
    private $bbpAdmLockLogSenha = '';

    /**
     * @var \DateTime
     */
    private $bbpAdmLockLogNasc;

    /**
     * @var string
     */
    private $bbpAdmLockLogCargo;

    /**
     * @var integer
     */
    private $bbhAdmLockLogNivel = '784';

    /**
     * @var string
     */
    private $bbhAdmLockLogSexo = 'm';

    /**
     * @var \DateTime
     */
    private $bbpAdmLockLogAcesso = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $bbpAdmLockLogObs;

    /**
     * @var string
     */
    private $bbpAdmLockLogAtivo = '1';


    /**
     * Get bbpAdmLockLogCodigo
     *
     * @return integer
     */
    public function getBbpAdmLockLogCodigo()
    {
        return $this->bbpAdmLockLogCodigo;
    }

    /**
     * Set bbpAdmLockLogNome
     *
     * @param string $bbpAdmLockLogNome
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogNome($bbpAdmLockLogNome)
    {
        $this->bbpAdmLockLogNome = $bbpAdmLockLogNome;

        return $this;
    }

    /**
     * Get bbpAdmLockLogNome
     *
     * @return string
     */
    public function getBbpAdmLockLogNome()
    {
        return $this->bbpAdmLockLogNome;
    }

    /**
     * Set bbpAdmLockLogEmail
     *
     * @param string $bbpAdmLockLogEmail
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogEmail($bbpAdmLockLogEmail)
    {
        $this->bbpAdmLockLogEmail = $bbpAdmLockLogEmail;

        return $this;
    }

    /**
     * Get bbpAdmLockLogEmail
     *
     * @return string
     */
    public function getBbpAdmLockLogEmail()
    {
        return $this->bbpAdmLockLogEmail;
    }

    /**
     * Set bbpAdmLockLogSenha
     *
     * @param string $bbpAdmLockLogSenha
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogSenha($bbpAdmLockLogSenha)
    {
        $this->bbpAdmLockLogSenha = $bbpAdmLockLogSenha;

        return $this;
    }

    /**
     * Get bbpAdmLockLogSenha
     *
     * @return string
     */
    public function getBbpAdmLockLogSenha()
    {
        return $this->bbpAdmLockLogSenha;
    }

    /**
     * Set bbpAdmLockLogNasc
     *
     * @param \DateTime $bbpAdmLockLogNasc
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogNasc($bbpAdmLockLogNasc)
    {
        $this->bbpAdmLockLogNasc = $bbpAdmLockLogNasc;

        return $this;
    }

    /**
     * Get bbpAdmLockLogNasc
     *
     * @return \DateTime
     */
    public function getBbpAdmLockLogNasc()
    {
        return $this->bbpAdmLockLogNasc;
    }

    /**
     * Set bbpAdmLockLogCargo
     *
     * @param string $bbpAdmLockLogCargo
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogCargo($bbpAdmLockLogCargo)
    {
        $this->bbpAdmLockLogCargo = $bbpAdmLockLogCargo;

        return $this;
    }

    /**
     * Get bbpAdmLockLogCargo
     *
     * @return string
     */
    public function getBbpAdmLockLogCargo()
    {
        return $this->bbpAdmLockLogCargo;
    }

    /**
     * Set bbhAdmLockLogNivel
     *
     * @param integer $bbhAdmLockLogNivel
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbhAdmLockLogNivel($bbhAdmLockLogNivel)
    {
        $this->bbhAdmLockLogNivel = $bbhAdmLockLogNivel;

        return $this;
    }

    /**
     * Get bbhAdmLockLogNivel
     *
     * @return integer
     */
    public function getBbhAdmLockLogNivel()
    {
        return $this->bbhAdmLockLogNivel;
    }

    /**
     * Set bbhAdmLockLogSexo
     *
     * @param string $bbhAdmLockLogSexo
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbhAdmLockLogSexo($bbhAdmLockLogSexo)
    {
        $this->bbhAdmLockLogSexo = $bbhAdmLockLogSexo;

        return $this;
    }

    /**
     * Get bbhAdmLockLogSexo
     *
     * @return string
     */
    public function getBbhAdmLockLogSexo()
    {
        return $this->bbhAdmLockLogSexo;
    }

    /**
     * Set bbpAdmLockLogAcesso
     *
     * @param \DateTime $bbpAdmLockLogAcesso
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogAcesso($bbpAdmLockLogAcesso)
    {
        $this->bbpAdmLockLogAcesso = $bbpAdmLockLogAcesso;

        return $this;
    }

    /**
     * Get bbpAdmLockLogAcesso
     *
     * @return \DateTime
     */
    public function getBbpAdmLockLogAcesso()
    {
        return $this->bbpAdmLockLogAcesso;
    }

    /**
     * Set bbpAdmLockLogObs
     *
     * @param string $bbpAdmLockLogObs
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogObs($bbpAdmLockLogObs)
    {
        $this->bbpAdmLockLogObs = $bbpAdmLockLogObs;

        return $this;
    }

    /**
     * Get bbpAdmLockLogObs
     *
     * @return string
     */
    public function getBbpAdmLockLogObs()
    {
        return $this->bbpAdmLockLogObs;
    }

    /**
     * Set bbpAdmLockLogAtivo
     *
     * @param string $bbpAdmLockLogAtivo
     *
     * @return BbpAdmLockLoginsenha
     */
    public function setBbpAdmLockLogAtivo($bbpAdmLockLogAtivo)
    {
        $this->bbpAdmLockLogAtivo = $bbpAdmLockLogAtivo;

        return $this;
    }

    /**
     * Get bbpAdmLockLogAtivo
     *
     * @return string
     */
    public function getBbpAdmLockLogAtivo()
    {
        return $this->bbpAdmLockLogAtivo;
    }
}

