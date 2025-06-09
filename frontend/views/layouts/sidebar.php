<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= Yii::$app->homeUrl ?>">
        <div class="sidebar-brand-icon">
            <img class="img-fluid" src="<?= Yii::getAlias('@web') ?>/img/logo-short.png" alt="logo" width="35">
        </div>
        <div class="sidebar-brand-text mx-3">
            <img class="img-fluid" src="<?= Yii::getAlias('@web') ?>/img/logo-full.png" alt="logo" width="100">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Navigation
    </div>

    <li class="nav-item active">
        <a class="nav-link" href="<?= Url::to(['/site/index']) ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/krs/index']) ?>">
            <i class="fas fa-fw fa-check-square"></i>
            <span>Kartu Rencana Studi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/biaya/index']) ?>">
            <i class="fas fa-fw fa-money-check"></i>
            <span>Biaya Kuliah</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/tugas/index']) ?>">
            <i class="fas fa-fw fa-tag"></i>
            <span>Bahan & Tugas</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/jadwal/index']) ?>">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal & Presensi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/nilai/index']) ?>">
            <i class="fas fa-fw fa-star"></i>
            <span>Nilai</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/biodata/index']) ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Biodata</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/panduan/index']) ?>">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>Panduan</span>
        </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
        <?= Html::a('<i class="fas fa-fw fa-sign-out-alt"></i><span> Logout</span>', ['site/logout'], [
            'class' => 'nav-link',
            'data-method' => 'post',
        ]) ?>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <!--<li class="nav-item">-->
    <!--    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"-->
    <!--       aria-expanded="true" aria-controls="collapseTwo">-->
    <!--        <i class="fas fa-fw fa-cog"></i>-->
    <!--        <span>Components</span>-->
    <!--    </a>-->
    <!--    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">-->
    <!--        <div class="bg-white py-2 collapse-inner rounded">-->
    <!--            <h6 class="collapse-header">Custom Components:</h6>-->
    <!--            <a class="collapse-item" href="buttons.html">Buttons</a>-->
    <!--            <a class="collapse-item" href="cards.html">Cards</a>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</li>-->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->