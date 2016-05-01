<div class="admin-default-index">
<?php 
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\DetailView;
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
            'label' => 'currency_id',
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
Цена в другой валюте:
<?php 
    echo '<pre>';
    print_r($priceInDiffCurrencies);
?>