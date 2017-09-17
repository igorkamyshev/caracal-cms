<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170903080922 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE articles_galleries');
        $this->addSql('DROP TABLE articles_products');
        $this->addSql('ALTER TABLE article ADD product_id INT DEFAULT NULL, ADD gallery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E664584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E664E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('CREATE INDEX IDX_23A0E664584665A ON article (product_id)');
        $this->addSql('CREATE INDEX IDX_23A0E664E7AF8F ON article (gallery_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE articles_galleries (article_id INT NOT NULL, gallery_id INT NOT NULL, UNIQUE INDEX UNIQ_ACD033B7294869C (article_id), INDEX IDX_ACD033B4E7AF8F (gallery_id), PRIMARY KEY(article_id, gallery_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_products (article_id INT NOT NULL, product_id INT NOT NULL, UNIQUE INDEX UNIQ_122EAC407294869C (article_id), INDEX IDX_122EAC404584665A (product_id), PRIMARY KEY(article_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles_galleries ADD CONSTRAINT FK_ACD033B4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE articles_galleries ADD CONSTRAINT FK_ACD033B7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE articles_products ADD CONSTRAINT FK_122EAC404584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE articles_products ADD CONSTRAINT FK_122EAC407294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E664584665A');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E664E7AF8F');
        $this->addSql('DROP INDEX IDX_23A0E664584665A ON article');
        $this->addSql('DROP INDEX IDX_23A0E664E7AF8F ON article');
        $this->addSql('ALTER TABLE article DROP product_id, DROP gallery_id');
    }
}