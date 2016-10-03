<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/4/16
 * Time: 12:25 AM
 */

namespace app\components;


use app\models\MoneyActiveClaims;
use yii\base\Component;

class DayRevenueRetriever extends Component{
    public $date;

    public function init()
    {
        if (!isset($date)) {
            //use todays date
            $this->date = date("Y-m-d");
        }
        parent::init();
    }

    public function getValue()
    {
        $value = 0;
        $value = MoneyActiveClaims::find()->where(['date(date_submitted)' => $this->date])->count();
        return $value;
    }
}