<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        $lists = \app\models\Lists::find()->all();
        $items = ArrayHelper::map($lists,'id','name');
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',
            'body:ntext',
            [
                'attribute' => 'send_as_copy',
                'format' => 'boolean',
                //'filter' => Html::input('boolean', 'UsersSearch[blocked]'),
                'filter' => [ 0 => 'No', 1 => 'Yes']
            ],
            [
                'attribute' => 'list_id',
                'filter' => $items,
                'value' => function ($data) {
                    return Html::a(Html::encode($data->list['name']), Url::to(['lists/view', 'id' => $data->list_id]));
                },
                'format' => 'raw',


            ],
            [

                'attribute' => 'created',
                'format' => 'date',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'created',
                    'language' => 'en',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>

</div>
