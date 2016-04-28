<?php

use yii\db\Migration;

class m160428_083609_create_yii_currency extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `yii_currency` (
               `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
               `cbr_id` VARCHAR(50) NOT NULL COMMENT 'ид валюты в цбр',
               `cbr_numcode` VARCHAR(50) NOT NULL COMMENT 'код числовой цбр',
               `cbr_charcode` VARCHAR(50) NOT NULL COMMENT 'код  символьный цбр',
               `name` VARCHAR(255) NOT NULL COMMENT 'наименование',
              PRIMARY KEY (`id`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
       ");
    }

    public function down()
    {
        $this->execute("DROP TABLE `yii_currency`");
    }
}
