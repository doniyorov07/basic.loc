<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\Post;
use app\models\search\Post as PostSearch;
use app\models\Tag;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends DefaultController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['error'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'create', 'index', 'update', 'delete', 'change'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $tagIds = \Yii::$app->request->post('Post')['tag_id'];
                $tagIds = is_array($tagIds) ? $tagIds : [];

                foreach ($tagIds as $tagId) {
                    $tag = Tag::findOne($tagId);
                    if (!$tag) {
                        $tag = new Tag();
                        $tag->name = $tagId;
                        $tag->save();
                    }
                    $model->link('tags', $tag);
                }

                $catIds = \Yii::$app->request->post('Post')['category_id'];
                $catIds = is_array($catIds) ? $catIds : [];

                foreach ($catIds as $catId) {
                    $cat = Category::findOne($catId);
                    if (!$cat) {
                        $cat = new Tag();
                        $cat->name = $catId;
                        $cat->save();
                    }
                    $model->link('categories', $cat);
                }

                \Yii::$app->session->setFlash('success', 'Ma\'lumot muvaffaqqiyatli qo\'shildi');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Post::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {


                $tagIds = \Yii::$app->request->post('Post')['tag_id'];
                $tagIds = is_array($tagIds) ? $tagIds : [];


                foreach ($tagIds as $tagId) {
                    $tag = Tag::findOne($tagId);
                    if (!$tag) {
                        $tag = new Tag();
                        $tag->name = $tagId;
                        $tag->save();
                    }
                    $model->link('tags', $tag);
                }

                $catIds = \Yii::$app->request->post('Post')['category_id'];
                $catIds = is_array($catIds) ? $catIds : [];


                foreach ($catIds as $catId) {
                    $cat = Category::findOne($catId);
                    if (!$cat) {
                        $cat = new Category();
                        $cat->name = $catId;
                        $cat->save();
                    }
                    $model->link('categories', $cat);
                }

                \Yii::$app->session->setFlash('success', 'Ma\'lumot muvaffaqqiyatli yangilandi');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('success', 'Ma\'lumot muvaffaqqiyatli o\'chirildi');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
