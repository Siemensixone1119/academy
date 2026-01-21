<?php

/** @var yii\web\View $this */
/** @var string $tab */
/** @var app\models\Request[] $requests */
/** @var string|null $reqStatus */
/** @var string $reqQ */
/** @var app\models\News[] $news */
/** @var string $newsQ */
/** @var string|null $newsPub */
/** @var app\models\News $newsForm */
/** @var app\models\MasterClass[] $masterClasses */
/** @var string $mcQ */
/** @var string|null $mcPub */
/** @var app\models\MasterClass $masterClassForm */

use yii\helpers\Html;
use app\models\Request as RequestModel;

$this->title = 'Админ-панель';
?>

<div class="admin">
  <aside class="admin__sidebar">
    <div class="admin__brand">
      <div class="admin__logo">Академия успеха</div>
      <div class="admin__badge">Admin</div>
    </div>

    <nav class="admin__nav" aria-label="Навигация админ-панели">
      <a class="admin__nav-link <?= $tab === 'requests' ? 'admin__nav-link--active' : '' ?>" href="/admin/index?tab=requests#requests">Заявки</a>
      <a class="admin__nav-link <?= $tab === 'news' ? 'admin__nav-link--active' : '' ?>" href="/admin/index?tab=news#news">Новости</a>
      <a class="admin__nav-link <?= $tab === 'masterclasses' ? 'admin__nav-link--active' : '' ?>" href="/admin/index?tab=masterclasses#masterclasses">Мастер-классы</a>
    </nav>
  </aside>

  <div class="admin__content">
    <header class="admin__topbar">
      <h1 class="admin__title">Админ-панель</h1>
      <div class="admin__user"><span class="admin__user-name">Рабочий режим</span></div>
      <?= Html::a('Выйти', ['/admin/logout'], [
        'class' => 'admin__logout-btn btn btn-danger', // Класс для стилизации
        'data-method' => 'post' // Переход с методом POST
      ]) ?>
    </header>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
      <div class="admin-flash admin-flash--success">
        <?= Html::encode(Yii::$app->session->getFlash('success')) ?>
      </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
      <div class="admin-flash admin-flash--error">
        <?= Html::encode(Yii::$app->session->getFlash('error')) ?>
      </div>
    <?php endif; ?>

    <!-- ===================== ЗАЯВКИ ===================== -->
    <section class="admin-section" id="requests">
      <div class="admin-section__head">
        <h2 class="admin-section__title">Заявки</h2>

        <form class="admin-section__actions" method="get" action="/admin/index">
          <input type="hidden" name="tab" value="requests">

          <label class="admin-filter">
            <span class="admin-filter__label">Статус</span>
            <select class="admin-filter__control" name="req_status">
              <option value="" <?= ($reqStatus === null || $reqStatus === '') ? 'selected' : '' ?>>Все</option>
              <option value="<?= RequestModel::STATUS_NEW ?>" <?= $reqStatus === RequestModel::STATUS_NEW ? 'selected' : '' ?>>Новые</option>
              <option value="<?= RequestModel::STATUS_IN_PROGRESS ?>" <?= $reqStatus === RequestModel::STATUS_IN_PROGRESS ? 'selected' : '' ?>>В работе</option>
              <option value="<?= RequestModel::STATUS_DONE ?>" <?= $reqStatus === RequestModel::STATUS_DONE ? 'selected' : '' ?>>Закрытые</option>
            </select>
          </label>

          <label class="admin-filter">
            <span class="admin-filter__label">Поиск</span>
            <input class="admin-filter__control" type="search" name="req_q" value="<?= Html::encode($reqQ) ?>" placeholder="Имя / телефон">
          </label>

          <button class="admin-btn" type="submit">Применить</button>
        </form>
      </div>

      <div class="admin-card">
        <div class="admin-card__body">
          <div class="admin-table-wrap">
            <table class="admin-table">
              <thead class="admin-table__head">
                <tr class="admin-table__row">
                  <th class="admin-table__th">Дата</th>
                  <th class="admin-table__th">Имя родителя</th>
                  <th class="admin-table__th">Возраст</th>
                  <th class="admin-table__th">Телефон</th>
                  <th class="admin-table__th">Статус</th>
                  <th class="admin-table__th admin-table__th--right">Действия</th>
                </tr>
              </thead>

              <tbody class="admin-table__body">
                <?php foreach ($requests as $r): ?>
                  <?php
                  $statusClass = '';
                  switch ($r->status) {
                    case RequestModel::STATUS_NEW:
                      $statusClass = 'admin-status--new';
                      break;
                    case RequestModel::STATUS_IN_PROGRESS:
                      $statusClass = 'admin-status--in-progress';
                      break;
                    case RequestModel::STATUS_DONE:
                      $statusClass = 'admin-status--done';
                      break;
                    default:
                      $statusClass = '';
                      break;
                  }
                  ?>
                  <tr class="admin-table__row">
                    <td class="admin-table__td"><?= Html::encode(date('d.m.Y H:i', (int)$r->created_at)) ?></td>
                    <td class="admin-table__td"><?= Html::encode($r->parent_name) ?></td>
                    <td class="admin-table__td"><?= Html::encode($r->child_age) ?></td>
                    <td class="admin-table__td"><?= Html::encode($r->parent_phone) ?></td>
                    <td class="admin-table__td">
                      <span class="admin-status <?= Html::encode($statusClass) ?>">
                        <?= Html::encode($r->getStatusLabel()) ?>
                      </span>
                    </td>

                    <!-- ✅ ВАЖНО: кнопки зависят от статуса -->
                    <td class="admin-table__td admin-table__td--right">
                      <?= Html::a('Открыть', ['/admin/request-view', 'id' => $r->id], [
                        'class' => 'admin-btn admin-btn--ghost',
                      ]) ?>

                      <?php if ($r->status === RequestModel::STATUS_NEW): ?>

                        <?= Html::a('В работу', ['/admin/request-status', 'id' => $r->id, 'status' => RequestModel::STATUS_IN_PROGRESS], [
                          'class' => 'admin-btn admin-btn--ghost',
                          'data-method' => 'post',
                        ]) ?>

                      <?php elseif ($r->status === RequestModel::STATUS_IN_PROGRESS): ?>

                        <?= Html::a('Закрыть', ['/admin/request-status', 'id' => $r->id, 'status' => RequestModel::STATUS_DONE], [
                          'class' => 'admin-btn admin-btn--success',
                          'data-method' => 'post',
                        ]) ?>

                        <?= Html::a('Вернуть в новые', ['/admin/request-status', 'id' => $r->id, 'status' => RequestModel::STATUS_NEW], [
                          'class' => 'admin-btn admin-btn--ghost',
                          'data-method' => 'post',
                        ]) ?>

                      <?php elseif ($r->status === RequestModel::STATUS_DONE): ?>

                        <?= Html::a('Вернуть в работу', ['/admin/request-status', 'id' => $r->id, 'status' => RequestModel::STATUS_IN_PROGRESS], [
                          'class' => 'admin-btn admin-btn--ghost',
                          'data-method' => 'post',
                        ]) ?>

                      <?php endif; ?>

                      <?= Html::a('Удалить', ['/admin/request-delete', 'id' => $r->id], [
                        'class' => 'admin-btn admin-btn--danger',
                        'data-method' => 'post',
                        'data-confirm' => 'Удалить заявку?',
                      ]) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>

                <?php if (empty($requests)): ?>
                  <tr class="admin-table__row">
                    <td class="admin-table__td" colspan="6">Заявок пока нет.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== НОВОСТИ ===================== -->
    <section class="admin-section" id="news">
      <div class="admin-section__head">
        <h2 class="admin-section__title">Новости</h2>

        <form class="admin-section__actions" method="get" action="/admin/index">
          <input type="hidden" name="tab" value="news">

          <label class="admin-filter">
            <span class="admin-filter__label">Публикация</span>
            <select class="admin-filter__control" name="news_pub">
              <option value="" <?= ($newsPub === null || $newsPub === '') ? 'selected' : '' ?>>Все</option>
              <option value="1" <?= $newsPub === '1' ? 'selected' : '' ?>>Опубликованные</option>
              <option value="0" <?= $newsPub === '0' ? 'selected' : '' ?>>Черновики</option>
            </select>
          </label>

          <label class="admin-filter">
            <span class="admin-filter__label">Поиск</span>
            <input class="admin-filter__control" type="search" name="news_q" value="<?= Html::encode($newsQ) ?>" placeholder="Заголовок">
          </label>

          <button class="admin-btn" type="submit">Применить</button>

          <?= Html::a('Сброс формы', ['/admin/news-reset-form'], ['class' => 'admin-btn admin-btn--ghost']) ?>
        </form>
      </div>

      <div class="admin-grid">
        <!-- Список -->
        <div class="admin-card">
          <div class="admin-card__head">
            <h3 class="admin-card__title">Список</h3>
            <div class="admin-card__hint">Нажми “Редактировать” чтобы загрузить в форму справа</div>
          </div>

          <div class="admin-card__body">
            <ul class="admin-news">
              <?php foreach ($news as $n): ?>
                <li class="admin-news__item">
                  <div class="admin-news__left">
                    <div class="admin-news__thumb" aria-hidden="true">
                      <?php if (!empty($n->image)): ?>
                        <img class="admin-news__thumb-img" src="<?= Html::encode($n->image) ?>" alt="">
                      <?php endif; ?>
                    </div>

                    <div class="admin-news__meta">
                      <span class="admin-news__title"><?= Html::encode($n->title) ?></span>
                      <span class="admin-news__date"><?= Html::encode(date('d.m.Y', (int)$n->created_at)) ?></span>
                    </div>
                  </div>

                  <div class="admin-news__actions">
                    <?php if ((int)$n->is_published === 1): ?>
                      <span class="admin-status admin-status--published">Опубликовано</span>
                      <?= Html::a('Снять', ['/admin/news-unpublish', 'id' => $n->id], [
                        'class' => 'admin-btn admin-btn--ghost',
                        'data-method' => 'post',
                      ]) ?>
                    <?php else: ?>
                      <span class="admin-status admin-status--draft">Черновик</span>
                      <?= Html::a('Опубликовать', ['/admin/news-publish', 'id' => $n->id], [
                        'class' => 'admin-btn admin-btn--success',
                        'data-method' => 'post',
                      ]) ?>
                    <?php endif; ?>

                    <?= Html::a('Редактировать', ['/admin/news-edit', 'id' => $n->id], [
                      'class' => 'admin-btn admin-btn--ghost',
                    ]) ?>

                    <?= Html::a('Удалить', ['/admin/news-delete', 'id' => $n->id], [
                      'class' => 'admin-btn admin-btn--danger',
                      'data-method' => 'post',
                      'data-confirm' => 'Удалить новость?',
                    ]) ?>
                  </div>
                </li>
              <?php endforeach; ?>

              <?php if (empty($news)): ?>
                <li class="admin-news__item">Новостей пока нет.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>

        <!-- Форма -->
        <div class="admin-card">
          <div class="admin-card__head">
            <h3 class="admin-card__title">
              <?= $newsForm->isNewRecord ? 'Создание новости' : 'Редактирование новости #' . (int)$newsForm->id ?>
            </h3>
            <div class="admin-card__hint">Можно добавить картинку</div>
          </div>

          <div class="admin-card__body">
            <form class="admin-form"
              action="<?= $newsForm->isNewRecord ? '/admin/news-save' : '/admin/news-save?id=' . (int)$newsForm->id ?>"
              method="post"
              enctype="multipart/form-data">

              <!-- CSRF -->
              <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">

              <label class="admin-form__field">
                <span class="admin-form__label">Заголовок</span>
                <input class="admin-form__control" type="text" name="title" required
                  value="<?= Html::encode($newsForm->title) ?>">
              </label>

              <label class="admin-form__field">
                <span class="admin-form__label">Текст</span>
                <textarea class="admin-form__control admin-form__control--textarea"
                  name="content"
                  rows="10"
                  required><?= Html::encode($newsForm->content) ?></textarea>
              </label>

              <label class="admin-form__field">
                <span class="admin-form__label">Картинка</span>

                <div class="admin-upload">
                  <input class="admin-upload__input" type="file" name="image" accept="image/*">
                  <div class="admin-upload__hint">PNG/JPG/WEBP (по желанию)</div>

                  <div class="admin-upload__preview" aria-hidden="true">
                    <?php if (!empty($newsForm->image)): ?>
                      <img class="admin-upload__preview-img" src="<?= Html::encode($newsForm->image) ?>" alt="">
                    <?php endif; ?>
                  </div>
                </div>
              </label>

              <label class="admin-form__check">
                <input class="admin-form__checkbox" type="checkbox" name="is_published" value="1"
                  <?= ((int)$newsForm->is_published === 1) ? 'checked' : '' ?>>
                <span class="admin-form__check-text">Опубликовать</span>
              </label>

              <div class="admin-form__actions">
                <button class="admin-btn admin-btn--ghost" type="reset">Сбросить</button>
                <button class="admin-btn" type="submit">Сохранить</button>
              </div>

              <div class="admin-form__note">
                <small>Картинки сохраняются в <b>/web/uploads/news</b>, путь в БД — в поле <b>image</b>.</small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== МАСТЕР-КЛАССЫ ===================== -->
    <section class="admin-section" id="masterclasses">
      <div class="admin-section__head">
        <h2 class="admin-section__title">Мастер-классы</h2>

        <form class="admin-section__actions" method="get" action="/admin/index">
          <input type="hidden" name="tab" value="masterclasses">

          <label class="admin-filter">
            <span class="admin-filter__label">Публикация</span>
            <select class="admin-filter__control" name="mc_pub">
              <option value="" <?= ($mcPub === null || $mcPub === '') ? 'selected' : '' ?>>Все</option>
              <option value="1" <?= $mcPub === '1' ? 'selected' : '' ?>>Опубликованные</option>
              <option value="0" <?= $mcPub === '0' ? 'selected' : '' ?>>Черновики</option>
            </select>
          </label>

          <label class="admin-filter">
            <span class="admin-filter__label">Поиск</span>
            <input class="admin-filter__control" type="search" name="mc_q"
              value="<?= Html::encode($mcQ) ?>" placeholder="Название">
          </label>

          <button class="admin-btn" type="submit">Применить</button>

          <?= Html::a('Сброс формы', ['/admin/master-class-reset-form'], ['class' => 'admin-btn admin-btn--ghost']) ?>
        </form>
      </div>

      <div class="admin-grid">
        <!-- Список -->
        <div class="admin-card">
          <div class="admin-card__head">
            <h3 class="admin-card__title">Список</h3>
            <div class="admin-card__hint">Нажми “Редактировать” чтобы загрузить в форму справа</div>
          </div>

          <div class="admin-card__body">
            <ul class="admin-news">
              <?php foreach ($masterClasses as $m): ?>
                <li class="admin-news__item">
                  <div class="admin-news__left">
                    <div class="admin-news__meta">
                      <span class="admin-news__title"><?= Html::encode($m->title) ?></span>
                      <span class="admin-news__date">
                        <?= Html::encode(Yii::$app->formatter->asDatetime($m->starts_at, 'php:d.m.Y H:i')) ?>
                      </span>
                    </div>
                  </div>

                  <div class="admin-news__actions">
                    <?php if ((int)$m->is_published === 1): ?>
                      <span class="admin-status admin-status--published">Опубликовано</span>
                      <?= Html::a('Снять', ['/admin/master-class-unpublish', 'id' => $m->id], [
                        'class' => 'admin-btn admin-btn--ghost',
                        'data-method' => 'post',
                      ]) ?>
                    <?php else: ?>
                      <span class="admin-status admin-status--draft">Черновик</span>
                      <?= Html::a('Опубликовать', ['/admin/master-class-publish', 'id' => $m->id], [
                        'class' => 'admin-btn admin-btn--success',
                        'data-method' => 'post',
                      ]) ?>
                    <?php endif; ?>

                    <?= Html::a('Редактировать', ['/admin/master-class-edit', 'id' => $m->id], [
                      'class' => 'admin-btn admin-btn--ghost',
                    ]) ?>

                    <?= Html::a('Удалить', ['/admin/master-class-delete', 'id' => $m->id], [
                      'class' => 'admin-btn admin-btn--danger',
                      'data-method' => 'post',
                      'data-confirm' => 'Удалить мастер-класс?',
                    ]) ?>
                  </div>
                </li>
              <?php endforeach; ?>

              <?php if (empty($masterClasses)): ?>
                <li class="admin-news__item">Записей пока нет.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>

        <!-- Форма -->
        <div class="admin-card">
          <div class="admin-card__head">
            <h3 class="admin-card__title">
              <?= $masterClassForm->isNewRecord ? 'Создание мастер-класса' : 'Редактирование мастер-класса #' . (int)$masterClassForm->id ?>
            </h3>
            <div class="admin-card__hint">Дата/время, возраст, цена — по желанию</div>
          </div>

          <div class="admin-card__body">
            <form class="admin-form"
              action="<?= $masterClassForm->isNewRecord ? '/admin/master-class-save' : '/admin/master-class-save?id=' . (int)$masterClassForm->id ?>"
              method="post">

              <!-- CSRF -->
              <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">

              <label class="admin-form__field">
                <span class="admin-form__label">Название</span>
                <input class="admin-form__control" type="text" name="title" required
                  value="<?= Html::encode($masterClassForm->title) ?>">
              </label>

              <label class="admin-form__field">
                <span class="admin-form__label">Описание</span>
                <textarea class="admin-form__control admin-form__control--textarea"
                  name="description"
                  rows="6"><?= Html::encode($masterClassForm->description) ?></textarea>
              </label>

              <?php
              // starts_at в БД у тебя DATETIME, для datetime-local нужно "YYYY-MM-DDTHH:MM"
              $startsValue = '';
              if (!empty($masterClassForm->starts_at)) {
                $ts = is_numeric($masterClassForm->starts_at) ? (int)$masterClassForm->starts_at : strtotime($masterClassForm->starts_at);
                if ($ts) $startsValue = date('Y-m-d\TH:i', $ts);
              }
              ?>

              <div class="admin-form__row" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;">
                <label class="admin-form__field">
                  <span class="admin-form__label">Дата и время</span>
                  <input class="admin-form__control" type="datetime-local" name="starts_at"
                    value="<?= Html::encode($startsValue) ?>">
                </label>

                <label class="admin-form__field">
                  <span class="admin-form__label">Длительность (мин)</span>
                  <input class="admin-form__control" type="number" name="duration_min" min="0"
                    value="<?= Html::encode((string)$masterClassForm->duration_min) ?>">
                </label>

                <label class="admin-form__field">
                  <span class="admin-form__label">Возраст от</span>
                  <input class="admin-form__control" type="number" name="age_from" min="0"
                    value="<?= Html::encode((string)$masterClassForm->age_from) ?>">
                </label>

                <label class="admin-form__field">
                  <span class="admin-form__label">Возраст до</span>
                  <input class="admin-form__control" type="number" name="age_to" min="0"
                    value="<?= Html::encode((string)$masterClassForm->age_to) ?>">
                </label>

                <label class="admin-form__field">
                  <span class="admin-form__label">Цена (₽)</span>
                  <input class="admin-form__control" type="number" name="price" min="0"
                    value="<?= Html::encode((string)$masterClassForm->price) ?>">
                </label>

                <label class="admin-form__field">
                  <span class="admin-form__label">Мест</span>
                  <input class="admin-form__control" type="number" name="seats" min="0"
                    value="<?= Html::encode((string)$masterClassForm->seats) ?>">
                </label>
              </div>

              <label class="admin-form__field">
                <span class="admin-form__label">Место проведения</span>
                <input class="admin-form__control" type="text" name="location"
                  value="<?= Html::encode((string)$masterClassForm->location) ?>">
              </label>

              <label class="admin-form__field">
                <span class="admin-form__label">Сортировка (меньше — выше)</span>
                <input class="admin-form__control" type="number" name="sort"
                  value="<?= Html::encode((string)$masterClassForm->sort) ?>">
              </label>

              <label class="admin-form__check">
                <input class="admin-form__checkbox" type="checkbox" name="is_published" value="1"
                  <?= ((int)$masterClassForm->is_published === 1) ? 'checked' : '' ?>>
                <span class="admin-form__check-text">Опубликовать</span>
              </label>

              <div class="admin-form__actions">
                <button class="admin-btn admin-btn--ghost" type="reset">Сбросить</button>
                <button class="admin-btn" type="submit">Сохранить</button>
              </div>

              <div class="admin-form__note">
                <small>Поля “цена/места/возраст/длительность” можно оставлять пустыми.</small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>


  </div>
</div>