<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MoneyActiveClaims */

$this->title = 'Create Money Active Claims';
$this->params['breadcrumbs'][] = ['label' => 'Money Active Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-active-claims-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
