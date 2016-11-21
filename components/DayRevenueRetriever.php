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
    /**
     * The day to which revenue will be calculated
     * Must be formatted in Y-m-d format
     * @var string
     */
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
        $value = MoneyActiveClaims::find()
        ->where(['date(date_submitted)' => $this->date])
        ->andWhere(['not',['outcome'=>null]])
        ->count();
        return $value;
    }

    /**
     *
     * @param $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}