<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Yii::$app->urlManagerFrontend->baseUrl ?>" class="nav-link" target="_blank">View Site</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <?= Html::encode(Yii::$app->user->identity->name ?? 'Guest') ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="<?= Url::to(['/site/profile']) ?>" class="dropdown-item">
                    <i class="mr-2 fas fa-file"></i>
                    My Profile
                </a>
                <div class="dropdown-divider"></div>
                <?= Html::beginForm(['/site/logout'], 'post') ?>
                <button type="submit" class="dropdown-item btn btn-link" style="color: inherit; text-align: left; padding: 0.5rem 1.5rem;">
                    <i class="mr-2 fas fa-sign-out-alt"></i>
                    Log Out
                </button>
                <?= Html::endForm() ?>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->