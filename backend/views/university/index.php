<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\University */
/* @var $facultiesCount int */
/* @var $activeStudents int */
/* @var $totalPrograms int */

$this->title = 'Profil ' . $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unit_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Profil';

// Register Bootstrap 4 CSS and JS
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
?>

<div class="university-profile">
    
    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white position-relative overflow-hidden">
        <div class="hero-background"></div>
        <div class="container position-relative">
            <div class="row align-items-center py-5">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="display-4 font-weight-bold mb-3">
                            <?= Html::encode($model->unit_name) ?>
                        </h1>
                        <p class="lead mb-3">
                            <?= Html::encode($model->unit_name_en ?: $model->unit_name) ?>
                        </p>
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="badge badge-light badge-lg mr-3 mb-2">
                                <i class="fas fa-code mr-1"></i>
                                <?= Html::encode($model->unit_code) ?>
                            </span>
                            <?php if ($model->abbreviation): ?>
                                <span class="badge badge-warning badge-lg mr-3 mb-2">
                                    <i class="fas fa-tag mr-1"></i>
                                    <?= Html::encode($model->abbreviation) ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($model->accreditation): ?>
                                <span class="badge badge-info badge-lg mb-2">
                                    <i class="fas fa-award mr-1"></i>
                                    Akreditasi <?= $model->getAccreditationLabel() ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="hero-logo">
                        <?php if ($model->logo): ?>
                            <img src="<?= Url::to('@web/uploads/universities/' . $model->logo) ?>" 
                                 alt="<?= Html::encode($model->unit_name) ?>" 
                                 class="img-fluid university-logo-hero rounded-lg shadow-lg">
                        <?php else: ?>
                            <div class="university-logo-placeholder-hero">
                                <i class="fas fa-university"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="container mt-n5 position-relative">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card bg-gradient-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon mr-3">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 font-weight-bold"><?= $facultiesCount ?></h3>
                                <p class="mb-0 opacity-75">Fakultas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card bg-gradient-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon mr-3">
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 font-weight-bold"><?= number_format($activeStudents) ?></h3>
                                <p class="mb-0 opacity-75">Mahasiswa Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card bg-gradient-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon mr-3">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 font-weight-bold"><?= $totalPrograms ?></h3>
                                <p class="mb-0 opacity-75">Program Studi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card bg-gradient-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon mr-3">
                                <i class="fas fa-calendar fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 font-weight-bold"><?= date('Y') - date('Y', $model->created_at) ?></h3>
                                <p class="mb-0 opacity-75">Tahun Berdiri</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- About Section -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                            Tentang <?= Html::encode($model->abbreviation ?: $model->unit_name) ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php if ($model->address): ?>
                            <div class="info-section mb-4">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Alamat
                                </h6>
                                <p class="mb-0"><?= nl2br(Html::encode($model->address)) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($model->work_unit): ?>
                            <div class="info-section mb-4">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    Unit/Satuan Kerja
                                </h6>
                                <p class="mb-0"><?= Html::encode($model->work_unit) ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <?php if ($model->establishment_permit_number): ?>
                                <div class="col-md-6">
                                    <div class="info-section">
                                        <h6 class="text-muted mb-2">
                                            <i class="fas fa-file-alt mr-1"></i>
                                            No. SP Pendirian
                                        </h6>
                                        <p class="mb-0"><?= Html::encode($model->establishment_permit_number) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($model->accreditation_sk_number): ?>
                                <div class="col-md-6">
                                    <div class="info-section">
                                        <h6 class="text-muted mb-2">
                                            <i class="fas fa-certificate mr-1"></i>
                                            No. SK Akreditasi
                                        </h6>
                                        <p class="mb-0"><?= Html::encode($model->accreditation_sk_number) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Leadership Section -->
                <?php if ($model->rector || $model->vice_rector_1 || $model->vice_rector_2 || $model->vice_rector_3): ?>
                    <div class="card profile-card mb-4">
                        <div class="card-header bg-white border-0">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-users text-primary mr-2"></i>
                                Struktur Pimpinan
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php if ($model->rector): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="leadership-item">
                                            <div class="leadership-avatar bg-primary text-white">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h6 class="mb-1"><?= Html::encode($model->rector) ?></h6>
                                                <small class="text-muted">Rektor/Ketua</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($model->vice_rector_1): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="leadership-item">
                                            <div class="leadership-avatar bg-success text-white">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h6 class="mb-1"><?= Html::encode($model->vice_rector_1) ?></h6>
                                                <small class="text-muted">Wakil Rektor 1</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($model->vice_rector_2): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="leadership-item">
                                            <div class="leadership-avatar bg-warning text-white">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h6 class="mb-1"><?= Html::encode($model->vice_rector_2) ?></h6>
                                                <small class="text-muted">Wakil Rektor 2</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($model->vice_rector_3): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="leadership-item">
                                            <div class="leadership-avatar bg-info text-white">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h6 class="mb-1"><?= Html::encode($model->vice_rector_3) ?></h6>
                                                <small class="text-muted">Wakil Rektor 3</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Contact Information -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-address-card text-primary mr-2"></i>
                            Kontak
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($model->phone): ?>
                            <div class="contact-item mb-3">
                                <a href="tel:<?= $model->phone ?>" class="text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <div class="contact-icon bg-success text-white mr-3">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Telepon</small>
                                            <span><?= Html::encode($model->phone) ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($model->email): ?>
                            <div class="contact-item mb-3">
                                <a href="mailto:<?= $model->email ?>" class="text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <div class="contact-icon bg-primary text-white mr-3">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Email</small>
                                            <span><?= Html::encode($model->email) ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($model->website): ?>
                            <div class="contact-item">
                                <a href="<?= $model->website ?>" target="_blank" class="text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <div class="contact-icon bg-info text-white mr-3">
                                            <i class="fas fa-globe"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Website</small>
                                            <span>Kunjungi Website</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info text-primary mr-2"></i>
                            Informasi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($model->accreditation): ?>
                            <div class="quick-info-item mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Akreditasi</span>
                                    <span class="badge badge-info mr-3 mb-2"><?= $model->getAccreditationLabel() ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="quick-info-item mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Dibuat</span>
                                <span><?= date('d M Y', $model->created_at) ?></span>
                            </div>
                        </div>
                        <div class="quick-info-item">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Terakhir Update</span>
                                <span><?= date('d M Y', $model->updated_at) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card profile-card">
                    <div class="card-body text-center">
                        <div class="navigation-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= Html::a('<i class="fas fa-edit mr-2"></i>Edit Profil', ['university/update', 'id' => $model->id], [
                                        'class' => 'btn btn-warning btn-block'
                                    ]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= Html::a('<i class="fas fa-tachometer-alt mr-2"></i>Dashboard', ['site/index'], [
                                    'class' => 'btn btn-outline-dark btn-block'
                                ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action Buttons Section - Improved Layout -->
            <div class="col-lg-8">
                <!-- Management Menu Card -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sitemap text-success mr-2"></i>
                            Manajemen Akademik
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <?= Html::a(
                                    '<div class="menu-item-icon bg-primary text-white mb-2">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <h6 class="mb-1">Fakultas</h6>
                                    <small class="text-muted">Kelola data fakultas</small>',
                                    ['faculty/index'],
                                    [
                                        'class' => 'btn btn-outline-primary btn-block text-center p-2 menu-card',
                                        'style' => 'height: 120px; text-decoration: none;'
                                    ]
                                ) ?>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <?= Html::a(
                                    '<div class="menu-item-icon bg-success text-white mb-2">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <h6 class="mb-1">Program Studi</h6>
                                    <small class="text-muted">Kelola program studi</small>',
                                    ['study-program/index'],
                                    [
                                        'class' => 'btn btn-outline-success btn-block text-center p-2 menu-card',
                                        'style' => 'height: 120px; text-decoration: none;'
                                    ]
                                ) ?>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <?= Html::a(
                                    '<div class="menu-item-icon bg-info text-white mb-2">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <h6 class="mb-1">Jenjang Pendidikan</h6>
                                    <small class="text-muted">Kelola jenjang pendidikan</small>',
                                    ['education-level/index'],
                                    [
                                        'class' => 'btn btn-outline-info btn-block text-center p-2 menu-card',
                                        'style' => 'height: 120px; text-decoration: none;'
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    min-height: 400px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><polygon points="36,34 6,34 6,6 36,6"/></g></g></svg>') repeat;
}

.university-logo-hero {
    max-width: 200px;
    max-height: 200px;
    border: 4px solid rgba(255, 255, 255, 0.2);
}

.university-logo-placeholder-hero {
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.8);
    font-size: 4rem;
    margin: 0 auto;
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
}

/* Stats Cards */
.stats-card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #117a8b);
}

.opacity-75 {
    opacity: 0.75;
}

/* Profile Cards */
.profile-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.3s ease;
}

