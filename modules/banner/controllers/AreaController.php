<?php

namespace app\modules\banner\controllers;

use Yii;
use app\modules\banner\models\BannerArea;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AreaController implements the CRUD actions for BannerArea model.
 */
class AreaController extends Controller
{
    /** @var string */
    public $layout = '@app/views/layouts/admin';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'view'],
                        'roles'   => [BannerArea::RULE_VIEW],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['delete'],
                        'verbs'   => ['POST'],
                        'roles'   => [BannerArea::RULE_UPDATE],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create'],
                        'roles'   => [BannerArea::RULE_CREATE],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['update'],
                        'roles'   => [BannerArea::RULE_UPDATE],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all BannerArea models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BannerArea::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BannerArea model.
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
     * Creates a new BannerArea model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BannerArea();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BannerArea model.
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
     * Deletes an existing BannerArea model.
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
     * Finds the BannerArea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BannerArea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BannerArea::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
