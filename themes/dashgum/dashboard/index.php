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
            <div class="col-md-4 col-sm-4 mb hidden">
                <!-- Revenue Today -->
                <?php 
                    //$this->render('_revenue_today', compact('total_revenue_today')); 
                ?>
                <!-- pox vs all leads -->
                <?php 
                // 
                    //$this->render('_pox1_percent_all', compact('pox_vs_lead','poxLeadPercentage')); 
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
        <div class="ds content-panel">
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
        <h3>NOTIFICATIONS</h3>

        <!-- First Action -->
        <div class="desc">
            <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
            </div>
            <div class="details">
                <p>
                    <muted>2 Minutes Ago</muted>
                    <br/>
                    <a href="#">James Brown</a> subscribed to your newsletter.<br/>
                </p>
            </div>
        </div>
        <!-- Second Action -->
        <div class="desc">
            <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
            </div>
            <div class="details">
                <p>
                    <muted>3 Hours Ago</muted>
                    <br/>
                    <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
                </p>
            </div>
        </div>
        <!-- Third Action -->
        <div class="desc">
            <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
            </div>
            <div class="details">
                <p>
                    <muted>7 Hours Ago</muted>
                    <br/>
                    <a href="#">Brandon Page</a> purchased a year subscription.<br/>
                </p>
            </div>
        </div>
        <!-- Fourth Action -->
        <div class="desc">
            <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
            </div>
            <div class="details">
                <p>
                    <muted>11 Hours Ago</muted>
                    <br/>
                    <a href="#">Mark Twain</a> commented your post.<br/>
                </p>
            </div>
        </div>
        <!-- Fifth Action -->
        <div class="desc">
            <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
            </div>
            <div class="details">
                <p>
                    <muted>18 Hours Ago</muted>
                    <br/>
                    <a href="#">Daniel Pratt</a> purchased a wallet in your store.<br/>
                </p>
            </div>
        </div>
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