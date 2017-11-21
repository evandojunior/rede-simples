<?php

namespace Project\Core\Entity;

/**
 * BbhStatusAtividade
 */
class BbhStatusAtividade
{
    /**
     * @var integer
     */
    private $bbhStaAtiCodigo;

    /**
     * @var string
     */
    private $bbhStaAtiNome;

    /**
     * @var integer
     */
    private $bbhStaAtiPeso;

    /**
     * @var string
     */
    private $bbhStaAtiObservacao;


    /**
     * Get bbhStaAtiCodigo
     *
     * @return integer
     */
    public function getBbhStaAtiCodigo()
    {
        return $this->bbhStaAtiCodigo;
    }

    /**
     * Set bbhStaAtiNome
     *
     * @param string $bbhStaAtiNome
     *
     * @return BbhStatusAtividade
     */
    public function setBbhStaAtiNome($bbhStaAtiNome)
    {
        $this->bbhStaAtiNome = $bbhStaAtiNome;

        return $this;
    }

    /**
     * Get bbhStaAtiNome
     *
     * @return string
     */
    public function getBbhStaAtiNome()
    {
        return $this->bbhStaAtiNome;
    }

    /**
     * Set bbhStaAtiPeso
     *
     * @param integer $bbhStaAtiPeso
     *
     * @return BbhStatusAtividade
     */
    public function setBbhStaAtiPeso($bbhStaAtiPeso)
    {
        $this->bbhStaAtiPeso = $bbhStaAtiPeso;

        return $this;
    }

    /**
     * Get bbhStaAtiPeso
     *
     * @return integer
     */
    public function getBbhStaAtiPeso()
    {
        return $this->bbhStaAtiPeso;
    }

    /**
     * Set bbhStaAtiObservacao
     *
     * @param string $bbhStaAtiObservacao
     *
     * @return BbhStatusAtividade
     */
    public function setBbhStaAtiObservacao($bbhStaAtiObservacao)
    {
        $this->bbhStaAtiObservacao = $bbhStaAtiObservacao;

        return $this;
    }

    /**
     * Get bbhStaAtiObservacao
     *
     * @return string
     */
    public function getBbhStaAtiObservacao()
    {
        return $this->bbhStaAtiObservacao;
    }
}

