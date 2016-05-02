<div class="admin-default-index">
<?php 
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<a href="<?php echo Url::toRoute('currency/index');?>">Список валют</a><br/>
<h1>Добавить товар</h1>
<?php $form = ActiveForm::begin(); ?>
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
        <?php echo $form->field($goods, 'currency_id')->dropDownList($currencyList,array('prompt'=>'Выберите значение(по умолчанию в рублях)')); ?>
    </div>
</div>

<div class="form-group clearfix">
    <div class="col-sm-6">
        <?php echo $form->field($goods,'price_str')->textInput(); ?>
    </div>
</div>

<?php echo Html::submitButton('Добавить', ['class'=> 'btn btn-primary']); ?>
<?php ActiveForm::end(); ?>
                
</div>