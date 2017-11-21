<?php

namespace Project\Core\Entity;

/**
 * BbhDetalhamentoFluxo
 */
class BbhDetalhamentoFluxo
{
    /**
     * @var integer
     */
    private $bbhDetFluCodigo;

    /**
     * @var integer
     */
    private $bbhDetFluTabelaCriada = '0';

    /**
     * @var \Project\Core\Entity\BbhModeloFluxo
     */
    private $bbhModFluCodigo;


    /**
     * Get bbhDetFluCodigo
     *
     * @return integer
     */
    public function getBbhDetFluCodigo()
    {
        return $this->bbhDetFluCodigo;
    }

    /**
     * Set bbhDetFluTabelaCriada
     *
     * @param integer $bbhDetFluTabelaCriada
     *
     * @return BbhDetalhamentoFluxo
     */
    public function setBbhDetFluTabelaCriada($bbhDetFluTabelaCriada)
    {
        $this->bbhDetFluTabelaCriada = $bbhDetFluTabelaCriada;

        return $this;
    }

    /**
     * Get bbhDetFluTabelaCriada
     *
     * @return integer
     */
    public function getBbhDetFluTabelaCriada()
    {
        return $this->bbhDetFluTabelaCriada;
    }

    /**
     * Set bbhModFluCodigo
     *
     * @param \Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo
     *
     * @return BbhDetalhamentoFluxo
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
}

