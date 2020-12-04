<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204170912 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dish (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, picture VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_957D8CB812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish_dish_ingredient (dish_id INT NOT NULL, dish_ingredient_id INT NOT NULL, INDEX IDX_8B911A7D148EB0CB (dish_id), INDEX IDX_8B911A7DFE65422 (dish_ingredient_id), PRIMARY KEY(dish_id, dish_ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB812469DE2 FOREIGN KEY (category_id) REFERENCES dish_category (id)');
        $this->addSql('ALTER TABLE dish_dish_ingredient ADD CONSTRAINT FK_8B911A7D148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dish_dish_ingredient ADD CONSTRAINT FK_8B911A7DFE65422 FOREIGN KEY (dish_ingredient_id) REFERENCES dish_ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish_dish_ingredient DROP FOREIGN KEY FK_8B911A7D148EB0CB');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE dish_dish_ingredient');
    }
}
