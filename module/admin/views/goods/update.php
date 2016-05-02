<div class="admin-default-index">
<?php 
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<a href="<?php echo Url::toRoute('currency/index');?>">Список валют</a><br/>

<?php $form = ActiveForm::begin(); ?>
<h1><?php echo $goods->name;?></h1>

<div class="form-group clearfix">
    <div class="col-sm-6">
        <?php echo $form->field($goods,'price_str')->textInput()->hint('Цена прописью')->label('Цена прописью'); ?>
    </div>
</div>

<?php echo Html::submitButton('Сохранить', ['class'=> 'btn btn-primary']); ?>
<?php ActiveForm::end(); ?>
                
</div>
