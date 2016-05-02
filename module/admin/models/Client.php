<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "yii_user".
 *
 * @property  $id
 * @property string $first_name
 * @property string $last_name
 * @property double $balance
 *
 * @property YiiOrder[] $yiiOrders
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'balance'], 'required'],
            [['balance'], 'number'],
            [['first_name', 'last_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'balance' => 'Баланс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYiiOrders()
    {
        return $this->hasMany(YiiOrder::className(), ['user_id' => 'id']);
    }
}
