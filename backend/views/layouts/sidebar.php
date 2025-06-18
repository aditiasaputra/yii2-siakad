<?php
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $assetDir; ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir; ?>/<?= Yii::$app->user->identity->image ?? 'img/avatar.png'; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->name; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview', 'role' => 'menu', 'data-accordion' => 'false'],
                'encodeLabels' => false,
                'items' => [
                    ['label' => 'MAIN NAVIGATION', 'header' => true],
                    [
                        'label' => 'Home',
                        'icon' => 'fas fa-tachometer-alt',
                        'url' => ['site/index'],
                    ],
                    [
                        'label' => 'Master Data',
                        'icon' => 'fas fa-database',
                        'url' => '#',
                        'active' => in_array(Yii::$app->controller->id, ['user', 'student', 'lecture', 'employee']),
                        'items' => [
                            [
                                'label' => 'Users',
                                'icon' => 'fas fa-users',
                                'url' => ['user/index'],
                                'active' => Yii::$app->controller->id === 'user',
                            ],
                            [
                                'label' => 'Pegawai',
                                'icon' => 'fas fa-id-badge',
                                'url' => ['employee/index'],
                                'active' => Yii::$app->controller->id === 'employee',
                            ],
                            [
                                'label' => 'Dosen',
                                'icon' => 'fas fa-user-tie',
                                'url' => ['lecture/index'],
                                'active' => Yii::$app->controller->id === 'lecture',
                            ],
                            [
                                'label' => 'Mahasiswa',
                                'icon' => 'fas fa-user-graduate',
                                'url' => ['student/index'],
                                'active' => Yii::$app->controller->id === 'student',
                            ],
                        ],
                    ],
                    ['label' => 'LAINNYA', 'header' => true],
                    [
                        'label' => 'About us',
                        'icon' => 'far fa-address-card',
                        'url' => ['site/about'],
                    ],
                    [
                        'label' => 'Two-level menu',
                        'icon' => 'fas fa-circle nav-icon',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Informational',
                                'iconStyle' => 'far',
                                'iconClassAdded' => 'text-info'
                            ],
                            [
                                'label' => 'Warning',
                                'iconStyle' => 'far',
                                'iconClassAdded' => 'text-warning'
                            ],
                        ],
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>