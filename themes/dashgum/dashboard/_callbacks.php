<?php
/**
 * @var $model \app\models\MoneyActiveClaims
 */
$url = \yii\helpers\Url::to(["/leads/view", 'id' => $model->id]);
?>
<div class="desc">
    <div class="thumb">
        <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
    </div>
    <div class="details">
        <p>
            <muted>
            <?= \yii\timeago\TimeAgo::widget(['timestamp' => $model->date_submitted]); ?>
            </muted>
            <br/>

            <a href="<?= $url ?>"><?= sprintf("%s %s %s",$model->title , $model->title,$model->surname) ?></a> <br/>
        </p>
    </div>
</div>
