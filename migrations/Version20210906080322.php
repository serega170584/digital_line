<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210906080322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX team_opponent_idx ON play');
        $this->addSql('CREATE UNIQUE INDEX team_opponent_idx ON play (team_id, opponent_id, stage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX team_opponent_idx ON play');
        $this->addSql('CREATE UNIQUE INDEX team_opponent_idx ON play (team_id, opponent_id)');
    }
}
