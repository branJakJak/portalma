<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/21/16
 * Time: 11:04 PM
 */

namespace app\dataproviders;


use app\models\MoneyActiveClaims;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;
use yii\db\Connection;
use yii\di\Instance;

class LeadCallbackDataProvider extends ActiveDataProvider{
    public function init()
    {
        $this->query = MoneyActiveClaims::find()->where(['outcome' => 'CALL BACK']);
        $this->pagination->pageSize = 10;
        parent::init();
    }

} 