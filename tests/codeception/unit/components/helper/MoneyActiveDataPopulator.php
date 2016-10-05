<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/5/16
 * Time: 3:44 AM
 */

namespace tests\codeception\unit\components\helper;


use Faker\Factory;
use yii\helpers\ArrayHelper;

class MoneyActiveDataPopulator
{
    public static function insertData($numberOfRecordToInsert=10, $customAttributes=[])
    {
        //prepare faker
        $faker = Factory::create();
        $testDataCollection = [];
        foreach (range(1, $numberOfRecordToInsert) as $currentIndex) {
            $newClaim = new \app\models\MoneyActiveClaims();
            $newClaim->attributes = [
                "title" => $faker->title,
                "firstname" => $faker->firstName,
                "surname" => $faker->lastName,
                "postcode" => $faker->postcode,
                "address" => $faker->address,
                "mobile" => $faker->phoneNumber,
                "tm" => $faker->userName,
                "acc_rej" => "ACC",
                "outcome" => "POX1",
                "packs_out" => "1",
                "claim_status" => \app\models\MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_DONE,
                "notes" => "",
                "comment" => "",
                "pb_agent" => $faker->userName,
                "date_of_birth" => $faker->date("Y-m-d"),
                "email" => $faker->email,
                "bank_name" => "Test Bank",
                "approx_month" => 1,
                "approx_date" => 3,
                "approx_year" => 2001,
                "paid_per_month" => 12,
                "bank_account_type" => "Joint",
                "submitted_by" => 1, //admin
                "date_submitted" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ];
            $updatedProps = ArrayHelper::merge($newClaim->attributes, $customAttributes);
            $newClaim->attributes = $updatedProps;
            if ($newClaim->save(false)) {
                $testDataCollection[] = $newClaim;
            }
        }
        return $testDataCollection;
    }
} 