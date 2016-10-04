<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/4/16
 * Time: 1:53 AM
 */

namespace tests\codeception\unit\components;

use app\components\DayRevenueRetriever;
use app\components\WeeklyRevenueRetriever;
use app\models\MoneyActiveClaims;
use Faker\Factory;
use yii\codeception\DbTestCase;

class WeeklyRevenueRetrieverTest extends DbTestCase
{

    public $faker;
    public $testDataCollection = [];

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        //remove all money active records test daata
        foreach ($this->testDataCollection as $currentTestDataCollection) {
            $currentTestDataCollection->delete(false);
        }
        parent::tearDown();
    }

    public function test_get_weekly_revenue()
    {
        $this->faker = Factory::create();
        //insert 10 records having date submitted last week
        foreach (range(1, 10) as $currentVal) {
            $lastWeekWednesday = date("Y-m-d H:i:s", strtotime("last week wednesday"));
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
                "outcome" => "VOX1",
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
                "date_submitted" => $lastWeekWednesday,
                "updated_at" => $lastWeekWednesday,
            ];
            if ($newClaim->save(false)) {
                $newClaim->date_submitted = $lastWeekWednesday;
                $newClaim->save(false);
                $this->testDataCollection[] = $newClaim;
            }
        }
        $weeklyRevenueRetriever = new WeeklyRevenueRetriever([
            'dayRevenueRetriever' => DayRevenueRetriever::className()
        ]);
        $weeklyRevenueRetriever->week = date("W", strtotime("last week"));
        $this->assertNotNull($weeklyRevenueRetriever->dayRevenueRetriever, "Day revenue should be initialized");
        $returnedData = $weeklyRevenueRetriever->getValue();
        $this->assertEquals(0, $returnedData['Sunday']);
        $this->assertEquals(0, $returnedData['Monday']);
        $this->assertEquals(0, $returnedData['Tuesday']);
        $this->assertEquals(10, $returnedData['Wednesday']);
        $this->assertEquals(0, $returnedData['Thursday']);
        $this->assertEquals(0, $returnedData['Saturday']);
    }


} 