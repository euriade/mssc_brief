<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329201839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief ADD avocat VARCHAR(255) DEFAULT NULL, CHANGE customer_name customer_name VARCHAR(255) DEFAULT NULL, CHANGE customer_lastname customer_lastname VARCHAR(255) DEFAULT NULL, CHANGE company company VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE files_uploaded files_uploaded VARCHAR(255) DEFAULT NULL, CHANGE pack artisan VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief ADD pack VARCHAR(255) DEFAULT NULL, DROP artisan, DROP avocat, CHANGE customer_name customer_name VARCHAR(255) NOT NULL, CHANGE customer_lastname customer_lastname VARCHAR(255) NOT NULL, CHANGE company company VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE files_uploaded files_uploaded LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }
}
