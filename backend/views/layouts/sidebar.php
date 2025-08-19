<?php
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $logo; ?>" alt="LOGO" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                        'active' => in_array(Yii::$app->controller->id, ['university', 'user', 'student', 'lecture', 'employee', 'religion', 'bank']),
                        'items' => [
                            [
                                'label' => 'Pengguna',
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
                            [
                                'label' => 'Agama',
                                'icon' => 'fas fa-place-of-worship',
                                'url' => ['religion/index'],
                                'active' => Yii::$app->controller->id === 'religion',
                            ],
                            [
                                'label' => 'Bank',
                                'icon' => 'fas fa-wallet',
                                'url' => ['bank/index'],
                                'active' => Yii::$app->controller->id === 'bank',
                            ],
                            [
                                'label' => 'Referensi',
                                'icon' => 'fas fa-list-alt',
                                'url' => '#',
                                'active' => in_array(Yii::$app->controller->id, [
                                    'university', 'faculty', 'study-program', 'education-level',
                                    'subject', 'semester', 'academic-year', 'class', 'room', 'schedule',
                                    'marital-status', 'blood-type', 'citizenship', 'gender',
                                    'position', 'rank', 'employment-status', 'work-unit', 'expertise-field',
                                    'region'
                                ]),
                                'items' => [
                                    [
                                        'label' => 'Perguruan Tinggi',
                                        'icon' => 'fas fa-university',
                                        'url' => '#',
                                        'items' => [
                                            [
                                                'label' => 'Universitas',
                                                'icon' => 'fas fa-building',
                                                'url' => ['university/index'],
                                                'active' => Yii::$app->controller->id === 'university',
                                            ],
                                            [
                                                'label' => 'Fakultas',
                                                'icon' => 'fas fa-layer-group',
                                                'url' => ['faculty/index'],
                                                'active' => Yii::$app->controller->id === 'faculty',
                                            ],
                                            [
                                                'label' => 'Program Studi',
                                                'icon' => 'fas fa-graduation-cap',
                                                'url' => ['study-program/index'],
                                                'active' => Yii::$app->controller->id === 'study-program',
                                            ],
                                            [
                                                'label' => 'Jenjang Pendidikan',
                                                'icon' => 'fas fa-level-up-alt',
                                                'url' => ['education-level/index'],
                                                'active' => Yii::$app->controller->id === 'education-level',
                                            ],
                                        ],
                                    ],

                                    [
                                        'label' => 'Perkuliahan',
                                        'icon' => 'fas fa-chalkboard-teacher',
                                        'url' => '#',
                                        'items' => [
                                            [
                                                'label' => 'Mata Kuliah',
                                                'icon' => 'fas fa-book',
                                                'url' => ['subject/index'],
                                                'active' => Yii::$app->controller->id === 'subject',
                                            ],
                                            [
                                                'label' => 'Semester',
                                                'icon' => 'fas fa-calendar-alt',
                                                'url' => ['semester/index'],
                                                'active' => Yii::$app->controller->id === 'semester',
                                            ],
                                            [
                                                'label' => 'Tahun Akademik',
                                                'icon' => 'fas fa-calendar-check',
                                                'url' => ['academic-year/index'],
                                                'active' => Yii::$app->controller->id === 'academic-year',
                                            ],
                                            [
                                                'label' => 'Kelas',
                                                'icon' => 'fas fa-chalkboard',
                                                'url' => ['class/index'],
                                                'active' => Yii::$app->controller->id === 'class',
                                            ],
                                            [
                                                'label' => 'Ruangan',
                                                'icon' => 'fas fa-door-open',
                                                'url' => ['room/index'],
                                                'active' => Yii::$app->controller->id === 'room',
                                            ],
                                            [
                                                'label' => 'Jadwal Kuliah',
                                                'icon' => 'fas fa-clock',
                                                'url' => ['schedule/index'],
                                                'active' => Yii::$app->controller->id === 'schedule',
                                            ],
                                        ],
                                    ],

                                    [
                                        'label' => 'Biodata',
                                        'icon' => 'fas fa-id-card',
                                        'url' => '#',
                                        'items' => [
                                            [
                                                'label' => 'Jenis Kelamin',
                                                'icon' => 'fas fa-venus-mars',
                                                'url' => ['gender/index'],
                                                'active' => Yii::$app->controller->id === 'gender',
                                            ],
                                            [
                                                'label' => 'Status Pernikahan',
                                                'icon' => 'fas fa-ring',
                                                'url' => ['marital-status/index'],
                                                'active' => Yii::$app->controller->id === 'marital-status',
                                            ],
                                            [
                                                'label' => 'Golongan Darah',
                                                'icon' => 'fas fa-tint',
                                                'url' => ['blood-type/index'],
                                                'active' => Yii::$app->controller->id === 'blood-type',
                                            ],
                                            [
                                                'label' => 'Kewarganegaraan',
                                                'icon' => 'fas fa-flag',
                                                'url' => ['citizenship/index'],
                                                'active' => Yii::$app->controller->id === 'citizenship',
                                            ],
                                        ],
                                    ],

                                    [
                                        'label' => 'Kepegawaian',
                                        'icon' => 'fas fa-briefcase',
                                        'url' => '#',
                                        'items' => [
                                            [
                                                'label' => 'Jabatan',
                                                'icon' => 'fas fa-user-cog',
                                                'url' => ['position/index'],
                                                'active' => Yii::$app->controller->id === 'position',
                                            ],
                                            [
                                                'label' => 'Pangkat/Golongan',
                                                'icon' => 'fas fa-medal',
                                                'url' => ['rank/index'],
                                                'active' => Yii::$app->controller->id === 'rank',
                                            ],
                                            [
                                                'label' => 'Status Kepegawaian',
                                                'icon' => 'fas fa-user-check',
                                                'url' => ['employment-status/index'],
                                                'active' => Yii::$app->controller->id === 'employment-status',
                                            ],
                                            [
                                                'label' => 'Unit Kerja',
                                                'icon' => 'fas fa-sitemap',
                                                'url' => ['work-unit/index'],
                                                'active' => Yii::$app->controller->id === 'work-unit',
                                            ],
                                            [
                                                'label' => 'Bidang Keahlian',
                                                'icon' => 'fas fa-tools',
                                                'url' => ['expertise-field/index'],
                                                'active' => Yii::$app->controller->id === 'expertise-field',
                                            ],
                                        ],
                                    ],
                                ],
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