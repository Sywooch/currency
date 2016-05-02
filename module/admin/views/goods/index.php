<div class="admin-default-index">
<?php 
    use yii\helpers\Url;
    use yii\grid\GridView;
 ?>
<a href="<?php echo Url::toRoute('default/index');?>">Главная</a><br/>
<a href="<?php echo Url::toRoute('goods/add');?>">Добавить товар</a><br/>
<?php 

echo "<h1>Список товаров</h1>";
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             'id',
            'name',
            'price',
            'price_str',
            [
                'label' => 'Прописью(auto)',
                'value'=>function ($data) {
                    return $data->getPriceToStr();
                }
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['admin/goods/view','id'=>$model['id']]);
                        return \yii\helpers\Html::a( 'Цена в других валютах', $customurl,
                            ['title' => Yii::t('yii', 'savePriceStr'), 'data-pjax' => '0']);
                     },
                    'update'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['admin/goods/update','id'=>$model['id']]);
                        return \yii\helpers\Html::a( 'Изменить надпись прописью', $customurl,
                            ['title' => Yii::t('yii', 'savePriceStr'), 'data-pjax' => '0']);
                    }
               ],
            ],
        ],
    ]); ?>
</div>
