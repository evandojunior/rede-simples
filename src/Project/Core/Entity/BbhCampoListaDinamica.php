<?php

namespace Project\Core\Entity;

/**
 * BbhCampoListaDinamica
 */
class BbhCampoListaDinamica
{
    /**
     * @var integer
     */
    private $bbhCamListCodigo;

    /**
     * @var string
     */
    private $bbhCamListMascara;

    /**
     * @var string
     */
    private $bbhCamListTitulo;

    /**
     * @var string
     */
    private $bbhCamListValor;

    /**
     * @var integer
     */
    private $bbhCamListOrdem;

    /**
     * @var string
     */
    private $bbhCamListTipo = 'S';


    /**
     * Get bbhCamListCodigo
     *
     * @return integer
     */
    public function getBbhCamListCodigo()
    {
        return $this->bbhCamListCodigo;
    }

    /**
     * Set bbhCamListMascara
     *
     * @param string $bbhCamListMascara
     *
     * @return BbhCampoListaDinamica
     */
    public function setBbhCamListMascara($bbhCamListMascara)
    {
        $this->bbhCamListMascara = $bbhCamListMascara;

        return $this;
    }

    /**
     * Get bbhCamListMascara
     *
     * @return string
     */
    public function getBbhCamListMascara()
    {
        return $this->bbhCamListMascara;
    }

    /**
     * Set bbhCamListTitulo
     *
     * @param string $bbhCamListTitulo
     *
     * @return BbhCampoListaDinamica
     */
    public function setBbhCamListTitulo($bbhCamListTitulo)
    {
        $this->bbhCamListTitulo = $bbhCamListTitulo;

        return $this;
    }

    /**
     * Get bbhCamListTitulo
     *
     * @return string
     */
    public function getBbhCamListTitulo()
    {
        return $this->bbhCamListTitulo;
    }

    /**
     * Set bbhCamListValor
     *
     * @param string $bbhCamListValor
     *
     * @return BbhCampoListaDinamica
     */
    public function setBbhCamListValor($bbhCamListValor)
    {
        $this->bbhCamListValor = $bbhCamListValor;

        return $this;
    }

    /**
     * Get bbhCamListValor
     *
     * @return string
     */
    public function getBbhCamListValor()
    {
        return $this->bbhCamListValor;
    }

    /**
     * Set bbhCamListOrdem
     *
     * @param integer $bbhCamListOrdem
     *
     * @return BbhCampoListaDinamica
     */
    public function setBbhCamListOrdem($bbhCamListOrdem)
    {
        $this->bbhCamListOrdem = $bbhCamListOrdem;

        return $this;
    }

    /**
     * Get bbhCamListOrdem
     *
     * @return integer
     */
    public function getBbhCamListOrdem()
    {
        return $this->bbhCamListOrdem;
    }

    /**
     * Set bbhCamListTipo
     *
     * @param string $bbhCamListTipo
     *
     * @return BbhCampoListaDinamica
     */
    public function setBbhCamListTipo($bbhCamListTipo)
    {
        $this->bbhCamListTipo = $bbhCamListTipo;

        return $this;
    }

    /**
     * Get bbhCamListTipo
     *
     * @return string
     */
    public function getBbhCamListTipo()
    {
        return $this->bbhCamListTipo;
    }
}

