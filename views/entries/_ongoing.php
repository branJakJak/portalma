<?php
/**
 * @var $model \app\models\MoneyActiveClaims
 */
?>
<hr>
<a href="<?=  \yii\helpers\Url::to(["/entries/new",'claim'=>$model->id]) ?>">
    <strong>
        <?= $model->title.' '.$model->firstname . ' '. $model->surname ?> | <?= $model->submittedBy->username?>
    </strong>
</a>
