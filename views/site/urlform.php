<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])?>
    <?=$f->field($form, 'url')->textarea(['rows' => '15'])->label('Введите в список url')?>
    <?=$f->field($form, 'type')->dropDownList([
        'min' => 'Минуты',
        'hours' => 'Часы',
        'week' => 'Недели',
        'months' => 'Месяца',
        'years' => 'Года',
    ], [
            'prompt' => 'Выберите единицу измерения'
    ])?>
    <?=$f->field($form, 'interval')?>
    <?=$f->field($form, 'file')->fileInput()?>
    <?=Html::submitButton('Добавить & Загрузить', ['class' => 'btn btn-primary'])?>
<?php ActiveForm::end()?>
<h1><?echo($mess)?></h1>
