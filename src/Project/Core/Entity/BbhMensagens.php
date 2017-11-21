<?php

namespace Project\Core\Entity;

/**
 * BbhMensagens
 */
class BbhMensagens
{
    /**
     * @var integer
     */
    private $bbhMenCodigo;

    /**
     * @var \DateTime
     */
    private $bbhMenDataRecebida;

    /**
     * @var \DateTime
     */
    private $bbhMenDataLeitura;

    /**
     * @var string
     */
    private $bbhMenAssunto;

    /**
     * @var string
     */
    private $bbhMenMensagem;

    /**
     * @var integer
     */
    private $bbhFluCodigo;

    /**
     * @var integer
     */
    private $bbhMenExclusaoRemetente = '0';

    /**
     * @var integer
     */
    private $bbhMenExclusaoDestinatario = '0';

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigoDestin;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuCodigoRemet;


    /**
     * Get bbhMenCodigo
     *
     * @return integer
     */
    public function getBbhMenCodigo()
    {
        return $this->bbhMenCodigo;
    }

    /**
     * Set bbhMenDataRecebida
     *
     * @param \DateTime $bbhMenDataRecebida
     *
     * @return BbhMensagens
     */
    public function setBbhMenDataRecebida($bbhMenDataRecebida)
    {
        $this->bbhMenDataRecebida = $bbhMenDataRecebida;

        return $this;
    }

    /**
     * Get bbhMenDataRecebida
     *
     * @return \DateTime
     */
    public function getBbhMenDataRecebida()
    {
        return $this->bbhMenDataRecebida;
    }

    /**
     * Set bbhMenDataLeitura
     *
     * @param \DateTime $bbhMenDataLeitura
     *
     * @return BbhMensagens
     */
    public function setBbhMenDataLeitura($bbhMenDataLeitura)
    {
        $this->bbhMenDataLeitura = $bbhMenDataLeitura;

        return $this;
    }

    /**
     * Get bbhMenDataLeitura
     *
     * @return \DateTime
     */
    public function getBbhMenDataLeitura()
    {
        return $this->bbhMenDataLeitura;
    }

    /**
     * Set bbhMenAssunto
     *
     * @param string $bbhMenAssunto
     *
     * @return BbhMensagens
     */
    public function setBbhMenAssunto($bbhMenAssunto)
    {
        $this->bbhMenAssunto = $bbhMenAssunto;

        return $this;
    }

    /**
     * Get bbhMenAssunto
     *
     * @return string
     */
    public function getBbhMenAssunto()
    {
        return $this->bbhMenAssunto;
    }

    /**
     * Set bbhMenMensagem
     *
     * @param string $bbhMenMensagem
     *
     * @return BbhMensagens
     */
    public function setBbhMenMensagem($bbhMenMensagem)
    {
        $this->bbhMenMensagem = $bbhMenMensagem;

        return $this;
    }

    /**
     * Get bbhMenMensagem
     *
     * @return string
     */
    public function getBbhMenMensagem()
    {
        return $this->bbhMenMensagem;
    }

    /**
     * Set bbhFluCodigo
     *
     * @param integer $bbhFluCodigo
     *
     * @return BbhMensagens
     */
    public function setBbhFluCodigo($bbhFluCodigo)
    {
        $this->bbhFluCodigo = $bbhFluCodigo;

        return $this;
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
     * Set bbhMenExclusaoRemetente
     *
     * @param integer $bbhMenExclusaoRemetente
     *
     * @return BbhMensagens
     */
    public function setBbhMenExclusaoRemetente($bbhMenExclusaoRemetente)
    {
        $this->bbhMenExclusaoRemetente = $bbhMenExclusaoRemetente;

        return $this;
    }

    /**
     * Get bbhMenExclusaoRemetente
     *
     * @return integer
     */
    public function getBbhMenExclusaoRemetente()
    {
        return $this->bbhMenExclusaoRemetente;
    }

    /**
     * Set bbhMenExclusaoDestinatario
     *
     * @param integer $bbhMenExclusaoDestinatario
     *
     * @return BbhMensagens
     */
    public function setBbhMenExclusaoDestinatario($bbhMenExclusaoDestinatario)
    {
        $this->bbhMenExclusaoDestinatario = $bbhMenExclusaoDestinatario;

        return $this;
    }

    /**
     * Get bbhMenExclusaoDestinatario
     *
     * @return integer
     */
    public function getBbhMenExclusaoDestinatario()
    {
        return $this->bbhMenExclusaoDestinatario;
    }

    /**
     * Set bbhUsuCodigoDestin
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigoDestin
     *
     * @return BbhMensagens
     */
    public function setBbhUsuCodigoDestin(\Project\Core\Entity\BbhUsuario $bbhUsuCodigoDestin = null)
    {
        $this->bbhUsuCodigoDestin = $bbhUsuCodigoDestin;

        return $this;
    }

    /**
     * Get bbhUsuCodigoDestin
     *
     * @return \Project\Core\Entity\BbhUsuario
     */
    public function getBbhUsuCodigoDestin()
    {
        return $this->bbhUsuCodigoDestin;
    }

    /**
     * Set bbhUsuCodigoRemet
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuCodigoRemet
     *
     * @return BbhMensagens
     */
    public function setBbhUsuCodigoRemet(\Project\Core\Entity\BbhUsuario $bbhUsuCodigoRemet = null)
    {
        $this->bbhUsuCodigoRemet = $bbhUsuCodigoRemet;

        return $this;
    }

    /**
     * Get bbhUsuCodigoRemet
     *
     * @return \Project\Core\Entity\BbhUsuario
     */
    public function getBbhUsuCodigoRemet()
    {
        return $this->bbhUsuCodigoRemet;
    }
}

