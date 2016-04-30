<?php
namespace app\module\admin\models;

use Yii;
use yii\base\Model;
class AbstractCurrency extends Model
{
    private $value;
    private $nominal;
    private $count;
    private $rub_count;

    public function attributeNames()
    {}
    
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function setNominal($nominal)
    {
        $this->nominal = $nominal;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }
    
    public function setRubCount($rub_count)
    {
        $this->rub_count = $rub_count;
    }
    
    public function getRublesCount() {
        if ($this->nominal == 0) {
            return 0;
        }
        $this->rub_count = $this->value * $this->count/$this->nominal;
        return $this->rub_count;;
    }
    
    public function  getCurrencyCount() {
        $this->count = $this->rub_count * $this->nominal /$this->value;
        return $this->count;
    }
}
