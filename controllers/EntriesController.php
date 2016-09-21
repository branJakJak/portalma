<?php

namespace app\controllers;

use app\components\PbDataRetriever;
use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
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
                        'roles' => ['admin'],
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

    public function actionIndex($agent_name)
    {
        $this->layout = "dashboard";

        $agentId = null;
        if (!isset($agent_name)) {
            throw new NotFoundHttpException("Agent $agent_name doesn't exists");
        }
        //check agentname
        if (UserAccount::find()->where(['username'=>$agent_name])->exists()) {
            $agentModel = UserAccount::find()->where(['username' => $agent_name])->one();
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
        $newFormEntry = new MoneyActiveClaims();
        $newFormEntry->submitted_by = Yii::$app->user->id;
        if ($newFormEntry->load(Yii::$app->request->post()) && $newFormEntry->save() ) {
            //create url to view submitted data
            $viewSubmittedDataLink =  Html::a("View submitted data", ['/money-active-claims/view', 'id' => $newFormEntry->id], ['class' => 'btn btn-default']);
            $messcontainer = sprintf("Success! New claim was saved . %s", $viewSubmittedDataLink);
            Yii::$app->session->setFlash("success",$messcontainer );
            $newFormEntry = new MoneyActiveClaims;
            return $this->redirect(['entries/new']);
        }
        return $this->render("new", ['model'=>$newFormEntry]);
    }
}
