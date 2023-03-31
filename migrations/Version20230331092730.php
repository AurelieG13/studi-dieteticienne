<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331092730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_step (recipe_id INT NOT NULL, step_id INT NOT NULL, INDEX IDX_3CA2A4E359D8A214 (recipe_id), INDEX IDX_3CA2A4E373B21E9C (step_id), PRIMARY KEY(recipe_id, step_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_step ADD CONSTRAINT FK_3CA2A4E359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_step ADD CONSTRAINT FK_3CA2A4E373B21E9C FOREIGN KEY (step_id) REFERENCES step (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_step DROP FOREIGN KEY FK_3CA2A4E359D8A214');
        $this->addSql('ALTER TABLE recipe_step DROP FOREIGN KEY FK_3CA2A4E373B21E9C');
        $this->addSql('DROP TABLE recipe_step');
    }
}
