<?php
/**
 * @var \app\models\UserAccount $model
 * @var $agentReportRetriever AgentEntriesReport
 */
use yii\helpers\Url;
use app\models\MoneyActiveClaims;

$agentReportRetriever = Yii::$app->agentEntriesReport;
$agentReportRetriever->setAgent($model['pb_agent']);
$callbackCount = MoneyActiveClaims::find()->where(['outcome'=>'CALL BACK','pb_agent'=>$model['pb_agent']])->count();

?>
<a href="<?php echo \yii\helpers\Url::to(["/entries/index","agent"=>$model['pb_agent']])?>">
	<div class="desc">
	    <div class="thumb">
	        <img class="img-circle" src="/img/agent-img.png" width="35px" height="35px" align="">
	    </div>
	    <div class="details">
	        <p>
	        	<a href="<?= Url::to(["/entries","agent"=>$model['pb_agent']]) ?>">
	        		<strong>
		        		<?= $model['pb_agent'] ?>
	        		</strong>
	        		<br>
		        	<b>
		        		POX : 
			        	<?= $agentReportRetriever->getPercentageAll() ?>
		        	</b>
		        	<br>
		        	<strong>
		        		Callback : <?= $callbackCount ?>
		        	</strong>
		        	<br />
		        	<br />
	        	</a>
	        </p>
	    </div>
	</div>
</a>
