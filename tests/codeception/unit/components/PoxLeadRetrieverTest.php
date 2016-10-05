<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/4/16
 * Time: 7:24 PM
 */

namespace tests\codeception\unit\components;


use app\components\PoxLeadRetriever;
use app\models\MoneyActiveClaims;
use Codeception\TestCase\Test;
use Faker\Factory;
use tests\codeception\unit\components\helper\MoneyActiveDataPopulator;
use yii\codeception\DbTestCase;

class PoxLeadRetrieverTest extends DbTestCase
{
    public $testDataCollection;
    protected $faker;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        MoneyActiveClaims::deleteAll();
        parent::tearDown();
    }
    public function test_pox_lead_retrieval()
    {
        $this->faker = Factory::create();
        //clear first
        MoneyActiveClaims::deleteAll();
        //load data
        foreach (range(1, 50) as $currentIndex) {
            $outComeVal = ($currentIndex > 25) ? 'POX1' : "LEADS";
            $this->insertData($outComeVal);
        }
        //make sure all 50 is loaded
        $this->assertEquals(50, count($this->testDataCollection), "All test data must be inserted");
        $poxLeadDataRetriever = new PoxLeadRetriever();
        $dataArr = $poxLeadDataRetriever->getValue();
        $this->assertEquals(50, $poxLeadDataRetriever->getLeads(), "Returned data leads must be 50");
        $this->assertEquals(25, $poxLeadDataRetriever->getPoxCount(), "There should be 25 claims with POX1 outcome");
        $this->assertEquals("50.00%", $poxLeadDataRetriever->getPercentage(), "Make sure percentage is 50%");
    }
    public function test_percentage_this_week()
    {
        //insert data
        MoneyActiveClaims::deleteAll();
        $mondayThisWeek = date("Y-m-d H:i:s", strtotime("monday this week"));
        $res = MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$mondayThisWeek,
            'pb_agent'=>'agent001',
            'outcome'=>'POX1'
        ]);
        foreach ($res as $cur) {
            $cur->date_submitted = $mondayThisWeek;
            $cur->update(false);
        }
        $mondayLastWeek = date("Y-m-d H:i:s", strtotime("wednesday this week"));
        $res = MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$mondayLastWeek,
            'outcome'=>'CALL BACK',
            'pb_agent'=>'agent001',
        ]);
        foreach ($res as $cur) {
            $cur->date_submitted = $mondayLastWeek;
            $cur->update(false);
        }
        //compute
        /**
         * @var $poxVsLeadRetriever PoxLeadRetriever
         */
        $poxVsLeadRetriever = \Yii::$app->poxVsLeadRetriever;
        $this->assertEquals(20, $poxVsLeadRetriever->getLeadsThisWeek(), 'There should be 20 leads this week ');
        $this->assertEquals(10, $poxVsLeadRetriever->getTotalPoxThisWeek(), 'There should be 10 POX leads');
        $this->assertEquals("50.00%", $poxVsLeadRetriever->getPoxPercentageThisWeek(),"It should be 50% , half of it is POX the other half is non POX");
    }
    public function test_percentage_this_month()
    {
        //insert data
        $dateLastMonth = date("Y-m-d H:i:s", strtotime("last month"));
        $res = MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$dateLastMonth,
            'pb_agent'=>'agent001',
            'outcome'=>'POX1'
        ]);
        foreach ($res as $cur) {
            $cur->date_submitted = $dateLastMonth;
            $cur->update(false);
        }
        $dateThisMonth = date("Y-m-d H:i:s", strtotime("wednesday this week"));
        $res = MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$dateThisMonth,
            'pb_agent'=>'agent001',
            'outcome'=>'POX1'
        ]);
        foreach ($res as $cur) {
            $cur->date_submitted = $dateThisMonth;
            $cur->update(false);
        }
        $dateThisMonth = date("Y-m-d H:i:s", strtotime("monday last week"));
        $res = MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$dateThisMonth,
            'pb_agent'=>'agent001',
            'outcome'=>'CALL BACK'
        ]);

        //compute
        /**
         * @var $poxVsLeadRetriever PoxLeadRetriever
         */
        $poxVsLeadRetriever = \Yii::$app->poxVsLeadRetriever;
        $this->assertEquals(20, $poxVsLeadRetriever->getTotalLeadsThisMonth(), 'There should be 20 leads this month');
        $this->assertEquals(10, $poxVsLeadRetriever->getTotalPoxThisMonth(), 'There should be 10 POX leads this month');
        $this->assertEquals("50.00%", $poxVsLeadRetriever->getPoxPercentageThisMonth(),"It should be 50% , 10 POX and 10 non POX");
    }

    private function insertData($outComeVal)
    {
        $customSubmitedDate = time();
        $newClaim = new MoneyActiveClaims();
        $newClaim->attributes = [
            "title" => $this->faker->title,
            "firstname" => $this->faker->firstName,
            "surname" => $this->faker->lastName,
            "postcode" => $this->faker->postcode,
            "address" => $this->faker->address,
            "mobile" => $this->faker->phoneNumber,
            "tm" => $this->faker->userName,
            "acc_rej" => "ACC",
            "outcome" => $outComeVal,
            "packs_out" => "1",
            "claim_status" => MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_DONE,
            "notes" => "",
            "comment" => "",
            "pb_agent" => $this->faker->userName,
            "date_of_birth" => $this->faker->date("Y-m-d"),
            "email" => $this->faker->email,
            "bank_name" => "Test Bank",
            "approx_month" => 1,
            "approx_date" => 3,
            "approx_year" => 2001,
            "paid_per_month" => 12,
            "bank_account_type" => "Joint",
            "submitted_by" => 1, //admin
            "date_submitted" => $customSubmitedDate,
            "updated_at" => $customSubmitedDate,
        ];
        if ($newClaim->save(false)) {
            $this->testDataCollection[] = $newClaim;
        }
    }
}