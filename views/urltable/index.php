<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UrlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обзор';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('
     $(document).ready(function(){
    $(\'#MyButton\').click(function(){

        var HotId = $(\'#w1\').yiiGridView(\'getSelectedRows\');
          $.ajax({
            type: \'POST\',
            url : \'urltable/multiple-delete\',
            data : {
    row_id:
    HotId},
            success : function ()
{
    $(this) . closest(\'tr\').remove();
            }
        });

    });
    });
', \yii\web\View::POS_READY);
?>
<div class="url-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить ссылку (тест)', ['create'], ['class' => 'btn btn-success']) ?>
        <input type="button" class="btn btn-info" value="Multiple Delete" id="MyButton" >
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            'create_date',
            'url:url',
            'first_url_file:url',
            'last_url_file:url',
            'last_check_date',
            'ckeck_interval',
            'status',
            'meta_title',
            'meta_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
