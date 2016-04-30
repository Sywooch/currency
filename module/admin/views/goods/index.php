<div class="admin-default-index">
<?php use yii\helpers\Url;?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<?php 
use yii\grid\GridView;
echo "<h1>Список товаров</h1>";
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            'id',
            'name',
            'price',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>
</div>
