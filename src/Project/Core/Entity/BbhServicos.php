<?php

namespace Project\Core\Entity;

/**
 * BbhServicos
 */
class BbhServicos
{
    /**
     * @var integer
     */
    private $bbhSerCodigo;

    /**
     * @var \Project\Core\Entity\BbhFluxo
     */
    private $bbhFluCodigo;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigoPrestador;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigoTomador;


    /**
     * Get bbhSerCodigo
     *
     * @return integer
     */
    public function getBbhSerCodigo()
    {
        return $this->bbhSerCodigo;
    }

    /**
     * Set bbhFluCodigo
     *
     * @param \Project\Core\Entity\BbhFluxo $bbhFluCodigo
     *
     * @return BbhServicos
     */
    public function setBbhFluCodigo(\Project\Core\Entity\BbhFluxo $bbhFluCodigo = null)
    {
        $this->bbhFluCodigo = $bbhFluCodigo;

        return $this;
    }

    /**
     * Get bbhFluCodigo
     *
     * @return \Project\Core\Entity\BbhFluxo
     */
    public function getBbhFluCodigo()
    {
        return $this->bbhFluCodigo;
    }

    /**
     * Set bbhUsuCodigoPrestador
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigoPrestador
     *
     * @return BbhServicos
     */
    public function setBbhUsuCodigoPrestador(\Project\Core\Entity\BbhUsuario $bbhUsuCodigoPrestador = null)
    {
        $this->bbhUsuCodigoPrestador = $bbhUsuCodigoPrestador;

        return $this;
    }

    /**
     * Get bbhUsuCodigoPrestador
     *
     * @return \Project\Core\Entity\BbhUsuario
     */
    public function getBbhUsuCodigoPrestador()
    {
        return $this->bbhUsuCodigoPrestador;
    }

    /**
     * Set bbhUsuCodigoTomador
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigoTomador
     *
     * @return BbhServicos
     */
    public function setBbhUsuCodigoTomador(\Project\Core\Entity\BbhUsuario $bbhUsuCodigoTomador = null)
    {
        $this->bbhUsuCodigoTomador = $bbhUsuCodigoTomador;

        return $this;
    }

    /**
     * Get bbhUsuCodigoTomador
     *
     * @return \Project\Core\Entity\BbhUsuario
     */
    public function getBbhUsuCodigoTomador()
    {
        return $this->bbhUsuCodigoTomador;
    }
}

