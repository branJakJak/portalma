<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => \yii\helpers\ArrayHelper::merge([
                ['label' => 'Home', 'url' => ['/site/index'],'visible'=>!Yii::$app->user->can('admin')],
                ['label' => 'Dashboard', 'url' => ['/dashboard'],'visible'=>Yii::$app->user->can('admin')],
                ['label' => 'User Accts', 'url' => ['/user-accounts/index'],'visible'=>Yii::$app->user->can('admin')],
                // ['label' => 'My Entries', 'url' => ['/entries/index','agent'=>Yii::$app->user->identity->username],'visible'=>Yii::$app->user->can('agent') && !Yii::$app->user->isGuest],
                Yii::$app->user->isGuest ? ['label' => 'Register', 'url' => ['/register'] , 'visible'=>!Yii::$app->user->isGuest]:'',
                Yii::$app->user->isGuest ?
                    ['label' => 'Login', 'url' => ['/login']] :
                    [
                        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ],
            ], Yii::$app->params['menu']),
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
