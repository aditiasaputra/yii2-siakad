<?php

$controllerId = Yii::$app->controller->id;
$isRegionMenu = $controllerId === 'region';
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
                    ['label' => 'REFERENSI', 'header' => true],
                    [
                        'label' => 'Home',
                        'icon' => 'fas fa-tachometer-alt',
                        'url' => ['site/index'],
                    ],
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
                            ['label' => 'Unsur Nilai', 'icon' => 'fas fa-list-ol', 'url' => ['grade-element/index'], 'active' => Yii::$app->controller->id === 'grade-element'],
                            ['label' => 'Pekerjaan', 'icon' => 'fas fa-briefcase', 'url' => ['job/index'], 'active' => Yii::$app->controller->id === 'job'],
                            ['label' => 'Penghasilan', 'icon' => 'fas fa-money-bill-wave', 'url' => ['income/index'], 'active' => Yii::$app->controller->id === 'income'],
                            ['label' => 'Transportasi', 'icon' => 'fas fa-bus', 'url' => ['transportation/index'], 'active' => Yii::$app->controller->id === 'transportation'],
                            ['label' => 'Status Mahasiswa', 'icon' => 'fas fa-user-check', 'url' => ['student-status/index'], 'active' => Yii::$app->controller->id === 'student-status'],
                                    [
                                        'label' => 'Perguruan Tinggi',
                                        'icon' => 'fas fa-university',
                                        'url' => '#',
                                        'active' => in_array(Yii::$app->controller->id, ['university', 'faculty', 'study-program', 'concentration', 'education-level', 'university-education-level', 'lecture-system', 'lecture-room', 'academic-activity', 'academic-calendar', 'external-university', 'company', 'company-contact', 'employee-type', 'rank', 'functional-position', 'structural-position', 'country', 'region']),
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
                                                'label' => 'Konsentrasi',
                                                'icon' => 'fas fa-sitemap',
                                                'url' => ['concentration/index'],
                                                'active' => Yii::$app->controller->id === 'concentration',
                                            ],
                                            [
                                                'label' => 'Jenjang Pendidikan',
                                                'icon' => 'fas fa-level-up-alt',
                                                'url' => ['education-level/index'],
                                                'active' => Yii::$app->controller->id === 'education-level',
                                            ],
                                            [
                                                'label' => 'Tingkat Pendidikan Universitas',
                                                'icon' => 'fas fa-university',
                                                'url' => ['university-education-level/index'],
                                                'active' => Yii::$app->controller->id === 'university-education-level',
                                            ],
                                            [
                                                'label' => 'Sistem Kuliah',
                                                'icon' => 'fas fa-chalkboard-teacher',
                                                'url' => ['lecture-system/index'],
                                                'active' => Yii::$app->controller->id === 'lecture-system',
                                            ],
                                            [
                                                'label' => 'Ruang Kuliah',
                                                'icon' => 'fas fa-door-open',
                                                'url' => ['lecture-room/index'],
                                                'active' => Yii::$app->controller->id === 'lecture-room',
                                            ],
                                            [
                                                'label' => 'Kegiatan Akademik',
                                                'icon' => 'fas fa-calendar-alt',
                                                'url' => ['academic-activity/index'],
                                                'active' => Yii::$app->controller->id === 'academic-activity',
                                            ],
                                            [
                                                'label' => 'Kalender Akademik',
                                                'icon' => 'fas fa-calendar',
                                                'url' => ['academic-calendar/index'],
                                                'active' => Yii::$app->controller->id === 'academic-calendar',
                                            ],
                                            ['label' => 'Universitas Luar', 'icon' => 'fas fa-university', 'url' => ['external-university/index'], 'active' => Yii::$app->controller->id === 'external-university'],
                                            ['label' => 'Perusahaan', 'icon' => 'fas fa-building', 'url' => ['company/index'], 'active' => Yii::$app->controller->id === 'company'],
                                            ['label' => 'Contact Person', 'icon' => 'fas fa-address-book', 'url' => ['company-contact/index'], 'active' => Yii::$app->controller->id === 'company-contact'],
                                            ['label' => 'Jenis Pegawai', 'icon' => 'fas fa-user-tag', 'url' => ['employee-type/index'], 'active' => Yii::$app->controller->id === 'employee-type'],
                                            ['label' => 'Golongan', 'icon' => 'fas fa-medal', 'url' => ['rank/index'], 'active' => Yii::$app->controller->id === 'rank'],
                                            ['label' => 'Jabatan Fungsional', 'icon' => 'fas fa-user-tie', 'url' => ['functional-position/index'], 'active' => Yii::$app->controller->id === 'functional-position'],
                                            ['label' => 'Jabatan Struktural', 'icon' => 'fas fa-sitemap', 'url' => ['structural-position/index'], 'active' => Yii::$app->controller->id === 'structural-position'],
                                            ['label' => 'Negara', 'icon' => 'fas fa-globe-asia', 'url' => ['country/index'], 'active' => Yii::$app->controller->id === 'country'],
                                            [
                                                'label' => 'Wilayah Indonesia',
                                                'icon' => 'fas fa-map-marked-alt',
                                                'url' => ['region/index'],
                                                'active' => $isRegionMenu,
                                            ],
                                        ],
                                    ],

                    ['label' => 'KEPEGAWAIAN', 'header' => true],
                    ['label' => 'Jabatan', 'icon' => 'fas fa-user-cog', 'url' => ['position/index'], 'active' => Yii::$app->controller->id === 'position'],
                    ['label' => 'Status Kepegawaian', 'icon' => 'fas fa-user-check', 'url' => ['employment-status/index'], 'active' => Yii::$app->controller->id === 'employment-status'],
                    ['label' => 'Unit Kerja', 'icon' => 'fas fa-sitemap', 'url' => ['work-unit/index'], 'active' => Yii::$app->controller->id === 'work-unit'],
                    ['label' => 'Bidang Keahlian', 'icon' => 'fas fa-tools', 'url' => ['expertise-field/index'], 'active' => Yii::$app->controller->id === 'expertise-field'],
                    ['label' => 'PERKULIAHAN', 'header' => true],
                    ['label' => 'Mata Kuliah', 'icon' => 'fas fa-book', 'url' => ['subject/index'], 'active' => Yii::$app->controller->id === 'subject'],
                    ['label' => 'Semester', 'icon' => 'fas fa-calendar-alt', 'url' => ['semester/index'], 'active' => Yii::$app->controller->id === 'semester'],
                    ['label' => 'Tahun Akademik', 'icon' => 'fas fa-calendar-check', 'url' => ['academic-year/index'], 'active' => Yii::$app->controller->id === 'academic-year'],
                    ['label' => 'Kelas', 'icon' => 'fas fa-chalkboard', 'url' => ['class/index'], 'active' => Yii::$app->controller->id === 'class'],
                    ['label' => 'Jadwal Kuliah', 'icon' => 'fas fa-clock', 'url' => ['schedule/index'], 'active' => Yii::$app->controller->id === 'schedule'],
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
