<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/3/16
 * Time: 11:41 PM
 */

namespace app\components;


use yii\base\Component;

class WeeklyRevenuRetriever extends Component{
    /**
     * @var DayRevenueRetriever
     */
    public $dayRevenueRetriever;
    /**
     *  Week day in calendar
     * @var int
     */
    public $week;
    /**
     * Returns collection of revenue this week
     * @return array
     */
    public function init()
    {
        $this->dayRevenueRetriever = \Yii::createObject($this->dayRevenueRetriever);
        parent::init();
    }

    public function getValue()
    {
        //todo possible support  , allow user to input week number, using week number to get collection of revenue on that week
        $weeklyRevenueRetriever = [];
        //using week day ,
        
        //get the date starting from sunday upto saturday
        // using day revenue retriever , pass the date to compute for the total
        return $weeklyRevenueRetriever;
    }

}