<?php

namespace Project\Core\Entity;

/**
 * BbhUsuarioPerfil
 */
class BbhUsuarioPerfil
{
    /**
     * @var integer
     */
    private $bbhUsuPerCodigo;

    /**
     * @var \Project\Core\Entity\BbhPerfil
     */
    private $bbhPerCodigo;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigo;


    /**
     * Get bbhUsuPerCodigo
     *
     * @return integer
     */
    public function getBbhUsuPerCodigo()
    {
        return $this->bbhUsuPerCodigo;
    }

    /**
     * Set bbhPerCodigo
     *
     * @param \Project\Core\Entity\BbhPerfil $bbhPerCodigo
     *
     * @return BbhUsuarioPerfil
     */
    public function setBbhPerCodigo(\Project\Core\Entity\BbhPerfil $bbhPerCodigo = null)
    {
        $this->bbhPerCodigo = $bbhPerCodigo;

        return $this;
    }

    /**
     * Get bbhPerCodigo
     *
     * @return \Project\Core\Entity\BbhPerfil
     */
    public function getBbhPerCodigo()
    {
        return $this->bbhPerCodigo;
    }

    /**
     * Set bbhUsuCodigo
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigo
     *
     * @return BbhUsuarioPerfil
     */
    public function setBbhUsuCodigo(\Project\Core\Entity\BbhUsuario $bbhUsuCodigo = null)
    {
        $this->bbhUsuCodigo = $bbhUsuCodigo;

        return $this;
    }

    /**
     * Get bbhUsuCodigo
     *
     * @return \Project\Core\Entity\BbhUsuario
     */
    public function getBbhUsuCodigo()
    {
        return $this->bbhUsuCodigo;
    }
}

