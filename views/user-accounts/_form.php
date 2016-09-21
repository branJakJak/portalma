<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserAccount */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">        
    </div>
        
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success!</strong> <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif ?>


        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Register new Account</h3>
          </div>
          <div class="panel-body">
            <div class="user-account-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Register' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
          </div>
        </div>            
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        
    </div>

</div>

