<?php 
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h1>Submissions</h1>
    Items per page : <?php echo \nterms\pagesize\PageSize::widget([
        'sizes'=>[
                '50'=>'50',
                '100'=>'100',
                '150'=>'150',
                '200'=>'200'
            ],
        'template'=>'{list} {label}'

    ]); ?>
    <hr>
    <?=
    GridView::widget([
        'dataProvider' => $dataSubmissiondataProvider,
        'filterSelector' => 'select[name="per-page"]',
        'tableOptions' => [
            'class'=>'table table-striped table-condensed table-bordered'
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'date_submitted:datetime',
            'pb_agent',
            'title',
            'firstname',
            'surname',
            'mobile',
            // 'tm',
            // 'postcode',
            // 'address',
            // 'acc_rej',
            // 'outcome',
            // 'notes',
            // 'comment'
            [
                'value'=>function($model){
                    return Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View',['/leads/view','id'=>$model->id],['target'=>'_blank','class'=>'btn btn-link']);
                },
                'encodeLabel'=>false,
                'format'=>'html'
            ]
        ]
    ]);
    ?>

</div>
<div class="clearfix"></div>
