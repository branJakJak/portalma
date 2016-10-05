<?php 


$poxCount = $pox_vs_lead['pox'];
$leadsCount = $pox_vs_lead['leads'];
$doughnutChart = <<< SCRIPT
	var doughnutData = [
		{
			value: $poxCount,
			color:"#1c9ca7",
		  	labelColor : 'white',
            labelFontSize : '16',
			label:"POX1"
		},
		{
			value : $leadsCount,
			color : "#f68275",
		  	labelColor : 'white',
            labelFontSize : '16',
			label:"LEADS"
		}];
	var myDoughnut = new Chart(document.getElementById("POXLeadChart").getContext("2d")).Pie(doughnutData);
SCRIPT;
$this->registerJs($doughnutChart, \yii\web\View::POS_READY);
?>

<div class="darkblue-panel pn">
	<div class="darkblue-header">
		<h5>POX1 ALL AGENTS</h5>
	</div>
<canvas id="POXLeadChart" height="120" width="120" style="width: 120px; height: 120px;"></canvas>
<p>
</p>
<footer>
	<div class="pull-left">
		<h5 style="text-align: left">
			<i class="fa fa-hdd-o"></i> <?= $pox_vs_lead['pox'] ?> <small>POX1</small> 
			<div style="margin: 5px 0px;"></div>
			<i class="fa fa-hdd-o"></i> <?= $pox_vs_lead['leads'] ?> <small>LEADS</small>
		</h5>
	</div>
	<div class="pull-right">
		<h5>POX1 = <?= $poxLeadPercentage ?></h5>
		<h5>LEADS = <?= (100 - floatval($poxLeadPercentage)) ?>%</h5>
	</div>
</footer>
</div><!-- -- /darkblue panel ---->
