<?php

namespace Project\Core\Entity;

/**
 * BbhTipoIndicio
 */
class BbhTipoIndicio
{
    /**
     * @var integer
     */
    private $bbhTipCodigo;

    /**
     * @var string
     */
    private $bbhTipNome;

    /**
     * @var string
     */
    private $bbhTipDescricao;

    /**
     * @var integer
     */
    private $bbhTipAtivo = '1';

    /**
     * @var integer
     */
    private $bbhTipoCorp = '1';

    /**
     * @var \Project\Core\Entity\BbhDepartamento
     */
    private $bbhDepCodigo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bbhCamIndCodigo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bbhCamIndCodigo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get bbhTipCodigo
     *
     * @return integer
     */
    public function getBbhTipCodigo()
    {
        return $this->bbhTipCodigo;
    }

    /**
     * Set bbhTipNome
     *
     * @param string $bbhTipNome
     *
     * @return BbhTipoIndicio
     */
    public function setBbhTipNome($bbhTipNome)
    {
        $this->bbhTipNome = $bbhTipNome;

        return $this;
    }

    /**
     * Get bbhTipNome
     *
     * @return string
     */
    public function getBbhTipNome()
    {
        return $this->bbhTipNome;
    }

    /**
     * Set bbhTipDescricao
     *
     * @param string $bbhTipDescricao
     *
     * @return BbhTipoIndicio
     */
    public function setBbhTipDescricao($bbhTipDescricao)
    {
        $this->bbhTipDescricao = $bbhTipDescricao;

        return $this;
    }

    /**
     * Get bbhTipDescricao
     *
     * @return string
     */
    public function getBbhTipDescricao()
    {
        return $this->bbhTipDescricao;
    }

    /**
     * Set bbhTipAtivo
     *
     * @param integer $bbhTipAtivo
     *
     * @return BbhTipoIndicio
     */
    public function setBbhTipAtivo($bbhTipAtivo)
    {
        $this->bbhTipAtivo = $bbhTipAtivo;

        return $this;
    }

    /**
     * Get bbhTipAtivo
     *
     * @return integer
     */
    public function getBbhTipAtivo()
    {
        return $this->bbhTipAtivo;
    }

    /**
     * Set bbhTipoCorp
     *
     * @param integer $bbhTipoCorp
     *
     * @return BbhTipoIndicio
     */
    public function setBbhTipoCorp($bbhTipoCorp)
    {
        $this->bbhTipoCorp = $bbhTipoCorp;

        return $this;
    }

    /**
     * Get bbhTipoCorp
     *
     * @return integer
     */
    public function getBbhTipoCorp()
    {
        return $this->bbhTipoCorp;
    }

    /**
     * Set bbhDepCodigo
     *
     * @param \Project\Core\Entity\BbhDepartamento $bbhDepCodigo
     *
     * @return BbhTipoIndicio
     */
    public function setBbhDepCodigo(\Project\Core\Entity\BbhDepartamento $bbhDepCodigo = null)
    {
        $this->bbhDepCodigo = $bbhDepCodigo;

        return $this;
    }

    /**
     * Get bbhDepCodigo
     *
     * @return \Project\Core\Entity\BbhDepartamento
     */
    public function getBbhDepCodigo()
    {
        return $this->bbhDepCodigo;
    }

    /**
     * Add bbhCamIndCodigo
     *
     * @param \Project\Core\Entity\BbhCampoIndicio $bbhCamIndCodigo
     *
     * @return BbhTipoIndicio
     */
    public function addBbhCamIndCodigo(\Project\Core\Entity\BbhCampoIndicio $bbhCamIndCodigo)
    {
        $this->bbhCamIndCodigo[] = $bbhCamIndCodigo;

        return $this;
    }

    /**
     * Remove bbhCamIndCodigo
     *
     * @param \Project\Core\Entity\BbhCampoIndicio $bbhCamIndCodigo
     */
    public function removeBbhCamIndCodigo(\Project\Core\Entity\BbhCampoIndicio $bbhCamIndCodigo)
    {
        $this->bbhCamIndCodigo->removeElement($bbhCamIndCodigo);
    }

    /**
     * Get bbhCamIndCodigo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBbhCamIndCodigo()
    {
        return $this->bbhCamIndCodigo;
    }
}

