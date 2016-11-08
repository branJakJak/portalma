<?php 
use yii\grid\GridView;

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h1>Submissions</h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataSubmissiondataProvider,
        'tableOptions' => [
            'class'=>'table table-striped table-condensed table-bordered'
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'date_submitted',
                'value'=>function($model){
                    return \Yii::$app->formatter->asDatetime($model->date_submitted, "php:d/m/y H:i:s");
                },
            ],
            'pb_agent',
            'title',
            'firstname',
            'surname',
            'mobile',
            'comment',
            'tm',
            // 'postcode',
            // 'address',
            'acc_rej',
            'outcome',
            'notes',
            // 'packs_out'
        ]
    ]);
    ?>
</div>
<div class="clearfix"></div>
