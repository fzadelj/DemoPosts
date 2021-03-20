<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210320120051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create posts table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE `posts` (
              `id` int(11) NOT NULL,
              `userId` int(11) NOT NULL,
              `title` varchar(255) DEFAULT NULL,
              `body` text,
              PRIMARY KEY (`id`),
              KEY `fk_posts_userId_idx` (`userId`),
              CONSTRAINT `fk_posts_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE posts');
    }
}
