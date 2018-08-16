<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180816134031 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("
            CREATE TABLE IF NOT EXISTS `user` ( 
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT , 
                `openId` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
                `nickname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '昵称' , 
                `gender` ENUM('male','female','unknow') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'unknow' COMMENT '性别' , 
                `city` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '所在城市' , 
                `province` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '所在省份' , 
                `country` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '所在国家' , 
                `avatarUrl` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '头像' , 
                `unionId` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
                `createdTime` INT(10) UNSIGNED NOT NULL COMMENT '创建时间' , 
                `updatedTime` INT(10) UNSIGNED NOT NULL COMMENT '更新时间' , 
                PRIMARY KEY (`id`), UNIQUE (`unionId`)
            ) ENGINE = InnoDB;
        ");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("
            DROP TABLE IF EXISTS `user`;
        ");
    }
}
