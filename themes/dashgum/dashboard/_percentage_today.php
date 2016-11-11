<?php 

?>
<!-- Today -->
<div class="weather-3 pn centered" id="pox-today">
    <i class="fa fa-calendar-minus-o"></i>
    <h1>Today</h1>
    <div class="info">
        <div class="row">
                <h3 class="centered"><?= $percentageToday ?></h3>
            <div class="col-sm-6 col-xs-6 pull-left">
                <p class="goleft">
 	           		<i class="fa fa-check-circle" aria-hidden="true"></i>
                    <?= $poxToday ?>
                    <small>POX</small>
                </p>

            </div>
            <div class="col-sm-6 col-xs-6 pull-right">
                <p class="goright">
                <i class="fa fa-flag"></i>
                <?= $leadToday ?> <small>Leads</small>
                </p>

            </div>
        </div>
    </div>
</div>
