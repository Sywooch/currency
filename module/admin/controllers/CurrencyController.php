<?php

namespace app\module\admin\controllers;

use app\module\admin\models\Currency;
use app\module\admin\models\CurrencyValues;
use app\module\admin\models\AbstractStructure;
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

    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo json_encode($data);
        die;
    }
    
    /**
     * Возращает историю валюты за период
     * @param number $id
     * @param number $start
     * @param number $end
     */
    public function actionGraphic($id, $start, $end)
    {
        $datetimeStart = strtotime($start);
        $datetimeEnd = strtotime($end);
        $currency = $this->loadModel($id);
        $values = $currency->getHistoryForPeriod($datetimeStart, $datetimeEnd);
        $this->renderJSON($values);
    }
    
    /**
     * Возвращает историю валюты
     * @param number $id
     * @param number $page
     * @param number $countperpage
     */
    public function actionHistory($id, $page = 1, $countperpage = 10)
    {
        $currency = $this->loadModel($id);
        $values = $currency->getHistory($page, $countperpage);
        $total = $currency->getHistoryCount();
        $result = array('history' => $values, 'total' => $total);
        $this->renderJSON($result);
    }
}