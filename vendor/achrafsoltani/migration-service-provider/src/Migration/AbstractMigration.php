<?php

namespace AchrafSoltani\Migration;

use Doctrine\DBAL\Schema\Schema;
use Silex\Application;

/**
 * Abstract migration class
 *
 * @package AchrafSoltani\Migration
 */
abstract class AbstractMigration
{
    public function getVersion()
    {
        $rc = new \ReflectionClass($this);

        if (preg_match('/^(\d+)/', basename($rc->getFileName()), $matches)) {
            return (int) ltrim($matches[1], 0);
        }

        throw new \RuntimeException(sprintf('Could not get version from "%"', basename($rc->getFileName())));
    }

    public function getMigrationInfo()
    {
        return null;
    }

    public function schemaUp(Schema $schema)
    {
    }

    public function schemaDown(Schema $schema)
    {
    }

    public function appUp(Application $app)
    {
    }

    public function appDown(Application $app)
    {
    }
}
