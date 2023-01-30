<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130153624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, discovery_day INT NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_9474526C8D93D649 (user), INDEX IDX_9474526C22195F70 (discovery_day), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discovery_day (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date DATETIME NOT NULL, max_participant INT NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_22195F708D93D649 (user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, discovery_day INT NOT NULL, filename VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_14B784188D93D649 (user), INDEX IDX_14B7841822195F70 (discovery_day), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rank (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, requirement INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, discovery_day INT NOT NULL, validated TINYINT(1) DEFAULT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_62A8A7A722195F70 (discovery_day), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, rank INT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, points INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6498879E8E5 (rank), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C22195F70 FOREIGN KEY (discovery_day) REFERENCES discovery_day (id)');
        $this->addSql('ALTER TABLE discovery_day ADD CONSTRAINT FK_22195F708D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784188D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841822195F70 FOREIGN KEY (discovery_day) REFERENCES discovery_day (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7BF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A722195F70 FOREIGN KEY (discovery_day) REFERENCES discovery_day (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498879E8E5 FOREIGN KEY (rank) REFERENCES rank (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D93D649');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C22195F70');
        $this->addSql('ALTER TABLE discovery_day DROP FOREIGN KEY FK_22195F708D93D649');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784188D93D649');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841822195F70');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7BF396750');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A722195F70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498879E8E5');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE discovery_day');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE rank');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP TABLE user');
    }
}
