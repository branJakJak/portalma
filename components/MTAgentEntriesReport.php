<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/9/16
 * Time: 1:25 AM
 */

namespace app\components;


use app\models\MoneyActiveClaims;
use yii\base\Component;
use yii\base\Exception;

class MTAgentEntriesReport extends Component{
    protected $total_leads = 0;
    protected $mt_agent;

    public function init()
    {
        parent::init();
    }

    public function getTodaysPercentage()
    {
        $retVal = "0.00%";
        $poxLeadCountToday = MoneyActiveClaims::find()->where([
            'date_format(date_submitted,"%Y-%m-%d")' => date("Y-m-d"),
            'outcome' => 'POX1',
            'submitted_by' => $this->mt_agent
        ])->count();

        $submissionTodayCount = $this->getTodaysSubmission();

        if ($submissionTodayCount != 0 && $poxLeadCountToday !=0 ) {
            $retVal = \Yii::$app->formatter->asPercent(($poxLeadCountToday / $submissionTodayCount), 2);
        } else {
            // throw new Exception("An error occured while retrieving todays percentage report");
        }
        return $retVal;
    }
    public function getPercentageAll()
    {
        $retVal = "0.00%";
        $poxAll = MoneyActiveClaims::find()
            ->where([
                'submitted_by' => $this->mt_agent,
                'outcome' => 'POX1'
            ])
            ->count();
            $totalLeads = MoneyActiveClaims::find()
            ->where([
                'submitted_by' => $this->mt_agent,                
            ])
            ->andWhere(['not',['outcome'=>null]])
            ->count();
        if ($totalLeads != 0 && $poxAll != 0) {
            $retVal = \Yii::$app->formatter->asPercent(($poxAll / $totalLeads), 2);
        } else {
            // throw new Exception("An error occured while retrieving this week's percentage report");
        }
        return $retVal;
    }
    public function getWeekPercentage()
    {
        $retVal = "0.00%";
        $poxThisWeek = MoneyActiveClaims::find()
            ->where([
                'submitted_by' => $this->mt_agent,
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
        $retVal = "0.00%";
        $poxThisMonth = MoneyActiveClaims::find()
            ->where([
                'submitted_by' => $this->mt_agent,
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
        $retValContainer = MoneyActiveClaims::find()
        ->where([
            'date_format(date_submitted,"%Y-%m-%d")' => date("Y-m-d"),
            'submitted_by' => $this->mt_agent
        ])
            ->andWhere(['not',['outcome'=>null]])
        ->count();
        if ($retValContainer == false) {
            // throw new Exception("Can't compute total submission today");
        }
        return $retValContainer;
    }

    public function getWeekSubmission()
    {
        $retValContainer = 0;
        $retValContainer = MoneyActiveClaims::find()
            ->where(['submitted_by' => $this->mt_agent, 'week(date_submitted)' => date('W', time())])
            ->andWhere(['not',['outcome'=>null]])
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
            ->where(['submitted_by' => $this->mt_agent, 'month(date_submitted)' => date("m")])
            ->andWhere(['not',['outcome'=>null]])
            ->count();
        if (!$retValContainer) {
            // throw new Exception("Cant compute total month submission");
        }
        return $retValContainer;
    }

    public function getTotalLead()
    {
        if ($this->total_leads == 0) {
            $this->total_leads = MoneyActiveClaims::find()
            ->where(['submitted_by' => $this->mt_agent])
            ->andWhere(['not',['outcome'=>null]])
            ->count();
            if ($this->total_leads == 0) {
                // throw new Exception("No total lead computed");
            }
        }
        return $this->total_leads;
    }

    public function setMtAgent($agent)
    {
        if (is_integer($agent)) {
            //check if user exists
            $this->mt_agent = $agent;
        }   else {
            throw new Exception("Please pass the ID of the agent");
        }
    }

    public function getMtAgent()
    {
        return $this->mt_agent;
    }
}