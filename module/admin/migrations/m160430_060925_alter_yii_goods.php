<?php

use yii\db\Migration;

class m160430_060925_alter_yii_goods extends Migration
{
    public function up()
    {
       $this->execute("
           ALTER TABLE `yii_goods`
              ADD COLUMN `price_str` VARCHAR(255) NOT NULL COMMENT 'цена прописью' AFTER `price`,
              ADD COLUMN `currency_id` INT(10) UNSIGNED NULL COMMENT 'валюта цены, если не задано - в рублях' AFTER `price_str`,
              ADD CONSTRAINT `FK_yii_goods_yii_currency` FOREIGN KEY (`currency_id`) REFERENCES `yii_currency` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
           ");
    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `yii_goods`
                DROP COLUMN `price_str`,
                DROP COLUMN `currency_id`,
                DROP FOREIGN KEY `FK_yii_goods_yii_currency`;
            ");
    }
}
