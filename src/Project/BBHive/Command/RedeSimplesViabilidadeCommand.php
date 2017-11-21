<?php

namespace Project\BBHive\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Project\Core\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;

class RedeSimplesViabilidadeCommand extends ContainerAwareCommand
{
    const PROCESSOS_PENDENTES = "pendentes";
    const PROCESSOS_CONFIRMA_RECEBIMENTO = "confirma-recebimento";
    const PROCESSOS_CONFIRMA_RESPOSTA_ANALISE_ENDERECO = "resposta-analise-endereco";

    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app);
    }

    protected function configure()
    {
        $this
            ->setName('redesimples-viabilidade:execute')
            ->setDescription('Comunicacao Rede Simples - Viabilidade Junta Comercial')
            ->addOption('env', null, InputOption::VALUE_OPTIONAL, 'Ambiente')
            ->addOption(self::PROCESSOS_PENDENTES, null, InputOption::VALUE_NONE, 'Requerimentos deferidos para Prefeitura')
            ->addOption(self::PROCESSOS_CONFIRMA_RECEBIMENTO, null, InputOption::VALUE_NONE, 'Resposta de confirmação de recebimento para Junta')
            ->addOption(self::PROCESSOS_CONFIRMA_RESPOSTA_ANALISE_ENDERECO, null, InputOption::VALUE_NONE, 'Resposta de análise de endereço')
            ->setHelp(<<<EOT
Processamento automatico para buscas de processos pendentes em Viabilidade Rede Simples:

  <info>./bin/console redesimples-viabilidade:execute --pendentes</info>
    Busca e cadastra todos as viabilidades pendentes na Junta Comercial;

  <info>./bin/console redesimples-viabilidade:execute --confirma-recebimento</info>
    Informa a Junta Comercial que processo já está cadastrado no BPM;

  <info>./bin/console redesimples-viabilidade:execute --resposta-analise-endereco</info>
    Informa a Junta Comercial resposta de análise de endereço, sendo que pode ser Deferido ou Indeferido;
EOT
            );
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;

        $this->output->writeln('[Rede Simples - Junta Comercial]');

        if ($input->getOption(self::PROCESSOS_PENDENTES)) {
            return $this->recuperaViabilidadesPendentes();
        }

        if ($input->getOption(self::PROCESSOS_CONFIRMA_RECEBIMENTO)) {
            return $this->confirmaRecebimentoViabilidade();
        }

        if ($input->getOption(self::PROCESSOS_CONFIRMA_RESPOSTA_ANALISE_ENDERECO)) {
            return $this->confirmaRespostaAnaliseEndereco();
        }

        $this->output->writeln("Nenhuma ação selecionada");
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function recuperaViabilidadesPendentes()
    {
        $user = $this->getUser();

        // Viabilidade
        $wsViabilidade = $this->app['longevo.api.rede_simples.ws_viabilidade']->executeViabilidadesPendentes($this->app['db.orm.em'], $user);

        $this->output->writeln(str_replace("<br>", "\r\n", $wsViabilidade['viabilidades']));
        $this->output->writeln("{$wsViabilidade['totalSincronizado']} protocolo(s) recepcionados");

        return true;
    }

    protected function confirmaRecebimentoViabilidade()
    {
        $user = $this->getUser();

        // Viabilidade
        $wsViabilidade = $this->app['longevo.api.rede_simples.ws_viabilidade']->confirmaRecebimentoViabilidade($this->app['db.orm.em'], $user);

        $this->output->writeln("{$wsViabilidade['totalSincronizado']} protocolo(s) com recebimento confirmado");

        return true;
    }

    protected function confirmaRespostaAnaliseEndereco()
    {
        // Viabilidade
        $wsViabilidade = $this->app['longevo.api.rede_simples.ws_viabilidade']->confirmaRespostaAnaliseEndereco($this->app['db.orm.em']);

        $this->output->writeln("{$wsViabilidade['totalSincronizado']} protocolo(s) com respostas sincronizadas");

        return true;
    }

    private function getUser()
    {
        // Usuário padrão para integracao rede simples
        $userDefault = $this->app['api.rede_simples.user_token'];

        $user = $this->app['db.orm.em']->getRepository(\Project\Core\Entity\BbhUsuario::class)->findOneByBbhUsuIdentificacao($userDefault);
        if (empty($user)) {
            throw new \Exception("Usuário não encontrado");
        }

        return $user;
    }
}
