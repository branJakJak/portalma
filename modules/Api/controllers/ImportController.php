<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/29/16
 * Time: 1:43 AM
 */

namespace app\modules\Api\controllers;



use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class ImportController extends Controller{

    public function init(){
        \Yii::$app->request->enableCsrfValidation = false;
        parent::init();
    }

    public function actionIndex()
    {
        $jsonMessage = [];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ( !is_null(\Yii::$app->request->post('API_KEY',null))  && \Yii::$app->request->post('API_KEY') === \Yii::$app->params['API_KEY']) {
            $model = new MoneyActiveClaims([
                'scenario'=>MoneyActiveClaims::MONEY_ACTIVE_CLAIM_STATUS_API_IMPORT
            ]);
            if ($model->load(\Yii::$app->request->post())) {
                //add default submitted by
                $userAccount = UserAccount::find()->where(['username' => 'moneyactive'])->one();
                if (isset($model->tm)) {
                    if (UserAccount::find()->where(['username' => strtoupper( $model->tm )])->exists()) {
                        $userAccount = UserAccount::find()->where(['username' => strtoupper( $model->tm ) ])->one();
                    }
                }
                $model->submitted_by = $userAccount->id;
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