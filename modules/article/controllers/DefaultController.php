<?php

namespace app\modules\article\controllers;

use app\modules\article\models\Tag;
use common\libs\fileuploader\actions\FileAction;
use common\libs\fileuploader\actions\FileConnectorAction;
use Yii;
use app\modules\article\models\Article;
use app\modules\article\models\ArticleEditForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\libs\safedata\SafeDataFinder;

/**
 * Class DefaultController
 * @package app\modules\article\controllers
 * @method string actionFile()
 * @method string actionFileConnector()
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
                'only'  => ['view', 'create', 'update', 'delete', 'file', 'fileconnector'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['view'],
                        'roles'   => ['?', Article::RULE_VIEW],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['delete'],
                        'verbs'   => ['POST'],
                        'roles'   => [Article::RULE_UPDATE],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create'],
                        'roles'   => [Article::RULE_CREATE],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['update'],
                        'roles'   => [Article::RULE_UPDATE],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['file', 'fileconnector'],
                        'roles'   => [Article::RULE_UPLOAD_FILES],
                    ],
                ],
            ],
        ];
    }

    /** @inheritdoc */
    public function beforeAction($action)
    {
        if ($action->id == 'fileconnector') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'file'          => [
                'class' => FileAction::className(),
            ],
            'fileconnector' => [
                'class' => FileConnectorAction::className(),
                'path'  => 'articles',
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return string
     */
    public function actionIndex()
    {
        $query = SafeDataFinder::init(Article::className())
            ->find()
            ->orderBy(['updated' => SORT_DESC]);

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize'   => self::ARTICLES_COUNT_PER_PAGE,
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
     * Просмотр категории
     * @param string|int $category
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($category)
    {
        $tagConditions = ['is_main' => Tag::IS_MAIN];
        $tagConditions += is_numeric($category) ?
            ['id' => $category] : ['slug' => $category];

        $tag = Tag::findOne($tagConditions);
        if (!$tag) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $query = SafeDataFinder::init(Article::className())
            ->find()
            ->joinWith('tags')
            ->where(['tags.id' => $tag->id])
            ->orderBy(['updated' => SORT_DESC]);

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize'   => self::ARTICLES_COUNT_PER_PAGE,
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
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->markDeleted()) {
            return $this->redirect(['index']);
        }

        throw new NotFoundHttpException('Occured error. Try again or not. :(');
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
        $model = SafeDataFinder::init(Article::className())->findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
