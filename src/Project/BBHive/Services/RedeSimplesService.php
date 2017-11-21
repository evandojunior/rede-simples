<?php

namespace Project\BBHive\Services;
use Project\BBHive\Services\RedeSimples\Factory\EmpreendimentoFactory;
use Project\BBHive\Services\RedeSimples\Factory\ViabilidadeFactory;
use Silex\Application;

/**
 * Class RedeSimplesService
 * @package Project\BBHive\Services
 */
class RedeSimplesService
{
    const WS_TIPO_VIABILIDADE = "viabilidade";

    const WS_TIPO_EMPREENDIMENTO = "empreendimento";

    protected $urlWsEmpreendimento;

    protected $urlWsViabilidade;

    public function __construct(Application $app)
    {
        $this->urlWsEmpreendimento = $app['api.rede_simples.ws_empreendimento'];
        $this->urlWsViabilidade = $app['api.rede_simples.ws_viabilidade'];
    }

    public function build($wsTipo)
    {
        switch ($wsTipo) {
            case self::WS_TIPO_EMPREENDIMENTO:
                return new EmpreendimentoFactory($this->urlWsEmpreendimento);
                break;
            case self::WS_TIPO_VIABILIDADE:
                return new ViabilidadeFactory($this->urlWsViabilidade);
                break;
            default:
                throw new \Exception("Tipo de acesso a Junta Comercial não encontrado");
        }
    }
}
