<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyActiveClaims */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Money Active Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-active-claims-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'firstname',
            'surname',
            'postcode',
            'address',
            'mobile',
            'tm',
            'acc_rej',
            'outcome',
            'packs_out',
            'date_submitted',
            'updated_at',
        ],
    ]) ?>

</div>
