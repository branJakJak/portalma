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
} 