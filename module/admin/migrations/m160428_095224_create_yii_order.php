<?php

use yii\db\Migration;

class m160428_095224_create_yii_order extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `yii_order` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'ид пользователя',
                `last_name` VARCHAR(50) NOT NULL COMMENT 'фамилия заказчика',
                `first_name` VARCHAR(50) NOT NULL COMMENT 'имя заказчика',
                `email` VARCHAR(50) NOT NULL COMMENT 'мыло заказчика',
                `total_sum` DOUBLE(10,2) NOT NULL COMMENT 'сумма заказа в рублях',
                PRIMARY KEY (`id`),
                INDEX `FK_yii_order_yii_user` (`user_id`),
                CONSTRAINT `FK_yii_order_yii_user` FOREIGN KEY (`user_id`) REFERENCES `yii_user` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
      ");
    }

    public function down()
    {
        $this->execute("DROP TABLE `yii_order`");
    }
}
