<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261006122743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY `FK_62A8A7A7A0631C12`');
        $this->addSql('DROP INDEX IDX_62A8A7A7A0631C12 ON registration');
        $this->addSql('ALTER TABLE registration CHANGE organiser_id organizer_id INT NOT NULL');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7876C4DDA FOREIGN KEY (organizer_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7876C4DDA ON registration (organizer_id)');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7876C4DDA');
        $this->addSql('DROP INDEX IDX_62A8A7A7876C4DDA ON registration');
        $this->addSql('ALTER TABLE registration CHANGE organizer_id organiser_id INT NOT NULL');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT `FK_62A8A7A7A0631C12` FOREIGN KEY (organiser_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7A0631C12 ON registration (organiser_id)');
        $this->addSql('ALTER TABLE users CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
