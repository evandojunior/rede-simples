<?php

namespace Project\Core\Entity;

/**
 * BbhCampoIndicio
 */
class BbhCampoIndicio
{
    /**
     * @var integer
     */
    private $bbhCamIndCodigo;

    /**
     * @var string
     */
    private $bbhCamIndNome;

    /**
     * @var string
     */
    private $bbhCamIndTitulo;

    /**
     * @var string
     */
    private $bbhCamIndTipo;

    /**
     * @var string
     */
    private $bbhCamIndCuringa;

    /**
     * @var string
     */
    private $bbhCamIndDescricao;

    /**
     * @var string
     */
    private $bbhCamIndTamanho;

    /**
     * @var string
     */
    private $bbhCamIndDefault;

    /**
     * @var string
     */
    private $bbhCamIndDisponivel = '1';

    /**
     * @var string
     */
    private $bbhCamIndObrigatorio = '0';

    /**
     * @var string
     */
    private $bbhCamIndMesmalinha = '0';

    /**
     * @var string
     */
    private $bbhCamIndVisivel = '1';

    /**
     * @var integer
     */
    private $bbhCamIndLarguraTitulo = '100';

    /**
     * @var integer
     */
    private $bbhCamIndLarguraCampo = '100';

    /**
     * @var integer
     */
    private $bbhCamIndOrdem = '1';

    /**
     * @var string
     */
    private $bbhCamIndFixo = '0';

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bbhTipCodigo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bbhTipCodigo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get bbhCamIndCodigo
     *
     * @return integer
     */
    public function getBbhCamIndCodigo()
    {
        return $this->bbhCamIndCodigo;
    }

    /**
     * Set bbhCamIndNome
     *
     * @param string $bbhCamIndNome
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndNome($bbhCamIndNome)
    {
        $this->bbhCamIndNome = $bbhCamIndNome;

        return $this;
    }

    /**
     * Get bbhCamIndNome
     *
     * @return string
     */
    public function getBbhCamIndNome()
    {
        return $this->bbhCamIndNome;
    }

    /**
     * Set bbhCamIndTitulo
     *
     * @param string $bbhCamIndTitulo
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndTitulo($bbhCamIndTitulo)
    {
        $this->bbhCamIndTitulo = $bbhCamIndTitulo;

        return $this;
    }

    /**
     * Get bbhCamIndTitulo
     *
     * @return string
     */
    public function getBbhCamIndTitulo()
    {
        return $this->bbhCamIndTitulo;
    }

    /**
     * Set bbhCamIndTipo
     *
     * @param string $bbhCamIndTipo
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndTipo($bbhCamIndTipo)
    {
        $this->bbhCamIndTipo = $bbhCamIndTipo;

        return $this;
    }

    /**
     * Get bbhCamIndTipo
     *
     * @return string
     */
    public function getBbhCamIndTipo()
    {
        return $this->bbhCamIndTipo;
    }

    /**
     * Set bbhCamIndCuringa
     *
     * @param string $bbhCamIndCuringa
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndCuringa($bbhCamIndCuringa)
    {
        $this->bbhCamIndCuringa = $bbhCamIndCuringa;

        return $this;
    }

    /**
     * Get bbhCamIndCuringa
     *
     * @return string
     */
    public function getBbhCamIndCuringa()
    {
        return $this->bbhCamIndCuringa;
    }

    /**
     * Set bbhCamIndDescricao
     *
     * @param string $bbhCamIndDescricao
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndDescricao($bbhCamIndDescricao)
    {
        $this->bbhCamIndDescricao = $bbhCamIndDescricao;

        return $this;
    }

    /**
     * Get bbhCamIndDescricao
     *
     * @return string
     */
    public function getBbhCamIndDescricao()
    {
        return $this->bbhCamIndDescricao;
    }

    /**
     * Set bbhCamIndTamanho
     *
     * @param string $bbhCamIndTamanho
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndTamanho($bbhCamIndTamanho)
    {
        $this->bbhCamIndTamanho = $bbhCamIndTamanho;

        return $this;
    }

    /**
     * Get bbhCamIndTamanho
     *
     * @return string
     */
    public function getBbhCamIndTamanho()
    {
        return $this->bbhCamIndTamanho;
    }

    /**
     * Set bbhCamIndDefault
     *
     * @param string $bbhCamIndDefault
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndDefault($bbhCamIndDefault)
    {
        $this->bbhCamIndDefault = $bbhCamIndDefault;

        return $this;
    }

    /**
     * Get bbhCamIndDefault
     *
     * @return string
     */
    public function getBbhCamIndDefault()
    {
        return $this->bbhCamIndDefault;
    }

