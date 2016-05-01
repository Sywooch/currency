<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "yii_goods".
 *
 * @property string $id
 * @property string $name
 * @property double $price
 * @property string $price_str
 * @property int $currency_id
 *
 * @property YiiOrderGoods[] $yiiOrderGoods
 */
use yii\data\ActiveDataProvider;
class Goods extends \yii\db\ActiveRecord
{
    use MoneyTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii_goods';
    }
    
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price', 'currency_id'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['price_str'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYiiOrderGoods()
    {
        return $this->hasMany(YiiOrderGoods::className(), ['goods_id' => 'id']);
    }
    public function getDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Goods::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
    
    /**
     * Получить цену товара прописью
     */
    public function getPriceToStr()
    {
        $currencyCode = $this->currency ? $this->currency->cbr_charcode : '';
        $moneyModel = Money::getMoneyModel($currencyCode);
        $sex = $moneyModel ? $moneyModel->getSex() : 0;
        $one = $moneyModel ? $moneyModel->getOne() : ''; 
        $four = $moneyModel ? $moneyModel->getFour() : '';
        $many = $moneyModel ? $moneyModel->getMany() : '';
  
        return $this->getTextForm($this->price, $sex, $one, $four, $many);
    }
    
    /**
     * Получить Цену товара в разных валютах
     * @param array $curencyList
     * @return array
     */
    public function getPriceInOtherCurrency(array $curencyList)
    {
        if (empty($curencyList)) {
            return array();
        }
        if ($this->currency) {
            if (isset($curencyList[$this->currency->id])) {
                $nominal = $curencyList[$this->currency->id]['currency_nominal'];
                $currencyValue = $curencyList[$this->currency->id]['currency_value'];
            }else {
                return array();
            }
        }else {
            $nominal = 1;
            $currencyValue = 1;
        }
        $modelFrom = Money::getMoneyModel($this->currency ? $this->currency->cbr_charcode : '');
        $rubley = $modelFrom->convertToRubles($this->price, $nominal, $currencyValue);
   
        $result = array();
        foreach ($curencyList as $currencyArr) {
            $modelTo = Money::getMoneyModel($currencyArr['cbr_charcode']);
            $item = array(
                'cbr_code' => $currencyArr['cbr_charcode'], 
                'value' => $modelTo->convertFromRubles($rubley, $currencyArr['currency_nominal'], $currencyArr['currency_value'])
            );
            $result[] = $item;
        }
        return $result;
    }
}
