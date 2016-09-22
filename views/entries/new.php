<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/22/16
 * Time: 12:31 AM
 */
use app\models\UserAccount;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var $pendingClaims \yii\data\ActiveDataProvider
 * @var $ongoingClaims \yii\data\ActiveDataProvider
 * @var $completedClaims \yii\data\ActiveDataProvider
 * @var $model \app\models\MoneyActiveClaims
 */



?>


<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
            	New Claims Arrived <span class="label label-info pull-right"><?= $pendingClaims->count ?></span>
            </h3>
        </div>
        <div class="panel-body">
            <?=
            ListView::widget([
                'dataProvider' => $pendingClaims,
                'itemView' => '_new_arrival',
            ]);
            ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
            	Ongoing <span class="label label-default pull-right"><?= $ongoingClaims->count ?></span>
            </h3>
        </div>
        <div class="panel-body">
            <?=
            ListView::widget([
                'dataProvider' => $ongoingClaims,
                'itemView' => '_ongoing',
            ]);
            ?>
        </div>
    </div>
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

                        <?= $form->field($model,'tm')->dropDownList(ArrayHelper::map(UserAccount::find()->where(['account_type'=>UserAccount::USER_ACCOUNT_TYPE_AGENT])->all(), 'username', 'username'))    ?>

					    <?= $form->field($model, 'acc_rej')->dropDownList(['ACC'=>'ACC','REJ'=>'REJ']) ?>

					    <?= $form->field($model, 'outcome')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'packs_out')->textInput(['maxlength' => true]) ?>

					    <hr>
					    <?= $form->field($model, 'notes')->textarea(['style'=>'margin-top: 0px; margin-bottom: 0px; height: 137px;']); ?>
					    <hr>



					    <div class="form-group">
					        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-primary  btn-block']) ?>
					    </div>

				    <?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">	
	<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">
					Completed
					<span class="label label-success pull-right">
					<?= $completedClaims->count ?>
					</span>
				</h3>
			</div>
			<div class="panel-body">
				<?= 
					ListView::widget([
						'dataProvider' => $completedClaims,
						'itemView' => '_completed',
					]);
				?>
			</div>
		</div>	
</div>
