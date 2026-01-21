<?php

/** @var yii\web\View $this */
/** @var app\models\News $news */

use yii\helpers\Html;

$this->title = $news->title;
?>

<main class="page layout section-decor">
  <article class="news-full">
    <h1 class="news-full__title"><?= Html::encode($news->title) ?></h1>
    <div class="news-full__wrap">
      <img src="<?= Html::encode($news->image) ?>" alt="">
      <div>
        <?php if (!empty($news->published_at)): ?>
          <div class="news-full__date">
            <?= Yii::$app->formatter->asDate($news->published_at, 'php:d.m.Y') ?>
          </div>
        <?php endif; ?>

        <div class="news-full__content">
          <?= $news->content ?>
        </div>
      </div>
    </div>
  </article>
</main>