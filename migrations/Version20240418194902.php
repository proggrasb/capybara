<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240418194902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('CREATE TABLE question(id INT NOT NULL, question VARCHAR(128) NOT NULL, is_active BOOLEAN NOT NULL DEFAULT \'true\', PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE answer(id INT NOT NULL, question_id INT NOT NULL, answer VARCHAR(128) NOT NULL, is_valid BOOLEAN NOT NULL DEFAULT \'true\', PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE test(id INT NOT NULL, started TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, finished TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE test_data(id INT NOT NULL, test_id INT NOT NULL, question_id INT NOT NULL, order_id INT NOT NULL, is_valid BOOLEAN NOT NULL DEFAULT \'false\', answers TEXT DEFAULT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE INDEX IDX_ANSWER_QUESTION_ID ON answer (question_id)');
        $this->addSql('CREATE INDEX IDX_TEST_DATA_TEST_ID ON test_data (test_id)');
        $this->addSql('CREATE INDEX IDX_TEST_DATA_QUESTION_ID ON test_data (question_id)');

        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_ANSWER_QUESTION_ID FOREIGN KEY (question_id) REFERENCES "question" (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE test_data ADD CONSTRAINT FK_TEST_DATA_TEST_ID FOREIGN KEY (test_id) REFERENCES "test" (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE test_data ADD CONSTRAINT FK_TEST_DATA_QUESTION_ID FOREIGN KEY (question_id) REFERENCES "question" (id) ON DELETE CASCADE NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE test_data DROP CONSTRAINT FK_TEST_DATA_QUESTION_ID');
        $this->addSql('ALTER TABLE test_data DROP CONSTRAINT FK_TEST_DATA_TEST_ID');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_ANSWER_QUESTION_ID');

        $this->addSql('DROP INDEX IDX_TEST_DATA_QUESTION_ID');
        $this->addSql('DROP INDEX IDX_TEST_DATA_TEST_ID');
        $this->addSql('DROP INDEX IDX_ANSWER_QUESTION_ID');

        $this->addSql('DROP SEQUENCE test_data_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');

        $this->addSql('DROP TABLE test_data');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question');
    }
}
