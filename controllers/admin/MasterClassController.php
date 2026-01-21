<?php

namespace app\controllers\admin;

use app\models\MasterClass;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class MasterClassController extends Controller
{
  public $layout = 'admin';

  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => MasterClass::find()->orderBy(['starts_at' => SORT_DESC]),
      'pagination' => ['pageSize' => 20],
    ]);

    return $this->render('index', compact('dataProvider'));
  }

  public function actionCreate()
  {
    $model = new MasterClass();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    }

    return $this->render('form', compact('model'));
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    }

    return $this->render('form', compact('model'));
  }

  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    return $this->redirect(['index']);
  }

  protected function findModel($id): MasterClass
  {
    $model = MasterClass::findOne((int)$id);
    if (!$model) throw new NotFoundHttpException('Запись не найдена');
    return $model;
  }
}
