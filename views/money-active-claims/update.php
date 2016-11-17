<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyActiveClaims */

$currentFullname = sprintf("%s %s %s",$model->title,$model->firstname,$model->surname);
$this->title = 'Update Money Active Claims: ' . $currentFullname;
$this->params['breadcrumbs'][] = ['label' => 'Money Active Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $currentFullname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="money-active-claims-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
