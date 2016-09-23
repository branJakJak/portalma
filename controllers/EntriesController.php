<?php

namespace app\controllers;

use app\components\PbDataRetriever;
use app\models\MoneyActiveClaims;
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
                'only' => ['index','new'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin','agent'],
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
        if (Yii::$app->user->can('admin')) {
            $this->layout = "dashboard";
        }else if (Yii::$app->user->can('agent')) {
            $this->layout = "main";
        }


        /*make sure the current user is either the admin or agent == current agent*/
        if (Yii::$app->user->can('admin') || (Yii::$app->user->identity->username === $agent)) {

        }
        $agentId = null;
        if (!isset($agent)) {
            throw new NotFoundHttpException("Agent $agent doesn't exists");
        }
        //check agentname
        if (UserAccount::find()->where(['username'=>$agent])->exists()) {
            $agentModel = UserAccount::find()->where(['username' => $agent])->one();
            $agentId = $agentModel->id;
        }else {
            throw new \yii\base\Exception("Agent doesnt exists");
        }
        $dataProvider = new ActiveDataProvider([
            'query'=>MoneyActiveClaims::find()->where(['submitted_by'=>$agentId])
        ]);
        return $this->render('index', compact('dataProvider', 'agentModel'));
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

        /*panel datasources*/
        $pendingClaims = new ActiveDataProvider([
            'query'=>MoneyActiveClaims::find()
            ->where(['claim_status'=>MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_PENDING])
            ->orderBy('id DESC')
        ]);
        $ongoingClaims = new ActiveDataProvider([
            'query'=>MoneyActiveClaims::find()
            ->where(['claim_status'=>MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_ONGOING])
            ->orderBy('id DESC')
        ]);
        $completedClaims = new ActiveDataProvider([
            'query'=>MoneyActiveClaims::find()
            ->where(['claim_status'=>MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_DONE,'submitted_by'=>Yii::$app->user->id])
            ->orderBy('id DESC')
        ]);

        /*money active momdel*/
        $newFormEntry = new MoneyActiveClaims([
                'submitted_by'=>Yii::$app->user->id,
            ]);
            
        if (isset(Yii::$app->request->queryParams['claim'])) {
            $claimId = intval(Yii::$app->request->queryParams['claim']);
            if (!MoneyActiveClaims::find()->where(['id' => $claimId])->exists()) {
                throw new Exception("The claim must have been deleted");
            }else {
                $newFormEntry = MoneyActiveClaims::find()->where(['id' => $claimId])->one();
                // if status is ongoing skip the update and alert the user ,
//                if ($newFormEntry->claim_status === MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_ONGOING) {
//                    $messcontainer = sprintf("! New claim was saved . %s", $viewSubmittedDataLink);
//                    Yii::$app->session->setFlash("info",$messcontainer );
//                    $newFormEntry = new MoneyActiveClaims;
//                } else if($newFormEntry->claim_status === MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_PENDING){
//                    // if status is pending , update status to ongoing
//                }
                
                $newFormEntry->claim_status = MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_ONGOING;
                $newFormEntry->submitted_by = Yii::$app->user-> id;
                $newFormEntry->update(false);

            }
        }

        /*form submit*/
        if ($newFormEntry->load(Yii::$app->request->post()) ) {
            if ($newFormEntry->isNewRecord) {
                $newFormEntry->claim_status = MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_PENDING;
                $newFormEntry->submitted_by = Yii::$app->user->id;
                $newFormEntry->save();
            }else{
                $newFormEntry->claim_status = MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_DONE;
                $newFormEntry->submitted_by = Yii::$app->user->id;
                $newFormEntry->touch('updated_at');
                $newFormEntry->update(false);
            }
            //create url to view submitted data
            $viewSubmittedDataLink =  Html::a("View submitted data", ['/money-active-claims/view', 'id' => $newFormEntry->id], ['class' => 'btn btn-default']);
            $messcontainer = sprintf("Success! New claim was saved . %s", $viewSubmittedDataLink);
            Yii::$app->session->setFlash("success",$messcontainer );
            $newFormEntry = new MoneyActiveClaims;
            return $this->redirect(['entries/new']);
        }

        $viewBag = ['model'=>$newFormEntry];
        $viewBag  = ArrayHelper::merge($viewBag, compact(
            'pendingClaims',
            'ongoingClaims',
            'completedClaims'
        ));
        return $this->render("new", $viewBag);
    }


}
