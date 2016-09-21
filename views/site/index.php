<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Portal pb.site8.co</h1>
        <hr>
        <p>
            <?php if (Yii::$app->user->isGuest): ?>
                
            <?=
                \yii\bootstrap\Html::a("Login",['site/login'],['class'=>''])
            ?>
            |
            <?=
            \yii\bootstrap\Html::a("Register",['/login'],['class'=>''])
            ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <?=
                \yii\bootstrap\Html::a("Go to Dashboard",['/dashboard'],['class'=>'btn btn-primary'])
                ?>
                
            <?php endif ?>
        </p>
    </div>

</div>
