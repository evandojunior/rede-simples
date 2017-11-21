<?php

namespace Project\Core\Entity;

/**
 * BbpAdmLockAplicacao
 */
class BbpAdmLockAplicacao
{
    /**
     * @var integer
     */
    private $bbpAdmLockCodigo;

    /**
     * @var \Project\Core\Entity\BbpAdmAplicacao
     */
    private $bbpAdmAplCodigo;

    /**
     * @var \Project\Core\Entity\BbpAdmLock
     */
    private $bbpAdmLocCodigo;


    /**
     * Get bbpAdmLockCodigo
     *
     * @return integer
     */
    public function getBbpAdmLockCodigo()
    {
        return $this->bbpAdmLockCodigo;
    }

    /**
     * Set bbpAdmAplCodigo
     *
     * @param \Project\Core\Entity\BbpAdmAplicacao $bbpAdmAplCodigo
     *
     * @return BbpAdmLockAplicacao
     */
    public function setBbpAdmAplCodigo(\Project\Core\Entity\BbpAdmAplicacao $bbpAdmAplCodigo = null)
    {
        $this->bbpAdmAplCodigo = $bbpAdmAplCodigo;

        return $this;
    }

    /**
     * Get bbpAdmAplCodigo
     *
     * @return \Project\Core\Entity\BbpAdmAplicacao
     */
    public function getBbpAdmAplCodigo()
    {
        return $this->bbpAdmAplCodigo;
    }

    /**
     * Set bbpAdmLocCodigo
     *
     * @param \Project\Core\Entity\BbpAdmLock $bbpAdmLocCodigo
     *
     * @return BbpAdmLockAplicacao
     */
    public function setBbpAdmLocCodigo(\Project\Core\Entity\BbpAdmLock $bbpAdmLocCodigo = null)
    {
        $this->bbpAdmLocCodigo = $bbpAdmLocCodigo;

        return $this;
    }

    /**
     * Get bbpAdmLocCodigo
     *
     * @return \Project\Core\Entity\BbpAdmLock
     */
    public function getBbpAdmLocCodigo()
    {
        return $this->bbpAdmLocCodigo;
    }
}

