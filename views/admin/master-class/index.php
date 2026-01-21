<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="admin-head">
  <h1>Расписание мастер-классов</h1>
  <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
</div>

<?= GridView::widget([
  'dataProvider' => $dataProvider,
  'columns' => [
    'id',
    'title',
    'starts_at',
    'age_from',
    'age_to',
    [
      'attribute' => 'is_published',
      'value' => fn($m) => $m->is_published ? 'Да' : 'Нет',
    ],
    ['class' => \yii\grid\ActionColumn::class],
  ],
]); ?>