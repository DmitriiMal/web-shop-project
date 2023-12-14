<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214095922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD fk_product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7B5EAACC9 FOREIGN KEY (fk_product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7B5EAACC9 ON cart (fk_product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD1AD5CDBF');
        $this->addSql('DROP INDEX IDX_D34A04AD1AD5CDBF ON product');
        $this->addSql('ALTER TABLE product DROP cart_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7B5EAACC9');
        $this->addSql('DROP INDEX IDX_BA388B7B5EAACC9 ON cart');
        $this->addSql('ALTER TABLE cart DROP fk_product_id');
        $this->addSql('ALTER TABLE product ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD1AD5CDBF ON product (cart_id)');
    }
}
