<?php 



?>
<!-- Month -->
<div class="weather-3 pn centered" id="pox-month">
    <i class="fa fa-calendar"></i>
    <h1>Month</h1>
    <div class="info">
        <div class="row">
                <h3 class="centered"><?= $percentageThisMonth ?></h3>
            <div class="col-sm-6 col-xs-6 pull-left">
                <p class="goleft">
 	           		<i class="fa fa-check-circle" aria-hidden="true"></i>
                    <?= $poxThisMonth ?>
                    <small>POX</small>
                </p>

            </div>
            <div class="col-sm-6 col-xs-6 pull-right">
                <p class="goright">
                <i class="fa fa-flag"></i>
                <?= $leadThisMonth ?> <small>Leads</small>
                </p>
            </div>
        </div>
    </div>
</div>
