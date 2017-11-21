<?php

namespace Project\BBHive\Services\RedeSimples;

use Project\Core\Helper\ArrayHelper;

/**
 * Class Viabilidade
 * @package Project\BBHive\Services\RedeSimples
 */
class Viabilidade
{
    const CAMPO_NUMERO_PROCESSO = 'rede-simples-viabilidade-numeroProcesso';
    const CAMPO_ANALISE_PROCESSO = 'rede-simples-viabilidade-analise-endereco';
    const CAMPO_MOTIVO_ANALISE_PROCESSO = 'rede-simples-viabilidade-analise-endereco-motivo';
    const CAMPO_SINCRONIZADO_ANALISE_PROCESSO = 'rede-simples-viabilidade-analise-endereco-sincronizado';

    /**
     * @var
     */
    protected $numeroProcesso;

    /**
     * @var
     */
    protected $nomeRequerente;

    /**
     * @var
     */
    protected $dadosEmpresa;

    /**
     * @var array
     */
    public $listFieldsViabilidadePendentes = [
        'numeroProcesso' => self::CAMPO_NUMERO_PROCESSO,
        'dadosEmpresa' => 'rede-simples-viabilidade-empresa'
    ];

    /**
     * @var array
     */
    public $listFieldsConfirmaRecebimentoViabilidades = [
        'confirmaRecebimento' => 'rede-simples-viabilidade-confirmaRecebimento'
    ];

    /**
     * @var array
     */
    public $listFieldsConfirmaRespostaAnaliseEndereco = [
        'sincronizadoRedeSimples' => self::CAMPO_SINCRONIZADO_ANALISE_PROCESSO,
        'respostaAnalise' => self::CAMPO_ANALISE_PROCESSO,
        'motivoAnalise' => self::CAMPO_MOTIVO_ANALISE_PROCESSO,
    ];

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
    public function getDadosEmpresa()
    {
        return $this->dadosEmpresa;
    }

    /**
     * @param mixed $dadosEmpresa
     */
    public function setDadosEmpresa($dadosEmpresa)
    {
        $this->dadosEmpresa = $dadosEmpresa;
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
     * @param array $fieldsProtocol
     * @param array $fieldListFrom
     * @return array
     */
    public function mergeFieldsToForm(array $fieldsProtocol, array $fieldListFrom)
    {
        // Todos os campos do protocolo precisam estar disponíveis, senão precisamos lançar uma exception
        // Campos a serem definidos no request
        foreach($fieldsProtocol as $field) {
            if ($key = array_search($field['bbh_cam_det_pro_apelido'], $fieldListFrom)) {
                unset($fieldListFrom[$key]);
                $fieldListFrom[$field['bbh_cam_det_pro_nome']] = $key;
            }
        }

        $this->hasError($fieldListFrom);
        return $fieldListFrom;
    }

    /**
     * @param array $fieldList
     */
    private function hasError(array $fieldList)
    {
        $errors = null;
        foreach($fieldList as $campoRedeSimples => $aliasBPM) {
            if (strpos($campoRedeSimples, "bbh_") === false) {
                $errors .= "Campo origem: <strong>{$campoRedeSimples}</strong> precisa do 'alias' <strong>{$aliasBPM}</strong> no protocolo;<br>";
            }
        }

        if (!empty($errors)) {
            exit("<h3>Ops, encontramos um problema!</h3><br>Corrija os campos abaixo antes de dar sequência:<hr>{$errors}");
        }
    }

    public function getKeyNumeroProcesso(array $fieldListFrom)
    {
        $keyNumeroProcesso = array_search('numeroProcesso', $fieldListFrom);
        if (empty($keyNumeroProcesso)) {
            exit("Chave {numeroProcesso} de consulta da rede simples não identificada");
        }

        return $keyNumeroProcesso;
    }

    /**
     * @param array $viabilidade
     */
    public function arrayToObject(array $viabilidade)
    {
        $attributes = ArrayHelper::extractContentIfExists($viabilidade, 'attributes');
        $protocolo = ArrayHelper::extractContentIfExists($attributes, 'numeroProtocolo');
        $requerente = ArrayHelper::extractContentIfExists($viabilidade, 'requerente');
        $nomeRequerente = ArrayHelper::extractContentIfExists($requerente, 'nome');

        $this->setNumeroProcesso($protocolo);
        $this->setDadosEmpresa(json_encode($viabilidade));
        $this->setNomeRequerente($nomeRequerente);
    }
}
