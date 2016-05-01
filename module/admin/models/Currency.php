<?php

namespace app\module\admin\models;

use Yii;
use yii\data\ActiveDataProvider;

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
    
    /**
     * Добавить валюту
     * @param array $currencyArray
     * @return \app\module\admin\models\Currency|boolean
     */
    public function addCurrency(array $currencyArray)
    {
        $model = new Currency();
        $model->cbr_id = $currencyArray["Id"];
        $model->cbr_numcode = mb_strtolower (trim ($currencyArray["NumCode"]), 'UTF-8');
        $model->cbr_charcode = mb_strtolower (trim ($currencyArray["CharCode"]), 'UTF-8');
        $model->name = mb_strtolower (trim ($currencyArray["Name"]), 'UTF-8');
        
        if ($model->save()) {
            return $model;
        }
        
        return false;
    }
    
    public function getCurrencyByNumCode($numCode)
    {
        if (empty ($numCode)) {
            return false;
        }
        return Currency::find()
        ->where(['cbr_numcode' => mb_strtolower (trim ($numCode), 'UTF-8')])
        ->one();
    }
    
    public function addValues($data)
    {
        $id = $this->id;
        $date = strtotime($data["Date"]);
        $model =  new CurrencyValues();
        $valueModel = $model->getCurrencyValue($id, $date);
        
        if(! $valueModel) {
            $valueModel = new CurrencyValues();
            return $valueModel->addValue($this->id, $data);
        }else {
           return $valueModel->updateValue($this->id, $data);
        }
        return false;
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
    
    public function getDataProvider()
    {
        return new ActiveDataProvider([
        'query' => Currency::find(),
        'pagination' => [
            'pageSize' => 20,
            ],
        ]);
    }

    /**
     * получить последние значения курсов валют
     */
    static public function getLastCurrencyValues()
    {
        $subQuery = 'SELECT s1.currency_id, s1.currency_value, s1.currency_nominal, s1.update
                        FROM   yii_currency_values s1
                        WHERE  s1.update=(SELECT MAX(s2.update)
                                            FROM yii_currency_values s2
                                            WHERE s1.currency_id = s2.currency_id)';
        $query = 'SELECT * FROM {{currency}} c
                    LEFT JOIN  ({{subquery}}) v on c.id = v.currency_id
            ';
        $query = str_replace('{{currency}}', self::tableName(), $query);
        $query = str_replace('{{subquery}}' , $subQuery, $query);
        $list = Yii::$app->db
        ->createCommand($query)
        ->queryAll();
        $result = array();
        foreach ($list as $item) {
            $result[$item['id']] = $item;
        }
        return $result;;
    }
}
