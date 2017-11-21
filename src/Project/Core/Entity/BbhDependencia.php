<?php

namespace Project\Core\Entity;

/**
 * BbhDependencia
 */
class BbhDependencia
{
    /**
     * @var integer
     */
    private $bbhPreModAtiCodigo;

    /**
     * @var string
     */
    private $bbhPreModAtiObservacao;

    /**
     * @var \Project\Core\Entity\BbhModeloAtividade
     */
    private $bbhModeloAtividadePredecessora;

    /**
     * @var \Project\Core\Entity\BbhModeloAtividade
     */
    private $bbhModeloAtividadeSucessora;


    /**
     * Get bbhPreModAtiCodigo
     *
     * @return integer
     */
    public function getBbhPreModAtiCodigo()
    {
        return $this->bbhPreModAtiCodigo;
    }

    /**
     * Set bbhPreModAtiObservacao
     *
     * @param string $bbhPreModAtiObservacao
     *
     * @return BbhDependencia
     */
    public function setBbhPreModAtiObservacao($bbhPreModAtiObservacao)
    {
        $this->bbhPreModAtiObservacao = $bbhPreModAtiObservacao;

        return $this;
    }

    /**
     * Get bbhPreModAtiObservacao
     *
     * @return string
     */
    public function getBbhPreModAtiObservacao()
    {
        return $this->bbhPreModAtiObservacao;
    }

    /**
     * Set bbhModeloAtividadePredecessora
     *
     * @param \Project\Core\Entity\BbhModeloAtividade $bbhModeloAtividadePredecessora
     *
     * @return BbhDependencia
     */
    public function setBbhModeloAtividadePredecessora(\Project\Core\Entity\BbhModeloAtividade $bbhModeloAtividadePredecessora = null)
    {
        $this->bbhModeloAtividadePredecessora = $bbhModeloAtividadePredecessora;

        return $this;
    }

    /**
     * Get bbhModeloAtividadePredecessora
     *
     * @return \Project\Core\Entity\BbhModeloAtividade
     */
    public function getBbhModeloAtividadePredecessora()
    {
        return $this->bbhModeloAtividadePredecessora;
    }

    /**
     * Set bbhModeloAtividadeSucessora
     *
     * @param \Project\Core\Entity\BbhModeloAtividade $bbhModeloAtividadeSucessora
     *
     * @return BbhDependencia
     */
    public function setBbhModeloAtividadeSucessora(\Project\Core\Entity\BbhModeloAtividade $bbhModeloAtividadeSucessora = null)
    {
        $this->bbhModeloAtividadeSucessora = $bbhModeloAtividadeSucessora;

        return $this;
    }

    /**
     * Get bbhModeloAtividadeSucessora
     *
     * @return \Project\Core\Entity\BbhModeloAtividade
     */
    public function getBbhModeloAtividadeSucessora()
    {
        return $this->bbhModeloAtividadeSucessora;
    }
}

