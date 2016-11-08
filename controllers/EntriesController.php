<?php

namespace app\controllers;

use app\components\AgentEntriesReport;
use app\components\PbDataRetriever;
use app\models\MoneyActiveClaims;
use app\models\QuickLeadSearchForm;
use app\models\UserAccount;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EntriesController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'new'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin', 'agent'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['new'],
                        'roles' => ['agent'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($agent)
    {
        /*choose layout depending on who is logged in*/
        if (Yii::$app->user->can('admin')) {
            $this->layout = "dashboard";
        } else if (Yii::$app->user->can('agent')) {
            $this->layout = "main";
        }

        /*make sure the current user is either the admin or agent == current agent*/
        if (Yii::$app->user->can('admin') || (Yii::$app->user->identity->username === $agent)) {
            if (!isset($agent)) {
                throw new NotFoundHttpException("Agent $agent doesn't exists");
            }
            //check agentname
            if (!MoneyActiveClaims::find()->where(['pb_agent' => $agent])->exists()) {
                throw new \yii\base\Exception("Agent doesnt exists");
            } else {
                //get all data submitted by certain pb_agent
                $dataProvider = new ActiveDataProvider([
                    'query' => MoneyActiveClaims::find()->where(['pb_agent' => $agent])
                ]);
                                
                /**
                 * @var $agentReportRetriever AgentEntriesReport
                 */
                $agentReportRetriever = Yii::$app->agentEntriesReport;
                $agentReportRetriever->setAgent($agent);
                $todayPercentage = $agentReportRetriever->getTodaysPercentage();
                $weekPercentage = $agentReportRetriever->getWeekPercentage();
                $monthPercentage = $agentReportRetriever->getMonthPercentage();

                $todaySubmission = $agentReportRetriever->getTodaysSubmission();
                $weekSubmission = $agentReportRetriever->getWeekSubmission();
                $monthSubmission = $agentReportRetriever->getMonthSubmission();
                
               return $this->render('index', compact(
                    'dataProvider', 
                    'agent',
                    'todayPercentage',
                    'weekPercentage',
                    'monthPercentage',
                    'todaySubmission',
                    'weekSubmission',
                    'monthSubmission'
                ));
            }
        } else {
            throw new NotFoundHttpException("Sorry you are ");
        }

    }

    /**
     *  This is an agent only controller
     *
     **/
    public function actionNew()
    {
        /**
         * @var $newFormEntry MoneyActiveClaims
         */
        $formModel = new QuickLeadSearchForm();
        $foundModels = null;
        if($formModel->load(Yii::$app->request->post())){
            $foundModels = $formModel->search();
        }
        /*panel datasources*/
        $pendingClaims = new ActiveDataProvider([
            'query' => MoneyActiveClaims::find()
                    ->where(['claim_status' => MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_PENDING])
                    ->orderBy('id DESC'),
            'pagination' => ['pageSize' => 5]
        ]);
        $ongoingClaims = new ActiveDataProvider([
            'query' => MoneyActiveClaims::find()
                    ->where(['claim_status' => MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_ONGOING])
                    ->orderBy('id DESC'),
            'pagination' => ['pageSize' => 5]

        ]);
        $completedClaims = new ActiveDataProvider([
            'query' => MoneyActiveClaims::find()
                    ->where(
                        [
                            'claim_status' => MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_DONE,
                            'submitted_by' => Yii::$app->user->id
                        ]
                    )
                    ->orderBy('id DESC'),
            'pagination' => ['pageSize' => 5]

        ]);

        /*money active momdel*/
        $newFormEntry = new MoneyActiveClaims([
            'submitted_by' => Yii::$app->user->id,
        ]);

        if (isset(Yii::$app->request->queryParams['claim'])) {
            $claimId = intval(Yii::$app->request->queryParams['claim']);
            if (!MoneyActiveClaims::find()->where(['id' => $claimId])->exists()) {
                throw new Exception("The claim must have been deleted");
            } else {
                $newFormEntry = MoneyActiveClaims::find()->where(['id' => $claimId])->one();
                $newFormEntry->claim_status = MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_ONGOING;
                $newFormEntry->submitted_by = Yii::$app->user->id;
                $newFormEntry->update(false);

            }
        } else {
            //get the next claim that is pending , 
            if (MoneyActiveClaims::find()->where(['claim_status' => MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_PENDING])->exists()) {
                $topPending = MoneyActiveClaims::findOne(['claim_status' => MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_PENDING]);
                return $this->redirect(Url::to(['/entries/new', 'claim' => $topPending->id]));
            }
            //if exists , then redirect , 
            //if no more pending , proceed empty 
        }

        /*form submit*/
        if ($newFormEntry->load(Yii::$app->request->post())) {
            if ($newFormEntry->isNewRecord) {
                $newFormEntry->claim_status = MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_PENDING;
                $newFormEntry->submitted_by = Yii::$app->user->id;
                $newFormEntry->save();
            } else {
                $newFormEntry->claim_status = MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_DONE;
                $newFormEntry->submitted_by = Yii::$app->user->id;
                $newFormEntry->updated_at = date("Y-m-d H:i:s");
                $newFormEntry->update(false);
            }
            //create url to view submitted data
            $viewSubmittedDataLink = Html::a("View submitted data", ['/money-active-claims/view', 'id' => $newFormEntry->id], ['class' => 'btn btn-default']);
            $messcontainer = sprintf("Success! New claim was saved . %s", $viewSubmittedDataLink);
            Yii::$app->session->setFlash("success", $messcontainer);
            $newFormEntry = new MoneyActiveClaims;
            return $this->redirect(['entries/new']);
        }

        $viewBag = ['model' => $newFormEntry];
        $viewBag = ArrayHelper::merge($viewBag, compact(
            'pendingClaims',
            'ongoingClaims',
            'completedClaims',
            'formModel',
            'foundModels'
        ));
        return $this->render("new", $viewBag);
    }


}
