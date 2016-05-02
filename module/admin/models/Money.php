<?php
namespace app\module\admin\models;

use Yii;
use yii\base\Model;

class Money extends Model
{

    protected $one = '';

    protected $four = '';

    protected $many = '';

    protected $sex = 0;

    public function attributeNames()
    {}

    /**
     * Получить количество рублей
     *
     * @param double $nominal            
     * @param double $currencyValue            
     * @param double $total            
     * @return double
     */
    public function convertToRubles($total, $nominal, $currencyValue)
    {
        if ($nominal == 0) {
            return 0;
        }
        return $currencyValue * $total / $nominal;
    }

    /**
     * Конвертировать из рублей в текущую валюту
     *
     * @param double $rubley            
     * @param double $nominal            
     * @param double $currencyValue            
     * @return double
     */
    public function convertFromRubles($rubley, $nominal, $currencyValue)
    {
        return $rubley * $nominal / $currencyValue;
    }

    /**
     * Наименование валюты прописью для количества 1
     *
     * @return string
     */
    public function getOne()
    {
        return $this->one;
    }

    /**
     * Наименование валюты прописью для количества 2,3,4
     *
     * @return string
     */
    public function getFour()
    {
        return $this->four;
    }

    /**
     * Наименование валюты прописью для количества больше 4
     *
     * @return string
     */
    public function getMany()
    {
        return $this->many;
    }

    /**
     *
     * @return number
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Получить модель валюты
     *
     * @param string $currencyCode            
     * @return Money
     */
    static public function getMoneyModel($currencyCode)
    {
        $currencyCode = $currencyCode ? trim($currencyCode) : 'RUR';
        
        $moneyClassName = 'app\module\admin\models\Money' . mb_strtoupper($currencyCode, 'UTF-8');
        $moneyModel = null;
        if (class_exists($moneyClassName)) {
            $moneyModel = new $moneyClassName();
        } else {
            $moneyModel = new Money();
        }
        return $moneyModel;
    }
}
