<?php

namespace Project\Core\Entity;

/**
 * BbhPermissaoFluxo
 */
class BbhPermissaoFluxo
{
    /**
     * @var integer
     */
    private $bbhPerFluCodigo;

    /**
     * @var \Project\Core\Entity\BbhModeloFluxo
     */
    private $bbhModFluCodigo;

    /**
     * @var \Project\Core\Entity\BbhPerfil
     */
    private $bbhPerCodigo;


    /**
     * Get bbhPerFluCodigo
     *
     * @return integer
     */
    public function getBbhPerFluCodigo()
    {
        return $this->bbhPerFluCodigo;
    }

    /**
     * Set bbhModFluCodigo
     *
     * @param \Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo
     *
     * @return BbhPermissaoFluxo
     */
    public function setBbhModFluCodigo(\Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo = null)
    {
        $this->bbhModFluCodigo = $bbhModFluCodigo;

        return $this;
    }

    /**
     * Get bbhModFluCodigo
     *
     * @return \Project\Core\Entity\BbhModeloFluxo
     */
    public function getBbhModFluCodigo()
    {
        return $this->bbhModFluCodigo;
    }

    /**
     * Set bbhPerCodigo
     *
     * @param \Project\Core\Entity\BbhPerfil $bbhPerCodigo
     *
     * @return BbhPermissaoFluxo
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
}

