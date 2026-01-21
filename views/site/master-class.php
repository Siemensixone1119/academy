<?php

use yii\helpers\Html;

/** @var app\models\MasterClass[] $items */
$this->title = 'Расписание мастер-классов';
?>

<main class="page layout">
  <h1 class="schedule__title">Расписание мастер-классов</h1>

  <?php if (empty($items)): ?>
    <p>Пока нет ближайших мастер-классов.</p>
  <?php else: ?>
    <ul class="schedule">
      <?php foreach ($items as $m): ?>
        <li class="schedule__item">
          <div class="schedule__meta">
            <span class="schedule__date">
              <?= Yii::$app->formatter->asDatetime($m->starts_at, 'php:d.m.Y H:i') ?>
            </span>
            <?php
            $ageText = '';

            if ($m->age_from && $m->age_to) {
              $ageText = $m->age_from . '–' . $m->age_to . ' лет';
            } elseif ($m->age_from) {
              $ageText = 'от ' . $m->age_from . ' лет'; // или $m->age_from . '+'
            } elseif ($m->age_to) {
              $ageText = 'до ' . $m->age_to . ' лет';
            }
            ?>

            <?php if ($ageText !== ''): ?>
              <span class="schedule__age"><?= \yii\helpers\Html::encode($ageText) ?></span>
            <?php endif; ?>

          </div>

          <h3 class="schedule__title"><?= Html::encode($m->title) ?></h3>

          <?php if (!empty($m->description)): ?>
            <p class="schedule__text"><?= Html::encode($m->description) ?></p>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</main>