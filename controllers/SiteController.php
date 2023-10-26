<?php

namespace app\controllers;

use app\models\Category;
use app\models\Post;
use app\models\SignupForm;
use app\models\Tag;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Post::find()->where(['status' => 1])->all();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionDetail($id)
    {
        $detail = Post::findOne($id);
        if (!$id){
            throw new NotFoundHttpException('Bunday malumot mavjid emas');
        }

        return $this->render('detail',[
            'detail' => $detail
        ]);
    }
    public function actionTags($id)
    {
        $tags = Tag::findOne($id);
        if (!$id){
            throw new NotFoundHttpException('Bunday malumot mavjid emas');
        }

        $otherPosts = Post::find()
            ->leftJoin('post_tag', 'post.id = post_tag.post_id')
            ->where(['post_tag.tag_id' => $id])
            ->all();

        return $this->render('tags', [
            'otherPosts' => $otherPosts,
        ]);
    }

    public function actionCategories($id)
    {
        $tags = Category::findOne($id);
        if (!$id){
            throw new NotFoundHttpException('Bunday malumot mavjid emas');
        }

        $otherPosts = Post::find()
            ->leftJoin('post_category', 'post.id = post_category.post_id')
            ->where(['post_category.category_id' => $id])
            ->all();

        return $this->render('tags', [
            'otherPosts' => $otherPosts,
        ]);
    }


//    public function actionLogin()
//    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        }
//
//        $model->password = '';
//        return $this->render('login', [
//            'model' => $model,
//        ]);
//    }

//    public function actionLogout()
//    {
//        Yii::$app->user->logout();
//
//        return $this->goHome();
//    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


}
