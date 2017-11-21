<?php

namespace Project\Core\Entity;

/**
 * BbpAdmLockFirewall
 */
class BbpAdmLockFirewall
{
    /**
     * @var integer
     */
    private $bbpAdmLockFirCodigo;

    /**
     * @var string
     */
    private $bbpAdmLockFirIp;

    /**
     * @var string
     */
    private $bbpAdmLockFirObs;


    /**
     * Get bbpAdmLockFirCodigo
     *
     * @return integer
     */
    public function getBbpAdmLockFirCodigo()
    {
        return $this->bbpAdmLockFirCodigo;
    }

    /**
     * Set bbpAdmLockFirIp
     *
     * @param string $bbpAdmLockFirIp
     *
     * @return BbpAdmLockFirewall
     */
    public function setBbpAdmLockFirIp($bbpAdmLockFirIp)
    {
        $this->bbpAdmLockFirIp = $bbpAdmLockFirIp;

        return $this;
    }

    /**
     * Get bbpAdmLockFirIp
     *
     * @return string
     */
    public function getBbpAdmLockFirIp()
    {
        return $this->bbpAdmLockFirIp;
    }

    /**
     * Set bbpAdmLockFirObs
     *
     * @param string $bbpAdmLockFirObs
     *
     * @return BbpAdmLockFirewall
     */
    public function setBbpAdmLockFirObs($bbpAdmLockFirObs)
    {
        $this->bbpAdmLockFirObs = $bbpAdmLockFirObs;

        return $this;
    }

    /**
     * Get bbpAdmLockFirObs
     *
     * @return string
     */
    public function getBbpAdmLockFirObs()
    {
        return $this->bbpAdmLockFirObs;
    }
}

