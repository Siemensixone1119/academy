<?php

/** @var yii\web\View $this */
$this->title = 'Академия успеха';
?>

<main class="page">
  <?= $this->render('blocks/main/hero') ?>
  <?= $this->render('blocks/main/categories') ?>
  <?= $this->render('blocks/main/master_class') ?>
  <?= $this->render('blocks/main/request', ['requestModel' => $requestModel]) ?>
  <?= $this->render('blocks/main/news', ['news' => $news]) ?>
  <?= $this->render('blocks/main/contact') ?>

</main>