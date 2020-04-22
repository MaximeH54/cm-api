<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422084242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, adress VARCHAR(255) NOT NULL, adress2 VARCHAR(255) DEFAULT NULL, INDEX IDX_5CECC7BE8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, mark VARCHAR(255) NOT NULL, year DATE DEFAULT NULL, motorization VARCHAR(255) NOT NULL, model VARCHAR(255) DEFAULT NULL, vehicle_type VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, numberplate VARCHAR(255) DEFAULT NULL, INDEX IDX_773DE69DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, adress_id INT DEFAULT NULL, logo VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, tva VARCHAR(255) DEFAULT NULL, INDEX IDX_4FBF094F8486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, adress_id INT DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, google VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649979B1AD6 (company_id), UNIQUE INDEX UNIQ_8D93D6498486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commercial_partners (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, link VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, zip_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B02347D662686 (zip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zip (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, postal_code VARCHAR(255) NOT NULL, INDEX IDX_421D9546F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, expenditure VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, distance VARCHAR(255) DEFAULT NULL, comments LONGTEXT DEFAULT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_F11FA745A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BE8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F8486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02347D662686 FOREIGN KEY (zip_id) REFERENCES zip (id)');
        $this->addSql('ALTER TABLE zip ADD CONSTRAINT FK_421D9546F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F8486F9AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498486F9AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745A76ED395');
        $this->addSql('ALTER TABLE adress DROP FOREIGN KEY FK_5CECC7BE8BAC62AF');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02347D662686');
        $this->addSql('ALTER TABLE zip DROP FOREIGN KEY FK_421D9546F92F3E70');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE commercial_partners');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE zip');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE reports');
    }
}
