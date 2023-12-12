<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212090408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fk_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD fk_category_id_id INT DEFAULT NULL, DROP rating, DROP fk_category, DROP description');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE27938F7 FOREIGN KEY (fk_category_id_id) REFERENCES fk_category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADE27938F7 ON product (fk_category_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE27938F7');
        $this->addSql('DROP TABLE fk_category');
        $this->addSql('DROP INDEX IDX_D34A04ADE27938F7 ON product');
        $this->addSql('ALTER TABLE product ADD rating INT NOT NULL, ADD fk_category INT NOT NULL, ADD description LONGTEXT NOT NULL, DROP fk_category_id_id');
    }
}
