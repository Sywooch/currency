<?php

namespace app\models;

use Yii;

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
        return $this->hasOne(YiiCurrency::className(), ['id' => 'currency_id']);
    }
    
    public function addValue($currencyId, $datetime, array $currency)
    {
        $model = new CurrencyValues();
        $model->currency_id = $currencyId;
        $model->currency_nominal = $currencyArray["Nominal"];
        $model->currency_value = $currencyArray["Value"];
        $model->update = $datetime;
        
        return $model->save();
    }
}
