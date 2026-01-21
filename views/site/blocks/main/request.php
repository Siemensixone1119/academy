<?php

use yii\helpers\Html;

/** @var app\models\Request $requestModel */
?>

<section class="request layout section-decor" id="request">
  <h2 class="request__title">Оставить заявку</h2>

  <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="request__flash request__flash--success">
      <?= Html::encode(Yii::$app->session->getFlash('success')) ?>
    </div>
  <?php endif; ?>

  <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="request__flash request__flash--error">
      <?= Html::encode(Yii::$app->session->getFlash('error')) ?>
    </div>
  <?php endif; ?>

  <form class="request__form" method="post" action="">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">

    <div class="request__wrap">
      <div class="request__content">
        <div class="request__fields">
          <input class="request__input" type="text" name="parent_name" placeholder="Ваше имя"
            value="<?= Html::encode($requestModel->parent_name ?? '') ?>" required>

          <input class="request__input" type="number" name="child_age" placeholder="Возраст вашего ребёнка"
            min="1" max="120" value="<?= Html::encode($requestModel->child_age ?? '') ?>" required>

          <input class="request__input" type="tel" name="parent_phone" placeholder="+7(000) 000-00-00"
            value="<?= Html::encode($requestModel->parent_phone ?? '') ?>" required>
        </div>



        <label class="request__agreement">
          <input class="request__checkbox" type="checkbox" required>
          <span class="request__agreement-text">
            Отправляя заявку, я соглашаюсь с обработкой персональных данных в соответствии с
            <a class="request__link" href="#">политикой конфиденциальности</a>.
          </span>
        </label><br>

        <button class="request__submit" type="submit">Отправить</button>
      </div>
      <img src="/images/request.png" alt="">
    </div>
  </form>
</section>