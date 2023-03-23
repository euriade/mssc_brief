<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230301134638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, customer_name VARCHAR(255) NOT NULL, customer_lastname VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, online_date DATE DEFAULT NULL, front_access VARCHAR(255) DEFAULT NULL, back_access VARCHAR(255) DEFAULT NULL, website_login VARCHAR(255) DEFAULT NULL, website_password VARCHAR(255) DEFAULT NULL, domain VARCHAR(255) DEFAULT NULL, domain_suscribe TINYINT(1) DEFAULT NULL, domain_existing TINYINT(1) DEFAULT NULL, host VARCHAR(255) DEFAULT NULL, host_login VARCHAR(255) DEFAULT NULL, host_password VARCHAR(255) DEFAULT NULL, pack VARCHAR(255) DEFAULT NULL, logo_reused TINYINT(1) DEFAULT NULL, content_reused TINYINT(1) DEFAULT NULL, other_data TINYINT(1) DEFAULT NULL, files_uploaded LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', more_information LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE brief');
    }
}
