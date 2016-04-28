<?php

use yii\db\Migration;

class m160428_095151_create_yii_goods extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `yii_goods` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(50) NOT NULL COMMENT 'наименование',
                `price` VARCHAR(50) NOT NULL COMMENT 'цена в рублях',
                PRIMARY KEY (`id`)
                )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
       ");
    }

    public function down()
    {
        $this->execute("DROP TABLE `yii_goods`");
    }
}
