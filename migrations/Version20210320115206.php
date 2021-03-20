<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210320115206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create users table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE `users` (
              `id` INT NOT NULL,
              `name` VARCHAR(255) NULL,
              `username` VARCHAR(255) NULL,
              `email` VARCHAR(255) NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `username_UNIQUE` (`username` ASC),
              UNIQUE INDEX `email_UNIQUE` (`email` ASC));
        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}
