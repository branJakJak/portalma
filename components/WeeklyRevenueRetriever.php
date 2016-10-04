<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/3/16
 * Time: 11:41 PM
 */

namespace app\components;


use DateInterval;
use yii\base\Component;

class WeeklyRevenueRetriever extends Component{
    /**
     * @var DayRevenueRetriever
     */
    public $dayRevenueRetriever;
    /**
     *  Week day in calendarc
     * @var int
     */
    public $week;

    public function init()
    {
        $this->dayRevenueRetriever = \Yii::createObject($this->dayRevenueRetriever);
        parent::init();
    }
    public function getValue()
    {
        $weeklyRevenueRetriever = [];
        $dtObj = new \DateTime();
        $dtObj->setISODate(date("Y"), $this->week);
        $dtObj->sub(new DateInterval("P1D"));//start at sunday
        //get the date starting from sunday up to saturday
        foreach(range(1,7) as $current){
            $this->dayRevenueRetriever->setDate($dtObj->format("Y-m-d"));
            $countVal = $this->dayRevenueRetriever->getValue();
            $weeklyRevenueRetriever[$dtObj->format("l")] = $countVal;
            $dtObj->add(new DateInterval("P1D"));//next day
        }
        // using day revenue retriever , pass the date to compute for the total
        return $weeklyRevenueRetriever;
    }

}