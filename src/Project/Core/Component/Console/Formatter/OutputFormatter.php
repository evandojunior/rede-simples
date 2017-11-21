<?php

namespace Project\Core\Component\Console\Formatter;

class OutputFormatter extends \Symfony\Component\Console\Formatter\OutputFormatter
{
    protected $commandName;
    private $hasMessages = 0;

    public function format($message)
    {
        $messageWithDateTime = '';
        if (!$this->hasMessages) {
            $messageWithDateTime = sprintf(
                '<info>%s %s</info>' . PHP_EOL,
                date('[Y-m-d H:i:s]'),
                $this->getCommandName()
            );
        }

        $messageWithDateTime .= sprintf(
            '<info>%s</info>%s%s',
            date('[Y-m-d H:i:s]'),
            ' |_ ',
            $message
        );
        $this->hasMessages = 1;

        return parent::format($messageWithDateTime);
    }

    public function getCommandName()
    {
        return $this->commandName;
    }

    public function setCommandName($commandName)
    {
        $this->commandName = $commandName;
    }
}
