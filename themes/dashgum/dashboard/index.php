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

?>
<section id="main-content">
<section class="wrapper">

<div class="row">
    <div class="col-lg-9 main-chart">
        <div class="row ">
            <div class="col-md-4 col-sm-4 mb">
                <!-- Revenue Today -->
                <?php //$this->render('_revenue_today', compact('total_revenue_today')); ?>
                <!-- pox vs all leads -->
                <?= $this->render('_pox1_percent_all', compact('pox_vs_lead','poxLeadPercentage')); ?>
            </div>
            <!-- /col-md-4 -->

            <div class="col-md-4 col-sm-4 mb">
                <!-- revenue this week -->
                <?= $this->render('_this_week_revenue', compact('weeklyRevenueDataCollection')); ?>

            </div>
            <!-- /col-md-4 -->

            <div class="col-md-4 col-sm-4 mb">
                <!-- revenue this month -->
                <?= $this->render('_this_month_revenue', compact('monthlyRevenueCollection')); ?>
            </div>
            <!-- /col-md-4 -->
        </div>
        <!-- /row -->
        <div class="ds content-panel">
            <?= $this->render('_agents', compact('dataProvider','agentSubmittionFilterModel')); ?>
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
        ]);?>
    </aside>
</div>
<!-- /col-lg-3 -->
</div>
<! --/row -->
</section>
</section>
