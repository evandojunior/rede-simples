<?php

namespace Project\Core\Entity;

/**
 * BbhAdministrativo
 */
class BbhAdministrativo
{
    /**
     * @var integer
     */
    private $bbhAdmCodigo;

    /**
     * @var string
     */
    private $bbhAdmIdentificacao;

    /**
     * @var string
     */
    private $bbhAdmNome;

    /**
     * @var \DateTime
     */
    private $bbhAdmDataNascimento;

    /**
     * @var string
     */
    private $bbhAdmSexo;

    /**
     * @var \DateTime
     */
    private $bbhAdmUltimoacesso;

    /**
     * @var integer
     */
    private $bbhAdmAtivo;

    /**
     * @var integer
     */
    private $bbhAdmNivel = '484';


    /**
     * Get bbhAdmCodigo
     *
     * @return integer
     */
    public function getBbhAdmCodigo()
    {
        return $this->bbhAdmCodigo;
    }

    /**
     * Set bbhAdmIdentificacao
     *
     * @param string $bbhAdmIdentificacao
     *
     * @return BbhAdministrativo
     */
    public function setBbhAdmIdentificacao($bbhAdmIdentificacao)
    {
        $this->bbhAdmIdentificacao = $bbhAdmIdentificacao;

        return $this;
    }

    /**
     * Get bbhAdmIdentificacao
     *
     * @return string
     */
    public function getBbhAdmIdentificacao()
    {
        return $this->bbhAdmIdentificacao;
    }

    /**
     * Set bbhAdmNome
     *
     * @param string $bbhAdmNome
     *
     * @return BbhAdministrativo
     */
    public function setBbhAdmNome($bbhAdmNome)
    {
        $this->bbhAdmNome = $bbhAdmNome;

        return $this;
    }

    /**
     * Get bbhAdmNome
     *
     * @return string
     */
    public function getBbhAdmNome()
    {
        return $this->bbhAdmNome;
    }

    /**
     * Set bbhAdmDataNascimento
     *
     * @param \DateTime $bbhAdmDataNascimento
     *
     * @return BbhAdministrativo
     */
    public function setBbhAdmDataNascimento($bbhAdmDataNascimento)
    {
        $this->bbhAdmDataNascimento = $bbhAdmDataNascimento;

        return $this;
    }

    /**
     * Get bbhAdmDataNascimento
     *
     * @return \DateTime
     */
    public function getBbhAdmDataNascimento()
    {
        return $this->bbhAdmDataNascimento;
    }

    /**
     * Set bbhAdmSexo
     *
     * @param string $bbhAdmSexo
     *
     * @return BbhAdministrativo
     */
    public function setBbhAdmSexo($bbhAdmSexo)
    {
        $this->bbhAdmSexo = $bbhAdmSexo;

        return $this;
    }

    /**
     * Get bbhAdmSexo
     *
     * @return string
     */
    public function getBbhAdmSexo()
    {
        return $this->bbhAdmSexo;
    }

    /**
     * Set bbhAdmUltimoacesso
     *
     * @param \DateTime $bbhAdmUltimoacesso
     *
     * @return BbhAdministrativo
     */
    public function setBbhAdmUltimoacesso($bbhAdmUltimoacesso)
    {
        $this->bbhAdmUltimoacesso = $bbhAdmUltimoacesso;

        return $this;
    }

    /**
     * Get bbhAdmUltimoacesso
     *
     * @return \DateTime
     */
    public function getBbhAdmUltimoacesso()
    {
        return $this->bbhAdmUltimoacesso;
    }

    /**
     * Set bbhAdmAtivo
     *
     * @param integer $bbhAdmAtivo
     *
     * @return BbhAdministrativo
     */
    public function setBbhAdmAtivo($bbhAdmAtivo)
    {
        $this->bbhAdmAtivo = $bbhAdmAtivo;

        return $this;
    }

    /**
     * Get bbhAdmAtivo
     *
     * @return integer
     */
    public function getBbhAdmAtivo()
    {
        return $this->bbhAdmAtivo;
    }

    /**
     * Set bbhAdmNivel
     *
     * @param integer $bbhAdmNivel
     *
     * @return BbhAdministrativo
     */
    public function setBbhAdmNivel($bbhAdmNivel)
    {
        $this->bbhAdmNivel = $bbhAdmNivel;

        return $this;
    }

    /**
     * Get bbhAdmNivel
     *
     * @return integer
     */
    public function getBbhAdmNivel()
    {
        return $this->bbhAdmNivel;
    }
}

