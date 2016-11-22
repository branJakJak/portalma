<?php

namespace app\controllers;

use Yii;
use app\models\MoneyActiveClaims;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UserAccount;
use app\models\QuickLeadSearchForm;


/**
 * MoneyActiveClaimsController implements the CRUD actions for MoneyActiveClaims model.
 */
class MoneyActiveClaimsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','new'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['superadmin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['agent'],
                    ],
                ],
            ],        
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MoneyActiveClaims models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryComm = MoneyActiveClaims::find();
        $searchForm = new QuickLeadSearchForm();
        if ($searchForm->load(Yii::$app->request->post()) ) {
            $searchForm->search();
            $queryComm = $searchForm->getQueryInstance();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $queryComm,
        ]);

        return $this->render('index', compact('dataProvider','searchForm'));
    }

    /**
     * Displays a single MoneyActiveClaims model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MoneyActiveClaims model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MoneyActiveClaims(['scenario'=>MoneyActiveClaims::MONEY_ACTIVE_CLAIM_SCENARIO_EMERGENCY_INPUT]);

        if ($model->load(Yii::$app->request->post())) {
            $userAccount = UserAccount::find()->where(['username' => 'moneyactive'])->one();
            $model->submitted_by = $userAccount->id;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MoneyActiveClaims model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = "update";
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MoneyActiveClaims model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the MoneyActiveClaims model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MoneyActiveClaims the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneyActiveClaims::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
