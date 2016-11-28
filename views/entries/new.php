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


// TODO auto update for pending and ongoing listview
$customScript = <<< SCRIPT

jQuery("body").on('click', '#pendingClaims a , #ongoingClaims a', function(event) {
	event.preventDefault();
	window.location.href = jQuery(this).attr('href');
});


setInterval(function () {
	$.pjax.reload({container:'#pendingClaims',async:false});
	$.pjax.reload({container:'#ongoingClaims',async:false});
	$.pjax.reload({container:'#completedClaims',async:false});
}, 5000);

SCRIPT;
/*disable auto update*/
// $this->registerJs($customScript, \yii\web\View::POS_READY);

// datasource for outcome  , dropdown
// $outcomeDatasource = [
//     "ACCEPTED" => "ACCEPTED",
//     "ALREADY  CLAIMED" => "ALREADY  CLAIMED",
//     "ALREADY CLAIMED" => "ALREADY CLAIMED",
//     "ALREADY CLAIMING" => "ALREADY CLAIMING",
//     "BAD LINE" => "BAD LINE",
//     "BAD LINE - CALL BACK" => "BAD LINE - CALL BACK",
//     "BLANK CALL" => "BLANK CALL",
//     "CALL BACK" => "CALL BACK",
//     "CANNOT LOCATE LEAD" => "CANNOT LOCATE LEAD",
//     "CLIENT THOUGHT WE WAS BANK" => "CLIENT THOUGHT WE WAS BANK",
//     "COMPLAINT" => "COMPLAINT",
//     "CUTS OFF" => "CUTS OFF",
//     "DEAD LINE" => "DEAD LINE",
//     "DEADLINE" => "DEADLINE",
//     "DIDN'T HAVE TIME" => "DIDN'T HAVE TIME",
//     "DROPPED - CALL BACK NO ANSWER" => "DROPPED - CALL BACK NO ANSWER",
//     "DROPPED  " => "DROPPED  ",
//     "DROPPED CALL" => "DROPPED CALL",
//     "DUP" => "DUP",
//     "HUNG UP" => "HUNG UP",
//     "HUNG UP - NO ANSWER" => "HUNG UP - NO ANSWER",
//     "HUNG UP - NO PBA" => "HUNG UP - NO PBA",
//     "HUNG UP - THOUGHT WE WAS LENDER" => "HUNG UP - THOUGHT WE WAS LENDER",
//     "HUNG UP AFTER TRANSFER" => "HUNG UP AFTER TRANSFER",
//     "HUNG UP ON CLOSE" => "HUNG UP ON CLOSE",
//     "IVA" => "IVA",
//     "NO PBA" => "NO PBA",
//     "NO TIME TO SPEAK" => "NO TIME TO SPEAK",
//     "NON PLACABLE" => "NON PLACABLE",
//     "NON PLACEABLE" => "NON PLACEABLE",
//     "NOT INTERESTED" => "NOT INTERESTED",
//     "NOT INTERESTED " => "NOT INTERESTED ",
//     "NP" => "NP",
//     "NP - ACCOUNT ONLY RAN FOR 2 YEARS" => "NP - ACCOUNT ONLY RAN FOR 2 YEARS",
//     "NP - ACTIVE ENQUIRY" => "NP - ACTIVE ENQUIRY",
//     "NP - ACTIVELY SOUGHT ACCOUNT" => "NP - ACTIVELY SOUGHT ACCOUNT",
//     "NP - ACTIVELY TOOK OUT ACCOUNT" => "NP - ACTIVELY TOOK OUT ACCOUNT",
//     "NP - ALEADY CLAIMED" => "NP - ALEADY CLAIMED",
//     "NP - ALREADY CLAIMED" => "NP - ALREADY CLAIMED",
//     "NP - ALREADY CLAIMING" => "NP - ALREADY CLAIMING",
//     "NP - ALREAY" => "NP - ALREAY",
//     "NP - ALWAYS USED OD" => "NP - ALWAYS USED OD",
//     "NP - APPLIED ONLINE" => "NP - APPLIED ONLINE",
//     "NP - ARREARS" => "NP - ARREARS",
//     "NP - BANKRUPT" => "NP - BANKRUPT",
//     "NP - BARCLAYS 2 YEARS" => "NP - BARCLAYS 2 YEARS",
//     "NP - BEEN REJECTED" => "NP - BEEN REJECTED",
//     "NP - BENEFITS FROM THE ACCOUNT" => "NP - BENEFITS FROM THE ACCOUNT",
//     "NP - BUISNESS ACCOUNT" => "NP - BUISNESS ACCOUNT",
//     "NP - CANX 12 YEARS AGO" => "NP - CANX 12 YEARS AGO",
//     "NP - CLAIMED" => "NP - CLAIMED",
//     "NP - CLAIMED  " => "NP - CLAIMED  ",
//     "NP - CLAIMED ON TRAVEL" => "NP - CLAIMED ON TRAVEL",
//     "NP - CLAIMED OVER PHONE" => "NP - CLAIMED OVER PHONE",
//     "NP - COMPLAINT" => "NP - COMPLAINT",
//     "NP - DEBT COLLECTORS" => "NP - DEBT COLLECTORS",
//     "NP - DEBT MANAGEMENT" => "NP - DEBT MANAGEMENT",
//     "NP - DEBT RELIF ORDER" => "NP - DEBT RELIF ORDER",
//     "NP - DIDNT HAVE PBA" => "NP - DIDNT HAVE PBA",
//     "NP - ENQUIRED ABOUT IT" => "NP - ENQUIRED ABOUT IT",
//     "NP - EXACT DATES" => "NP - EXACT DATES",
//     "NP - FEE VALUE" => "NP - FEE VALUE",
//     "NP - FIRST DIRECT" => "NP - FIRST DIRECT",
//     "NP - HAD CLAIMED ON TRAVEL INSURANCE" => "NP - HAD CLAIMED ON TRAVEL INSURANCE",
//     "NP - HAD FOR 4 MONTHS" => "NP - HAD FOR 4 MONTHS",
//     "NP - HAD LESS THEN 1 YEAR" => "NP - HAD LESS THEN 1 YEAR",
//     "NP - HAPPY USES FEATURES" => "NP - HAPPY USES FEATURES",
//     "NP - HAPPY WITH ACC" => "NP - HAPPY WITH ACC",
//     "NP - HAPPY WITH ACCOUNT" => "NP - HAPPY WITH ACCOUNT",
//     "NP - IN DEBT" => "NP - IN DEBT",
//     "NP - IVA" => "NP - IVA",
//     "NP - LESS THEN 1 YEAR" => "NP - LESS THEN 1 YEAR",
//     "NP - LESS THEN A YEAR" => "NP - LESS THEN A YEAR",
//     "NP - LLOYDS 1 YEAR" => "NP - LLOYDS 1 YEAR",
//     "NP - LLOYDS 2 YEARS" => "NP - LLOYDS 2 YEARS",
//     "NP - LOW FEE" => "NP - LOW FEE",
//     "NP - LOW FINANCE" => "NP - LOW FINANCE",
//     "NP - MADE CLAIMS" => "NP - MADE CLAIMS",
//     "NP - MADE USE OF THE ACCOUNT" => "NP - MADE USE OF THE ACCOUNT",
//     "NP - MAKES USE OF THE ACCOUNT" => "NP - MAKES USE OF THE ACCOUNT",
//     "NP - MIGHT HAVE ALREADY CLAIMED" => "NP - MIGHT HAVE ALREADY CLAIMED",
//     "NP - NO ANSWER" => "NP - NO ANSWER",
//     "NP - NO LONGER WITH PARTNER" => "NP - NO LONGER WITH PARTNER",
//     "NP - NO ONE THERE" => "NP - NO ONE THERE",
//     "NP - NO PBA" => "NP - NO PBA",
//     "NP - NO TIME" => "NP - NO TIME",
//     "NP - NO TIME TO SPEAK" => "NP - NO TIME TO SPEAK",
//     "NP - NO TIME TO TALK" => "NP - NO TIME TO TALK",
//     "NP - NOBODY ON THE CALL" => "NP - NOBODY ON THE CALL",
//     "NP - NOT AWARE OF FEE" => "NP - NOT AWARE OF FEE",
//     "NP - NOT HAPPY WITH FEE" => "NP - NOT HAPPY WITH FEE",
//     "NP - NOT INTERESTED" => "NP - NOT INTERESTED",
//     "NP - NOT MISS SOLD" => "NP - NOT MISS SOLD",
//     "NP - NOT MISSOLD" => "NP - NOT MISSOLD",
//     "NP - ONLINE" => "NP - ONLINE",
//     "NP - ONLY 2 YEARS" => "NP - ONLY 2 YEARS",
//     "NP - ONLY ACTIVE 2 YEARS" => "NP - ONLY ACTIVE 2 YEARS",
//     "NP - ONLY ACTIVE FOR 2 YEARS" => "NP - ONLY ACTIVE FOR 2 YEARS",
//     "NP - ONLY HAD ACC FOR 1 YEAR" => "NP - ONLY HAD ACC FOR 1 YEAR",
//     "NP - ONLY HAD ACCOUNT FOR 1 YEAR" => "NP - ONLY HAD ACCOUNT FOR 1 YEAR",
//     "NP - ONLY HAD FOR 2 YEARS" => "NP - ONLY HAD FOR 2 YEARS",
//     "NP - ONLY ONE YEAR" => "NP - ONLY ONE YEAR",
//     "NP - ONLY PAID FOR ACCOUNT" => "NP - ONLY PAID FOR ACCOUNT",
//     "NP - ONLY RAN FOR 1 YEAR" => "NP - ONLY RAN FOR 1 YEAR",
//     "NP - ONLY RAN FOR 2 YEARS" => "NP - ONLY RAN FOR 2 YEARS",
//     "NP - OUT OF CRITERIA" => "NP - OUT OF CRITERIA",
//     "NP - OVERDRAFT HALIFAX" => "NP - OVERDRAFT HALIFAX",
//     "NP - OVERDRAFT USED" => "NP - OVERDRAFT USED",
//     "NP - PAID WHEN ILL" => "NP - PAID WHEN ILL",
//     "NP - REG IN OD" => "NP - REG IN OD",
//     "NP - SANTANDER" => "NP - SANTANDER",
//     "NP - TAKEN ACCOUNT ONLINE" => "NP - TAKEN ACCOUNT ONLINE",
//     "NP - TAKEN OUT OVER INTERNET" => "NP - TAKEN OUT OVER INTERNET",
//     "NP - TECH PACK" => "NP - TECH PACK",
//     "NP - TECK PACK" => "NP - TECK PACK",
//     "NP - THOUGHT WE WAS LENDER" => "NP - THOUGHT WE WAS LENDER",
//     "NP - THOUGHT WE WAS THE BANK" => "NP - THOUGHT WE WAS THE BANK",
//     "NP - THOUGHT WE WAS THE BANK, USED OD" => "NP - THOUGHT WE WAS THE BANK, USED OD",
//     "NP - TRAVEL INSURANCE" => "NP - TRAVEL INSURANCE",
//     "NP - UNAVILABLE TO SPEAK" => "NP - UNAVILABLE TO SPEAK",
//     "NP - UNSURE" => "NP - UNSURE",
//     "NP - UNSURE IF HE PAYS FOR THE ACCOUNT" => "NP - UNSURE IF HE PAYS FOR THE ACCOUNT",
//     "NP - UNSURE IF PBA" => "NP - UNSURE IF PBA",
//     "NP - UNSURE OF PBA" => "NP - UNSURE OF PBA",
//     "NP - USED 2XFEATURES" => "NP - USED 2XFEATURES",
//     "NP - USED 3 FEATURES" => "NP - USED 3 FEATURES",
//     "NP - USED A LOT OF THE PRODUCTS" => "NP - USED A LOT OF THE PRODUCTS",
//     "NP - USED BENEFITS" => "NP - USED BENEFITS",
//     "NP - USED FEATURES OF ACCOUNT" => "NP - USED FEATURES OF ACCOUNT",
//     "NP - USED OD" => "NP - USED OD",
//     "NP - USED OVERDRAFT" => "NP - USED OVERDRAFT",
//     "NP - USED TOO MUCH" => "NP - USED TOO MUCH",
//     "NP - USED TWO PRODUCTS" => "NP - USED TWO PRODUCTS",
//     "NP - USES BENEFITS" => "NP - USES BENEFITS",
//     "NP - USES FEATURES" => "NP - USES FEATURES",
//     "NP - USES FULL SERVICES" => "NP - USES FULL SERVICES",
//     "NP - WAS HAPPY WITH ACCOUNT" => "NP - WAS HAPPY WITH ACCOUNT",
//     "NP - WOULD NOT GIVE DOB" => "NP - WOULD NOT GIVE DOB",
//     "NP -WANTED THE UPGRADE" => "NP -WANTED THE UPGRADE",
//     "NP  - ARREARS" => "NP  - ARREARS",
//     "NP ON TERM" => "NP ON TERM",
//     "OUT OF CRITERIA" => "OUT OF CRITERIA",
//     "OUT OF CRITIERIA" => "OUT OF CRITIERIA",
//     "PACKED OUT ON THE 22ND" => "PACKED OUT ON THE 22ND",
//     "PO" => "PO",
//     "POX1" => "POX1",
//     "POX2" => "POX2",
//     "REJ" => "REJ",
//     "REJECTED" => "REJECTED",
//     "THOUGHT WE WAS BANK" => "THOUGHT WE WAS BANK",
//     "USED BENEFITS" => "USED BENEFITS",
//     "USES BENEFITS" => "USES BENEFITS",
//     "USES MULTIPLE BENEFITS" => "USES MULTIPLE BENEFITS",
// ];

