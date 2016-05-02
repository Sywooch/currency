<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "yii_order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $last_name
 * @property string $first_name
 * @property string $email
 * @property double $total_sum
 *
 * @property YiiUser $user
 * @property YiiOrderGoods[] $yiiOrderGoods
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['last_name', 'first_name', 'email', 'total_sum'], 'required'],
            [['total_sum'], 'number'],
            [['last_name', 'first_name', 'email'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'user_id' => 'Ид клиента',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'email' => 'Email',
            'total_sum' => 'Сумма заказа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(YiiUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYiiOrderGoods()
    {
        return $this->hasMany(YiiOrderGoods::className(), ['order_id' => 'id']);
    }
}
