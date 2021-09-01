<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901064250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBAD8188A84');
        $this->addSql('DROP INDEX IDX_5E89DEBAD8188A84 ON play');
        $this->addSql('ALTER TABLE play CHANGE еteam_id team_id INT NOT NULL');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_5E89DEBA296CD8AE ON play (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA296CD8AE');
        $this->addSql('DROP INDEX IDX_5E89DEBA296CD8AE ON play');
        $this->addSql('ALTER TABLE play CHANGE team_id еteam_id INT NOT NULL');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBAD8188A84 FOREIGN KEY (еteam_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_5E89DEBAD8188A84 ON play (еteam_id)');
    }
}
