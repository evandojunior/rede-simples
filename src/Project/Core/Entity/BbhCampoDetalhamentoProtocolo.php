<?php

namespace Project\Core\Entity;

/**
 * BbhCampoDetalhamentoProtocolo
 */
class BbhCampoDetalhamentoProtocolo
{
    /**
     * @var integer
     */
    private $bbhCamDetProCodigo;

    /**
     * @var string
     */
    private $bbhCamDetProNome;

    /**
     * @var string
     */
    private $bbhCamDetProTitulo;

    /**
     * @var string
     */
    private $bbhCamDetProTipo;

    /**
     * @var string
     */
    private $bbhCamDetProCuringa;

    /**
     * @var string
     */
    private $bbhCamDetProDescricao;

    /**
     * @var string
     */
    private $bbhCamDetProTamanho;

    /**
     * @var string
     */
    private $bbhCamDetProDefault;

    /**
     * @var string
     */
    private $bbhCamDetProDisponivel = '1';

    /**
     * @var string
     */
    private $bbhCamDetProObrigatorio = '0';

    /**
     * @var string
     */
    private $bbhCamDetProVisivel = '1';

    /**
     * @var integer
     */
    private $bbhCamDetProOrdem = '1';

    /**
     * @var integer
     */
    private $bbhCamDetProFixo = '0';

    /**
     * @var integer
     */
    private $bbhCamDetProPreencherAposReceber = '0';


    /**
     * Get bbhCamDetProCodigo
     *
     * @return integer
     */
    public function getBbhCamDetProCodigo()
    {
        return $this->bbhCamDetProCodigo;
    }

    /**
     * Set bbhCamDetProNome
     *
     * @param string $bbhCamDetProNome
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProNome($bbhCamDetProNome)
    {
        $this->bbhCamDetProNome = $bbhCamDetProNome;

        return $this;
    }

    /**
     * Get bbhCamDetProNome
     *
     * @return string
     */
    public function getBbhCamDetProNome()
    {
        return $this->bbhCamDetProNome;
    }

    /**
     * Set bbhCamDetProTitulo
     *
     * @param string $bbhCamDetProTitulo
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProTitulo($bbhCamDetProTitulo)
    {
        $this->bbhCamDetProTitulo = $bbhCamDetProTitulo;

        return $this;
    }

    /**
     * Get bbhCamDetProTitulo
     *
     * @return string
     */
    public function getBbhCamDetProTitulo()
    {
        return $this->bbhCamDetProTitulo;
    }

    /**
     * Set bbhCamDetProTipo
     *
     * @param string $bbhCamDetProTipo
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProTipo($bbhCamDetProTipo)
    {
        $this->bbhCamDetProTipo = $bbhCamDetProTipo;

        return $this;
    }

    /**
     * Get bbhCamDetProTipo
     *
     * @return string
     */
    public function getBbhCamDetProTipo()
    {
        return $this->bbhCamDetProTipo;
    }

    /**
     * Set bbhCamDetProCuringa
     *
     * @param string $bbhCamDetProCuringa
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProCuringa($bbhCamDetProCuringa)
    {
        $this->bbhCamDetProCuringa = $bbhCamDetProCuringa;

        return $this;
    }

    /**
     * Get bbhCamDetProCuringa
     *
     * @return string
     */
    public function getBbhCamDetProCuringa()
    {
        return $this->bbhCamDetProCuringa;
    }

    /**
     * Set bbhCamDetProDescricao
     *
     * @param string $bbhCamDetProDescricao
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProDescricao($bbhCamDetProDescricao)
    {
        $this->bbhCamDetProDescricao = $bbhCamDetProDescricao;

        return $this;
    }

    /**
     * Get bbhCamDetProDescricao
     *
     * @return string
     */
    public function getBbhCamDetProDescricao()
    {
        return $this->bbhCamDetProDescricao;
    }

