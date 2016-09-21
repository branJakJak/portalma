<?php

namespace app\controllers;

use app\components\PbDataRetriever;
use app\models\MoneyActiveClaims;
use app\models\UserAccount;
use Exception;
use Faker\Provider\zh_CN\DateTime;
use Yii;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\filters\AccessControl;

class DownloadController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','agent'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     *
     */
    public function actionIndex()
    {
         if (MoneyActiveClaims::find()->count() <= 0) {
            throw new Exception("Nothing to export");
        }
        $filename = sprintf("%s.%s.csv", Yii::$app->formatter->asDate(date("Y-m-d"), "long"), Yii::$app->name);
        $tempNameContainer = tempnam(sys_get_temp_dir(), "asd");
        $fileres = fopen($tempNameContainer, "r+");
        $resultArr = MoneyActiveClaims::find()->select(['title','firstname','surname','postcode','address','mobile','tm','acc_rej','outcome','packs_out','date_submitted'])->asArray(true)->all();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename.csv\";");
        header("Content-Transfer-Encoding: binary");
        $headers = [
            'Title',
            'Firstname',
            'Surname',
            'Postcode',
            'Address',
            'Mobile',
            'TM',
            'ACC/REJ',
            'OUTCOME',
            'PACKS OUT',
            'Submitted',
        ];
        fputcsv($fileres, $headers);
        foreach ($resultArr as $currentRow) {
            fputcsv($fileres, $currentRow);
        }
        fclose($fileres);
        echo file_get_contents($tempNameContainer);
        \Yii::$app->end();
    }

    /**
     * Agent specific download
     * @param $agentName
     * @throws \Exception
     */
    public function actionAgent($agentName){
        $agentId = null;
        if (MoneyActiveClaims::find()->count() <= 0) {
            throw new \yii\base\Exception("Nothing to export");
        }
        //check agentname
        if (UserAccount::find()->where(['username'=>$agentName])->exists()) {
            $searchAgentResult = UserAccount::find()->where(['username' => $agentName])->one();
            $agentId = $searchAgentResult->id;
        }else {
            throw new \yii\base\Exception("Agent doesnt exists");
        }


        $filename = sprintf("%s.%s.csv", Yii::$app->formatter->asDate(date("Y-m-d"), "long"), Yii::$app->name);
        $tempNameContainer = tempnam(sys_get_temp_dir(), "asd");
        $fileres = fopen($tempNameContainer, "r+");
        $resultArr = MoneyActiveClaims::find()->where(['submitted_by'=>$agentId])->select(['title','firstname','surname','postcode','address','mobile','tm','acc_rej','outcome','packs_out','date_submitted'])->asArray(true)->all();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename.csv\";");
        header("Content-Transfer-Encoding: binary");
        $headers = [
            'Firstname',
            'Surname',
            'Postcode',
            'Title',
            'Address',
            'Mobile',
            'TM',
            'ACC/REJ',
            'OUTCOME',
            'PACKS OUT',
            'Submitted',
        ];
        fputcsv($fileres, $headers);
        foreach ($resultArr as $currentRow) {
            fputcsv($fileres, $currentRow);
        }
        fclose($fileres);
        echo file_get_contents($tempNameContainer);
        \Yii::$app->end();
    }

}
