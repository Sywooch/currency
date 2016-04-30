<div class="admin-default-index">
<?php use yii\helpers\Url;?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<?php 
use yii\grid\GridView;
echo "<h1>Список валют</h1>";
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            'id',
            'cbr_id',
            'cbr_numcode:ntext',
            'cbr_charcode:ntext',
            'name:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>
</div>
