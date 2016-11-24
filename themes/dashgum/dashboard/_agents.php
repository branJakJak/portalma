<?php 
use yii\grid\GridView;
use yii\helpers\Html;


$this->registerJsFile('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$customScript = <<< SCRIPT

/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover({
         'trigger':'hover'
    }); 
});

SCRIPT;

$this->registerJs($customScript, \yii\web\View::POS_READY);
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
            [
                'header'=>'Notes',
                'value' => function($model){
                    $retVal = $model->notes;
                    if (strlen($model->notes) > 10) {
                        $retVal = substr($model->notes, 0,10).'...';
                    }
                    // return Html::a($retVal, "#", ['data-toggle'=>"popover",'data-placement'=>'top','data-content'=>$model->notes]);
                    return Html::tag('span', $retVal, [
                        'data-placement'=>'top',
                        'data-content'=> $model->notes,
                        'data-toggle'=>'popover',
                        'style'=>'text-decoration: underline; cursor:pointer;'
                    ]);
                },
                'format'=>'raw',
            ],
            [
                'header'=>'Notes',
                'value' => function($model){
                    $retVal = $model->comment;
                    if (strlen($model->comment) > 10) {
                        $retVal = substr($model->comment, 0,10).'...';
                    }
                    // return Html::a($retVal, "#", ['data-toggle'=>"popover",'data-placement'=>'top','data-content'=>$model->comment]);
                    return Html::tag('span', $retVal, [
                        'data-placement'=>'top',
                        'data-content'=> $model->comment,
                        'data-toggle'=>'popover',
                        'style'=>'text-decoration: underline; cursor:pointer;'
                    ]);
                },
                'format'=>'raw',
            ],
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
