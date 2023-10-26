<?php

namespace app\modules\admin\controllers;

use app\models\Tag;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends DefaultController
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

        $tag = Tag::find()->all();
        $model = new Tag();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                \Yii::$app->session->setFlash('success', 'Tag muvaffaqqiyatli qo\'shildi');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('index', [
            'model' => $model,
            'tag' => $tag,
        ]);
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model)
        {
            throw new NotFoundHttpException('Bunday tag mavjud emas!');
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Tag muvaffaqqiyatli o\'zgartirildi');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->request->isPost) {
            $model = $this->findModel($id);
            if ($model->delete())
            \Yii::$app->session->setFlash('success', 'Tag muvaffaqqiyatli o\'chirildi');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChange()
    {
        $id = \Yii::$app->request->get('id');
        $model = Tag::findOne($id);
        if($model->status == 1){
            $model->status = 0;
        }else{
            $model->status = 1;
        }
        if ($model->save()) {
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
}
