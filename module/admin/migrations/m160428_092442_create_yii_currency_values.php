<?php

use yii\db\Migration;

class m160428_092442_create_yii_currency_values extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `yii_currency_values` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `currency_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'ид валюты',
                `currency_value` DOUBLE(10,2) UNSIGNED NOT NULL COMMENT 'значение валюты',
                `currency_nominal` DOUBLE(10,2) UNSIGNED NOT NULL COMMENT 'номинал валюты',
                `update` INT(10) UNSIGNED NOT NULL COMMENT 'дата',
                PRIMARY KEY (`id`),
                UNIQUE INDEX `currency_update` (`currency_id`, `update`),
                CONSTRAINT `FK_yii_currency_values_yii_currency` FOREIGN KEY (`currency_id`) REFERENCES `yii_currency` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;");
    }

    public function down()
    {
        $this->execute("DROP TABLE `yii_currency_values`");
    }
}
