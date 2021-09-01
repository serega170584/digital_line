<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901063841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE play (id INT AUTO_INCREMENT NOT NULL, еteam_id INT NOT NULL, opponent_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_5E89DEBAD8188A84 (еteam_id), INDEX IDX_5E89DEBA7F656CDC (opponent_id), INDEX IDX_5E89DEBA2298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBAD8188A84 FOREIGN KEY (еteam_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA7F656CDC FOREIGN KEY (opponent_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE play');
    }
}
