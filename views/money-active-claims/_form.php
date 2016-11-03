<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyActiveClaims */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-active-claims-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput() ?>

    <?= $form->field($model, 'tm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acc_rej')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_birth') ?>

    <?= $form->field($model, 'outcome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'packs_out')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'submitted_by')->textInput() ?>

    <?= $form->field($model, 'date_submitted')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
