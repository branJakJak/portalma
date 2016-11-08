<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = sprintf("%s %s %s",$this->title,$this->firstname,$this->surname) .' record';
$this->params['breadcrumbs'][] = sprintf("%s %s %s",$this->title,$this->firstname,$this->surname);
?>
<div class="money-active-claims-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--     <p>
        <?= Html::a('Create Money Active Claims', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 -->    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'firstname',
            'surname',
            'postcode',
            'notes',
            'address',
            'mobile',
            'tm',
            'acc_rej',
            'outcome',
            'packs_out',
            // 'submitted_by',
            // 'date_submitted',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
