<?php

namespace Project\Core\Entity;

/**
 * BbhFluxo
 */
class BbhFluxo
{
    /**
     * @var integer
     */
    private $bbhFluCodigo;

    /**
     * @var string
     */
    private $bbhFluObservacao;

    /**
     * @var \DateTime
     */
    private $bbhFluDataIniciado;

    /**
     * @var string
     */
    private $bbhFluTitulo;

    /**
     * @var integer
     */
    private $bbhFluTarefaPai;

    /**
     * @var integer
     */
    private $bbhProtocoloReferencia;

    /**
     * @var string
     */
    private $bbhFluOculto = '0';

    /**
     * @var string
     */
    private $bbhFluFinalizado = '0';

    /**
     * @var integer
     */
    private $bbhFluAutonumeracao;

    /**
     * @var integer
     */
    private $bbhFluAnonumeracao;

    /**
     * @var string
     */
    private $bbhFluCodigobarras;

    /**
     * @var \Project\Core\Entity\BbhModeloFluxo
     */
    private $bbhModFluCodigo;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bbhFluCodigoP;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bbhFluCodigoP = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get bbhFluCodigo
     *
     * @return integer
     */
    public function getBbhFluCodigo()
    {
        return $this->bbhFluCodigo;
    }

    /**
     * Set bbhFluObservacao
     *
     * @param string $bbhFluObservacao
     *
     * @return BbhFluxo
     */
    public function setBbhFluObservacao($bbhFluObservacao)
    {
        $this->bbhFluObservacao = $bbhFluObservacao;

        return $this;
    }

    /**
     * Get bbhFluObservacao
     *
     * @return string
     */
    public function getBbhFluObservacao()
    {
        return $this->bbhFluObservacao;
    }

    /**
     * Set bbhFluDataIniciado
     *
     * @param \DateTime $bbhFluDataIniciado
     *
     * @return BbhFluxo
     */
    public function setBbhFluDataIniciado($bbhFluDataIniciado)
    {
        $this->bbhFluDataIniciado = $bbhFluDataIniciado;

        return $this;
    }

    /**
     * Get bbhFluDataIniciado
     *
     * @return \DateTime
     */
    public function getBbhFluDataIniciado()
    {
        return $this->bbhFluDataIniciado;
    }

    /**
     * Set bbhFluTitulo
     *
     * @param string $bbhFluTitulo
     *
     * @return BbhFluxo
     */
    public function setBbhFluTitulo($bbhFluTitulo)
    {
        $this->bbhFluTitulo = $bbhFluTitulo;

        return $this;
    }

    /**
     * Get bbhFluTitulo
     *
     * @return string
     */
    public function getBbhFluTitulo()
    {
        return $this->bbhFluTitulo;
    }

    /**
     * Set bbhFluTarefaPai
     *
     * @param integer $bbhFluTarefaPai
     *
     * @return BbhFluxo
     */
    public function setBbhFluTarefaPai($bbhFluTarefaPai)
    {
        $this->bbhFluTarefaPai = $bbhFluTarefaPai;

        return $this;
    }

    /**
     * Get bbhFluTarefaPai
     *
     * @return integer
     */
    public function getBbhFluTarefaPai()
    {
        return $this->bbhFluTarefaPai;
    }

    /**
     * @return int
     */
    public function getBbhProtocoloReferencia()
    {
        return $this->bbhProtocoloReferencia;
    }

    /**
     * @param int $bbhProtocoloReferencia
     */
    public function setBbhProtocoloReferencia($bbhProtocoloReferencia)
    {
        $this->bbhProtocoloReferencia = $bbhProtocoloReferencia;
    }

    /**
     * Set bbhFluOculto
     *
     * @param string $bbhFluOculto
     *
     * @return BbhFluxo
     */
    public function setBbhFluOculto($bbhFluOculto)
    {
        $this->bbhFluOculto = $bbhFluOculto;

        return $this;
    }

    /**
     * Get bbhFluOculto
     *
     * @return string
     */
    public function getBbhFluOculto()
    {
        return $this->bbhFluOculto;
    }

    /**
     * Set bbhFluFinalizado
     *
     * @param string $bbhFluFinalizado
     *
     * @return BbhFluxo
     */
    public function setBbhFluFinalizado($bbhFluFinalizado)
    {
        $this->bbhFluFinalizado = $bbhFluFinalizado;

        return $this;
    }

    /**
     * Get bbhFluFinalizado
     *
     * @return string
     */
    public function getBbhFluFinalizado()
    {
        return $this->bbhFluFinalizado;
    }

    /**
     * Set bbhFluAutonumeracao
     *
     * @param integer $bbhFluAutonumeracao
     *
     * @return BbhFluxo
     */
    public function setBbhFluAutonumeracao($bbhFluAutonumeracao)
    {
        $this->bbhFluAutonumeracao = $bbhFluAutonumeracao;

        return $this;
    }

    /**
     * Get bbhFluAutonumeracao
     *
     * @return integer
     */
    public function getBbhFluAutonumeracao()
    {
        return $this->bbhFluAutonumeracao;
    }

    /**
     * Set bbhFluAnonumeracao
     *
     * @param integer $bbhFluAnonumeracao
     *
     * @return BbhFluxo
     */
    public function setBbhFluAnonumeracao($bbhFluAnonumeracao)
    {
        $this->bbhFluAnonumeracao = $bbhFluAnonumeracao;

        return $this;
    }

    /**
     * Get bbhFluAnonumeracao
     *
     * @return integer
     */
    public function getBbhFluAnonumeracao()
    {
        return $this->bbhFluAnonumeracao;
    }

    /**
     * Set bbhFluCodigobarras
     *
     * @param string $bbhFluCodigobarras
     *
     * @return BbhFluxo
     */
    public function setBbhFluCodigobarras($bbhFluCodigobarras)
    {
        $this->bbhFluCodigobarras = $bbhFluCodigobarras;

        return $this;
    }

    /**
     * Get bbhFluCodigobarras
     *
     * @return string
     */
    public function getBbhFluCodigobarras()
    {
        return $this->bbhFluCodigobarras;
    }

    /**
     * Set bbhModFluCodigo
     *
     * @param \Project\Core\Entity\BbhModeloFluxo $bbhModFluCodigo
     *
     * @return BbhFluxo
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
     * Set bbhUsuCodigo
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigo
     *
     * @return BbhFluxo
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

    /**
     * Add bbhFluCodigoP
     *
     * @param \Project\Core\Entity\BbhFluxo $bbhFluCodigoP
     *
     * @return BbhFluxo
     */
    public function addBbhFluCodigoP(\Project\Core\Entity\BbhFluxo $bbhFluCodigoP)
    {
        $this->bbhFluCodigoP[] = $bbhFluCodigoP;

        return $this;
    }

    /**
     * Remove bbhFluCodigoP
     *
     * @param \Project\Core\Entity\BbhFluxo $bbhFluCodigoP
     */
    public function removeBbhFluCodigoP(\Project\Core\Entity\BbhFluxo $bbhFluCodigoP)
    {
        $this->bbhFluCodigoP->removeElement($bbhFluCodigoP);
    }

    /**
     * Get bbhFluCodigoP
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBbhFluCodigoP()
    {
        return $this->bbhFluCodigoP;
    }
}

