<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyActiveClaims */

$this->title = 'Update Money Active Claims: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Money Active Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="money-active-claims-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