.profile-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.info-section {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.info-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

/* Leadership */
.leadership-item {
    display: flex;
    align-items: center;
}

.leadership-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

/* Contact Items */
.contact-item {
    transition: background-color 0.3s ease;
    padding: 0.5rem;
    border-radius: 8px;
}

.contact-item:hover {
    background-color: #f8f9fa;
}

.contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

/* Quick Info */
.quick-info-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.quick-info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

/* Menu Card Styles */
.menu-card {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    transition: all 0.3s ease;
    background: #fff;
}

.menu-card:hover {
    border-color: #007bff;
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
    transform: translateY(-3px);
    text-decoration: none !important;
}

.menu-card.btn-outline-primary:hover {
    background-color: rgba(0, 123, 255, 0.1);
    color: #007bff;
}

.menu-card.btn-outline-success:hover {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
    border-color: #28a745;
}

.menu-card.btn-outline-info:hover {
    background-color: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
    border-color: #17a2b8;
}

.menu-item-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}


@media (max-width: 768px) {
    .menu-card {
        height: auto !important;
        padding: 1.5rem !important;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section {
        min-height: 300px;
    }
    
    .display-4 {
        font-size: 2rem;
    }
    
    .university-logo-hero,
    .university-logo-placeholder-hero {
        max-width: 150px;
        max-height: 150px;
        width: 150px;
        height: 150px;
    }
    
    .university-logo-placeholder-hero {
        font-size: 3rem;
    }
    
    .btn-group-wrapper .btn {
        display: block;
        width: 100%;
        margin: 0.25rem 0;
    }
}

/* Animations */
.stats-card {
    animation: fadeInUp 0.6s ease-out;
}

.profile-card {
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.rounded-lg {
    border-radius: 15px !important;
}
</style>