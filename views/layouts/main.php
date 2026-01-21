<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
    $this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => true]);
    $this->registerCssFile('https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap', ['rel' => 'stylesheet']);

    $this->registerJsFile(
        'https://api-maps.yandex.ru/v3/?apikey=5843308f-c988-4097-80d3-1ed2ef92d0ee&lang=ru_RU',
        ['position' => View::POS_HEAD]
    );

    $this->registerJsFile(
        '@web/js/map.js',
        ['position' => View::POS_END]
    );
    ?>
    <?php
    $this->registerLinkTag(['rel' => 'icon', 'href' => Yii::getAlias('@web/favicon.ico'), 'sizes' => 'any']);?>

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="site">
        <header class="header">
            <a href="<?= \yii\helpers\Url::to(['/']) ?>" class="header__logo">
                <svg>
                    <use xlink:href="/images/symbol-defs.svg#icon-logo"></use>
                </svg>
            </a>

            <nav class="header__nav" aria-label="Основное меню">
                <ul class="header__menu">
                    <li class="header__menu-item">
                        <a class="header__menu-link" href="<?= \yii\helpers\Url::to(['/']) ?>#group">Группы</a>
                    </li>
                    <li class="header__menu-item">
                        <a class="header__menu-link" href="<?= \yii\helpers\Url::to(['/']) ?>#interactive">Интерактивы</a>
                    </li>
                    <li class="header__menu-item">
                        <a class="header__menu-link" href="<?= \yii\helpers\Url::to(['/']) ?>#news">Новости</a>
                    </li>
                    <li class="header__menu-item">
                        <a class="header__menu-link" href="<?= \yii\helpers\Url::to(['/']) ?>#contacts">Контакты</a>
                    </li>
                </ul>
            </nav>
            <div class="header__phone-wrap">
                <a class="header__phone" href="tel:89379143470">8 937 914-34-70</a>
                <a class="header__phone" href="tel:89093218354">8 909 321-83-54</a>
            </div>
        </header>

        <?= $content ?>

        <footer class="footer layout">
            <div class="footer__logo">
                <svg>
                    <use xlink:href="/images/symbol-defs.svg#icon-logo"></use>
                </svg>
            </div>

            <div class="footer__columns">
                <div class="footer__col">
                    <span class="footer__title">Программы</span>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <a class="footer__link" href="#programs-preschool">Успешный малыш</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="#programs-school">Успешный первоклассник</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="#programs-holidays">Группа продленного дня</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="#programs-holidays">Английский язык</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="#programs-holidays">Ментальная арифметика</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="#programs-holidays">Академия творчества</a>
                        </li>
                    </ul>
                </div>

                <div class="footer__col">
                    <span class="footer__title">О нас</span>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <a class="footer__link" href="<?= \yii\helpers\Url::to(['/']) ?>#group">Группы</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="<?= \yii\helpers\Url::to(['/']) ?>#interactive">Интерактивы</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="<?= \yii\helpers\Url::to(['/']) ?>#news">Новости</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="<?= \yii\helpers\Url::to(['/']) ?>#contacts">Контакты</a>
                        </li>
                    </ul>
                </div>

                <div class="footer__col">
                    <span class="footer__title">Интерактивы</span>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <a class="footer__link" href="#group">Мастер-классы</a>
                        </li>
                        <li class="footer__item">
                            <a class="footer__link" href="#age">Дни рождения</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>