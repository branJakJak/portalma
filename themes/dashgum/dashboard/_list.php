<?php
/**
 * @var \app\models\UserAccount $model
 */


?>
<a href="<?php echo \yii\helpers\Url::to(["/entries/index","agent_name"=>$model->username])?>">
	<div class="desc">
	    <div class="thumb">
	        <img class="img-circle" src="/img/agent-img.png" width="35px" height="35px" align="">
	    </div>
	    <div class="details">
	        <p><a href="#"><?= $model->username ?></a><br/>
	            <muted>Joined : <?= Yii::$app->formatter->asDate($model->date_joined,"long") ?></muted>
	        </p>
	    </div>
	</div>
</a>
