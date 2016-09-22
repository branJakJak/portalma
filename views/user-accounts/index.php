<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="main-content">
<section class="wrapper">
    

<div class="sd">
    <div class="user-account-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create User Account', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'username',
                'password',
                'account_type',
                'authkey',
                // 'accesstoken',
                // 'date_joined',
                // 'date_last_update',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>

            
</div>

</section>
</section>
