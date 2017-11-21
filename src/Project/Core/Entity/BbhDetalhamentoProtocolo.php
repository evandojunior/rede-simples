<?php

namespace Project\Core\Entity;

/**
 * BbhDetalhamentoProtocolo
 */
class BbhDetalhamentoProtocolo
{
    /**
     * @var integer
     */
    private $bbhDetProCodigo;

    /**
     * @var \Project\Core\Entity\BbhProtocolos
     */
    private $bbhProCodigo;


    /**
     * Get bbhDetProCodigo
     *
     * @return integer
     */
    public function getBbhDetProCodigo()
    {
        return $this->bbhDetProCodigo;
    }

    /**
     * Set bbhProCodigo
     *
     * @param \Project\Core\Entity\BbhProtocolos $bbhProCodigo
     *
     * @return BbhDetalhamentoProtocolo
     */
    public function setBbhProCodigo(\Project\Core\Entity\BbhProtocolos $bbhProCodigo = null)
    {
        $this->bbhProCodigo = $bbhProCodigo;

        return $this;
    }

    /**
     * Get bbhProCodigo
     *
     * @return \Project\Core\Entity\BbhProtocolos
     */
    public function getBbhProCodigo()
    {
        return $this->bbhProCodigo;
    }
}

