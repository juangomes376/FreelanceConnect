<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416083746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F81A76ED395 ON address (user_id)');
        $this->addSql('ALTER TABLE application ADD mission_id INT DEFAULT NULL, ADD freelancer_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC18545BDF5 FOREIGN KEY (freelancer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC16BF700BD FOREIGN KEY (status_id) REFERENCES application_status (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC1BE6CAE90 ON application (mission_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC18545BDF5 ON application (freelancer_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC16BF700BD ON application (status_id)');
        $this->addSql('ALTER TABLE invoice ADD application_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517443E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('CREATE INDEX IDX_906517443E030ACD ON invoice (application_id)');
        $this->addSql('ALTER TABLE mission ADD category_id INT DEFAULT NULL, ADD client_id INT DEFAULT NULL, ADD freelance_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CE8DF656B FOREIGN KEY (freelance_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C6BF700BD FOREIGN KEY (status_id) REFERENCES mission_status (id)');
        $this->addSql('CREATE INDEX IDX_9067F23C12469DE2 ON mission (category_id)');
        $this->addSql('CREATE INDEX IDX_9067F23C19EB6921 ON mission (client_id)');
        $this->addSql('CREATE INDEX IDX_9067F23CE8DF656B ON mission (freelance_id)');
        $this->addSql('CREATE INDEX IDX_9067F23C6BF700BD ON mission (status_id)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('DROP INDEX IDX_D4E6F81A76ED395 ON address');
        $this->addSql('ALTER TABLE address DROP user_id');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE6CAE90');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC18545BDF5');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC16BF700BD');
        $this->addSql('DROP INDEX IDX_A45BDDC1BE6CAE90 ON application');
        $this->addSql('DROP INDEX IDX_A45BDDC18545BDF5 ON application');
        $this->addSql('DROP INDEX IDX_A45BDDC16BF700BD ON application');
        $this->addSql('ALTER TABLE application DROP mission_id, DROP freelancer_id, DROP status_id');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517443E030ACD');
        $this->addSql('DROP INDEX IDX_906517443E030ACD ON invoice');
        $this->addSql('ALTER TABLE invoice DROP application_id');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C12469DE2');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C19EB6921');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CE8DF656B');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C6BF700BD');
        $this->addSql('DROP INDEX IDX_9067F23C12469DE2 ON mission');
        $this->addSql('DROP INDEX IDX_9067F23C19EB6921 ON mission');
        $this->addSql('DROP INDEX IDX_9067F23CE8DF656B ON mission');
        $this->addSql('DROP INDEX IDX_9067F23C6BF700BD ON mission');
        $this->addSql('ALTER TABLE mission DROP category_id, DROP client_id, DROP freelance_id, DROP status_id');
        $this->addSql('ALTER TABLE user DROP is_verified');
    }
}
