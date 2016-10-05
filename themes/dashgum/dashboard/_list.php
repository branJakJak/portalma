<?php
/**
 * @var \app\models\UserAccount $model
 */
use yii\helpers\Url;


?>
<a href="<?php echo \yii\helpers\Url::to(["/entries/index","agent"=>$model['pb_agent']])?>">
	<div class="desc">
	    <div class="thumb">
	        <img class="img-circle" src="/img/agent-img.png" width="35px" height="35px" align="">
	    </div>
	    <div class="details">

	        <p><a href="<?= Url::to(["/entries","agent"=>$model['pb_agent']]) ?>"><?= $model['pb_agent'] ?></a><br/>
	        </p>
	    </div>
	</div>
</a>
