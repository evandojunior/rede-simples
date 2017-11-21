<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170517134441 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `bbh_campo_detalhamento_protocolo` ADD `bbh_cam_det_pro_apelido` VARCHAR(255)');
        $this->addSql('ALTER TABLE `bbh_campo_detalhamento_fluxo` ADD `bbh_cam_det_flu_apelido` VARCHAR(255)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `bbh_campo_detalhamento_protocolo` DROP COLUMN  `bbh_cam_det_pro_apelido`');
        $this->addSql('ALTER TABLE `bbh_campo_detalhamento_fluxo` DROP COLUMN  `bbh_cam_det_flu_apelido`');
    }
}