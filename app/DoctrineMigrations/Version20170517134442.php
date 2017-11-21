<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170517134442 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `bbh_fluxo` ADD `bbh_protocolo_referencia` INT(11)');
        $this->addSql('ALTER TABLE bbh_campo_detalhamento_fluxo ADD bbh_cam_det_flu_obrigatorio char(1) DEFAULT \'1\' NOT NULL;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `bbh_fluxo` DROP COLUMN  `bbh_protocolo_referencia`');
        $this->addSql('ALTER TABLE `bbh_campo_detalhamento_fluxo` DROP COLUMN  `bbh_cam_det_flu_obrigatorio`');
    }
}