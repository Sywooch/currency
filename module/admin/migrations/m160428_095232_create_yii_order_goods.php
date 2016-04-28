<?php

use yii\db\Migration;

class m160428_095232_create_yii_order_goods extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `yii_order_goods` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `order_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'ид заказа',
                `goods_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'ид товара',  
                `goods_price` DOUBLE(10,2) UNSIGNED NOT NULL COMMENT 'цена товара',
                `goods_count` DOUBLE(10,2) UNSIGNED NOT NULL COMMENT 'количество товара',
                `goods_name` VARCHAR(50) NOT NULL COMMENT 'наименование товара',
               PRIMARY KEY (`id`),
               INDEX `FK_yii_order_goods_yii_order` (`order_id`),
               INDEX `FK_yii_order_goods_yii_goods` (`goods_id`),
               CONSTRAINT `FK_yii_order_goods_yii_goods` FOREIGN KEY (`goods_id`) REFERENCES `yii_goods` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
               CONSTRAINT `FK_yii_order_goods_yii_order` FOREIGN KEY (`order_id`) REFERENCES `yii_order` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
       ");
    }

    public function down()
    {
        $this->execute("DROP TABLE CREATE TABLE `yii_order_goods`;");
    }
}
