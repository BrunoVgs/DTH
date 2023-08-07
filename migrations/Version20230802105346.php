<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802105346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaign (id INT AUTO_INCREMENT NOT NULL, collection_center_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_1F1512DD7F1A4315 (collection_center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_center (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(255) NOT NULL, available_seats INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, donor_id INT NOT NULL, collection_center_id INT NOT NULL, date DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, INDEX IDX_31E581A03DD7B7A7 (donor_id), INDEX IDX_31E581A07F1A4315 (collection_center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, height INT NOT NULL, weight INT NOT NULL, age INT NOT NULL, adress VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', phone_number VARCHAR(20) NOT NULL, birthdate DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D64983A00E68 (firstname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DD7F1A4315 FOREIGN KEY (collection_center_id) REFERENCES collection_center (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A03DD7B7A7 FOREIGN KEY (donor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A07F1A4315 FOREIGN KEY (collection_center_id) REFERENCES collection_center (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campaign DROP FOREIGN KEY FK_1F1512DD7F1A4315');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A03DD7B7A7');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A07F1A4315');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('DROP TABLE collection_center');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE `user`');
    }
}
