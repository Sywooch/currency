<?php

use yii\db\Migration;
use app\module\admin\models\Currency;
use app\module\admin\models\CurrencyStructure;
class m160428_155542_fill_currency_values extends Migration
{
    public function up()
    {
        $currenttime = time();
        for ($i=1; $i<=45; $i++) {
            $datestr = date( 'd/m/Y', $currenttime);
            $structure = new CurrencyStructure();
            $structure->loadXML('http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $datestr);
            $currency = new Currency();
            $currency->updateCurrency($structure);
            $currenttime -= 24*60*60;
        }
    }

    public function down()
    {
        echo "m160428_155542_fill_currency_values cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
