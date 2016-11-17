<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyActiveClaims */

$this->title = sprintf("%s %s %s",$model->title,$model->firstname,$model->surname) .' record';
if (Yii::$app->user->can("admin")) {
    $this->params['breadcrumbs'][] = ['label' => 'Leads', 'url' => ['index']];
}else if (Yii::$app->user->can("agent")) {
    $this->params['breadcrumbs'][]  = $this->title = sprintf("%s %s %s " , $model->title,$model->firstname,$model->surname);
}



?>
<div class="money-active-claims-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin')): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>
    <?php if (Yii::$app->user->can('agent')): ?>
        <?= Html::a("New Entry", ['entries/new'],['class'=>'btn btn-primary btn-lg']); ?>        
    <?php endif ?>
    <?=
    DetailView::widget([
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
            'claim_status',
            'packs_out',
            'notes',
            'comment',
            'date_of_birth',
            'email',
            'bank_name',
            // 'approx_month',
            // 'approx_date',
            // 'approx_year',
            'paid_per_month',
            'pb_agent',
            'bank_account_type',            
            'notes',            
            'comment',
            [
                'label'=>'Submitted by',
                'value'=>$model->submittedBy->username
            ],
            'date_submitted:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
