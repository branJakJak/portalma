<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/5/16
 * Time: 2:27 AM
 */

namespace app\components;


use app\models\MoneyActiveClaims;
use yii\base\Component;
use yii\base\Exception;

class AgentEntriesReport extends Component
{
    protected $total_leads = 0;
    protected $agent_name;

    public function init()
    {
        parent::init();
    }

    public function getTodaysPercentage()
    {
        $retVal = "";
        $poxLeadCountToday = MoneyActiveClaims::find()->where([
            'date_format(date_submitted,"%Y-%m-%d")' => date("Y-m-d"),
            'outcome' => 'POX1',
            'pb_agent' => $this->agent_name
        ])->count();

        $submissionTodayCount = $this->getTodaysSubmission();

        if ($submissionTodayCount != 0 && $poxLeadCountToday !=0 ) {
            $retVal = \Yii::$app->formatter->asPercent(($poxLeadCountToday / $submissionTodayCount), 2);
        } else {
            // throw new Exception("An error occured while retrieving todays percentage report");
        }
        return $retVal;
    }

    public function getWeekPercentage()
    {
        $retVal = "";

        $poxThisWeek = MoneyActiveClaims::find()
            ->where([
                'pb_agent' => $this->agent_name,
                'week(date_submitted)' => date('W', time()),
                'outcome' => 'POX1'
            ])
            ->count();
        $totalLeadsWeek = $this->getWeekSubmission();
        if ($totalLeadsWeek != 0 && $poxThisWeek != 0) {
            $retVal = \Yii::$app->formatter->asPercent(($poxThisWeek / $totalLeadsWeek), 2);
        } else {
            // throw new Exception("An error occured while retrieving this week's percentage report");
        }
        return $retVal;
    }

    public function getMonthPercentage()
    {
        $retVal = "";
        $poxThisMonth = MoneyActiveClaims::find()
            ->where([
                'pb_agent' => $this->agent_name,
                'outcome' => 'POX1',
                'month(date_submitted)' => date("m")
            ])
            ->count();
        $totalMonthSubmission = $this->getMonthSubmission();

        if ($totalMonthSubmission != 0 && $poxThisMonth != 0) {
            $retVal = \Yii::$app->formatter->asPercent(($poxThisMonth / $totalMonthSubmission), 2);
        } else {
            // throw new Exception("An error occured while retrieving current month's percentage report");
        }
        return $retVal;
    }

    public function getTodaysSubmission()
    {
        $retValContainer = MoneyActiveClaims::find()->where([
            'date_format(date_submitted,"%Y-%m-%d")' => date("Y-m-d"),
            'pb_agent' => $this->agent_name
        ])->count();
        if ($retValContainer == false) {
            // throw new Exception("Can't compute total submission today");
        }
        return $retValContainer;
    }

    public function getWeekSubmission()
    {
        $retValContainer = 0;
        $retValContainer = MoneyActiveClaims::find()
            ->where(['pb_agent' => $this->agent_name, 'week(date_submitted)' => date('W', time())])
            ->count();
        if (!$retValContainer) {
            // throw new Exception("Cant compute total week submission");
        }
        return $retValContainer;
    }

    public function getMonthSubmission()
    {
        $retValContainer = 0;
        $retValContainer = MoneyActiveClaims::find()
            ->where(['pb_agent' => $this->agent_name, 'month(date_submitted)' => date("m")])
            ->count();
        if (!$retValContainer) {
            // throw new Exception("Cant compute total month submission");
        }
        return $retValContainer;
    }

    public function getTotalLead()
    {
        if ($this->total_leads == 0) {
            $this->total_leads = MoneyActiveClaims::find()->where(['pb_agent' => $this->agent_name])->count();
            if ($this->total_leads == 0) {
                // throw new Exception("No total lead computed");
            }
        }
        return $this->total_leads;
    }

    public function setAgent($agent)
    {
        $this->agent_name = $agent;
    }

    public function getAgent()
    {
        return $this->agent_name;
    }

} 