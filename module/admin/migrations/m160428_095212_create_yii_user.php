<?php

use yii\db\Migration;

class m160428_095212_create_yii_user extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `yii_user` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `first_name` VARCHAR(50) NOT NULL COMMENT 'имя пользователя',
                `last_name` VARCHAR(50) NOT NULL COMMENT 'фамилия пользователя',
                `balance` DOUBLE(10,2) UNSIGNED NOT NULL COMMENT 'баланс в рублях',
                PRIMARY KEY (`id`)
                )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
        ");
    }

    public function down()
    {
        $this->execute('DROP TABLE `yii_user`');
    }
}
