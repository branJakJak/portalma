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
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class DownloadController extends \yii\web\Controller
{
    protected $exportCols = [
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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['all','agent','callbacks','dropcalls'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['all','agent','callbacks','dropcalls'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }
    public function actionDropcalls($filter)
    {
        $query = MoneyActiveClaims::find()
            ->select($this->exportCols)
            ->where(['outcome' => 'DROPPED CALL']);
        $this->downloadHelper($query, 'dropped-calls', $filter);
    }

    public function actionAll()
    {
        if (MoneyActiveClaims::find()->count() <= 0) {
            throw new Exception("Nothing to export");
        }
        $query = MoneyActiveClaims::find()
            ->select($this->exportCols);
        $this->downloadHelper($query, 'all', '', 'all-records');
    }

    public function actionAgent($agentName)
    {
        $agentId = null;
        if (MoneyActiveClaims::find()->count() <= 0) {
            throw new \yii\base\Exception("Nothing to export");
        }
        //check agentname
        if (MoneyActiveClaims::find()->where(['pb_agent' => $agentName])->exists()) {
            $query = MoneyActiveClaims::find()
                ->where(['pb_agent' => $agentName])
                ->select($this->exportCols);
            $this->downloadHelper($query, 'agent-' . $agentName, '');
        } else {
            throw new \yii\base\Exception("Agent doesnt exists");
        }
    }

    public function actionCallbacks($filter='all')
    {
        $query = MoneyActiveClaims::find()
            ->select($this->exportCols)
            ->where(['outcome' => 'CALL BACK']);
        $this->downloadHelper($query, 'callbacks', $filter);
    }
    protected function downloadHelper(ActiveQuery $query ,$type,$filter)
    {
        $fileName = "$type." . date("Y-m-d").'-';
        if ($filter === 'today') {
            $fileName .= '-today';
            $query->andWhere(['date(date_submitted)' => date("Y-m-d")]);
        }
        $queryResultArr = new QueryResultToCsv();
        $fileOutput = $queryResultArr->writeToFile($query->asArray()->all());
        //force download
        ForceDownloadCsv::export($fileOutput , $fileName);
    }


}
