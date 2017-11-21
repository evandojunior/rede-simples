<?php

namespace Project\Core\Entity;

/**
 * BbhPerfil
 */
class BbhPerfil
{
    /**
     * @var integer
     */
    private $bbhPerCodigo;

    /**
     * @var string
     */
    private $bbhPerNome;

    /**
     * @var string
     */
    private $bbhPerObservacao;

    /**
     * @var string
     */
    private $bbhPerFluxo = '0';

    /**
     * @var string
     */
    private $bbhPerMensagem = '0';

    /**
     * @var string
     */
    private $bbhPerArquivos = '0';

    /**
     * @var string
     */
    private $bbhPerEquipe = '0';

    /**
     * @var string
     */
    private $bbhPerTarefas = '0';

    /**
     * @var string
     */
    private $bbhPerRelatorios = '0';

    /**
     * @var string
     */
    private $bbhPerProtocolos = '0';

    /**
     * @var string
     */
    private $bbhPerCentralIndicios = '0';

    /**
     * @var string
     */
    private $bbhPerBi = '0';

    /**
     * @var string
     */
    private $bbhPerGeo = '0';

    /**
     * @var string
     */
    private $bbhPerPeoplerank = '0';

    /**
     * @var string
     */
    private $bbhPerCorp = '0';

    /**
     * @var string
     */
    private $bbhPerPub = '0';

    /**
     * @var integer
     */
    private $bbhPerMatriz = '0';

    /**
     * @var integer
     */
    private $bbhPerUnidade = '0';


    /**
     * Get bbhPerCodigo
     *
     * @return integer
     */
    public function getBbhPerCodigo()
    {
        return $this->bbhPerCodigo;
    }

    /**
     * Set bbhPerNome
     *
     * @param string $bbhPerNome
     *
     * @return BbhPerfil
     */
    public function setBbhPerNome($bbhPerNome)
    {
        $this->bbhPerNome = $bbhPerNome;

        return $this;
    }

    /**
     * Get bbhPerNome
     *
     * @return string
     */
    public function getBbhPerNome()
    {
        return $this->bbhPerNome;
    }

    /**
     * Set bbhPerObservacao
     *
     * @param string $bbhPerObservacao
     *
     * @return BbhPerfil
     */
    public function setBbhPerObservacao($bbhPerObservacao)
    {
        $this->bbhPerObservacao = $bbhPerObservacao;

        return $this;
    }

    /**
     * Get bbhPerObservacao
     *
     * @return string
     */
    public function getBbhPerObservacao()
    {
        return $this->bbhPerObservacao;
    }

    /**
     * Set bbhPerFluxo
     *
     * @param string $bbhPerFluxo
     *
     * @return BbhPerfil
     */
    public function setBbhPerFluxo($bbhPerFluxo)
    {
        $this->bbhPerFluxo = $bbhPerFluxo;

        return $this;
    }

    /**
     * Get bbhPerFluxo
     *
     * @return string
     */
    public function getBbhPerFluxo()
    {
        return $this->bbhPerFluxo;
    }

    /**
     * Set bbhPerMensagem
     *
     * @param string $bbhPerMensagem
     *
     * @return BbhPerfil
     */
    public function setBbhPerMensagem($bbhPerMensagem)
    {
        $this->bbhPerMensagem = $bbhPerMensagem;

        return $this;
    }

    /**
     * Get bbhPerMensagem
     *
     * @return string
     */
    public function getBbhPerMensagem()
    {
        return $this->bbhPerMensagem;
    }

    /**
     * Set bbhPerArquivos
     *
     * @param string $bbhPerArquivos
     *
     * @return BbhPerfil
     */
    public function setBbhPerArquivos($bbhPerArquivos)
    {
        $this->bbhPerArquivos = $bbhPerArquivos;

        return $this;
    }

    /**
     * Get bbhPerArquivos
     *
     * @return string
     */
    public function getBbhPerArquivos()
    {
        return $this->bbhPerArquivos;
    }

    /**
     * Set bbhPerEquipe
     *
     * @param string $bbhPerEquipe
     *
     * @return BbhPerfil
     */
    public function setBbhPerEquipe($bbhPerEquipe)
    {
        $this->bbhPerEquipe = $bbhPerEquipe;

        return $this;
    }

    /**
     * Get bbhPerEquipe
     *
     * @return string
     */
    public function getBbhPerEquipe()
    {
        return $this->bbhPerEquipe;
    }

    /**
     * Set bbhPerTarefas
     *
     * @param string $bbhPerTarefas
     *
     * @return BbhPerfil
     */
    public function setBbhPerTarefas($bbhPerTarefas)
    {
        $this->bbhPerTarefas = $bbhPerTarefas;

        return $this;
    }

