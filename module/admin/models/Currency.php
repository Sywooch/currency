<?php

namespace app\module\admin\models;

use Yii;
use app\models\CurrencyValues;

/**
 * This is the model class for table "yii_currency".
 *
 * @property string $id
 * @property string $cbr_id
 * @property string $cbr_numcode
 * @property string $cbr_charcode
 * @property string $name
 *
 * @property YiiCurrencyValues[] $yiiCurrencyValues
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii_currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cbr_id', 'cbr_numcode', 'cbr_charcode', 'name'], 'required'],
            [['cbr_id', 'cbr_numcode', 'cbr_charcode'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cbr_id' => 'Cbr ID',
            'cbr_numcode' => 'Cbr Numcode',
            'cbr_charcode' => 'Cbr Charcode',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYiiCurrencyValues()
    {
        return $this->hasMany(YiiCurrencyValues::className(), ['currency_id' => 'id']);
    }
    
    public function addCurrency(array $currencyArray)
    {
        $model = new Currency();
        $model->cbr_id = $currencyArray["cbr_id"];
        $model->cbr_numcode = mb_strtolower (trim ($currencyArray["NumCode"]), 'UTF-8');
        $model->cbr_charcode = mb_strtolower (trim ($currencyArray["CharCode"]), 'UTF-8');
        $model->name = mb_strtolower (trim ($currencyArray["Name"]), 'UTF-8');
        
        return $model->save();
    }
    
    public function getCurrencyByNumCode($numCode)
    {
        if (empty ($numCode)) {
            return null;
        }
        return Currency::model ()->findByAttributes (array (), array (
            'condition' => 'LOWER(`cbr_numcode`)=:numcode',
            'params' => array (
                ':numcode' => mb_strtolower (trim ($numCode), 'UTF-8')
            )
        ));
    }
    
    public function addValues($data)
    {
        $currencyValue = new CurrencyValues();
        $currencyValue->addValue($this->id, time(), $data);
    }
    
    public function updateCurrency(CurrencyStructure $model)
    {
       $currencyList = $model->getCurrency();
       if ($currencyList) {
           foreach ($currencyList as $data) {
               $date = time();
               $currencyModel = $this->getCurrencyByNumCode($data["NumCode"]);
               if (! $currencyModel) {
                   $currencyModel = $this->addCurrency($data);
               }
               if ($currencyModel) {
                   $currencyModel->addValues($data);
               }
           }
       }
    }

}
