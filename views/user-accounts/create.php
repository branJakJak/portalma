<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserAccount */

$this->title = 'Register Account';
// $this->params['breadcrumbs'][] = ['label' => 'User Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="main-content">
<section class="wrapper">

<div class="user-account-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</section>
</section>
