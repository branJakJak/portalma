<?php

namespace tests\codeception\unit\components;

use app\components\DayRevenueRetriever;
use Codeception\Specify;
use Faker\Factory;
use yii\codeception\DbTestCase;

class DayRevenueRetrieverTest extends DbTestCase
{
    use Specify;

    public $testDataCollection = [];
    protected $faker;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        foreach ($this->testDataCollection as $currentTestData)
        {
            $currentTestData->delete();
        }
        parent::tearDown();
    }

    public function test_day_revenue()
    {
        /*insert test data*/
        $testResult = 0;
        $this->faker = Factory::create();
        foreach (range(1, 10) as $currentVal) {
            $lastWeekWednesday = date("Y-m-d H:i:s", strtotime("last week wednesday"));
            $newClaim = new \app\models\MoneyActiveClaims();
            $newClaim->attributes = [
                "title" => $this->faker->title,
                "firstname" => $this->faker->firstName,
                "surname" => $this->faker->lastName,
                "postcode" => $this->faker->postcode,
                "address" => $this->faker->address,
                "mobile" => $this->faker->phoneNumber,
                "tm" => $this->faker->userName,
                "acc_rej" => "ACC",
                "outcome" => "VOX1",
                "packs_out" => "1",
                "claim_status" => \app\models\MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_DONE,
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
                "date_submitted" => $lastWeekWednesday,
                "updated_at" => $lastWeekWednesday,
            ];
            if ($newClaim->save(false)) {
                $this->testDataCollection[] = $newClaim;
            }
        }
        $dayRevenueRetriever = new DayRevenueRetriever();
        $dayRevenueRetriever->setDate(date("Y-m-d"));
        $testResult = $dayRevenueRetriever->getValue();
        $this->assertNotEquals(0, $testResult, "Make sure retrieved data is not zero");
        $this->assertEquals(10, $testResult, "Make sure there are 10 records inserted");
    }

}
