<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/22/16
 * Time: 12:31 AM
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>


<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">New Money Active Claim</h3>
		</div>
		<div class="panel-body">
				<?php if (Yii::$app->session->hasFlash('success')): ?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?= Yii::$app->session->getFlash('success') ?>
				</div>
				<?php endif ?>
		
			<?= Html::errorSummary($model) ?>
			<div class="money-active-claims-form">

				    <?php $form = ActiveForm::begin(); ?>


						<?= $form->field($model, 'title')->dropDownList(['Ms.'=>'Ms.','Mr.'=>'Mr.','Mrs.'=>'Mrs.'], []); ?>    

					    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'address')->textarea(['maxlength' => true]); ?>

					    <?= $form->field($model, 'mobile')->textInput() ?>

					    <?= $form->field($model, 'tm')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'acc_rej')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'outcome')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'packs_out')->textInput(['maxlength' => true]) ?>

					    <div class="form-group">
					        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-primary']) ?>
					    </div>

				    <?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">	
</div>
