<?php
/* @var $this yii\web\View */
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $agentModel \app\models\UserAccount
 */
use yii\grid\GridView;
use yii\helpers\Html;
$customCss = <<< SCRIPT
        .entries-agent {
                padding: 20px;
        }
SCRIPT;
$this->registerCss($customCss);


$sidebarToggleBox = <<< SCRIPT
    setTimeout(function(){
        jQuery(".sidebar-toggle-box .fa-bars").click();
    }, 200);
SCRIPT;
$this->registerJs($sidebarToggleBox, \yii\web\View::POS_READY);



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

<br>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1>
                    Agent : <small><?= Html::encode($agent); ?></small>
                </h1>
            </div>
        </div>
    </section>
    <section class="wrapper">
        <div class="row">
            <div class="col-md-4 col-sm-4 mb">
                <!-- Today -->
                <div class="weather-3 pn centered" id="pox-today">
                    <i class="fa fa-calendar-check-o"></i>
                    <h1>
                        Today
                    </h1>
                    <div class="info">
                        <div class="row">
                                <h3 class="centered">MADRID</h3>
                            <div class="col-sm-6 col-xs-6 pull-left">
                                <p class="goleft">
                                    <i class="fa fa-tint"></i> 
                                    <?= $todayPercentage ?>
                                </p>
                            </div>
                            <div class="col-sm-6 col-xs-6 pull-right">
                                <p class="goright"><i class="fa fa-flag"></i> 
                                    <?= $todaySubmission ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 mb">
                <!-- Week -->
                <div class="weather-3 pn centered" id="pox-week">
                    <i class="fa fa-calendar-minus-o"></i>
                    <h1>Week</h1>
                    <div class="info">
                        <div class="row">
                                <h3 class="centered">MADRID</h3>
                            <div class="col-sm-6 col-xs-6 pull-left">
                                <p class="goleft">
                                    <i class="fa fa-tint"></i>
                                    <?= $weekPercentage ?>
                                </p>
                            </div>
                            <div class="col-sm-6 col-xs-6 pull-right">
                                <p class="goright"><i class="fa fa-flag"></i> 
                                <?= $weekSubmission ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 mb">
                <!-- Month -->
                <div class="weather-3 pn centered" id="pox-month">
                    <i class="fa fa-calendar"></i>
                    <h1>Month</h1>
                    <div class="info">
                        <div class="row">
                                <h3 class="centered">MADRID</h3>
                            <div class="col-sm-6 col-xs-6 pull-left">
                                <p class="goleft">
                                    <i class="fa fa-tint"></i> 
                                    <?= $monthPercentage ?>
                                </p>
                            </div>
                            <div class="col-sm-6 col-xs-6 pull-right">
                                <p class="goright"><i class="fa fa-flag"></i>
                                <?= $monthSubmission ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </section>
    <section class="wrapper">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                <div class="ds content-panel entries-agent">
                        <h1>
                                Data submitted by <?= Html::encode($agent); ?>
                                <?php if (Yii::$app->user->can('admin')): ?>
                                    <?= Html::a("Export this record",['/download/agent','agentName'=>$agent], ['class'=>'btn btn-default']); ?>
                                <?php endif ?>
                        </h1>
                        <hr>
                        <p>
                        <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                        'title',
                        'firstname',
                        'surname',
                        'postcode',
                         'address',
                         'mobile',
                         'tm',
                         'acc_rej',
                         'outcome',
                         'packs_out',
                        // 'submitted_by',
                        // 'date_submitted',
                        // 'updated_at',
                        ]
                        ]);?>
                        </p>
                </div>
            </div>
        </div>
    </section>
</section>