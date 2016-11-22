<?php 

use yii\grid\GridView;
use yii\helpers\Html;
$customCss = <<< SCRIPT
        .entries-agent {
                padding: 20px;
        }
SCRIPT;
$this->registerCss($customCss);
?>
<section id="main-content">
<section class="wrapper">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="ds content-panel entries-agent">
                <h1><?= $agentName ?> - callbacks</h1>
                <?= GridView::widget([
                    'dataProvider' => $callbackDataProvider,
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
            </div>
            
        </div>
    </div>
</section>
</section>