    /**
     * Set bbhCamIndDisponivel
     *
     * @param string $bbhCamIndDisponivel
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndDisponivel($bbhCamIndDisponivel)
    {
        $this->bbhCamIndDisponivel = $bbhCamIndDisponivel;

        return $this;
    }

    /**
     * Get bbhCamIndDisponivel
     *
     * @return string
     */
    public function getBbhCamIndDisponivel()
    {
        return $this->bbhCamIndDisponivel;
    }

    /**
     * Set bbhCamIndObrigatorio
     *
     * @param string $bbhCamIndObrigatorio
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndObrigatorio($bbhCamIndObrigatorio)
    {
        $this->bbhCamIndObrigatorio = $bbhCamIndObrigatorio;

        return $this;
    }

    /**
     * Get bbhCamIndObrigatorio
     *
     * @return string
     */
    public function getBbhCamIndObrigatorio()
    {
        return $this->bbhCamIndObrigatorio;
    }

    /**
     * Set bbhCamIndMesmalinha
     *
     * @param string $bbhCamIndMesmalinha
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndMesmalinha($bbhCamIndMesmalinha)
    {
        $this->bbhCamIndMesmalinha = $bbhCamIndMesmalinha;

        return $this;
    }

    /**
     * Get bbhCamIndMesmalinha
     *
     * @return string
     */
    public function getBbhCamIndMesmalinha()
    {
        return $this->bbhCamIndMesmalinha;
    }

    /**
     * Set bbhCamIndVisivel
     *
     * @param string $bbhCamIndVisivel
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndVisivel($bbhCamIndVisivel)
    {
        $this->bbhCamIndVisivel = $bbhCamIndVisivel;

        return $this;
    }

    /**
     * Get bbhCamIndVisivel
     *
     * @return string
     */
    public function getBbhCamIndVisivel()
    {
        return $this->bbhCamIndVisivel;
    }

    /**
     * Set bbhCamIndLarguraTitulo
     *
     * @param integer $bbhCamIndLarguraTitulo
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndLarguraTitulo($bbhCamIndLarguraTitulo)
    {
        $this->bbhCamIndLarguraTitulo = $bbhCamIndLarguraTitulo;

        return $this;
    }

    /**
     * Get bbhCamIndLarguraTitulo
     *
     * @return integer
     */
    public function getBbhCamIndLarguraTitulo()
    {
        return $this->bbhCamIndLarguraTitulo;
    }

    /**
     * Set bbhCamIndLarguraCampo
     *
     * @param integer $bbhCamIndLarguraCampo
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndLarguraCampo($bbhCamIndLarguraCampo)
    {
        $this->bbhCamIndLarguraCampo = $bbhCamIndLarguraCampo;

        return $this;
    }

    /**
     * Get bbhCamIndLarguraCampo
     *
     * @return integer
     */
    public function getBbhCamIndLarguraCampo()
    {
        return $this->bbhCamIndLarguraCampo;
    }

    /**
     * Set bbhCamIndOrdem
     *
     * @param integer $bbhCamIndOrdem
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndOrdem($bbhCamIndOrdem)
    {
        $this->bbhCamIndOrdem = $bbhCamIndOrdem;

        return $this;
    }

    /**
     * Get bbhCamIndOrdem
     *
     * @return integer
     */
    public function getBbhCamIndOrdem()
    {
        return $this->bbhCamIndOrdem;
    }

    /**
     * Set bbhCamIndFixo
     *
     * @param string $bbhCamIndFixo
     *
     * @return BbhCampoIndicio
     */
    public function setBbhCamIndFixo($bbhCamIndFixo)
    {
        $this->bbhCamIndFixo = $bbhCamIndFixo;

        return $this;
    }

    /**
     * Get bbhCamIndFixo
     *
     * @return string
     */
    public function getBbhCamIndFixo()
    {
        return $this->bbhCamIndFixo;
    }

    /**
     * Add bbhTipCodigo
     *
     * @param \Project\Core\Entity\BbhTipoIndicio $bbhTipCodigo
     *
     * @return BbhCampoIndicio
     */
    public function addBbhTipCodigo(\Project\Core\Entity\BbhTipoIndicio $bbhTipCodigo)
    {
        $this->bbhTipCodigo[] = $bbhTipCodigo;

        return $this;
    }

    /**
     * Remove bbhTipCodigo
     *
     * @param \Project\Core\Entity\BbhTipoIndicio $bbhTipCodigo
     */
    public function removeBbhTipCodigo(\Project\Core\Entity\BbhTipoIndicio $bbhTipCodigo)
    {
        $this->bbhTipCodigo->removeElement($bbhTipCodigo);
    }

    /**
     * Get bbhTipCodigo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBbhTipCodigo()
    {
        return $this->bbhTipCodigo;
    }
}

