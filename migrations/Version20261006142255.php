<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261006142255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY `FK_62A8A7A7876C4DDA`');
        $this->addSql('DROP INDEX IDX_62A8A7A7876C4DDA ON registration');
        $this->addSql('ALTER TABLE registration ADD event_id INT NOT NULL, CHANGE organizer_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A771F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7A76ED395 ON registration (user_id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A771F7E88B ON registration (event_id)');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7A76ED395');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A771F7E88B');
        $this->addSql('DROP INDEX IDX_62A8A7A7A76ED395 ON registration');
        $this->addSql('DROP INDEX IDX_62A8A7A771F7E88B ON registration');
        $this->addSql('ALTER TABLE registration ADD organizer_id INT NOT NULL, DROP user_id, DROP event_id');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT `FK_62A8A7A7876C4DDA` FOREIGN KEY (organizer_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7876C4DDA ON registration (organizer_id)');
        $this->addSql('ALTER TABLE users CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
