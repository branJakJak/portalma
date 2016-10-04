<?php
namespace app\controllers;

use app\components\MonthlyRevenueRetriever;
use app\components\TotalRevenueTodayRetriever;
use app\components\WeeklyRevenueRetriever;
use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use Faker\Provider\ka_GE\DateTime;
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
            'query' => $agentSubmittionFilterModel
        ]);

        $listViewDataProvider = new ActiveDataProvider([
            'query' => UserAccount::find()->where(['account_type' => UserAccount::USER_ACCOUNT_TYPE_AGENT])
        ]);

        /*Total Revenue Today*/
        /**
         * @var $totalRevenueTodayRetriever TotalRevenueTodayRetriever
         */
        // $totalRevenueTodayRetriever = Yii::$app->totalRevenueTodayRetriever;
        // $total_revenue_today = $totalRevenueTodayRetriever->getValue();

        /**
         * @var $poxVsLeadRetriever
         */
        $poxVsLeadRetriever = Yii::$app->poxVsLeadRetriever;
        $pox_vs_lead = $poxVsLeadRetriever->getValue();
        $poxLeadPercentage = $poxVsLeadRetriever->getPercentage();
        /*Weekly Revenue*/
        /**
         * @var $weeklyRevenueRetriever WeeklyRevenueRetriever
         */
        $weeklyRevenueRetriever = Yii::$app->weeklyRevenueRetriever;
        $dt = new \DateTime(date("Y-m-d"));
        $weeklyRevenueRetriever->week = $dt->format("W");
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
                'pox_vs_lead',
                'poxLeadPercentage',
                // 'total_revenue_today',
                'weeklyRevenueDataCollection',
                'monthlyRevenueCollection',
                'dataProvider',
                'listViewDataProvider',
                'agentSubmittionFilterModel')
        );
    }
}