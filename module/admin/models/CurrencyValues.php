<?php

namespace app\module\admin\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "yii_currency_values".
 *
 * @property string $id
 * @property string $currency_id
 * @property double $currency_value
 * @property double $currency_nominal
 * @property string $update
 *
 * @property YiiCurrency $currency
 */
class CurrencyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii_currency_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id', 'update'], 'integer'],
            [['currency_value', 'currency_nominal', 'update'], 'required'],
            [['currency_value', 'currency_nominal'], 'number'],
            [['currency_id', 'update'], 'unique', 'targetAttribute' => ['currency_id', 'update'], 'message' => 'The combination of Currency ID and Update has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_id' => 'Currency ID',
            'currency_value' => 'Currency Value',
            'currency_nominal' => 'Currency Nominal',
            'update' => 'Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
    
    public function getCurrencyValue($currencyId, $date)
    {
        return CurrencyValues::find()
        ->where(['currency_id' => $currencyId, 'update' => $date])
        ->one();
    }
    
    public function addValue($currencyId, array $currencyArray)
    {
        $model = new CurrencyValues();
        $model->currency_id = $currencyId;
        $model->currency_nominal = $currencyArray["Nominal"];
        $model->currency_value = $currencyArray["Value"];
        $model->update = strtotime($currencyArray["Date"]);
        
        return $model->save();
    }
    
    public function updateValue($currencyId, array $currencyArray)
    {
        $changeFlag = false;
        if ($this->currency_nominal != $currencyArray["Nominal"]) {
            $this->currency_nominal = $currencyArray["Nominal"];
            $changeFlag = true;
        }
        if ($this->currency_value != $currencyArray["Value"]) {
            $this->currency_value = $currencyArray["Value"];
            $changeFlag = true;
        }
    
        if ($changeFlag) {
            return $this->save();
        }
        return true;;
    }
    
    public function getDataProvider($currencyId)
    {
        return new ActiveDataProvider([
            'query' => CurrencyValues::find()->
            where(['currency_id'=>$currencyId])->
            orderBy('update DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
}