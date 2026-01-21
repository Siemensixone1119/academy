<?php
/** @var yii\web\View $this */
/** @var app\models\Request $model */

use yii\helpers\Html;

$this->title = 'Заявка #' . (int)$model->id;
?>

<div class="admin-card" style="max-width: 860px; margin: 0 auto;">
  <div class="admin-card__head">
    <h3 class="admin-card__title"><?= Html::encode($this->title) ?></h3>
    <?= Html::a('← Назад', ['/admin/index', 'tab' => 'requests', '#' => 'requests'], ['class' => 'admin-btn admin-btn--ghost']) ?>
  </div>

  <div class="admin-card__body">
    <dl class="admin-dl">
      <div class="admin-dl__row">
        <dt class="admin-dl__term">Дата</dt>
        <dd class="admin-dl__desc"><?= Html::encode(date('d.m.Y H:i', (int)$model->created_at)) ?></dd>
      </div>

      <div class="admin-dl__row">
        <dt class="admin-dl__term">Имя родителя</dt>
        <dd class="admin-dl__desc"><?= Html::encode($model->parent_name) ?></dd>
      </div>

      <div class="admin-dl__row">
        <dt class="admin-dl__term">Возраст ребёнка</dt>
        <dd class="admin-dl__desc"><?= Html::encode($model->child_age) ?></dd>
      </div>

      <div class="admin-dl__row">
        <dt class="admin-dl__term">Телефон</dt>
        <dd class="admin-dl__desc"><?= Html::encode($model->parent_phone) ?></dd>
      </div>

      <div class="admin-dl__row">
        <dt class="admin-dl__term">Статус</dt>
        <dd class="admin-dl__desc"><?= Html::encode($model->getStatusLabel()) ?></dd>
      </div>
    </dl>

    <div style="display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap; margin-top:14px;">
      <?= Html::a('В работу', ['/admin/request-status', 'id' => $model->id, 'status' => 'in_progress'], [
        'class' => 'admin-btn admin-btn--ghost',
        'data-method' => 'post',
      ]) ?>

      <?= Html::a('Закрыть', ['/admin/request-status', 'id' => $model->id, 'status' => 'done'], [
        'class' => 'admin-btn admin-btn--success',
        'data-method' => 'post',
      ]) ?>

      <?= Html::a('Удалить', ['/admin/request-delete', 'id' => $model->id], [
        'class' => 'admin-btn admin-btn--danger',
        'data-method' => 'post',
        'data-confirm' => 'Удалить заявку?',
      ]) ?>
    </div>
  </div>
</div>
