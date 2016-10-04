<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/4/16
 * Time: 4:28 AM
 */

namespace tests\codeception\unit\components;


use app\components\MonthlyRevenueRetriever;
use app\models\MoneyActiveClaims;
use Faker\Factory;
use yii\codeception\DbTestCase;

class MonthlyRevenueRetrieverTest extends  DbTestCase {
    public $faker;
    protected $testDataCollection;

    protected function setUp()
    {
        $this->faker = Factory::create();
        parent::setUp();
    }

    protected function tearDown()
    {
        MoneyActiveClaims::deleteAll();
        parent::tearDown();
    }
    public function test_month_revenue_retrieve()
    {
        MoneyActiveClaims::deleteAll();

        //computes  monthly revenue based on passed year
        $monthRevenueRetriever = new MonthlyRevenueRetriever();
        $monthRevenueRetriever->setYear(date("Y"));

        $extraData = 10;
        foreach (range(2001,2003) as $currentYear) {
            //insert data from 2001 -- 2003
            foreach (range(1,12) as $currentMonth) {
                //add 10 data per month
                foreach(range(1,$extraData) as $currentContaniner){
                    $this->insertData($currentMonth, $currentYear);
                }
            }
            $extraData += 10;
        }
        /**
         * @var $month2001RetVal array
         * @var $month2002RetVal array
         * @var $month2003RetVal array
         */
        //2001 - all months  has 10 data per month
        $monthRevenueRetriever->setYear(2001);
        $month2001RetVal = $monthRevenueRetriever->getValue();
        foreach ($month2001RetVal as $currentMonthRetkey => $currentMonthRetVal) {
            $this->assertEquals(10, $currentMonthRetVal);
        }
        //2002 - all months has 20 data per month
        $monthRevenueRetriever->setYear(2002);
        $month2002RetVal = $monthRevenueRetriever->getValue();
        foreach ($month2002RetVal as $currentMonthRetkey => $currentMonthRetVal) {
            $this->assertEquals(20, $currentMonthRetVal);
        }
//
        //2003 - all months has 30 data per month
        $monthRevenueRetriever->setYear(2003);
        $month2003RetVal = $monthRevenueRetriever->getValue();
        foreach ($month2003RetVal as $currentMonthRetkey => $currentMonthRetVal) {
            $this->assertEquals(30, $currentMonthRetVal);
        }

        $this->deleteData();

    }

    private function insertData($monthNumber, $year)
    {
        $customSubmitedDate = date("Y-m-d", strtotime(sprintf("%s-%s-%s", $year, $monthNumber, 10)));
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
            "date_submitted" => $customSubmitedDate,
            "updated_at" => $customSubmitedDate,
        ];
        if ($newClaim->save(false)) {
            $newClaim->date_submitted = $customSubmitedDate;
            $newClaim->save(false);
            $this->testDataCollection[] = $newClaim;
        }

    }

    private function deleteData()
    {
        foreach ($this->testDataCollection as $currentTestData) {
            $currentTestData->delete();
        }
    }


} 