<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вход в админ-панель';
?>

<div class="admin-auth">
  <div class="admin-auth__card">
    <div class="admin-auth__header">
      <div class="admin-auth__logo">Академия успеха</div>
      <h1 class="admin-auth__title">Вход</h1>
      <p class="admin-auth__subtitle">Только для администраторов</p>
    </div>

    <form class="admin-auth__form" action="" method="post">
      <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">

      <label class="admin-auth__field">
        <span class="admin-auth__label">Email</span>
        <input class="admin-auth__input" type="email" name="email" placeholder="admin@example.com" required>
      </label>

      <label class="admin-auth__field">
        <span class="admin-auth__label">Пароль</span>
        <input class="admin-auth__input" type="password" name="password" placeholder="••••••••" required>
      </label>

      <button class="admin-auth__submit" type="submit">Войти</button>
    </form>
  </div>
</div>