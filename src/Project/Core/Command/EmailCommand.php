<?php

namespace Project\Core\Command;

use Project\Core\Model;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmailCommand extends ContainerAwareCommand
{
    private $email = null;

    public function __construct(\Silex\Application $app)
    {
        // Injetamos o tal de container :)
        parent::__construct($app);
        //$this->email = $app['mandrill.messages'];
    }

    protected function configure()
    {

        $this
            ->setName('email:execute')
            ->setDescription('Send emails pending');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;

        $text = '[Searching emails] Status PENDING' . PHP_EOL;

        if ( ! $result = $this->processEmailPending()) {
            $text .= 'Nenhum email encontrado.' . PHP_EOL;
        } else {
            $text .= $result;
        }
        $this->output->writeln($text);
    }

    private function processEmailPending()
    {
        return true;
    }

    private function parseEmailData($emailData)
    {
        return true;
    }
}
