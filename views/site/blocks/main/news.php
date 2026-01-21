<?php

use yii\helpers\Html;

/** @var app\models\News[] $news */
?>

<section class="news layout section-decor" id="news">
  <h2 class="news__title">Новости</h2>

  <ul class="news__list">
    <?php foreach ($news as $n): ?>
      <li class="news__item news-card">
        <img class="news-card__media" src="<?= Html::encode($n->image) ?>" alt="">
        <div class="news-card__content">
          <span class="news-card__title"><?= Html::encode($n->title) ?></span><br>

          <span class="news-card__text">
            <?= Html::encode($n->content) ?>
          </span>

          <a class="news-card__link" href="<?= \yii\helpers\Url::to(['site/news-view', 'id' => $n->id]) ?>">Подробнее →</a>
        </div>
      </li>
    <?php endforeach; ?>

    <?php if (empty($news)): ?>
      <li class="news__item news-card">
        <div class="news-card__content">
          <span class="news-card__title">Новостей пока нет</span><br>
          <span class="news-card__text">Здесь появятся опубликованные новости.</span>
        </div>
      </li>
    <?php endif; ?>
  </ul>
</section>