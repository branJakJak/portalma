<?php 


?>

<!-- Week -->
<div class="weather-3 pn centered" id="pox-week">
    <i class="fa fa-calendar-minus-o"></i>
    <h1>Week</h1>
    <div class="info">
        <div class="row">
                <h3 class="centered"><?= $percentageThisWeek ?></h3>
            <div class="col-sm-6 col-xs-6 pull-left">
                <p class="goleft">
 	           		<i class="fa fa-check-circle" aria-hidden="true"></i>
                    <?= $poxThisWeek ?>
                    <small>POX</small>
                </p>

            </div>
            <div class="col-sm-6 col-xs-6 pull-right">
                <p class="goright">
                <i class="fa fa-flag"></i>
                <?= $leadThisWeek ?> <small>Leads</small>
                </p>

            </div>
        </div>
    </div>
</div>
