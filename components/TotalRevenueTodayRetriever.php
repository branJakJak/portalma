<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/3/16
 * Time: 11:36 PM
 */

namespace app\components;


use app\models\MoneyActiveClaims;
use yii\base\Component;
class TotalRevenueTodayRetriever extends Component{

    /**
     * Computes and returns total revenue all in all
     * @return int
     */
    public function getValue()
    {
        $total = 0;
        $dayRevRet = new DayRevenueRetriever();
        $dayRevRet->date = date("Y-m-d");
        $total = $dayRevRet->getValue();
        return $total;
    }
}