<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/5/16
 * Time: 3:39 AM
 */

namespace tests\codeception\unit\components;


use app\components\AgentEntriesReport;
use app\models\MoneyActiveClaims;
use tests\codeception\unit\components\helper\MoneyActiveDataPopulator;
use yii\codeception\DbTestCase;

class AgentEntriesReportTest extends DbTestCase{
    /**
     * @var AgentEntriesReport
     */
    public $agentEntriesReport;

    protected function setUp()
    {
        parent::setUp();
    }
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function test_total_lead()
    {
        $this->initializeObject();
        //insert 10 leads .
        MoneyActiveDataPopulator::insertData(10,['pb_agent'=>'agent001']);
        //there must be 10 leads
        $totalLeadContainer = $this->agentEntriesReport->getTotalLead();
        $this->assertEquals(10, $totalLeadContainer, "There must be a total of 10 leads  in the database");
        $agentEntriesReport = null;
        $this->clean();
    }

    public function test_todays_submission()
    {
        $this->initializeObject();
        $customAttr = [
            'date_submitted'=> date("Y-m-d H:i:s"),
            'pb_agent'=>'agent001'
        ];
        MoneyActiveDataPopulator::insertData(25, $customAttr);
        $this->assertEquals(25, $this->agentEntriesReport->getTodaysSubmission(),"There should be 25 records today");
        $this->clean();
    }
    public function test_week_submission()
    {
        $this->initializeObject();
        // insert 3 from monday
        $mondayDt = date("Y-m-d H:i:s", strtotime("monday this week"));
        MoneyActiveDataPopulator::insertData(20, ['date_submitted'=>$mondayDt,'pb_agent'=>'agent001']);
        //insert 3 wednesday
        $wednesdayDt = date("Y-m-d H:i:s", strtotime("wednesday this week"));
        MoneyActiveDataPopulator::insertData(20, ['date_submitted'=>$wednesdayDt,'pb_agent'=>'agent001']);
        // insert 3 friday
        $fridayDt = date("Y-m-d H:i:s", strtotime("driday this week"));
        MoneyActiveDataPopulator::insertData(20, ['date_submitted'=>$fridayDt,'pb_agent'=>'agent001']);
        /*there should be 60 records in the database*/
        $this->assertEquals(60, $this->agentEntriesReport->getWeekSubmission(),"There should be 60 records in the database");
        $this->clean();
    }
    public function test_month_submission()
    {
        $this->initializeObject();
        //insert data using date today
        //get wednesday from last week , insert 20
        // insert 3 from monday
        $wednesdayLastWeek = date("Y-m-d H:i:s", strtotime("wednesday last week"));
        MoneyActiveDataPopulator::insertData(20, ['date_submitted'=>$wednesdayLastWeek,'pb_agent'=>'agent001']);
        //get wednesday today , insert 10
        // insert 3 from monday
        $wednesdayThisWeek = date("Y-m-d H:i:s", strtotime("wednesday this week"));
        MoneyActiveDataPopulator::insertData(20, ['date_submitted'=>$wednesdayThisWeek,'pb_agent'=>'agent001']);
        $this->assertEquals(40, $this->agentEntriesReport->getMonthSubmission(), 'There should be 40 records in the database');
        $this->clean();
    }
    public function test_today_percentage()
    {
        $this->initializeObject();
        // insert 10 leads , that is POX
        $dateToday = date("Y-m-d H:i:s", time());
        MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$dateToday,
            'pb_agent'=>'agent001',
            'outcome'=>'POX1'
        ]);
        // insert 10 leads , non POX
        MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$dateToday,
            'pb_agent'=>'agent001',
            'outcome'=>'CALL BACK'
        ]);
        // there should be 50 %
        $this->assertEquals("50.00%", $this->agentEntriesReport->getTodaysPercentage(),"Make sure POX1 percentage is 50%");
        $this->clean();
    }
    public function test_today_percentage_with_zero_pox()
    {
        $this->initializeObject();

        $this->clean();
    }
    public function test_week_percentage()
    {
        $this->initializeObject();
        // insert 10 leads , that is POX , using monday date
        $mondayThisWeek = date("Y-m-d H:i:s", strtotime("monday this week"));
        MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$mondayThisWeek,
            'pb_agent'=>'agent001',
            'outcome'=>'POX1'
        ]);
        // insert 10 leads , non POX , using monday date
        MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$mondayThisWeek,
            'pb_agent'=>'agent001',
            'outcome'=>'CALL BACK'
        ]);
        // there should be 50 %
        $this->assertEquals("50.00%", $this->agentEntriesReport->getWeekPercentage(),"Make sure POX1 percentage is 50% this week");
        $this->clean();
    }
    public function test_month_percentage()
    {
        $this->initializeObject();
        // insert 10 leads , that is POX , using date last wednesday
        $mondayLastWeek = date("Y-m-d H:i:s", strtotime("wednesday last week"));
        MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$mondayLastWeek,
            'pb_agent'=>'agent001',
            'outcome'=>'POX1'
        ]);
        // insert 10 leads , that is POX , using date today
        $mondayThisWeek = date("Y-m-d H:i:s", strtotime("wednesday this week"));
        MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$mondayThisWeek,
            'pb_agent'=>'agent001',
            'outcome'=>'POX1'
        ]);
        // insert 20 leads , non POX , using date last today
        $today = date("Y-m-d H:i:s", time());
        MoneyActiveDataPopulator::insertData(20, [
            'date_submitted'=>$today,
            'pb_agent'=>'agent001',
            'outcome'=>'CALL BACK'
        ]);
        // there should be 50 %
        $this->assertEquals("50.00%", $this->agentEntriesReport->getMonthPercentage(), "Make sure 50% for this months");
        $this->clean();
    }

    private function initializeObject()
    {
        MoneyActiveClaims::deleteAll();
        $this->agentEntriesReport = \Yii::$app->agentEntriesReport;
        $this->agentEntriesReport->setAgent("agent001");
    }
    private function clean()
    {
        MoneyActiveClaims::deleteAll();
        $this->agentEntriesReport = null;
    }


}