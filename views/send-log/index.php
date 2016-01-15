<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SendLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Send Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="send-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php

        $list = \app\models\Mails::find()->all();
        $mails = ArrayHelper::map($list,'id','subject');

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
                'attribute' => 'mail_id',
                'value' => function ($data) {
                    return Html::a(Html::encode($data->mail['subject']), Url::to(['mails/view', 'id' => $data->mail_id]));
                },
                'format' => 'raw',
                'filter' => $mails
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
