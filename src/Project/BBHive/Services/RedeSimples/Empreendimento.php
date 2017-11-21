<?php

namespace Project\BBHive\Services\RedeSimples;

use Project\Core\Helper\ArrayHelper;

class Empreendimento
{
    protected $protocolo;
    protected $numeroProcesso;
    protected $dataGravacaoCnpj;
    protected $cnpj;
    protected $nire;
    protected $nomeEmpresa;
    protected $objetoSocial;
    protected $porte;
    protected $capitalSocial;
    protected $dataInicioAtividade;
    protected $nomeRequerente;
    protected $cpfRequerente;
    protected $dddTelefoneRequerente;
    protected $telefoneRequerente;
    protected $emailRequerente;
    protected $dataAssinatura;
    protected $nomeLogradouro;
    protected $numeroLogradouro;
    protected $complemento;
    protected $bairro;
    protected $municipio;
    protected $cep;
    protected $uf;
    protected $pais;

    public $listFields = [
        'protocolo' => '@bbh_pro_identificacao@',
        'numeroProcesso' => 'rede-simples-numeroProcesso',
        'dataGravacaoCnpj' => 'rede-simples-dataGravacaoCnpj',
        'cnpj' => 'rede-simples-cnpj',
        'nire' => 'rede-simples-nire',
        'nomeEmpresa' => '@bbh_pro_assunto@',
        'objetoSocial' => 'rede-simples-objetoSocial',
        'porte' => 'rede-simples-porte',
        'capitalSocial' => 'rede-simples-capitalSocial',
        'dataInicioAtividade' => 'rede-simples-dataInicioAtividade',
        'nomeRequerente' => 'rede-simples-nomeRequerente',
        'cpfRequerente' => 'rede-simples-cpfRequerente',
        'dddTelefoneRequerente' => 'rede-simples-dddTelefoneRequerente',
        'telefoneRequerente' => 'rede-simples-telefoneRequerente',
        'emailRequerente' => 'rede-simples-emailRequerente',
        'dataAssinatura' => 'rede-simples-dataAssinatura',
        'nomeLogradouro' => 'rede-simples-nomeLogradouro',
        'numeroLogradouro' => 'rede-simples-numeroLogradouro',
        'complemento' => 'rede-simples-complemento',
        'bairro' => 'rede-simples-bairro',
        'municipio' => 'rede-simples-municipio',
        'cep' => 'rede-simples-cep',
        'uf' => 'rede-simples-uf',
        'pais' => 'rede-simples-pais'
    ];

    /**
     * @return mixed
     */
    public function getProtocolo()
    {
        return $this->protocolo;
    }

    /**
     * @param mixed $protocolo
     */
    public function setProtocolo($protocolo)
    {
        $this->protocolo = $protocolo;
    }

    /**
     * @return mixed
     */
    public function getNumeroProcesso()
    {
        return $this->numeroProcesso;
    }

    /**
     * @param mixed $numeroProcesso
     */
    public function setNumeroProcesso($numeroProcesso)
    {
        $this->numeroProcesso = $numeroProcesso;
    }

    /**
     * @return mixed
     */
    public function getDataGravacaoCnpj()
    {
        return $this->dataGravacaoCnpj;
    }

