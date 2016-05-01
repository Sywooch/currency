<?php

namespace app\module\admin\controllers;

use app\module\admin\models\Goods;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\module\admin\models\Currency;
class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Goods();
        $dataProvider = $model->getDataProvider();
        return $this->render('index', array('dataProvider' => $dataProvider));
    }
    
    public function actionView($id)
    {
        $goods = $this->loadModel($id);
        $currencyList = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
        $list = Currency::getLastCurrencyValues();;
        $priceInDiffCurrencies = $goods->getPriceInOtherCurrency($list);
        return $this->render('view', array('goods'=> $goods, 'currencyList' => $currencyList, 'priceInDiffCurrencies' => $priceInDiffCurrencies));
    }
    
    public function loadModel($id)
    {
        $model = Goods::find()->
        where([Goods::tableName() . '.id'=>$id])->joinWith('currency')->one();
        if ($model === null)
            throw new CHttpException (404, 'The requested page does not exist.');
        return $model;
    }
    
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        
        if (isset ($_POST[ 'Goods' ])) {
            if ($model->savePriceStr ($model, 'price_str', $_POST[ 'Goods' ]['price_str'])) {
                $this->redirect (Url::toRoute('index'));
            }
        }
        
        return $this->render('update', array('goods'=> $model));
    }
    
    public function actionAdd()
    {
        $model = new Goods();

        if (isset ($_POST[ 'Goods' ])) {
            $model->setAttributes($_POST['Goods']);
            if ($model->save ($model)) {
                $this->redirect (Url::toRoute('index'));
            }
        }
        $currencyList = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
        return $this->render('add', array('goods'=> $model, 'currencyList' => $currencyList));
    }
   
}
