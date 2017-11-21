<?php

namespace Project\BBHive\Services\RedeSimples\Helper;

use Project\Core\Helper\ArrayHelper;

class ViabilidadeTemplate
{
    private $contentViabilidade;
    private $coleta;

    protected $municipio;
    protected $naturezaJuridica;
    protected $tipoEnquadramento;
    protected $evento;
    protected $resultadoClassificacao;
    protected $orgaoRegistro;
    protected $requerente;
    protected $endereco;
    protected $objetoSocial;
    protected $cnae;
    protected $tipoAtividadeEconomica;
    protected $exercidaNoLocal;
    protected $coletaTipoUnidadeFormaAtuacao;
    protected $codigoTipoUnidade;
    protected $numeroProtocolo;
    protected $atividades;

    public function __construct(Array $contentViabilidade)
    {
        $this->contentViabilidade = $contentViabilidade;

        $this->parseMunicipio();
        $this->parseNaturezaJuridica();
        $this->parseTipoEnquadramento();
        $this->parseEvento();
        $this->parseResultadoClassificacao();
        $this->parseOrgaoRegistro();
        $this->parseRequerente();

        $this->coleta = ArrayHelper::extractContentIfExists($contentViabilidade, 'coleta');
        $this->parseEndereco();
        $this->parseObjetoSocial();
        $this->parseAtividade();
        $this->parseTipoUnidade();
        $this->parseFormaAtuacao();
        $this->parseProtocolo();
    }

    protected function parseMunicipio()
    {
        $this->municipio = ArrayHelper::extractContentIfExists(
            ArrayHelper::extractContentIfExists(
                ArrayHelper::extractContentIfExists($this->contentViabilidade, 'municipio'),
                'attributes'),
            'codigoRFB');
    }

    protected function parseNaturezaJuridica()
    {
        $naturezaJuridicaList = json_decode(file_get_contents(__DIR__ . "/../Config/NaturezaJuridica.json"), true);
        $naturezaJuridica = ArrayHelper::extractContentIfExists(
            ArrayHelper::extractContentIfExists(
                ArrayHelper::extractContentIfExists($this->contentViabilidade, 'naturezaJuridica'),
                'attributes'),
            'codigo');


        $this->naturezaJuridica = array_key_exists($naturezaJuridica, $naturezaJuridicaList) ? $naturezaJuridicaList[$naturezaJuridica] : $naturezaJuridica;
    }

    protected function parseTipoEnquadramento()
    {
        $this->tipoEnquadramento = ArrayHelper::extractContentIfExists($this->contentViabilidade, 'tipoEnquadramento');
    }

    protected function parseEvento()
    {
        $eventoList = json_decode(file_get_contents(__DIR__ . "/../Config/EventoInscricao.json"), true);

        $evento = ArrayHelper::extractContentIfExists(
            ArrayHelper::extractContentIfExists(
                ArrayHelper::extractContentIfExists($this->contentViabilidade, 'evento'),
                'attributes'),
            'codigo');

        $this->evento = array_key_exists($evento, $eventoList) ? $eventoList[$evento] : $evento;
    }

    protected function parseResultadoClassificacao()
    {
        $this->resultadoClassificacao = ArrayHelper::extractContentIfExists($this->contentViabilidade, 'resultadoClassificacao');
    }

    protected function parseOrgaoRegistro()
    {
        $registro = ArrayHelper::extractContentIfExists(
            ArrayHelper::extractContentIfExists($this->contentViabilidade, 'orgaoRegistro'),
            'attributes');

        $this->orgaoRegistro = sprintf("%s - %s",
            ArrayHelper::extractContentIfExists($registro, 'codigo'),
            ArrayHelper::extractContentIfExists($registro, 'nome')
        );
    }

    protected function parseRequerente()
    {
        $requerente = ArrayHelper::extractContentIfExists($this->contentViabilidade, 'requerente');
        $login = ArrayHelper::extractContentIfExists($requerente, 'login');
        $nome = ArrayHelper::extractContentIfExists($requerente, 'nome');
        $email = ArrayHelper::extractContentIfExists($requerente, 'email');
        $ddd = ArrayHelper::extractContentIfExists($requerente, 'dddTelefone');
        $telefone = ArrayHelper::extractContentIfExists($requerente, 'telefone');

        $this->requerente = [
            'Login' => $login,
            'Nome' => $nome,
            'Email' => $email,
            'Telefone' => sprintf("%s %s", $ddd, $telefone)
        ];
    }

    protected function parseEndereco()
    {
        $enderecoColeta = ArrayHelper::extractContentIfExists($this->coleta, 'coletaEndereco');
        $endereco = ArrayHelper::extractContentIfExists($enderecoColeta, 'endereco');

        $logradouro = ArrayHelper::extractContentIfExists($endereco, 'logradouro');
        $cep = ArrayHelper::extractContentIfExists($endereco, 'numeroCep');
        $numero = ArrayHelper::extractContentIfExists($endereco, 'numeroLogradouro');
        $bairro = ArrayHelper::extractContentIfExists($endereco, 'bairro');
        $areaTotalEmpreendimento = ArrayHelper::extractContentIfExists($enderecoColeta, 'areaTotalEmpreendimento');
        $areaUtilizada = ArrayHelper::extractContentIfExists($enderecoColeta, 'areaUtilizada');

        $this->endereco = [
            'Logradouro' => $logradouro,
            'Número' => $numero,
            'CEP' => $cep,
            'Bairro' => $bairro,
            'Área total do empreendimento' => $areaTotalEmpreendimento,
            'Área utilizada' => $areaUtilizada,
        ];
    }

