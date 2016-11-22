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
                        'actions' => ['index', 'agent'],
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
        $headers = ['title', 'firstname', 'surname', 'postcode', 'address', 'mobile', 'tm', 'acc_rej', 'outcome', 'notes', 'comment', 'packs_out', 'date_submitted'];
        $resultArr = MoneyActiveClaims::find()
            ->select($headers)
            ->asArray(true)
            ->all();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename.csv\";");
        header("Content-Transfer-Encoding: binary");
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
    public function actionAgent($agentName)
    {
        $agentId = null;
        if (MoneyActiveClaims::find()->count() <= 0) {
            throw new \yii\base\Exception("Nothing to export");
        }
        //check agentname
        if (MoneyActiveClaims::find()->where(['pb_agent' => $agentName])->exists()) {
            $filename = sprintf("%s.%s.csv", Yii::$app->formatter->asDate(date("Y-m-d"), "long"), Yii::$app->name);
            $tempNameContainer = tempnam(sys_get_temp_dir(), "asd");
            $fileres = fopen($tempNameContainer, "r+");
            $headers = ['title', 'firstname', 'surname', 'postcode', 'address', 'mobile', 'tm', 'acc_rej', 'outcome', 'notes', 'comment', 'packs_out', 'date_submitted'];
            $resultArr = MoneyActiveClaims::find()
                ->where(['pb_agent' => $agentName])
                ->select($headers)
                ->asArray(true)
                ->all();
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$filename.csv\";");
            header("Content-Transfer-Encoding: binary");

            fputcsv($fileres, $headers);


            foreach ($resultArr as $currentRow) {
                fputcsv($fileres, $currentRow);
            }
            fclose($fileres);
            echo file_get_contents($tempNameContainer);
            \Yii::$app->end();
        } else {
            throw new \yii\base\Exception("Agent doesnt exists");
        }


    }

}
