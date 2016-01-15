<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Mails */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Mails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'subject',
            'body:html',
            'send_as_copy:boolean',
            [
                'attribute' => 'list.name',
                'label' => 'List'
            ],

            'created:date',
        ],
    ]) ?>

    <h1>Sent mails</h1>

    <?php
    $list = \app\models\Users::find()->all();
    $users = ArrayHelper::map($list,'id','name');

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function($model){
            if(!$model->success){
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return Html::a(Html::encode($data->user['name']), Url::to(['users/view', 'id' => $data->user_id]));
                },
                'format' => 'raw',
                'filter' => $users
            ],
            [
                'attribute' => 'send_time',
                'format' => 'date',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'send_time',
                    'language' => 'en',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
            ],
            [
                'attribute' => 'success',
                'format' => 'boolean',
                'filter' => [ 0 => 'No', 1 => 'Yes']
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>

</div>
