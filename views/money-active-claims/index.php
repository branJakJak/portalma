<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leads';
$this->params['breadcrumbs'][] = "Leads";

?>
<div class="container-fluid">
    <div class="row">
        <h1>
            <?= Html::encode($this->title) ?>
            <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add record', ['create'], ['class' => 'btn btn-link']) ?>
        </h1>
        <hr>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                     Search mobile:</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([]); ?>
                      <div class="input-group">
                            <?= $form->field($searchForm, 'searchTerm') ?>
                            <span class="input-group-btn">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block','style'=>'    margin-top: 24px;']) ?>
                            </span>
                      </div>                    
                        
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'title',
                    'firstname',
                    'surname',
                    // 'postcode',
                    'notes',
                    // 'address',
                    'mobile',
                    'tm',
                    'acc_rej',
                    'outcome',
                    'packs_out',
                    // 'submitted_by',
                    'date_submitted:datetime',
                    [
                        'attribute'=>'updated_at',
                        'label'=>'Last updated',
                    ],
                    'updated_at:datetime',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); 
            ?>
        </div>
    </div>
</div>