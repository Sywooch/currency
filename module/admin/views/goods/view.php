<div class="admin-default-index">
<?php use yii\helpers\Url;?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<a href="<?php echo Url::toRoute('currency/index');?>">Список валют</a><br/>
<?php 
use yii\grid\GridView;
use yii\widgets\DetailView;
echo "<h1>Товар</h1>";

echo DetailView::widget([
    'model' => $goods,
    'attributes' => [
        'id',
        'name',
        'price',
    ],
]);

?>
</div>
