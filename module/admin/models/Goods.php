<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "yii_goods".
 *
 * @property string $id
 * @property string $name
 * @property string $price
 *
 * @property YiiOrderGoods[] $yiiOrderGoods
 */
use yii\data\ActiveDataProvider;
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['name', 'price'], 'string', 'max' => 50]
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
}
