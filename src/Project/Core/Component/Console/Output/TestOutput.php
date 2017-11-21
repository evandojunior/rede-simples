<?php

namespace Project\Core\Component\Console\Output;

use Symfony\Component\Console;

/**
 * Instead of outputting messages, keep them to be
 * searched later. Useful for tests.
 */
class TestOutput extends Console\Output\ConsoleOutput
{
    /**
     * @var array
     */
    private $messages = array();

    public function doWrite($message, $newline)
    {
        $this->messages[] = $message;
    }

    public function hasMessage($expectedMessage)
    {
        $messageFound = array_search($expectedMessage, $this->messages);
        if (false === $messageFound) {
            return false;
        }

        return true;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setFormatter(Console\Formatter\OutputFormatterInterface $outputFormatterInterface)
    {
        return true;
    }
}
