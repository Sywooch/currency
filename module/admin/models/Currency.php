<?php

namespace app\models;

use Yii;

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
}
