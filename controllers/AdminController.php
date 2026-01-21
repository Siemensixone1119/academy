<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\models\News;
use app\models\Request;
use app\models\MasterClass;
use app\models\AdminUser;

class AdminController extends Controller
{
  public $layout = 'admin';  // Шаблон для админки

  // Экшен для входа
  public function actionLogin()
  {
    // Если уже залогинен, редиректим в админку
    if (!Yii::$app->user->isGuest) {
      return $this->redirect(['/admin/index']);
    }

    // Создаём модель AdminUser для логина
    $model = new AdminUser();

    // Простейшая авторизация: проверяем логин и пароль
    if (Yii::$app->request->isPost) {
      $email = Yii::$app->request->post('email');
      $password = Yii::$app->request->post('password');

      // Ищем пользователя в базе данных
      $user = AdminUser::findByEmail($email);

      // Если пользователь найден и пароль совпадает
      if ($user && $user->validatePassword($password)) {
        // Логиним пользователя
        Yii::$app->user->login($user, 3600 * 24); // Логиним на 24 часа
        return $this->redirect(['/admin/index']);  // Перенаправляем в админку
      }

      // Если логин не успешен
      Yii::$app->session->setFlash('error', 'Неверные данные для входа');
    }

    // Если логин не успешен, показываем страницу логина
    return $this->render('login', [
      'model' => $model,  // Передаем модель в представление
    ]);
  }

