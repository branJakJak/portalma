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

?>
<br>
<br>k
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-md-4 col-sm-4 mb">
                <!-- REVENUE PANEL -->
                <div class="green-panel pn">
                    <div class="green-header">
                        <h5>REVENUE  - @TODO</h5>
                    </div>
                    <div class="chart mt">
                        <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,464,655]"><canvas width="320" height="75" style="display: inline-block; width: 320px; height: 75px; vertical-align: top;"></canvas></div>
                    </div>
                    <p class="mt"><b>$ 17,980</b><br>Month Income</p>
                </div>
            </div>
        </div>        
    </section>
    <section class="wrapper">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                <div class="ds content-panel entries-agent">
                        <h1>
                                Data submitted by <?= Html::encode($agentModel->username); ?>
                                <?php if (Yii::$app->user->can('admin')): ?>
                                    <?= Html::a("Export this record",['/download/agent','agentName'=>$agentModel->username], ['class'=>'btn btn-default']); ?>
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