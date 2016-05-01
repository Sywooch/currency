<div class="admin-default-index">
<?php 
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<a href="<?php echo Url::toRoute('currency/index');?>">Список валют</a><br/>

<?php $form = ActiveForm::begin(); ?>
<?php echo $goods->name;?>
<div>
    <?php echo  "Cгенерированный вариант " . $goods->getPriceToStr(); ?>
</div>

<div class="form-group clearfix">
    <div class="col-sm-6">
        <?php echo $form->field($goods,'name')->textInput(); ?>
    </div>
</div>

<div class="form-group clearfix">
    <div class="col-sm-6">
        <?php echo $form->field($goods,'price')->textInput(); ?>
    </div>
</div>

<div class="form-group clearfix">
    <div class="col-sm-6">
        <?php echo $form->field($goods, 'currency_id')->dropDownList($currencyList); ?>
    </div>
</div>

<div class="form-group clearfix">
    <div class="col-sm-6">
        <?php echo $form->field($goods,'price_str')->textInput()->hint('Цена прописью')->label('Цена прописью'); ?>
    </div>
</div>

<?php echo Html::submitButton('Submit', ['class'=> 'btn btn-primary']); ?>
<?php ActiveForm::end(); ?>
                
</div>
