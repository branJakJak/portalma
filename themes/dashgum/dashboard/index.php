<?php
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

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
        <li>
          <a href="javascript:;">
            <?php 
                $mTAgentEntriesReport->setMtAgent($currentMtAgent->id);
            ?>
            <?= $currentMtAgent->username ?> | <?= $mTAgentEntriesReport->getPercentageAll() ?>
          </a>
        </li>
    <?php endforeach ?>
<?php $this->endBlock(); ?>