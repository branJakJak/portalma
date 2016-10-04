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
//        //make sure all 50 is loaded
        $this->assertEquals(50, count($this->testDataCollection), "All test data must be inserted");
        $poxLeadDataRetriever = new PoxLeadRetriever();
        $dataArr = $poxLeadDataRetriever->getValue();
        $this->assertEquals(50, $poxLeadDataRetriever->getLeads(), "Returned data leads must be 50");
        $this->assertEquals(25, $poxLeadDataRetriever->getPoxCount(), "There should be 25 claims with POX1 outcome");
        $this->assertEquals("50.00%", $poxLeadDataRetriever->getPercentage(), "Make sure percentage is 50%");
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