    protected function parseObjetoSocial()
    {
        $objetoSocial = ArrayHelper::extractContentIfExists($this->coleta, 'coletaObjetoSocial');
        $this->objetoSocial = ArrayHelper::extractContentIfExists($objetoSocial, 'objetoSocial');
    }

    protected function parseAtividade()
    {
        $coletaAtividadeEconomica = ArrayHelper::extractContentIfExists($this->coleta, 'coletaAtividadeEconomica');
        $detalheAtividade = [];
        
        if (!array_key_exists('atividadeEconomica', $coletaAtividadeEconomica))
        {
            foreach($coletaAtividadeEconomica as $atividades) {
                $atividade = null;
                $atividadeDetail = ArrayHelper::extractContentIfExists($atividades, 'attributes');

                $cnae = ArrayHelper::extractContentIfExists(
                    ArrayHelper::extractContentIfExists(
                        ArrayHelper::extractContentIfExists($atividades, 'atividadeEconomica'),
                        'attributes'),
                    'cnae');
                $tipoAtividadeEconomica = ArrayHelper::extractContentIfExists($atividadeDetail, 'tipoAtividadeEconomica');
                $exercidaNoLocal = ArrayHelper::extractContentIfExists($atividadeDetail, 'exercidaNoLocal');

                $detalheAtividade["CNAE: {$cnae}"] = sprintf(
                    "%s - exercida no local: %s",
                    $tipoAtividadeEconomica == 'P' ? "Principal" : "Secundária",
                    $exercidaNoLocal == 'true' ? "Sim" : "Não"
                );
            }
        } else {
            $cnae = ArrayHelper::extractContentIfExists(
                ArrayHelper::extractContentIfExists(
                    ArrayHelper::extractContentIfExists($coletaAtividadeEconomica, 'atividadeEconomica'),
                    'attributes'),
                'cnae');


            $atividade = ArrayHelper::extractContentIfExists($coletaAtividadeEconomica, 'attributes');
            $tipoAtividadeEconomica = ArrayHelper::extractContentIfExists($atividade, 'tipoAtividadeEconomica');
            $exercidaNoLocal = ArrayHelper::extractContentIfExists($atividade, 'exercidaNoLocal');

            $detalheAtividade["CNAE: {$cnae}"] = sprintf(
                "%s - exercida no local: %s",
                $tipoAtividadeEconomica == 'P' ? "Principal" : "Secundária",
                $exercidaNoLocal == 'true' ? "Sim" : "Não"
            );
        }


        $this->atividades = $detalheAtividade;
    }

    protected function parseFormaAtuacao()
    {
        $coletaTipoUnidadeFormaAtuacao = ArrayHelper::extractContentIfExists($this->coleta, 'coletaTipoUnidadeFormaAtuacao');
        $formaAtuacaoList = json_decode(file_get_contents(__DIR__ . "/../Config/UnidadeProdutiva.json"), true);

        $formaAtuacao = [];
        if (count($coletaTipoUnidadeFormaAtuacao) > 1) {
            foreach ($coletaTipoUnidadeFormaAtuacao as $key => $value) {
                $codigo = (int) ArrayHelper::extractContentIfExists(ArrayHelper::extractContentIfExists($value, 'attributes'), 'codigo');
                $descricao = $this->getDescricaoFormaAtuacao($formaAtuacaoList, $codigo);

                $formaAtuacao["{$codigo}"] = $descricao;
            }
        } else {
            $codigo = ArrayHelper::extractContentIfExists(ArrayHelper::extractContentIfExists($coletaTipoUnidadeFormaAtuacao, 'attributes'), 'codigo');
            $descricao = $this->getDescricaoFormaAtuacao($formaAtuacaoList, $codigo);

            $formaAtuacao["{$codigo}"] = $descricao;
        }

        $this->coletaTipoUnidadeFormaAtuacao = $formaAtuacao;
    }

    private function getDescricaoFormaAtuacao($formaAtuacaoList, $codigo)
    {
        return array_key_exists($codigo, $formaAtuacaoList[$this->codigoTipoUnidade]) ?
            $formaAtuacaoList[$this->codigoTipoUnidade][$codigo] : $codigo;
    }

    protected function parseTipoUnidade()
    {
        $this->codigoTipoUnidade = ArrayHelper::extractContentIfExists($this->coleta, 'codigoTipoUnidade');
    }

    protected function parseProtocolo()
    {
        $this->numeroProtocolo = ArrayHelper::extractContentIfExists(
            ArrayHelper::extractContentIfExists($this->contentViabilidade, 'attributes'),
            'numeroProtocolo');
    }

    public function view()
    {
        return [
            'Município' => $this->municipio,
            'Natureza jurídica' => $this->naturezaJuridica,
            'Tipo de enquadramento' => $this->tipoEnquadramento,
            'Evento' => $this->evento,
            'Resultado classificação' => empty($this->resultadoClassificacao) ? "-" : $this->resultadoClassificacao,
            'Órgão registro' => empty($this->orgaoRegistro) ? "-" : $this->orgaoRegistro,
            'Requerente' => $this->requerente,
            'Endereço' => $this->endereco,
            'Objeto social' => $this->objetoSocial,
            'Atividades' => $this->atividades,
            'Tipo de unidade' => $this->codigoTipoUnidade,
            'Forma de atuação' => $this->coletaTipoUnidadeFormaAtuacao,
            'Número do protocolo' => $this->numeroProtocolo,
        ];
    }
}
