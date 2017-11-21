<?php

namespace Project\Core\Command;

use Project\Core\Component\Console\Formatter\OutputFormatter;
use Project\Core\Helper\StringHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    /**
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    protected $output;
    protected $commandName;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $oldFormatter = $output->getFormatter();
        $formatter = new OutputFormatter();
        $formatter->setDecorated($oldFormatter->isDecorated());
        $formatter->setCommandName($this->getName());

        $output->setFormatter($formatter);
        $this->output = $output;
    }

    /**
     * @return \Symfony\Component\Console\Output\ConsoleOutput
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param \Symfony\Component\Console\Output\ConsoleOutput $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Returns a string to identify command on update log
     * @deprecated
     * Must be removed
     * @return string
     */
    public function getId()
    {
        $classNameSpace = get_called_class();
        $classParts = array_reverse(explode('\\', $classNameSpace));
        $class = str_replace('Command', '', $classParts[0]);

        return StringHelper::convertToSnakeCase($class);
    }

    /**
     * @return \Symfony\Component\Console\Output\ConsoleOutput
     * @deprecated
     * Must be removed and use $this->output instead
     */
    protected function out()
    {
        $console = $this->app['console.output'];
        $console->setFormatter(new OutputFormatter());

        return $console;
    }
}
