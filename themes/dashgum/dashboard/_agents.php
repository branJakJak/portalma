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
            'date_submitted:datetime',
            'pb_agent',
            'title',
            'firstname',
            'surname',
            'mobile',
            'tm',
            // 'postcode',
            // 'address',
            'acc_rej',
            'outcome',
            'notes',
            'comment'
        ]
    ]);
    ?>
</div>
<div class="clearfix"></div>
