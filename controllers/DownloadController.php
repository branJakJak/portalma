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
        $exportCols = [
                'title',
                'firstname',
                'surname' ,
                'postcode',
                'address',
                'tm',
                'acc_rej',
                'outcome',
                'packs_out',
                'claim_status',
                'notes',
                'mobile',
                'pb_agent',
                'comment',
                'date_of_birth',
                'email',
                'bank_name',
                'approx_month',
                'approx_date',
                'approx_year',
                'paid_per_month',
                'bank_account_type',
                'date_submitted',
                'updated_at'
        ];

        if (MoneyActiveClaims::find()->count() <= 0) {
            throw new Exception("Nothing to export");
        }
        $filename = sprintf("%s.%s.csv", Yii::$app->formatter->asDate(date("Y-m-d"), "long"), Yii::$app->name);
        $tempNameContainer = tempnam(sys_get_temp_dir(), "asd");
        $fileres = fopen($tempNameContainer, "r+");
        $resultArr = MoneyActiveClaims::find()
            ->select($exportCols)
            ->asArray(true)
            ->all();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename.csv\";");
        header("Content-Transfer-Encoding: binary");


        foreach ($resultArr as $index => $currentRow) {
            if ($index === 0) {
                $headers = array_keys($currentRow);
                fputcsv($fileres, $headers);
            }
            $curVals = array_values($currentRow);
            fputcsv($fileres, $curVals);
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

            $exportCols = [
                    'title',
                    'firstname',
                    'surname' ,
                    'postcode',
                    'address',
                    'tm',
                    'acc_rej',
                    'outcome',
                    'packs_out',
                    'claim_status',
                    'notes',
                    'mobile',
                    'pb_agent',
                    'comment',
                    'date_of_birth',
                    'email',
                    'bank_name',
                    'approx_month',
                    'approx_date',
                    'approx_year',
                    'paid_per_month',
                    'bank_account_type',
                    'date_submitted',
                    'updated_at'
            ];


            $resultArr = MoneyActiveClaims::find()
                ->where(['pb_agent' => $agentName])
                ->select($exportCols)
                ->asArray(true)
                ->all();
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$filename.csv\";");
            header("Content-Transfer-Encoding: binary");

            fputcsv($fileres, $exportCols);


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
        $exportCols = [
                'title',
                'firstname',
                'surname' ,
                'postcode',
                'address',
                'tm',
                'acc_rej',
                'outcome',
                'packs_out',
                'claim_status',
                'notes',
                'mobile',
                'pb_agent',
                'comment',
                'date_of_birth',
                'email',
                'bank_name',
                'approx_month',
                'approx_date',
                'approx_year',
                'paid_per_month',
                'bank_account_type',
                'date_submitted',
                'updated_at'
        ];        
        $query = MoneyActiveClaims::find()
            ->select($exportCols)
            ->where(['outcome' => 'CALL BACK']);
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
