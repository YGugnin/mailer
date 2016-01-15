<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Mails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mails-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'send_as_copy')->checkbox() ?>

    <?php
        $lists = \app\models\Lists::find()->all();
        $items = ArrayHelper::map($lists,'id','name');
    ?>
    <?= $form->field($model, 'list_id')->dropDownList($items,['prompt' => '[Select list]']); ?>

    <div class="alert-block">* Emails for blocked users will not send</div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
