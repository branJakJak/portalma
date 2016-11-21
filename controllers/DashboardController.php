<?php
namespace app\controllers;

use app\components\MonthlyRevenueRetriever;
use app\components\MTAgentEntriesReport;
use app\components\PoxLeadRetriever;
use app\components\TotalRevenueTodayRetriever;
use app\components\WeeklyRevenueRetriever;
use app\dataproviders\LeadCallbackDataProvider;
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
        $mTAgentEntriesReport = new MTAgentEntriesReport();
        $agentSubmittionFilterModel = MoneyActiveClaims::find();
        $agentSubmittionFilterModel->orderBy("date_submitted DESC");
        $dataSubmissiondataProvider = new ActiveDataProvider([
            'query' => $agentSubmittionFilterModel
        ]);

        /*our agents*/
        $agentsListCollection = (new Query())
            ->select(['pb_agent'])
            ->from("ma_claims")
            ->groupBy(['pb_agent'])
            ->all();
        $agentsList = new ArrayDataProvider([
            'models' => $agentsListCollection
        ]);


        /* MT Agents*/
        $mtAgentsCollection = UserAccount::find()->where(['account_type'=>UserAccount::USER_ACCOUNT_TYPE_AGENT])->all();


        /**
         * @var $poxVsLeadRetriever PoxLeadRetriever
         */
        $poxVsLeadRetriever = Yii::$app->poxVsLeadRetriever;
        /*POX today*/
        $poxToday = $poxVsLeadRetriever->getTotalPoxToday();
        $leadToday = $poxVsLeadRetriever->getLeadsToday();
        $percentageToday = $poxVsLeadRetriever->getPoxPercentageToday();
        /*POX this week*/
        $poxThisWeek = $poxVsLeadRetriever->getTotalPoxThisWeek();
        $leadThisWeek = $poxVsLeadRetriever->getLeadsThisWeek();
        $percentageThisWeek = $poxVsLeadRetriever->getPoxPercentageThisWeek();
        /*POX this month*/
        $percentageThisMonth = $poxVsLeadRetriever->getPoxPercentageThisMonth();
        $poxThisMonth = $poxVsLeadRetriever->getTotalPoxThisMonth();
        $leadThisMonth = $poxVsLeadRetriever->getTotalLeadsThisMonth();

        /*callback data*/
        $callbackDataProvider = new LeadCallbackDataProvider();

        return $this->render(
            'index',
            compact(
                    'poxToday',
                    'leadToday',
                    'percentageToday',
                    'percentageThisWeek',
                    'poxThisWeek',
                    'leadThisWeek',
                    'percentageThisMonth',
                    'poxThisMonth',
                    'leadThisMonth',
                    'poxLeadPercentage',
                    'dataSubmissiondataProvider',
                    'agentsList',
                    'agentSubmittionFilterModel',
                    'agentReportRetriever',
                    'mtAgentsCollection',
                    'mTAgentEntriesReport',
                    'callbackDataProvider'
                )
        );
    }
}