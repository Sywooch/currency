<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "yii_order_goods".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $goods_id
 * @property double $goods_price
 * @property double $goods_count
 * @property string $goods_name
 *
 * @property YiiGoods $goods
 * @property YiiOrder $order
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii_order_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id'], 'integer'],
            [['goods_price', 'goods_count', 'goods_name'], 'required'],
            [['goods_price', 'goods_count'], 'number'],
            [['goods_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'order_id' => 'Ид заказа',
            'goods_id' => 'Ид товара',
            'goods_price' => 'Цена',
            'goods_count' => 'Количество',
            'goods_name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(YiiGoods::className(), ['id' => 'goods_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(YiiOrder::className(), ['id' => 'order_id']);
    }
}