$outcomeDatasource = [
    "POX1"=>"POX1",
    "POX2"=>"POX2",
    "CALL BACK"=>"CALL BACK",
    "NOT INTERESTED"=>"NOT INTERESTED",
    "DROPPED CALL" => "DROPPED CALL",
    "CANNOT LOCATE"=>"CANNOT LOCATE",
    "LEAD OUT OF CRITERIA"=>"LEAD OUT OF CRITERIA",
    "ALREADY CLAIMED"=>"ALREADY CLAIMED",
    "NON PLACEABLE"=>"NON PLACEABLE",
    "NO PBA"=>"NO PBA",
    "NO TIME"=>"NO TIME",
    "TO SPEAK"=>"TO SPEAK",
    "DEAD LINE"=>"DEAD LINE",
];

?>


<?php 
// \yii\widgets\Pjax::begin([
//     'id' => 'ajaxRefresh',
//     'enablePushState' => false
// ]);
?>
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<?php

 //     \yii\widgets\Pjax::begin([
	//     'id' => 'pendingClaims',
	// ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Seach</h3>
        </div>
        <div class="panel-body">
            <?php 
                $form = ActiveForm::begin([]); 
            ?>
                <?= $form->field($formModel, 'searchTerm') ?>

                <?php if (!is_null($foundModels) && !empty($foundModels)): ?>
                    <strong><?= count($foundModels) ?> records found : </strong>
                    <div class="list-group">
                    <?php foreach ($foundModels as $currentFoundModel): ?>
                        <?= Html::a( 
                            $currentFoundModel->title .' '.$currentFoundModel->firstname.' '.$currentFoundModel->surname,
                            ['/leads/view','id'=>$currentFoundModel->id], ['class' => 'list-group-item']); ?>                    
                    <?php endforeach ?>
                    </div>
                <?php endif ?>
                <?php if (empty($foundModels) && isset($formModel->searchTerm)): ?>
                    <i>Sorry , we can't find that record in the database </i>
                <?php endif ?>
                <?= Html::submitButton('Seach', ['class' => 'btn btn-primary btn-block']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                New Claims Arrived <span class="label label-info pull-right"><?= $pendingClaims->totalCount ?></span>
            </h3>
        </div>
        <div class="panel-body">

            <?=
            ListView::widget([
                'id' => 'pendingClaimsList',
                'dataProvider' => $pendingClaims,
                'itemView' => '_new_arrival',
            ]);
            ?>
        </div>
    </div>

    <?php //\yii\widgets\Pjax::end(); ?>

	<?php 
 //    \yii\widgets\Pjax::begin([
	//     'id' => 'ongoingClaims'
	// ]);

    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Ongoing <span class="label label-default pull-right"><?= $ongoingClaims->totalCount ?></span>
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
	<?php 
    // \yii\widgets\Pjax::end(); 
    ?>
</div>
<?php 
// \yii\widgets\Pjax::end(); 
?>

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

                <?= $form->field($model, 'title')->dropDownList(['Ms.' => 'Ms.', 'Mr.' => 'Mr.', 'Mrs.' => 'Mrs.'], ['autofocus'=>'autofocus']); ?>

                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address')->textarea(['maxlength' => true]); ?>

                <?= $form->field($model, 'mobile')->textInput() ?>

                <?= $form->field($model, 'pb_agent')->textInput() ?>

                <?= $form->field($model, 'tm')->dropDownList(ArrayHelper::map(UserAccount::find()->where(['account_type' => UserAccount::USER_ACCOUNT_TYPE_AGENT])->all(), 'username', 'username')) ?>

                <?= $form->field($model, 'acc_rej')->dropDownList(['ACC' => 'ACC', 'REJ' => 'REJ']) ?>

                <?= $form->field($model,'outcome')->dropDownList($outcomeDatasource)->hint('POX2 = 2 Pack Outs') ?>


                <hr>

                <?= $form->field($model, 'notes')->textarea(['style' => 'margin-top: 0px; margin-bottom: 0px; height: 137px;']); ?>

                <hr>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-primary  btn-block']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>



<?php 
// \yii\widgets\Pjax::begin([
//     'id' => 'completedClaims'
// ]);
?>

<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                Completed 
					<span class="label label-success pull-right">
					<?= $completedClaims->totalCount ?>
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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">CALL BACKS</h3>
        </div>
        <div class="panel-body">
            <?=
                ListView::widget([
                    'dataProvider' => $callBackLeads,
                    'itemView' => '_call_back_agent_template',
                ]);
            ?>
        </div>
    </div>
</div>
<?php 
// \yii\widgets\Pjax::end(); 
?>

