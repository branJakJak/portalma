<?php
namespace app\controllers;

use app\components\PbDataRetriever;
use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;


/**
 * DashboardController
 */
class DashboardController extends Controller
{
    public $layout = "dashboard";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query'=> MoneyActiveClaims::find()
        ]);

        $listViewDataProvider = new ActiveDataProvider([
            'query'=>UserAccount::find()->where(['account_type'=>UserAccount::USER_ACCOUNT_TYPE_AGENT])
        ]);

        return $this->render('index',compact('dataProvider','listViewDataProvider'));
    }
}