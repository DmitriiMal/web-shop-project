<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215085823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP INDEX UNIQ_BA388B76DE8AF9C, ADD INDEX IDX_BA388B76DE8AF9C (fk_user_id_id)');
        $this->addSql('ALTER TABLE cart CHANGE fk_user_id_id fk_user_id_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP INDEX IDX_BA388B76DE8AF9C, ADD UNIQUE INDEX UNIQ_BA388B76DE8AF9C (fk_user_id_id)');
        $this->addSql('ALTER TABLE cart CHANGE fk_user_id_id fk_user_id_id INT NOT NULL');
    }
}
