<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330171819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_allergy (recipe_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_87554CF559D8A214 (recipe_id), INDEX IDX_87554CF5DBFD579D (allergy_id), PRIMARY KEY(recipe_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_allergy (user_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_93BC5CBFA76ED395 (user_id), INDEX IDX_93BC5CBFDBFD579D (allergy_id), PRIMARY KEY(user_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_allergy ADD CONSTRAINT FK_87554CF559D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_allergy ADD CONSTRAINT FK_87554CF5DBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergy ADD CONSTRAINT FK_93BC5CBFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergy ADD CONSTRAINT FK_93BC5CBFDBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergy_recipe DROP FOREIGN KEY FK_9F8DD577DBFD579D');
        $this->addSql('ALTER TABLE allergy_recipe DROP FOREIGN KEY FK_9F8DD57759D8A214');
        $this->addSql('ALTER TABLE allergy_user DROP FOREIGN KEY FK_D51E2B22DBFD579D');
        $this->addSql('ALTER TABLE allergy_user DROP FOREIGN KEY FK_D51E2B22A76ED395');
        $this->addSql('DROP TABLE allergy_recipe');
        $this->addSql('DROP TABLE allergy_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergy_recipe (allergy_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_9F8DD577DBFD579D (allergy_id), INDEX IDX_9F8DD57759D8A214 (recipe_id), PRIMARY KEY(allergy_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE allergy_user (allergy_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D51E2B22DBFD579D (allergy_id), INDEX IDX_D51E2B22A76ED395 (user_id), PRIMARY KEY(allergy_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE allergy_recipe ADD CONSTRAINT FK_9F8DD577DBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergy_recipe ADD CONSTRAINT FK_9F8DD57759D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergy_user ADD CONSTRAINT FK_D51E2B22DBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergy_user ADD CONSTRAINT FK_D51E2B22A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_allergy DROP FOREIGN KEY FK_87554CF559D8A214');
        $this->addSql('ALTER TABLE recipe_allergy DROP FOREIGN KEY FK_87554CF5DBFD579D');
        $this->addSql('ALTER TABLE user_allergy DROP FOREIGN KEY FK_93BC5CBFA76ED395');
        $this->addSql('ALTER TABLE user_allergy DROP FOREIGN KEY FK_93BC5CBFDBFD579D');
        $this->addSql('DROP TABLE recipe_allergy');
        $this->addSql('DROP TABLE user_allergy');
    }
}
