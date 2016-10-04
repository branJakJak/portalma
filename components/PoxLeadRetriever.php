<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/4/16
 * Time: 6:22 PM
 */

namespace app\components;


use app\models\MoneyActiveClaims;
use yii\base\Component;
use yii\base\Exception;

class PoxLeadRetriever extends Component
{
    protected $leads;
    protected $pox_count;

    public function init()
    {
        parent::init();
    }

    public function getValue()
    {
        $retVal = [
            'pox' => 0,
            'leads' => 0,
        ];
        $poxCount = MoneyActiveClaims::find()->where([
            'outcome' => 'POX1'
        ])->count();
        $this->pox_count = $poxCount ? $poxCount : 0;
        $retVal['pox'] = $this->pox_count;

        $totalLeads = MoneyActiveClaims::find()->count();
        $this->leads = $totalLeads ? $totalLeads : 0;
        $retVal['leads'] = $this->leads;
        return $retVal;
    }

    /**
     * @param mixed $leads
     */
    public function setLeads($leads)
    {
        $this->leads = $leads;
    }

    public function getPercentage()
    {
        $formatter = \Yii::$app->formatter;
        $retVal ="0.00%";
        if ($this->getPoxCount() !== 0 && $this->getLeads() !== 0) {
            $retVal = $formatter->asPercent(($this->pox_count / $this->leads), 2);
        }
        return $retVal;
    }

    /**
     * @return mixed
     */
    public function getLeads()
    {
        return $this->leads;
    }

    /**
     * @param mixed $pox_count
     */
    public function setPoxCount($pox_count)
    {
        $this->pox_count = $pox_count;
    }

    /**
     * @return mixed
     */
    public function getPoxCount()
    {
        return $this->pox_count;
    }

}