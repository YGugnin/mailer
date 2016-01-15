<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="row">
        <div class="col-md-2 menu">
            <?php
            echo Menu::widget([
                'items' => [
                    ['label' => 'Users', 'url' => ['/']],
                    ['label' => 'Lists', 'url' => ['/lists']],
                    ['label' => 'Send / List mails', 'url' => ['/mails']],
                    ['label' => 'Send Log', 'url' => ['/send-log']],
                ],
                'activeCssClass'=>'activeclass',
            ]);
            ?>
        </div>
        <div class="col-md-10 content">
            <div class="container">
                <?= $content;?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
        <p class="pull-left">&copy; Mailer <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
