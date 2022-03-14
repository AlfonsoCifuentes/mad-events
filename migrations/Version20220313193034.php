<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220313193034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, ubication VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento_user (evento_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_95D710D387A5F842 (evento_id), INDEX IDX_95D710D3A76ED395 (user_id), PRIMARY KEY(evento_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evento_user ADD CONSTRAINT FK_95D710D387A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_user ADD CONSTRAINT FK_95D710D3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento_user DROP FOREIGN KEY FK_95D710D387A5F842');
        $this->addSql('ALTER TABLE evento_user DROP FOREIGN KEY FK_95D710D3A76ED395');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE evento_user');
        $this->addSql('DROP TABLE `user`');
    }
}
