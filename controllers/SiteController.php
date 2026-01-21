<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\News;
use app\models\Request as RequestModel;
use Yii;
use yii\web\NotFoundHttpException;
use app\models\MasterClass;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $news = News::find()
            ->where(['is_published' => 1])
            ->orderBy(['published_at' => SORT_DESC])
            ->limit(4)
            ->all();

        $requestModel = new RequestModel();

        if (Yii::$app->request->isPost) {
            $requestModel->parent_name  = trim((string)Yii::$app->request->post('parent_name'));
            $requestModel->child_age    = (int)Yii::$app->request->post('child_age');
            $requestModel->parent_phone = trim((string)Yii::$app->request->post('parent_phone'));

            if ($requestModel->save()) {
                Yii::$app->session->setFlash('success', 'Заявка отправлена! Мы свяжемся с вами.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Проверьте поля формы. Заявка не отправлена.');
            }
        }

        return $this->render('index', [
            'news' => $news,
            'requestModel' => $requestModel,
        ]);
    }

    public function actionNewsView($id)
    {
        $news = News::find()
            ->where(['id' => (int)$id, 'is_published' => 1])
            ->one();

        if (!$news) {
            throw new NotFoundHttpException('Новость не найдена');
        }

        return $this->render('new', [
            'news' => $news,
        ]);
    }


    public function actionPage($view)
    {
        return $this->render('blocks/' . $view);
    }

    public function actionBirthday()
    {
        return $this->render('birthday');
    }

    public function actionNew()
    {
        return $this->render('new');
    }

    public function actionCategorie($view = 'categories/categorie_1')
    {
        return $this->render('categorie', [
            'view' => $view,
        ]);
    }

    public function actionMasterClass()
    {
        $items = MasterClass::find()
            ->where(['is_published' => 1])
            ->andWhere(['>=', 'starts_at', date('Y-m-d 00:00:00')])
            ->orderBy(['starts_at' => SORT_ASC, 'sort' => SORT_ASC])
            ->all();

        return $this->render('master-class', [
            'items' => $items,
        ]);
    }
}
