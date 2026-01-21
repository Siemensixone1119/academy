<section class="layout other" id="interactive">
  <h2>Интерактивы</h2>
  <ul class="other__list">
    <li class="other__item">
      <img class="other__image" src="/images/master-class.jpg" alt="" />
      <div class="other__content">
        <h3 class="other__title">Мастер классы</h3>
        <a class="other__link" href="<?= \yii\helpers\Url::to(['site/master-class']) ?>">
          Расписание →
        </a>
      </div>
    </li>

    <li class="other__item other__item--span-2">
      <img class="other__image" src="/images/birthday.png" alt="" />
      <div class="other__content">
        <h3 class="other__title">Проводим веселые дни рождения!</h3>
        <a class="other__link" href="<?= \yii\helpers\Url::to(['site/birthday']) ?>">
          Подробнее →
        </a>
      </div>
    </li>
  </ul>
</section>