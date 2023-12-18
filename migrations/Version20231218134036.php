<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218134036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD fk_review_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B75F77410B FOREIGN KEY (fk_review_id) REFERENCES reviews (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B75F77410B ON cart (fk_review_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B75F77410B');
        $this->addSql('DROP INDEX UNIQ_BA388B75F77410B ON cart');
        $this->addSql('ALTER TABLE cart DROP fk_review_id');
    }
}
