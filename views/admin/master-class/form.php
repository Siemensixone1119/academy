<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\models\MasterClass */
?>

<h1><?= $model->isNewRecord ? 'Добавить мастер-класс' : 'Редактировать мастер-класс' ?></h1>

<?php $f = ActiveForm::begin(); ?>

<?= $f->field($model, 'title')->textInput() ?>
<?= $f->field($model, 'description')->textarea(['rows' => 5]) ?>

<div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;">
  <?= $f->field($model, 'age_from')->input('number') ?>
  <?= $f->field($model, 'age_to')->input('number') ?>
  <?= $f->field($model, 'starts_at')->input('datetime-local') ?>
  <?= $f->field($model, 'duration_min')->input('number') ?>
  <?= $f->field($model, 'price')->input('number') ?>
  <?= $f->field($model, 'seats')->input('number') ?>
</div>

<?= $f->field($model, 'location')->textInput() ?>

<div style="display:flex;gap:16px;align-items:center;">
  <?= $f->field($model, 'is_published')->checkbox() ?>
  <?= $f->field($model, 'sort')->input('number') ?>
</div>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>