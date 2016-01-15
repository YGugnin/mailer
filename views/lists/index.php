<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ListsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lists-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'last_sent',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'last_sent',
                    'language' => 'en',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'format' => 'date',
            ],
            [
                'attribute' => 'created',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'created',
                    'language' => 'en',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'format' => 'date',
            ],
            [
                'attribute' => 'modified',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'modified',
                    'language' => 'en',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'format' => 'date',
            ],
            'users_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
