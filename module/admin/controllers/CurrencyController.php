<?php

namespace app\module\admin\controllers;

use app\module\admin\models\Currency;
use app\module\admin\models\CurrencyValues;
class CurrencyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Currency();
        $dataProvider = $model->getDataProvider();
        return $this->render('index', array('dataProvider' => $dataProvider));
    }
    
    public function actionView($id)
    {
        $currency = $this->loadModel($id);
        $model = new CurrencyValues(); 
        $history = $model->getDataProvider($id);
        return $this->render('view', array('currency'=> $currency, 'dataProvider' => $history));
    }
    
    public function loadModel($id)
    {
        $model = Currency::find()->
         where(['id'=>$id])->one();
        if ($model === null)
            throw new CHttpException (404, 'The requested page does not exist.');
        return $model;
    }

}
