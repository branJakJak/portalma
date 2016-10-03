<?php
namespace app\controllers;

use app\components\MonthlyRevenueRetriever;
use app\components\TotalRevenueRetriever;
use app\components\WeeklyRevenuRetriever;
use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use Yii;
use yii\data\ActiveDataProvider;
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
        $agentSubmittionFilterModel = MoneyActiveClaims::find()->orderBy("date_submitted DESC");
        
        $dataProvider = new ActiveDataProvider([
            'query'=> $agentSubmittionFilterModel
        ]);

        $listViewDataProvider = new ActiveDataProvider([
            'query'=>UserAccount::find()->where(['account_type'=>UserAccount::USER_ACCOUNT_TYPE_AGENT])
        ]);

        /*Total Revenue Today*/
        /**
         * @var $totalRevenueRetriever TotalRevenueRetriever
         */
        $totalRevenueRetriever = Yii::$app->totalRevenueRetriever;
        $total_revenue_today = $totalRevenueRetriever->getValue();
        /*Weekly Revenue*/
        /**
         * @var $weeklyRevenueRetriever WeeklyRevenuRetriever
         */
        $weeklyRevenueRetriever = Yii::$app->weeklyRevenueRetriever;
        $weeklyRevenueDataCollection = $weeklyRevenueRetriever->getValue();

        /* Monthyl Revenue */
        /**
         * @var $monthlyRevenueRetriever MonthlyRevenueRetriever
         */
        $monthlyRevenueRetriever = Yii::$app->monthlyRevenueRetriever;
        $monthlyRevenueCollection = $monthlyRevenueRetriever->getValue();

        return $this->render(
            'index',
            compact(
                'total_revenue_today',
                'weeklyRevenueDataCollection',
                'monthlyRevenueCollection',
                'dataProvider',
                'listViewDataProvider',
                'agentSubmittionFilterModel')
        );
    }
}