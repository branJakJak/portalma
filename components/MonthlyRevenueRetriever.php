<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/3/16
 * Time: 11:52 PM
 */

namespace app\components;


use app\models\MoneyActiveClaims;
use yii\base\Component;

class MonthlyRevenueRetriever extends Component{
    protected  $year= null;

    public function init()
    {
        // default to current year
        if (is_null($this->year)) {
            $this->year = date("Y");
        }
        parent::init();
    }


    /**
     * Retrieves monthly revenue generated. Jan-Dec
     * @return array
     */
    public function getValue()
    {
        $monthylRevCollection = [];
        //using year , iterate through months .
        foreach (range(1,12) as $currentMonthIndex) {
            $rawDateContainer = strtotime(sprintf("%s-%s-%s", $this->getYear(), $currentMonthIndex, 1));
            $count = MoneyActiveClaims::find()
            ->where([
                'date_format(date_submitted,"%Y-%m")'=>date("Y-m",$rawDateContainer)
            ])
           ->andWhere(['not',['outcome'=>null]])
            ->count();
            $monthylRevCollection[date("F",$rawDateContainer)] = $count;
        }
        //using each month , compute total
        return $monthylRevCollection;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

}