<?php
/**
 * @var \app\models\UserAccount $model
 * @var $agentReportRetriever AgentEntriesReport
 */
use yii\helpers\Url;

$agentReportRetriever = Yii::$app->agentEntriesReport;
$agentReportRetriever->setAgent($model['pb_agent']);

?>
<a href="<?php echo \yii\helpers\Url::to(["/entries/index","agent"=>$model['pb_agent']])?>">
	<div class="desc">
	    <div class="thumb">
	        <img class="img-circle" src="/img/agent-img.png" width="35px" height="35px" align="">
	    </div>
	    <div class="details">
	        <p>
	        	<a href="<?= Url::to(["/entries","agent"=>$model['pb_agent']]) ?>">
	        		<?= $model['pb_agent'] ?> | 
		        	<?= $agentReportRetriever->getPercentageAll() ?>
	        	</a>
	        	<br/>
	        </p>
	    </div>
	</div>
</a>
