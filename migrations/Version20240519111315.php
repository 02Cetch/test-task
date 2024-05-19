<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240519111315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE PROCEDURE AddBook(IN IN_title VARCHAR(255), IN IN_author VARCHAR(255), IN IN_publicationYear INT)
            BEGIN
                INSERT INTO book (title, author, publication_year) VALUES (IN_title, IN_author, IN_publicationYear);
            END');

        $this->addSql('CREATE PROCEDURE UpdateBook(IN IN_bookId INT, IN IN_title VARCHAR(255), IN IN_author VARCHAR(255), IN IN_publicationYear INT)
            BEGIN
                UPDATE book SET title = IN_title, author = IN_author, publication_year = IN_publicationYear WHERE id = IN_bookId;
            END');

        $this->addSql('CREATE PROCEDURE DeleteBook(IN IN_bookId INT)
            BEGIN
                DELETE FROM book WHERE id = IN_bookId;
            END');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP PROCEDURE IF EXISTS AddBook');
        $this->addSql('DROP PROCEDURE IF EXISTS UpdateBook');
        $this->addSql('DROP PROCEDURE IF EXISTS DeleteBook');
    }
}
