<?php

namespace app\modules\Api\controllers;


use Yii;
use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\web\YiiAsset;

/**
 * Default controller for the `modules` module
 */
class DefaultController extends Controller
{
    public function init()
    {
        \Yii::$app->request->enableCsrfValidation = false;
        parent::init(); 
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $jsonMessage = [];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ( !is_null(\Yii::$app->request->post('API_KEY',null))  && \Yii::$app->request->post('API_KEY') === \Yii::$app->params['API_KEY']) {
            $model = new MoneyActiveClaims();
            if ($model->load(\Yii::$app->request->post())) {
                //add default submitted by
                $userAccount = UserAccount::find()->where(['username' => 'moneyactive'])->one();
                $model->submitted_by = $userAccount->id;
                $model->date_submitted = date("Y-m-d H:i:s");
                if($model->save()){
                    $jsonMessage = [
                        "status"=>'success',
                        "message"=>'New claim saved',
                    ];
                }else{
                    $jsonMessage = [
                        "status"=>'error',
                        "message"=>Html::errorSummary($model),
                    ];
                }
            }
        }else{
            $jsonMessage = [
                "status"=>'failed',
                "message"=>'Empty or Invalid key',
            ];
        }
        echo Json::encode($jsonMessage);
    }
}
