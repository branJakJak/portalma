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
use Codeception\TestCase\Test;
use tests\codeception\unit\components\helper\MoneyActiveDataPopulator;
use yii\codeception\DbTestCase;

class AgentEntriesReportTest extends DbTestCase{
    protected function setUp()
    {
        parent::setUp();
        MoneyActiveClaims::deleteAll();
    }
    protected function tearDown()
    {
        parent::tearDown();
        MoneyActiveClaims::deleteAll();
    }
    public function test_total_lead()
    {
        //insert 10 leads .
        MoneyActiveDataPopulator::insertData();
        //there must be 10 leads
        $agentEntriesReport = new AgentEntriesReport();
        $agentEntriesReport->init();
        $this->assertEquals(10, $agentEntriesReport->getTotalLead(), "There must be a total of 10 leads  in the database");
    }

    public function test_todays_submission()
    {
        //todo insert data using date today
        $customAttr = [
            'date_submitted'=>
        ];
    }
    public function test_week_submission()
    {
        // insert 3 from monday

        //insert 3 wednesday

        // insert 3 friday

    }
    public function test_month_submission()
    {
        //todo insert data using date today
        //get wednesday from last week , insert 20
        //get wednesday today , insert 10
        // todo there should be 30 total
    }
    public function test_today_percentage()
    {
        // insert 10 leads , that is POX
        // insert 10 leads , non POX
        // there should be 50 %
    }
    public function test_week_percentage()
    {
        // insert 10 leads , that is POX , using monday date
        // insert 10 leads , non POX , using monday date

        // insert 10 leads , that is POX , using today date
        // insert 10 leads , non POX , using today date

        // there should be 50 %

    }
    public function test_month_percentage()
    {
        // insert 10 leads , that is POX , using date last wednesday
        // insert 10 leads , non POX , using date last wednesday

        // insert 10 leads , that is POX , using date today
        // insert 10 leads , non POX , using date last today

        // there should be 50 %
    }
}