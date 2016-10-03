<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/3/16
 * Time: 11:52 PM
 */

namespace app\components;


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
        // todo code here boi
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