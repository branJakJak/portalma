<?php 

use yii\helpers\Json;


/*remove this at production*/
unset($this_month_revenue_data);
$this_month_revenue_data = [];
/*upto this*/


$totalMonthRev =  0;
$sparklineData = array();
foreach ($monthlyRevenueCollection as $key => $value) {
    $this_month_revenue_data[] = $value;
    $totalMonthRev += floatval($value);
}


/*use this at production*/
$sparklineData = implode($this_month_revenue_data, ',');
$lineChartCode = <<< SCRIPT
    console.log([$sparklineData]);
    $("#this_month_revenue").sparkline([$sparklineData], {
        type: 'line',
        width: '90%',
        height: '75',
        valueSpots: {'0:': "#fff"},
        fillColor: '',
        lineColor: '#fff',
        resize: true,
        lineWidth: 1,
        spotColor: '#fff',
        spotRadius: 4,
        highlightLineColor: '#ffffff',
        tooltipFormat: '<span style="display:block; padding:0px 10px 12px 0px;">' +
        '<span style="color: {{color}}">&pound;</span> {{y}} | {{offset:offset}}</span>',
        tooltipValueLookups: {
            'offset': {
                0:'January',
                1:'February',
                2:'March',
                3:'April',
                4:'May',
                5:'June',
                6:'July',
                7:'August',
                8:'September',
                9:'October',
                10:'November',
                11:'December'
            }
        },        

    });
SCRIPT;
$this->registerJs($lineChartCode, \yii\web\View::POS_READY);
?>
<div class="darkblue-panel pn">
    <div class="darkblue-header">
        <h5>
            MONTHLY SUBMISSION
            <br>
            <small class="hidden">@TODO - computation</small> 
        </h5>
    </div>
    <div class="chart mt">
        <div id="this_month_revenue"></div>
    </div>
    <p class="mt">
        <strong style="color: white">
            <b>$ <?= number_format($totalMonthRev) ?></b>
        </strong>
        <br/>
        This Months Submission
    </p>
</div>