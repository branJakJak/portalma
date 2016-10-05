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

    protected $total_leads;

    public function init()
    {
        parent::init();
        $this->total_leads = $this->getTotalLead();
    }

    public function getTodaysPercentage()
    {
        $retVal = "";
        $todayCount = $this->getTodaysSubmission();
        if ($todayCount) {
            $retVal = \Yii::$app->formatter(($todayCount / $this->total_leads), 2);
        }else{
            throw new Exception("An error occured while retrieving todays total count");
        }
        return $retVal;
    }

    public function getWeekPercentage()
    {
        $retVal = "";
        $weekCount = $this->getWeekSubmission();
        if ($weekCount) {
            $retVal = \Yii::$app->formatter(($weekCount / $this->total_leads), 2);
        }else{
            throw new Exception("An error occured while retrieving this week's total submission count");
        }
        return $retVal;
    }

    public function getMonthPercentage()
    {
        $retVal = "";
        $monthCount = $this->getMonthSubmission();
        if ($monthCount) {
            $retVal = \Yii::$app->formatter(($monthCount / $this->total_leads), 2);
        }else{
            throw new Exception("An error occured while retrieving current month's total submission count");
        }
        return $retVal;
    }

    public function getTodaysSubmission()
    {
        $retValContainer = 0;
        $retValContainer = MoneyActiveClaims::find()->where([
            'date(date_submitted)'=>'date(now())',
            'pb_agent'=>$this->agent_name
        ])->count();
        if(!$this->total_leads){
            throw new Exception("No total lead computed");
        }
        return $retValContainer;
    }

    public function getWeekSubmission()
    {
        $retValContainer = 0;
        $retValContainer = MoneyActiveClaims::find()
            ->where(['pb_agent'=>$this->agent_name , 'YEARWEEK(now(),3)'=> date('oW',time()) ])
            ->count();
        if(!$this->total_leads){
            throw new Exception("No total lead computed");
        }
        return $retValContainer;
    }

    public function getMonthSubmission()
    {
        $retValContainer = 0;
        $retValContainer = MoneyActiveClaims::find()
            ->where(['pb_agent'=>$this->agent_name , 'DATE_FORMAT(date_submitted,"%m")'=> date("m") ])
            ->count();
        if(!$this->total_leads){
            throw new Exception("No total lead computed");
        }
        return $retValContainer;
    }

    public function getTotalLead()
    {
        $this->total_leads = MoneyActiveClaims::find()->where([
            'pb_agent'=>$this->agent_name,
        ])->count();
        if(!$this->total_leads){
            throw new Exception("No total lead computed");
        }
        return $this->total_leads;
    }

    public function setAgent($agent)
    {
        $this->agent_name = $agent;

    }

} 