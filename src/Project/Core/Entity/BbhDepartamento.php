<?php

namespace Project\Core\Entity;

/**
 * BbhDepartamento
 */
class BbhDepartamento
{
    /**
     * @var integer
     */
    private $bbhDepCodigo;

    /**
     * @var string
     */
    private $bbhDepNome;

    /**
     * @var string
     */
    private $bbhDepObs;

    /**
     * @param int $bbhDepCodigo
     */
    public function setBbhDepCodigo($bbhDepCodigo)
    {
        $this->bbhDepCodigo = $bbhDepCodigo;
    }

    /**
     * Get bbhDepCodigo
     *
     * @return integer
     */
    public function getBbhDepCodigo()
    {
        return $this->bbhDepCodigo;
    }

    /**
     * Set bbhDepNome
     *
     * @param string $bbhDepNome
     *
     * @return BbhDepartamento
     */
    public function setBbhDepNome($bbhDepNome)
    {
        $this->bbhDepNome = $bbhDepNome;

        return $this;
    }

    /**
     * Get bbhDepNome
     *
     * @return string
     */
    public function getBbhDepNome()
    {
        return $this->bbhDepNome;
    }

    /**
     * Set bbhDepObs
     *
     * @param string $bbhDepObs
     *
     * @return BbhDepartamento
     */
    public function setBbhDepObs($bbhDepObs)
    {
        $this->bbhDepObs = $bbhDepObs;

        return $this;
    }

    /**
     * Get bbhDepObs
     *
     * @return string
     */
    public function getBbhDepObs()
    {
        return $this->bbhDepObs;
    }
}

