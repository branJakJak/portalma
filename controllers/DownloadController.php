<?php

namespace app\controllers;

use app\components\ForceDownloadCsv;
use app\components\PbDataRetriever;
use app\components\QueryResultToCsv;
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
                'only' => ['all','agent'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['all', 'agent'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     *
     */
    public function actionAll()
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

    public function actionCallbacks($filter='all')
    {
        $query = MoneyActiveClaims::find()->where(['outcome' => 'CALL BACK']);
        $fileName = "callbacks." . date("Y-m-d").'-';
        if ($filter === 'today') {
            $fileName .= 'today';
            $query->andWhere(['date(date_submitted)' => date("Y-m-d")]);
        }
        $queryResultArr = new QueryResultToCsv();
        $fileOutput = $queryResultArr->writeToFile($query->asArray()->all());
        //force download
        ForceDownloadCsv::export($fileOutput , $fileName);
    }


}
