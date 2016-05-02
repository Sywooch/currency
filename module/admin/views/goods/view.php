<div class="admin-default-index">
<?php 
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\DetailView;
    use yii\grid\GridView;
?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<a href="<?php echo Url::toRoute('currency/index');?>">Список валют</a><br/>
<?php 

echo "<h1>Товар</h1>";

echo DetailView::widget([
    'model' => $goods,
    'attributes' => [
        'id',
        'name',
        'price',
        [
            'label' => 'Валюта',
            'value' => $goods->currency ? $goods->currency->name : 'рубль' ,
        ],
        'price_str',
        [
            'label' => 'Пропись(auto)',
            'value' => $goods->getPriceToStr(),
        ]
    ],
]);

?>
<h3>Цена в другой валюте</h3>
<?php 

    if($priceInDiffCurrencies) {
        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $priceInDiffCurrencies,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        echo GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Код валюты',
                    'value' => function ($data) {
                        return $data['cbr_code'];
                    }
                ],
                [
                    'label' => 'Значение',
                    'value' => function ($data) {
                        return $data['value'];
                    }
                    ]
                ],
        ]); 
    }
?>