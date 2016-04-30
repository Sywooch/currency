<?php
namespace app\module\admin\models;

use Yii;
use yii\base\Model;
class Money extends Model
{
    protected $value;
    protected $nominal;
    protected $count;
    protected $rub_count;
    
    protected $one = '';
    protected $four = '';
    protected $many = '';
    protected $sex = 0;

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
    
    public function getOne()
    {
        return $this->one;
    }
    
    public function getFour()
    {
        return $this->four;
    }
    
    public function getMany()
    {
        return $this->many;
    }
    
    public function getSex()
    {
        return $this->sex;
    }


}
