<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20230316172610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Order projection';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE order_item (
                id INT AUTO_INCREMENT NOT NULL, 
                order_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)', 
                name VARCHAR(255) NOT NULL, 
                price INT NOT NULL, 
                quantity INT NOT NULL, 
                INDEX IDX_52EA1F098D9F6D38 (order_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
        ");

        $this->addSql("
            CREATE TABLE `order` (
                id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)', 
                placed_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', 
                purchaser_first_name VARCHAR(255) DEFAULT NULL, 
                purchaser_last_name VARCHAR(255) DEFAULT NULL, 
                purchaser_address VARCHAR(255) DEFAULT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
        ");

        $this->addSql("
            ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id);
        ");
    }
}
