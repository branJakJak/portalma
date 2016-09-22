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
<br>
<section id="main-content">
        <section class="wrapper">
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

        </section>
</section>