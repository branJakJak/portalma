<?php 

namespace app\controllers;

use Yii;
use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
* CallbackReportController
*/
class CallbackReportController extends Controller
{
    public $layout = "dashboard";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['agent'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['agent'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }
    public function actionAgent($agentName)
    {
    	$useraccount = UserAccount::find()
    		->where(['username' => $agentName])
    		->one();
		if ($useraccount) {
	    	$query = MoneyActiveClaims::find()
	    		->where(['submitted_by' => $useraccount->id,'outcome'=>'CALL BACK']);
	        $callbackDataProvider = new ActiveDataProvider([
	            'query' => $query
	        ]);
			return $this->render('index', compact('callbackDataProvider','agentName'));
		}else {
			throw new Exception('Sorry this agent doesnt exists in the database');
		}
    	
    }

}