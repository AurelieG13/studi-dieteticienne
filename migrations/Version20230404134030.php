<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404134030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating ADD recipies_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926222286F6CF FOREIGN KEY (recipies_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_D88926222286F6CF ON rating (recipies_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926222286F6CF');
        $this->addSql('DROP INDEX IDX_D88926222286F6CF ON rating');
        $this->addSql('ALTER TABLE rating DROP recipies_id');
    }
}
