<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/21/16
 * Time: 1:01 AM
 */

namespace app\commands;


use app\models\UserAccount;
use yii\base\Exception;
use yii\bootstrap\Html;
use yii\console\Controller;
use yii\rbac\DbManager;

class InitController extends Controller
{
    /**
     * Create an admin account having username admin and password loNgyFubi3rw9BfPEHqn
     */
    public function actionIndex()
    {
        if ( $this->confirm("Are you sure you want to initialize the app ?")) {
            /*check if user_account table exists ; anything wrong throw error*/
            $tableSchema = \Yii::$app->db->getTableSchema("user_account");
            if ($tableSchema === null) {
                throw new Exception("table user_account doesnt exists make sure you run migrations");
            }
            //delete all roles
            \Yii::$app->authManager->removeAll();
            /**
             * @var $authManager DbManager
             */
            $authManager = \Yii::$app->authManager;
            $adminRole = $authManager->createRole("admin");
            $agentRole = $authManager->createRole("agent");
            $authManager->add($adminRole);
            $authManager->add($agentRole);

            //create role
            /*check if no probs , create admin account */
            $newUserAccount = new UserAccount();
            $newUserAccount->username = "moneyactive";
            $newUserAccount->password = "mz9jWskN1D63oyb";
            $newUserAccount->account_type = UserAccount::USER_ACCOUNT_TYPE_ADMIN;
            //register the user admin role
            if ($newUserAccount->save()) {
                $authManager->assign($adminRole, $newUserAccount->id);
                echo("Done admin account created : \n");
                echo('username : moneyactive'.PHP_EOL);
                echo('password : mz9jWskN1D63oyb' . PHP_EOL);
            }else{
                throw new Exception(Html::errorSummary($newUserAccount));
            }
        } else {
            die;
        }
    }
    public function actionAgent()
    {
        /*creates initial agents*/
        if ( $this->confirm("Are you sure you want to initialize the creation of agents.  Running this will delete all agents record ?")) {
            UserAccount::deleteAll(["account_type"=>UserAccount::USER_ACCOUNT_TYPE_AGENT]);
            $agentCollection  = [
                [
                    "username"=>"CANNOT LOCATE LEAD",
                    "password"=>"TW6F5OBvyr"
                ],
                [
                    "username"=>"DUP SEE ABOVE",
                    "password"=>"RuCb07r3Kl"
                ],
                [
                    "username"=>"KEITH",
                    "password"=>"1Cmdq9kcut"
                ],
                [
                    "username"=>"LEENA",
                    "password"=>"0B7mv5DJVu"
                ],
                [
                    "username"=>"REMY",
                    "password"=>"DO9327kJAV"
                ],
                [
                    "username"=>"SEREN",
                    "password"=>"2dYAxGKEPT"
                ],
                [
                    "username"=>"STACEY",
                    "password"=>"xF9YG0oIhl"
                ],
                [
                    "username"=>"THARUN",
                    "password"=>"j7TCc1fA3v"
                ],
                [
                    "username"=>"TM",
                    "password"=>"FWAx3c6bsO"
                ]
            ];
            foreach ($agentCollection as $currentVal) {
                $authManager = \Yii::$app->authManager;
                $agentRole = $authManager->getRole("agent");

                $newUserAccount = new UserAccount();
                $newUserAccount->username = $currentVal['username'];
                $newUserAccount->password = $currentVal['password'];
                $newUserAccount->account_type = UserAccount::USER_ACCOUNT_TYPE_AGENT;
                if ($newUserAccount->save()) {
                    $authManager->assign($agentRole, $newUserAccount->id);
                    echo("Done admin account created : \n");
                    echo('username : '.$currentVal['username'].PHP_EOL);
                    echo('password : '.$currentVal['password'] . PHP_EOL.PHP_EOL);
                } else {
                    echo \yii\helpers\Html::errorSummary($newUserAccount, []); 
                    die();
                }
            }
        }
    }
} 