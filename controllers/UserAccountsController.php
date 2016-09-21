<?php

namespace app\controllers;

use Yii;
use app\models\UserAccount;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserAccountsController implements the CRUD actions for UserAccount model.
 */
class UserAccountsController extends Controller
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
                        'actions' => ['index','view','create','update','delete'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['new'],
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
     * Lists all UserAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UserAccount::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserAccount model.
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
     * Creates a new UserAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserAccount();
        $model->account_type = UserAccount::USER_ACCOUNT_TYPE_AGENT;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            if ($model->save()) {
                $authManager = Yii::$app->authManager;
                $agentRole = $authManager->getRole('agent');
                $authManager->assign($agentRole, $model->id);
                if (Yii::$app->user->can('admin')) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    Yii::$app->session->setFlash("success", "New account created");
                    $model = new UserAccount;
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);        
    }

    /**
     * Updates an existing UserAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserAccount model.
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
     * Finds the UserAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
