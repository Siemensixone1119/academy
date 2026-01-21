<?php

/** @var yii\web\View $this */
/** @var string $view */

use yii\web\NotFoundHttpException;

$this->title = 'Категория';
$view = ltrim($view, '/');

$allowed = [
  'categories/categorie_1',
  'categories/categorie_2',
  'categories/categorie_3',
  'categories/categorie_4',
  'categories/categorie_5',
  'categories/categorie_6',
];

if (!in_array($view, $allowed, true)) {
  throw new NotFoundHttpException('Категория не найдена');
}
?>

<main class="page">
  <?= $this->render('blocks/' . $view) ?>
</main>