    /**
     * Get bbhPerTarefas
     *
     * @return string
     */
    public function getBbhPerTarefas()
    {
        return $this->bbhPerTarefas;
    }

    /**
     * Set bbhPerRelatorios
     *
     * @param string $bbhPerRelatorios
     *
     * @return BbhPerfil
     */
    public function setBbhPerRelatorios($bbhPerRelatorios)
    {
        $this->bbhPerRelatorios = $bbhPerRelatorios;

        return $this;
    }

    /**
     * Get bbhPerRelatorios
     *
     * @return string
     */
    public function getBbhPerRelatorios()
    {
        return $this->bbhPerRelatorios;
    }

    /**
     * Set bbhPerProtocolos
     *
     * @param string $bbhPerProtocolos
     *
     * @return BbhPerfil
     */
    public function setBbhPerProtocolos($bbhPerProtocolos)
    {
        $this->bbhPerProtocolos = $bbhPerProtocolos;

        return $this;
    }

    /**
     * Get bbhPerProtocolos
     *
     * @return string
     */
    public function getBbhPerProtocolos()
    {
        return $this->bbhPerProtocolos;
    }

    /**
     * Set bbhPerCentralIndicios
     *
     * @param string $bbhPerCentralIndicios
     *
     * @return BbhPerfil
     */
    public function setBbhPerCentralIndicios($bbhPerCentralIndicios)
    {
        $this->bbhPerCentralIndicios = $bbhPerCentralIndicios;

        return $this;
    }

    /**
     * Get bbhPerCentralIndicios
     *
     * @return string
     */
    public function getBbhPerCentralIndicios()
    {
        return $this->bbhPerCentralIndicios;
    }

    /**
     * Set bbhPerBi
     *
     * @param string $bbhPerBi
     *
     * @return BbhPerfil
     */
    public function setBbhPerBi($bbhPerBi)
    {
        $this->bbhPerBi = $bbhPerBi;

        return $this;
    }

    /**
     * Get bbhPerBi
     *
     * @return string
     */
    public function getBbhPerBi()
    {
        return $this->bbhPerBi;
    }

    /**
     * Set bbhPerGeo
     *
     * @param string $bbhPerGeo
     *
     * @return BbhPerfil
     */
    public function setBbhPerGeo($bbhPerGeo)
    {
        $this->bbhPerGeo = $bbhPerGeo;

        return $this;
    }

    /**
     * Get bbhPerGeo
     *
     * @return string
     */
    public function getBbhPerGeo()
    {
        return $this->bbhPerGeo;
    }

    /**
     * Set bbhPerPeoplerank
     *
     * @param string $bbhPerPeoplerank
     *
     * @return BbhPerfil
     */
    public function setBbhPerPeoplerank($bbhPerPeoplerank)
    {
        $this->bbhPerPeoplerank = $bbhPerPeoplerank;

        return $this;
    }

    /**
     * Get bbhPerPeoplerank
     *
     * @return string
     */
    public function getBbhPerPeoplerank()
    {
        return $this->bbhPerPeoplerank;
    }

    /**
     * Set bbhPerCorp
     *
     * @param string $bbhPerCorp
     *
     * @return BbhPerfil
     */
    public function setBbhPerCorp($bbhPerCorp)
    {
        $this->bbhPerCorp = $bbhPerCorp;

        return $this;
    }

    /**
     * Get bbhPerCorp
     *
     * @return string
     */
    public function getBbhPerCorp()
    {
        return $this->bbhPerCorp;
    }

    /**
     * Set bbhPerPub
     *
     * @param string $bbhPerPub
     *
     * @return BbhPerfil
     */
    public function setBbhPerPub($bbhPerPub)
    {
        $this->bbhPerPub = $bbhPerPub;

        return $this;
    }

    /**
     * Get bbhPerPub
     *
     * @return string
     */
    public function getBbhPerPub()
    {
        return $this->bbhPerPub;
    }

    /**
     * Set bbhPerMatriz
     *
     * @param integer $bbhPerMatriz
     *
     * @return BbhPerfil
     */
    public function setBbhPerMatriz($bbhPerMatriz)
    {
        $this->bbhPerMatriz = $bbhPerMatriz;

        return $this;
    }

    /**
     * Get bbhPerMatriz
     *
     * @return integer
     */
    public function getBbhPerMatriz()
    {
        return $this->bbhPerMatriz;
    }

    /**
     * Set bbhPerUnidade
     *
     * @param integer $bbhPerUnidade
     *
     * @return BbhPerfil
     */
    public function setBbhPerUnidade($bbhPerUnidade)
    {
        $this->bbhPerUnidade = $bbhPerUnidade;

        return $this;
    }

    /**
     * Get bbhPerUnidade
     *
     * @return integer
     */
    public function getBbhPerUnidade()
    {
        return $this->bbhPerUnidade;
    }
}

