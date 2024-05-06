<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501143655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY fk_market');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY fk_trans_iduser');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE market CHANGE rate rate VARCHAR(255) NOT NULL, CHANGE Sprice sprice DOUBLE PRECISION NOT NULL, CHANGE Bprice bprice DOUBLE PRECISION DEFAULT NULL, CHANGE Mcap mcap DOUBLE PRECISION DEFAULT NULL, CHANGE typeM typeM VARCHAR(50) DEFAULT NULL, CHANGE IMG_SRC img_src VARCHAR(260) NOT NULL, CHANGE ID_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transactions (id INT NOT NULL, idT INT AUTO_INCREMENT NOT NULL, dateT INT NOT NULL, amount INT NOT NULL, IDmarket INT NOT NULL, INDEX fk_market (IDmarket), INDEX fk_trans_iduser (id), PRIMARY KEY(idT)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (Id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Balance DOUBLE PRECISION DEFAULT NULL, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, passeport INT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT fk_market FOREIGN KEY (IDmarket) REFERENCES market (IDmarket) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT fk_trans_iduser FOREIGN KEY (id) REFERENCES user (Id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE market CHANGE rate rate INT DEFAULT 0, CHANGE sprice Sprice DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE bprice Bprice DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE mcap Mcap DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE typeM typeM VARCHAR(10) NOT NULL, CHANGE img_src IMG_SRC VARCHAR(400) NOT NULL, CHANGE id_user ID_user INT NOT NULL');
        $this->addSql('ALTER TABLE payment MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON payment');
        $this->addSql('ALTER TABLE payment CHANGE id id INT NOT NULL');
    }
}
