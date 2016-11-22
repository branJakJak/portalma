<?php
namespace api;


use Faker\Factory;

class RestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testMe()
    {
        $faker = Factory::create();
//
//        $postParameters = array(
//            "title"=>$faker->title,
//            "firstname"=>$faker ,
//            "surname"=>$requestParameters['lastname'],
//            "house"=>$requestParameters['textHouse'],
//            "address1"=>$requestParameters['address'],
//            "address2"=>"",
//            "address3"=>"",
//            "town"=>$requestParameters['town'],
//            "county"=>"",
//            "postcode"=>$requestParameters['postalCode'],
//            "telephone"=>$requestParameters['telephone'],
//            "telephonemobile"=>$requestParameters['mobile'],
//            "bankname1"=>$requestParameters['bankname1'],
//            "singlejoint1"=>$requestParameters['singlejoint1'],
//            "startdatemonth1"=>$requestParameters['startdatemonth1'],
//            "startdateyear1"=>$requestParameters['startdateyear1'],
//            "enddatemonth1"=>$requestParameters['enddatemonth1'],
//            "enddateyear1"=>$requestParameters['enddateyear1'],
//            "paidpermonth1"=>$requestParameters['paidpermonth1'],
//        );
//        $postUrl = "http://localhost:8080/api?";
//        $postFields = http_build_query($postParameters);
//        $curlRes = curl_init($postUrl);
//        curl_setopt($curlRes, CURLOPT_POST, true);
//        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postFields);
//        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER, true);
//        $returnedMessage = curl_exec($curlRes);
//        $returnedMessageArr = json_decode($returnedMessage, true);
//        $logMessage = sprintf("%s|%s|%s", $returnedMessageArr['status'],$returnedMessageArr['message'],$postFields);
//
//        $this->assertContains("Success", $logMessage);

    }
}