  // Выход
  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();  // Перенаправляем на главную страницу
  }

  // Проверка на авторизацию
  public function beforeAction($action)
  {
    if (Yii::$app->user->isGuest && $action->id !== 'login') {
      return $this->redirect(['/admin/login']);  // Перенаправляем на страницу логина
    }

    return parent::beforeAction($action);
  }

  public function actionIndex($tab = 'requests', $editNewsId = null, $editMasterClassId = null)
  {
    // ===================== REQUESTS filters =====================
    $reqStatus = Yii::$app->request->get('req_status');
    $reqQ = trim((string)Yii::$app->request->get('req_q', ''));

    $requestsQuery = Request::find()->orderBy(['created_at' => SORT_DESC]);

    if ($reqStatus !== null && $reqStatus !== '') {
      $requestsQuery->andWhere(['status' => $reqStatus]);
    }

    if ($reqQ !== '') {
      $requestsQuery->andWhere([
        'or',
        ['like', 'parent_name', $reqQ],
        ['like', 'parent_phone', $reqQ],
      ]);
    }

    $requests = $requestsQuery->limit(100)->all();

    // ===================== NEWS filters =====================
    $newsQ = trim((string)Yii::$app->request->get('news_q', ''));
    $newsPub = Yii::$app->request->get('news_pub'); // '', '1', '0'

    $newsQuery = News::find()->orderBy(['created_at' => SORT_DESC]);

    if ($newsQ !== '') {
      $newsQuery->andWhere(['like', 'title', $newsQ]);
    }

    if ($newsPub !== null && $newsPub !== '') {
      $newsQuery->andWhere(['is_published' => (int)$newsPub]);
    }

    $news = $newsQuery->limit(100)->all();

    // ------- News form model (create/edit)
    $newsForm = new News();
    if ($editNewsId) {
      $newsForm = News::findOne((int)$editNewsId);
      if (!$newsForm) {
        throw new NotFoundHttpException('Новость не найдена');
      }
    }

    // ===================== MASTER CLASSES filters =====================
    $mcQ = trim((string)Yii::$app->request->get('mc_q', ''));
    $mcPub = Yii::$app->request->get('mc_pub'); // '', '1', '0'

    $masterClassQuery = MasterClass::find()->orderBy(['starts_at' => SORT_DESC]);

    if ($mcQ !== '') {
      $masterClassQuery->andWhere(['like', 'title', $mcQ]);
    }

    if ($mcPub !== null && $mcPub !== '') {
      $masterClassQuery->andWhere(['is_published' => (int)$mcPub]);
    }

    $masterClasses = $masterClassQuery->limit(200)->all();

    // ------- MasterClass form model (create/edit)
    $masterClassForm = new MasterClass();
    if ($editMasterClassId) {
      $masterClassForm = MasterClass::findOne((int)$editMasterClassId);
      if (!$masterClassForm) {
        throw new NotFoundHttpException('Мастер-класс не найден');
      }
    }

    return $this->render('/admin/index', [
      'tab' => $tab,

      // Requests
      'requests' => $requests,
      'reqStatus' => $reqStatus,
      'reqQ' => $reqQ,

      // News
      'news' => $news,
      'newsQ' => $newsQ,
      'newsPub' => $newsPub,
      'newsForm' => $newsForm,

      // Master classes
      'masterClasses' => $masterClasses,
      'mcQ' => $mcQ,
      'mcPub' => $mcPub,
      'masterClassForm' => $masterClassForm,
    ]);
  }

  // ===================== REQUESTS =====================
  public function actionRequestView($id)
  {
    $model = Request::findOne((int)$id);
    if (!$model) {
      throw new NotFoundHttpException('Заявка не найдена');
    }

    return $this->render('/admin/request-view', [
      'model' => $model,
    ]);
  }

  public function actionRequestStatus($id, $status)
  {
    if (!Yii::$app->request->isPost) {
      return $this->redirect(['/admin/index', 'tab' => 'requests', '#' => 'requests']);
    }

    $model = Request::findOne((int)$id);
    if (!$model) {
      throw new NotFoundHttpException('Заявка не найдена');
    }

    $allowed = [Request::STATUS_NEW, Request::STATUS_IN_PROGRESS, Request::STATUS_DONE];
    if (!in_array($status, $allowed, true)) {
      throw new NotFoundHttpException('Неверный статус');
    }

    $model->status = $status;
    $model->save(false);

    Yii::$app->session->setFlash('success', 'Статус заявки обновлён');
    return $this->redirect(['/admin/index', 'tab' => 'requests', '#' => 'requests']);
  }

  public function actionRequestDelete($id)
  {
    if (!Yii::$app->request->isPost) {
      return $this->redirect(['/admin/index', 'tab' => 'requests', '#' => 'requests']);
    }

    $model = Request::findOne((int)$id);
    if (!$model) {
      throw new NotFoundHttpException('Заявка не найдена');
    }

    $model->delete();
    Yii::$app->session->setFlash('success', 'Заявка удалена');

    return $this->redirect(['/admin/index', 'tab' => 'requests', '#' => 'requests']);
  }

  // ===================== NEWS =====================
  public function actionNewsEdit($id)
  {
    return $this->redirect(['/admin/index', 'tab' => 'news', 'editNewsId' => (int)$id, '#' => 'news']);
  }

  public function actionNewsResetForm()
  {
    return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
  }

  public function actionNewsSave($id = null)
  {
    if (!Yii::$app->request->isPost) {
      return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
    }

    $model = $id ? News::findOne((int)$id) : new News();
    if ($id && !$model) {
      throw new NotFoundHttpException('Новость не найдена');
    }

    $model->title = trim((string)Yii::$app->request->post('title', ''));
    $model->content = trim((string)Yii::$app->request->post('content', ''));

    $isPublished = Yii::$app->request->post('is_published') ? 1 : 0;
    $model->is_published = $isPublished;

    if ($isPublished) {
      if (!$model->published_at) {
        $model->published_at = time();
      }
    } else {
      $model->published_at = null;
    }

    // upload image
    $file = UploadedFile::getInstanceByName('image');
    if ($file) {
      $ext = strtolower($file->extension);
      $allowed = ['png', 'jpg', 'jpeg', 'webp'];

      if (!in_array($ext, $allowed, true)) {
        Yii::$app->session->setFlash('error', 'Неверный формат картинки. Разрешено: PNG/JPG/WEBP');
        return $this->redirect(['/admin/index', 'tab' => 'news', 'editNewsId' => (int)$model->id, '#' => 'news']);
      }

      $dir = Yii::getAlias('@webroot') . '/uploads/news';
      if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
      }

      // remove old image
      if (!empty($model->image)) {
        $oldPath = Yii::getAlias('@webroot') . $model->image;
        if (is_file($oldPath)) {
          @unlink($oldPath);
        }
      }

      $name = Yii::$app->security->generateRandomString(18) . '.' . $ext;
      $path = $dir . '/' . $name;

      if (!$file->saveAs($path)) {
        Yii::$app->session->setFlash('error', 'Не удалось сохранить картинку');
        return $this->redirect(['/admin/index', 'tab' => 'news', 'editNewsId' => (int)$model->id, '#' => 'news']);
      }

      $model->image = '/uploads/news/' . $name;
    }

    if (!$model->save()) {
      Yii::$app->session->setFlash('error', 'Ошибка сохранения новости');
      return $this->redirect(['/admin/index', 'tab' => 'news', 'editNewsId' => (int)$model->id, '#' => 'news']);
    }

    Yii::$app->session->setFlash('success', 'Новость сохранена');
    return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
  }

  public function actionNewsDelete($id)
  {
    if (!Yii::$app->request->isPost) {
      return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
    }

    $model = News::findOne((int)$id);
    if (!$model) {
      throw new NotFoundHttpException('Новость не найдена');
    }

    if (!empty($model->image)) {
      $imgPath = Yii::getAlias('@webroot') . $model->image;
      if (is_file($imgPath)) {
        @unlink($imgPath);
      }
    }

    $model->delete();
    Yii::$app->session->setFlash('success', 'Новость удалена');

    return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
  }

  public function actionNewsPublish($id)
  {
    if (!Yii::$app->request->isPost) {
      return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
    }

    $model = News::findOne((int)$id);
    if (!$model) {
      throw new NotFoundHttpException('Новость не найдена');
    }

    $model->is_published = 1;
    if (!$model->published_at) {
      $model->published_at = time();
    }
    $model->save(false);

    Yii::$app->session->setFlash('success', 'Новость опубликована');
    return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
  }

  public function actionNewsUnpublish($id)
  {
    if (!Yii::$app->request->isPost) {
      return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
    }

    $model = News::findOne((int)$id);
    if (!$model) {
      throw new NotFoundHttpException('Новость не найдена');
    }

    $model->is_published = 0;
    $model->published_at = null;
    $model->save(false);

    Yii::$app->session->setFlash('success', 'Новость снята с публикации');
    return $this->redirect(['/admin/index', 'tab' => 'news', '#' => 'news']);
  }
}
