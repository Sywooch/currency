<?php

namespace app\module\admin\controllers;

use yii\web\Controller;
use app\module\admin\models\CurrencyStructure;
use app\module\admin\models\Currency;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
   