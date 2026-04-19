<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260419000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add created_at and language_id to mission table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE mission ADD created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\', ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_9067F23C82F1BAF4 ON mission (language_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C82F1BAF4');
        $this->addSql('DROP INDEX IDX_9067F23C82F1BAF4 ON mission');
        $this->addSql('ALTER TABLE mission DROP created_at, DROP language_id');
    }
}
