<?php
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use app\models\MoneyActiveClaims;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;

$customCss = <<< SCRIPT
    .ds .desc {
        width: auto;
    }
SCRIPT;
$this->registerCss($customCss);


$this->registerCssFile('//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');

?>

<style type="text/css">
    #pox-today{
        background: #444c57;
    }
    #pox-week{
        background: #444c57;
    }
    #pox-month{
        background: #444c57;
    }
     .ds td a {
        color: white !important;
     }
    .pox1-hit {
        background: green !important;
        color: white;
    }
    .pox1-hit .popover-content , .non-pox1-hit .popover-content{
        color: #808080 !important;
    }
    .non-pox1-hit{
        background: red !important;
        color: white;
    }
</style>


<section id="main-content">
<section class="wrapper">

<div class="row">
    <div class="col-lg-9 main-chart">
        <div class="row ">
            <div class="col-md-4 col-sm-4 mb">
                <!-- Revenue Today -->
                <?php 
                    // $this->render('_revenue_today', compact('total_revenue_today')); 
                ?>
                <!-- pox vs all today -->
                <?= 
                    $this->render('_percentage_today', compact('poxToday','leadToday','percentageToday')); 
                ?>
            </div>
            <!-- /col-md-4 -->

            <div class="col-md-4 col-sm-4 mb">
                <!-- percentage this week -->
                <?php 
                    //$this->render('_this_week_revenue', compact('weeklyRevenueDataCollection')); 
                ?>
                <?= $this->render('_percentage_this_week', compact('percentageThisWeek','poxThisWeek','leadThisWeek') ); ?>
            </div>
            <!-- /col-md-4 -->

            <div class="col-md-4 col-sm-4 mb">
                <!-- percentage this month -->
                <?php 
                    //$this->render('_this_month_revenue', compact('monthlyRevenueCollection')); 
                ?>
                <?= $this->render('_percentage_this_month', compact('percentageThisMonth','poxThisMonth','leadThisMonth') ); ?>
            </div>
            <!-- /col-md-4 -->
        </div>
        <!-- /row -->
        <div class="ds content-panel" style="overflow: scroll;">
            <?= 
            $this->render('_agents', compact('dataSubmissiondataProvider','agentSubmittionFilterModel')); 
            ?>
        </div>
    </div>
    <!-- /col-lg-9 END SECTION MIDDLE -->


<!-- **********************************************************************************************************************************************************
RIGHT SIDEBAR CONTENT
*********************************************************************************************************************************************************** -->

<div class="col-lg-3 ds ">
    <!--COMPLETED ACTIONS DONUTS CHART-->
    <aside class="notification-area hidden">
        <h3>Callbacks</h3>
        <?=
            ListView::widget([
                'dataProvider' => $callbackDataProvider,
                'itemView' => '_callbacks',
                'layout' => "{summary}\n{items}\n{pager}",
            ]);
        ?>

    </aside>

    <aside class="team-members-panel ">
        <!-- USERS ONLINE SECTION -->
        <h3>Agents</h3>
        <br>

        <?=
            ListView::widget([
                'dataProvider' => $agentsList,
                'itemView' => '_list',
                'layout' => "{pager}{summary}\n{items}\n{pager}",
            ]);
        ?>
    </aside>
</div>
<!-- /col-lg-3 -->
</div>
<! --/row -->
</section>
</section>


<?php $this->beginBlock('mt_agents') ?>
    <?php foreach ($mtAgentsCollection as $currentMtAgent): ?>
        <?php 
            $callbackCount = MoneyActiveClaims::find()->where(['outcome'=>'CALL BACK','submitted_by'=>$currentMtAgent->id])->count();
        ?>
        <li>
          <a href="<?= Url::to(["/callback-report/agent",'agentName'=>$currentMtAgent->username]) ?>">
            <?php 
                $mTAgentEntriesReport->setMtAgent($currentMtAgent->id);
            ?>
            <?= $currentMtAgent->username ?> 
            <br> 
            <strong>
                POX : <?= $mTAgentEntriesReport->getPercentageAll() ?>
            </strong>
            <br> 
            <strong>
                Callback : <?= $callbackCount ?>
            </strong>            
          </a>
        </li>
    <?php endforeach ?>
<?php $this->endBlock(); ?>


<?php 
    $modalObject = Modal::begin([
        'header' => '<h2 style="color: white">Export range</h2>',
        'toggleButton' => ['label' => 'Range'],
    ]);
?>
<form action="/download/range" method="GET" role="form">

    <label>From:</label>
    <?= 
        DatePicker::widget([
            'name'  => 'date_from',
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]                                  
        ]);
    ?>
    <br>
    <label>To:</label>
    <?= 
        DatePicker::widget([
            'name'  => 'date_to',
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]);
    ?>
    <br>
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
</form>



<?php
    Modal::end();
?>
