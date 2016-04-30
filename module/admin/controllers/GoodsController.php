<?php

namespace app\module\admin\controllers;

use app\module\admin\models\Goods;
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
        return $this->render('view', array('goods'=> $goods));
    }
    
    public function loadModel($id)
    {
        $model = Goods::find()->
        where(['id'=>$id])->one();
        if ($model === null)
            throw new CHttpException (404, 'The requested page does not exist.');
        return $model;
    }
}
