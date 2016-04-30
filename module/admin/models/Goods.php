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
    
    public function getPriceToStr()
    {
        if ($this->price_str) {
            return $this->price_str;
        }
        
        $moneyModel = null;
        if ($this->currency) {
            $moneyClassName = 'app\module\admin\models\Money'. mb_strtoupper ($this->currency->cbr_charcode, 'UTF-8');
            if (class_exists ($moneyClassName)) {
                $moneyModel = new $moneyClassName();
            }
        }else {
            $moneyModel = new MoneyRUR();
        }
        $sex = $moneyModel ? $moneyModel->getSex() : 0;
        $one = $moneyModel ? $moneyModel->getOne() : ''; 
        $four = $moneyModel ? $moneyModel->getFour() : '';
        $many = $moneyModel ? $moneyModel->getMany() : '';
  
        return $this->getTextForm($this->price, $sex, $one, $four, $many);
    }
}
