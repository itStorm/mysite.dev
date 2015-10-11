<?php

namespace app\modules\article\controllers;

use Yii;
use app\modules\article\models\Article;
use app\modules\article\models\ArticleEditForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 * @package app\modules\article\controllers
 */
class DefaultController extends Controller
{
    /**
     * Количество статей на странице
     */
    const ARTICLES_COUNT_PER_PAGE = 10;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?', Article::RULE_VIEW],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'verbs' => ['POST'],
                        'roles' => [Article::RULE_UPDATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [Article::RULE_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => [Article::RULE_UPDATE],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Article::find();
        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => self::ARTICLES_COUNT_PER_PAGE,
        ]);

        $articles = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'articles' => $articles,
            'pages'    => $pages,
        ]);
    }

    /**
     * Displays a single Article model.
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
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleEditForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $article = $this->findModel($id);
        $model = new ArticleEditForm();
        $model->setModel($article);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
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
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
