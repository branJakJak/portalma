<?php
/**
 * @var $model \app\models\MoneyActiveClaims
 */
?>
<hr>
<a href="<?=  \yii\helpers\Url::to(["/entries/new",'claim'=>$model->id]) ?>">
    <mute>
        <?= $model->title.' '.$model->firstname . ' '. $model->surname ?> | <?= $model->submittedBy->username?>
    </mute>
</a>
