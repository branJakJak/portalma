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
use yii\data\ArrayDataProvider;
use yii\db\cubrid\QueryBuilder;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
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
        $agentSubmittionFilterModel = MoneyActiveClaims::find();
        $agentSubmittionFilterModel->orderBy("date_submitted DESC");
        $dataProvider = new ActiveDataProvider([
            'query' => $agentSubmittionFilterModel
        ]);

        $agentsListCollection = (new Query())
            ->select(['pb_agent'])
            ->from("ma_claims")
            ->groupBy(['pb_agent'])
            ->all();
        $agentsList = new ArrayDataProvider([
            'models' => $agentsListCollection
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
                'agentsList',
                'agentSubmittionFilterModel')
        );
    }
}