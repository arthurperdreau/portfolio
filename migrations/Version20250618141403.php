<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250618141403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE project (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_techno (project_id INT NOT NULL, techno_id INT NOT NULL, PRIMARY KEY(project_id, techno_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2E230596166D1F9C ON project_techno (project_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2E23059651F3C1BC ON project_techno (techno_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_techno ADD CONSTRAINT FK_2E230596166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_techno ADD CONSTRAINT FK_2E23059651F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_techno DROP CONSTRAINT FK_2E230596166D1F9C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_techno DROP CONSTRAINT FK_2E23059651F3C1BC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_techno
        SQL);
    }
}
