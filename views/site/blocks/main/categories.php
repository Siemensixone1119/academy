<section class="groups layout section-decor" id="group">
  <div class="section-decor__bg" aria-hidden="true"></div>
  <h2 class="groups__title">Выбери свою группу</h2>
  <?php
  $cats = [
    1 => [
      'title' => 'Успешный малыш',
      'age'   => '1,5 – 4 года',
      'view'  => 'categories/categorie_1',
      'src' => '/images/categories1.jpg'
    ],
    2 => [
      'title' => 'Успешный первоклассник',
      'age'   => '4 - 7 лет',
      'view'  => 'categories/categorie_2',
      'src' => '/images/categories2.jpg'
    ],
    3 => [
      'title' => 'Группа продленного дня',
      'age'   => '6 – 11 лет',
      'view'  => 'categories/categorie_3',
      'src' => '/images/categories3.jpg'
    ],
    4 => [
      'title' => 'Английский язык',
      'age'   => 'c 4 лет',
      'view'  => 'categories/categorie_4',
      'src' => '/images/categories4.jpg'
    ],
    5 => [
      'title' => 'Ментальная арифметика',
      'age'   => 'c 5 лет',
      'view'  => 'categories/categorie_5',
      'src' => '/images/categories5.jpg'
    ],
    6 => [
      'title' => 'Академия творчества',
      'age'   => 'c 4 лет',
      'view'  => 'categories/categorie_6',
      'src' => '/images/categories6.jpg'
    ],
  ];
  ?>

  <ul class="groups__list">
    <?php foreach ($cats as $cat): ?>
      <li class="groups__item">
        <img class="groups__image" src=<?= htmlspecialchars($cat['src']) ?>></img>
        <div class="groups__content">
          <h3 class="groups__name"><?= htmlspecialchars($cat['title']) ?></h3>
          <span class="groups__age"><?= htmlspecialchars($cat['age']) ?></span>
          <a class="groups__link"
            href="<?= \yii\helpers\Url::to(['site/categorie', 'view' => $cat['view']]) ?>">
            Подробнее →
          </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>