    /**
     * @param mixed $dataGravacaoCnpj
     */
    public function setDataGravacaoCnpj($dataGravacaoCnpj)
    {
        $dataGravacaoCnpj = !empty($dataGravacaoCnpj) ? (\DateTime::createFromFormat("d/m/Y H:i:s", $dataGravacaoCnpj)) : NULL;
        $this->dataGravacaoCnpj = $dataGravacaoCnpj instanceof \DateTime ? $dataGravacaoCnpj->format('Y-m-d') : NULL;
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return mixed
     */
    public function getNire()
    {
        return $this->nire;
    }

    /**
     * @param mixed $nire
     */
    public function setNire($nire)
    {
        $this->nire = $nire;
    }

    /**
     * @return mixed
     */
    public function getNomeEmpresa()
    {
        return $this->nomeEmpresa;
    }

    /**
     * @param mixed $nomeEmpresa
     */
    public function setNomeEmpresa($nomeEmpresa)
    {
        $this->nomeEmpresa = $nomeEmpresa;
    }

    /**
     * @return mixed
     */
    public function getObjetoSocial()
    {
        return $this->objetoSocial;
    }

    /**
     * @param mixed $objetoSocial
     */
    public function setObjetoSocial($objetoSocial)
    {
        $this->objetoSocial = $objetoSocial;
    }

    /**
     * @return mixed
     */
    public function getPorte()
    {
        return $this->porte;
    }

    /**
     * @param mixed $porte
     */
    public function setPorte($porte)
    {
        $this->porte = $porte;
    }

    /**
     * @return mixed
     */
    public function getCapitalSocial()
    {
        return $this->capitalSocial;
    }

    /**
     * @param mixed $capitalSocial
     */
    public function setCapitalSocial($capitalSocial)
    {
        $this->capitalSocial = $capitalSocial;
    }

    /**
     * @return mixed
     */
    public function getDataInicioAtividade()
    {
        return $this->dataInicioAtividade;
    }

    /**
     * @param mixed $dataInicioAtividade
     */
    public function setDataInicioAtividade($dataInicioAtividade)
    {
        $dataInicioAtividade = !empty($dataInicioAtividade) ? (\DateTime::createFromFormat("d/m/Y", $dataInicioAtividade)) : NULL;
        $this->dataInicioAtividade = $dataInicioAtividade instanceof \DateTime ? $dataInicioAtividade->format('Y-m-d') : NULL;
    }

    /**
     * @return mixed
     */
    public function getNomeRequerente()
    {
        return $this->nomeRequerente;
    }

    /**
     * @param mixed $nomeRequerente
     */
    public function setNomeRequerente($nomeRequerente)
    {
        $this->nomeRequerente = $nomeRequerente;
    }

    /**
     * @return mixed
     */
    public function getCpfRequerente()
    {
        return $this->cpfRequerente;
    }

    /**
     * @param mixed $cpfRequerente
     */
    public function setCpfRequerente($cpfRequerente)
    {
        $this->cpfRequerente = $cpfRequerente;
    }

    /**
     * @return mixed
     */
    public function getDddTelefoneRequerente()
    {
        return $this->dddTelefoneRequerente;
    }

    /**
     * @param mixed $dddTelefoneRequerente
     */
    public function setDddTelefoneRequerente($dddTelefoneRequerente)
    {
        $this->dddTelefoneRequerente = $dddTelefoneRequerente;
    }

    /**
     * @return mixed
     */
    public function getTelefoneRequerente()
    {
        return $this->telefoneRequerente;
    }

    /**
     * @param mixed $telefoneRequerente
     */
    public function setTelefoneRequerente($telefoneRequerente)
    {
        $this->telefoneRequerente = $telefoneRequerente;
    }

    /**
     * @return mixed
     */
    public function getEmailRequerente()
    {
        return $this->emailRequerente;
    }

    /**
     * @param mixed $emailRequerente
     */
    public function setEmailRequerente($emailRequerente)
    {
        $this->emailRequerente = $emailRequerente;
    }

    /**
     * @return mixed
     */
    public function getDataAssinatura()
    {
        return $this->dataAssinatura;
    }

    /**
     * @param mixed $dataAssinatura
     */
    public function setDataAssinatura($dataAssinatura)
    {
        $this->dataAssinatura = $dataAssinatura;
    }

    /**
     * @return mixed
     */
    public function getNomeLogradouro()
    {
        return $this->nomeLogradouro;
    }

    /**
     * @param mixed $nomeLogradouro
     */
    public function setNomeLogradouro($nomeLogradouro)
    {
        $this->nomeLogradouro = $nomeLogradouro;
    }

    /**
     * @return mixed
     */
    public function getNumeroLogradouro()
    {
        return $this->numeroLogradouro;
    }

    /**
     * @param mixed $numeroLogradouro
     */
    public function setNumeroLogradouro($numeroLogradouro)
    {
        $this->numeroLogradouro = $numeroLogradouro;
    }

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * @param mixed $municipio
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    /**
     * @param array $empreendimento
     */
    public function arrayToObject(array $empreendimento)
    {
        $processo = ArrayHelper::extractContentIfExists($empreendimento, 'processo');
        $viabilidade = ArrayHelper::extractContentIfExists($processo, 'viabilidade');
        $matriz = ArrayHelper::extractContentIfExists($processo, 'matriz');
        $requerente = ArrayHelper::extractContentIfExists($processo, 'requerente');
        $endereco = ArrayHelper::extractContentIfExists($matriz, 'endereco');

        $this->setNumeroProcesso(ArrayHelper::extractContentIfExists($empreendimento, 'numeroProcesso'));

        $dataCnpj = array_key_exists('dataGravacaoCnpj', $empreendimento) ? $empreendimento['dataGravacaoCnpj'] : [];
        $this->setDataGravacaoCnpj(ArrayHelper::extractContentIfExists($dataCnpj, 'content'));


        $this->setCnpj(ArrayHelper::extractContentIfExists($empreendimento, 'cnpj'));
        $this->setNire(ArrayHelper::extractContentIfExists($empreendimento, 'nire'));

        $protocolo = is_array($viabilidade) && array_key_exists('protocolo', $viabilidade) ? $viabilidade['protocolo'] : '';
        $this->setProtocolo($protocolo);

        $this->setNomeEmpresa(ArrayHelper::extractContentIfExists($matriz, 'nome'));
        $this->setObjetoSocial(ArrayHelper::extractContentIfExists($matriz, 'descricaoObjeto'));
        $this->setPorte(ArrayHelper::extractContentIfExists($matriz, 'porte'));
        $this->setCapitalSocial(ArrayHelper::extractContentIfExists($matriz, 'capitalSocial'));

        $this->setDataInicioAtividade(ArrayHelper::extractContentIfExists($matriz['dataInicioAtividade'], 'content'));

        $this->setNomeRequerente(ArrayHelper::extractContentIfExists($requerente, 'nome'));
        $this->setCpfRequerente(ArrayHelper::extractContentIfExists($requerente, 'cpf'));
        $this->setDddTelefoneRequerente(ArrayHelper::extractContentIfExists($requerente, 'dddTelefone'));
        $this->setTelefoneRequerente(ArrayHelper::extractContentIfExists($requerente, 'telefone'));
        $this->setEmailRequerente(ArrayHelper::extractContentIfExists($requerente, 'email'));

        $this->setDataAssinatura(ArrayHelper::extractContentIfExists($processo['dataAssinatura'], 'content'));

        $this->setNomeLogradouro(ArrayHelper::extractContentIfExists($endereco, 'nomeLogradouro'));
        $this->setComplemento(ArrayHelper::extractContentIfExists($endereco, 'complemento'));
        $this->setBairro(ArrayHelper::extractContentIfExists($endereco, 'bairro'));

        $municipio = ArrayHelper::extractContentIfExists($endereco, 'municipio');
        $municipio = !empty($municipio) ? ArrayHelper::extractContentIfExists($municipio['attributes'], 'codigoRFB') : null;

        $uf = ArrayHelper::extractContentIfExists($endereco, 'uf');
        $uf = !empty($uf) ? ArrayHelper::extractContentIfExists($uf['attributes'], 'sigla') : null;

        $pais = ArrayHelper::extractContentIfExists($endereco, 'pais');
        $pais = !empty($pais) ? ArrayHelper::extractContentIfExists($pais['attributes'], 'codigoRFB') : null;

        $this->setMunicipio($municipio);
        $this->setUf($uf);
        $this->setPais($pais);

        $this->setNumeroLogradouro(ArrayHelper::extractContentIfExists($endereco, 'numeroLogradouro'));
        $this->setCep(ArrayHelper::extractContentIfExists($endereco, 'cep'));
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}