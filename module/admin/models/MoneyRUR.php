<?php
namespace app\module\admin\models;

use Yii;
use yii\base\Model;

class MoneyRUR extends Money
{

    protected $one = 'рубль';

    protected $four = 'рубля';

    protected $many = 'рублей';

    protected $sex = 0;

    public function attributeNames()
    {}

    public function getRublesCount()
    {
        return $this->rub_count;
    }

    public function getCurrencyCount()
    {
        return $this->rub_count;
    }
}
