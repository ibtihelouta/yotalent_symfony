<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602153916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY contrat_ibfk_1');
        $this->addSql('ALTER TABLE espacetalent DROP FOREIGN KEY espacetalent_ibfk_1');
        $this->addSql('ALTER TABLE espacetalent DROP FOREIGN KEY espacetalent_ibfk_2');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY participation_ibfk_1');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY participation_ibfk_2');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY participation_ibfk_3');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY planning_ibfk_1');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY remboursement_ibfk_1');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY ticket_ibfk_1');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY video_ibfk_1');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY videos_ibfk_1');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY vote_ibfk_1');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY vote_ibfk_2');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY IdVid');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY vote_ibfk_3');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY voyage_ibfk_1');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE espacetalent');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE remboursement');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE videos');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE voyage');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (idCat INT AUTO_INCREMENT NOT NULL, nomCat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idCat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, comment TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idEst INT NOT NULL, INDEX comment_ibfk_1 (idEst), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contrat (idC INT AUTO_INCREMENT NOT NULL, nomC VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, DateDC VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, DateFC VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idEST INT NOT NULL, INDEX contrat_ibfk_1 (idEST), PRIMARY KEY(idC)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE espacetalent (idEST INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nbVotes INT NOT NULL, idU INT NOT NULL, idCat INT NOT NULL, INDEX idU (idU), INDEX idCat (idCat), PRIMARY KEY(idEST)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (idEv INT AUTO_INCREMENT NOT NULL, nomEv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateDEv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateFEv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, localisation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, ImageEv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idEv)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, queue_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participation (idP INT AUTO_INCREMENT NOT NULL, nbRemb INT NOT NULL, idEv INT NOT NULL, idU INT NOT NULL, idT INT NOT NULL, INDEX idU (idU), INDEX idT (idT), INDEX idEv (idEv), PRIMARY KEY(idP)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planning (idP INT AUTO_INCREMENT NOT NULL, hour VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nomActivite VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, datePL VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idEv INT NOT NULL, INDEX idEv (idEv), PRIMARY KEY(idP)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE remboursement (idRem INT AUTO_INCREMENT NOT NULL, dc VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, idT INT NOT NULL, idu INT DEFAULT NULL, INDEX prixT (idT), PRIMARY KEY(idRem)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket (idT INT AUTO_INCREMENT NOT NULL, prixT INT NOT NULL, idEv INT NOT NULL, nomEv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat TINYINT(1) DEFAULT NULL, INDEX idEv (idEv), PRIMARY KEY(idT)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE video (idVid INT AUTO_INCREMENT NOT NULL, nomVid VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, idEST INT DEFAULT NULL, INDEX idEST (idEST), PRIMARY KEY(idVid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE videos (idVid INT AUTO_INCREMENT NOT NULL, nomVid VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idEST INT NOT NULL, INDEX idEST (idEST), PRIMARY KEY(idVid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vote (idV INT AUTO_INCREMENT NOT NULL, nbrV INT DEFAULT NULL, dateV VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'CURRENT_TIMESTAMP\' COLLATE `utf8mb4_general_ci`, idU INT DEFAULT NULL, idEV INT DEFAULT NULL, idEST INT DEFAULT NULL, IdVid INT DEFAULT NULL, nomVid VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX idEV (idEV), INDEX idEST (idEST), INDEX IdVid (IdVid), INDEX idU (idU), PRIMARY KEY(idV)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voyage (idVoy INT AUTO_INCREMENT NOT NULL, dateDVoy VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateRVoy VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, destination VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idC INT NOT NULL, INDEX idC (idC), PRIMARY KEY(idVoy)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT contrat_ibfk_1 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE espacetalent ADD CONSTRAINT espacetalent_ibfk_1 FOREIGN KEY (idU) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE espacetalent ADD CONSTRAINT espacetalent_ibfk_2 FOREIGN KEY (idCat) REFERENCES categorie (idCat) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT participation_ibfk_1 FOREIGN KEY (idEv) REFERENCES evenement (idEv)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT participation_ibfk_2 FOREIGN KEY (idU) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT participation_ibfk_3 FOREIGN KEY (idT) REFERENCES ticket (idT)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT planning_ibfk_1 FOREIGN KEY (idEv) REFERENCES evenement (idEv)');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT remboursement_ibfk_1 FOREIGN KEY (idT) REFERENCES ticket (idT)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT ticket_ibfk_1 FOREIGN KEY (idEv) REFERENCES evenement (idEv)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT video_ibfk_1 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT videos_ibfk_1 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT vote_ibfk_1 FOREIGN KEY (idU) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT vote_ibfk_2 FOREIGN KEY (idEV) REFERENCES evenement (idEv)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT IdVid FOREIGN KEY (IdVid) REFERENCES video (idVid)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT vote_ibfk_3 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT voyage_ibfk_1 FOREIGN KEY (idC) REFERENCES contrat (idC) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