    /**
     * Set bbhCamDetProTamanho
     *
     * @param string $bbhCamDetProTamanho
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProTamanho($bbhCamDetProTamanho)
    {
        $this->bbhCamDetProTamanho = $bbhCamDetProTamanho;

        return $this;
    }

    /**
     * Get bbhCamDetProTamanho
     *
     * @return string
     */
    public function getBbhCamDetProTamanho()
    {
        return $this->bbhCamDetProTamanho;
    }

    /**
     * Set bbhCamDetProDefault
     *
     * @param string $bbhCamDetProDefault
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProDefault($bbhCamDetProDefault)
    {
        $this->bbhCamDetProDefault = $bbhCamDetProDefault;

        return $this;
    }

    /**
     * Get bbhCamDetProDefault
     *
     * @return string
     */
    public function getBbhCamDetProDefault()
    {
        return $this->bbhCamDetProDefault;
    }

    /**
     * Set bbhCamDetProDisponivel
     *
     * @param string $bbhCamDetProDisponivel
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProDisponivel($bbhCamDetProDisponivel)
    {
        $this->bbhCamDetProDisponivel = $bbhCamDetProDisponivel;

        return $this;
    }

    /**
     * Get bbhCamDetProDisponivel
     *
     * @return string
     */
    public function getBbhCamDetProDisponivel()
    {
        return $this->bbhCamDetProDisponivel;
    }

    /**
     * Set bbhCamDetProObrigatorio
     *
     * @param string $bbhCamDetProObrigatorio
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProObrigatorio($bbhCamDetProObrigatorio)
    {
        $this->bbhCamDetProObrigatorio = $bbhCamDetProObrigatorio;

        return $this;
    }

    /**
     * Get bbhCamDetProObrigatorio
     *
     * @return string
     */
    public function getBbhCamDetProObrigatorio()
    {
        return $this->bbhCamDetProObrigatorio;
    }

    /**
     * Set bbhCamDetProVisivel
     *
     * @param string $bbhCamDetProVisivel
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProVisivel($bbhCamDetProVisivel)
    {
        $this->bbhCamDetProVisivel = $bbhCamDetProVisivel;

        return $this;
    }

    /**
     * Get bbhCamDetProVisivel
     *
     * @return string
     */
    public function getBbhCamDetProVisivel()
    {
        return $this->bbhCamDetProVisivel;
    }

    /**
     * Set bbhCamDetProOrdem
     *
     * @param integer $bbhCamDetProOrdem
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProOrdem($bbhCamDetProOrdem)
    {
        $this->bbhCamDetProOrdem = $bbhCamDetProOrdem;

        return $this;
    }

    /**
     * Get bbhCamDetProOrdem
     *
     * @return integer
     */
    public function getBbhCamDetProOrdem()
    {
        return $this->bbhCamDetProOrdem;
    }

    /**
     * Set bbhCamDetProFixo
     *
     * @param integer $bbhCamDetProFixo
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProFixo($bbhCamDetProFixo)
    {
        $this->bbhCamDetProFixo = $bbhCamDetProFixo;

        return $this;
    }

    /**
     * Get bbhCamDetProFixo
     *
     * @return integer
     */
    public function getBbhCamDetProFixo()
    {
        return $this->bbhCamDetProFixo;
    }

    /**
     * Set bbhCamDetProPreencherAposReceber
     *
     * @param integer $bbhCamDetProPreencherAposReceber
     *
     * @return BbhCampoDetalhamentoProtocolo
     */
    public function setBbhCamDetProPreencherAposReceber($bbhCamDetProPreencherAposReceber)
    {
        $this->bbhCamDetProPreencherAposReceber = $bbhCamDetProPreencherAposReceber;

        return $this;
    }

    /**
     * Get bbhCamDetProPreencherAposReceber
     *
     * @return integer
     */
    public function getBbhCamDetProPreencherAposReceber()
    {
        return $this->bbhCamDetProPreencherAposReceber;
    }
}

