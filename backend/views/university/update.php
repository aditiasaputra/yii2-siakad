<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\University */

$this->title = 'Edit Profil - ' . $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Universitas', 'url' => ['university/index']];
$this->params['breadcrumbs'][] = ['label' => $model->unit_name, 'url' => ['university/index']];
$this->params['breadcrumbs'][] = 'Edit Profil';

// Register Bootstrap 4 CSS and JS
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
?>

<div class="university-edit-profile">

    <!-- Header Section -->
    <div class="edit-header bg-gradient-primary text-white py-4 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="h2 mb-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profil Universitas
                    </h1>
                    <p class="mb-0 opacity-75">
                        Perbarui informasi profil <?= Html::encode($model->unit_name) ?>
                    </p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <div class="header-actions">
                        <?= Html::a('<i class="fas fa-arrow-left mr-1"></i> Kembali', ['university/index'], [
                            'class' => 'btn btn-outline-light btn-sm'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'class' => 'edit-profile-form', 'autocomplete' => 'off'],
            'enableClientValidation' => true,
            'validateOnChange' => true,
            'validateOnSubmit' => true,
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label font-weight-semibold'],
                'inputOptions' => ['class' => 'form-control form-control-lg'],
                'errorOptions' => ['class' => 'invalid-feedback d-block'],
            ],
        ]); ?>

        <div class="row">
            <!-- Left Column - Main Information -->
            <div class="col-lg-8">
                
                <!-- Basic Information Card -->
                <div class="card profile-edit-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-university mr-2"></i>
                            Informasi Dasar
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'unit_code')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'Contoh: UGM, ITB, UI',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'abbreviation')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'Nama singkat universitas',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'unit_name')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Nama lengkap universitas',
                            'class' => 'form-control form-control-lg'
                        ]) ?>

                        <?= $form->field($model, 'unit_name_en')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Nama universitas dalam Bahasa Inggris',
                            'class' => 'form-control form-control-lg'
                        ]) ?>

                        <?= $form->field($model, 'work_unit')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Unit/Satuan kerja',
                            'class' => 'form-control form-control-lg'
                        ]) ?>

                        <?= $form->field($model, 'address')->textarea([
                            'rows' => 4,
                            'placeholder' => 'Alamat lengkap universitas',
                            'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="card profile-edit-card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-address-book mr-2"></i>
                            Informasi Kontak
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'phone')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => '+62-21-xxxxxxx',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'email@university.ac.id',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'website')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'https://www.university.ac.id',
                            'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>
                </div>

                <!-- Leadership Information Card -->
                <div class="card profile-edit-card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users mr-2"></i>
                            Struktur Pimpinan
                        </h5>
                    </div>
                    <div class="card-body">
                        <?= $form->field($model, 'rector')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Nama Rektor/Ketua',
                            'class' => 'form-control form-control-lg'
                        ]) ?>

                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'vice_rector_1')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'Wakil Rektor 1',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'vice_rector_2')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'Wakil Rektor 2',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'vice_rector_3')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'Wakil Rektor 3',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Logo, Status & Actions -->
            <div class="col-lg-4">
                
                <!-- Logo Upload Card -->
                <div class="card profile-edit-card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-image mr-2"></i>
                            Logo Universitas
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="logo-preview-section mb-4">
                            <?php if ($model->logo): ?>
                                <div class="current-logo-preview">
                                    <img src="<?= Url::to('@web/uploads/universities/' . $model->logo) ?>" alt="Current Logo" class="img-fluid current-logo-img">
                                    <p class="text-muted mt-2 mb-0">Logo saat ini</p>
                                </div>
                            <?php else: ?>
                                <div class="no-logo-placeholder">
                                    <i class="fas fa-university fa-4x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada logo</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="logo-upload-section">
                            <?= $form->field($model, 'logo')->fileInput([
                                'accept' => 'image/*',
                                'class' => 'form-control-file',
                                'id' => 'logo-upload'
                            ])->label('Upload Logo Baru', ['class' => 'btn btn-outline-primary btn-block']) ?>
                            
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Format: JPG, PNG, GIF<br>
                                Maksimal: 2MB<br>
                                Rekomendasi: 300x300px
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Accreditation & Status Card -->
                <div class="card profile-edit-card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-award mr-2"></i>
                            Status & Akreditasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <?= $form->field($model, 'accreditation')->dropDownList(
                            ['' => 'Pilih Akreditasi...'] + \backend\models\University::getAccreditationOptions(),
                            ['class' => 'form-control form-control-lg']
                        ) ?>

                        <?= $form->field($model, 'accreditation_sk_number')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Nomor SK Akreditasi',
                            'class' => 'form-control form-control-lg'
                        ]) ?>

                        <?= $form->field($model, 'establishment_permit_number')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Nomor SP Pendirian',
                            'class' => 'form-control form-control-lg'
                        ]) ?>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="card profile-edit-card">
                        <div class="card-body">
                        <div class="action-buttons d-flex justify-content-end">
                            <?= Html::a('<i class="fas fa-arrow-left mr-1"></i> Batal', ['university/index'], [
                                'class' => 'btn btn-secondary mr-2'
                            ]) ?>
                            <?= Html::submitButton(
                                '<i class="fas fa-check mr-1"></i>Ubah',
                                ['class' => 'btn btn-warning']
                            ) ?>
                            </div>

                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Perubahan akan disimpan secara otomatis
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>

<style>
/* Header Styles */
.edit-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
}

.edit-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><polygon points="36,34 6,34 6,6 36,6"/></g></g></svg>') repeat;
}

.edit-header .container {
    position: relative;
    z-index: 1;
}

.opacity-75 {
    opacity: 0.75;
}

/* Card Styles */
.profile-edit-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out;
}

.profile-edit-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.profile-edit-card .card-header {
    border-radius: 15px 15px 0 0;
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

.profile-edit-card .card-body {
    padding: 2rem 1.5rem;
}

/* Form Styles */
.form-label {
    color: #495057;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.form-control-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control-lg:focus {
    border-color: #80bdff;
    box-shadow: 0 0 15px rgba(0, 123, 255, 0.15);
    transform: translateY(-1px);
}

.form-control-lg::placeholder {
    color: #a0a9b8;
    font-style: italic;
}

/* Logo Upload Styles */
.current-logo-img {
    max-width: 150px;
    max-height: 150px;
    border-radius: 15px;
    border: 3px solid #e9ecef;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.no-logo-placeholder {
    padding: 2rem 1rem;
    background: #f8f9fa;
    border-radius: 15px;
    border: 2px dashed #dee2e6;
}

.logo-upload-section .btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.logo-upload-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Custom Switch */
.custom-switch .custom-control-label::before {
    border-radius: 1rem;
    background-color: #e9ecef;
    border: 2px solid #dee2e6;
}

.custom-switch .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #28a745;
    border-color: #28a745;
}

.custom-switch .custom-control-label::after {
    border-radius: 50%;
    background-color: #fff;
}

/* Action Buttons */
.save-btn {
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    transition: all 0.3s ease;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
}

.btn-group .btn {
    border-radius: 8px;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .edit-header {
        text-align: center;
    }
    
    .header-actions {
        margin-top: 1rem;
    }
    
    .profile-edit-card .card-body {
        padding: 1.5rem 1rem;
    }
    
    .current-logo-img {
        max-width: 120px;
        max-height: 120px;
    }
}

/* Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* File Input Styling */
#logo-upload {
    display: none;
}

.logo-upload-section label {
    cursor: pointer;
    margin-bottom: 0;
}

/* Form Group Spacing */
.form-group {
    margin-bottom: 1.5rem;
}

/* Invalid Feedback */
.invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.5rem;
    color: #dc3545;
}

/* Progress Indicator */
.edit-profile-form {
    position: relative;
}

.edit-profile-form::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #28a745, #20c997);
    z-index: 9999;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.edit-profile-form.saving::before {
    transform: scaleX(1);
}
</style>

<script>
// Logo preview
document.getElementById('logo-upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.current-logo-img');
            const placeholder = document.querySelector('.no-logo-placeholder');
            
            if (preview) {
                preview.src = e.target.result;
            } else if (placeholder) {
                placeholder.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="img-fluid current-logo-img">
                    <p class="text-muted mt-2 mb-0">Preview logo baru</p>
                `;
            }
        };
        reader.readAsDataURL(file);
    }
});

// Form submission animation
document.querySelector('.edit-profile-form').addEventListener('submit', function() {
    this.classList.add('saving');
    document.querySelector('.save-btn').innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
});

// Auto-save draft (optional)
let autoSaveTimer;
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            // Implement auto-save logic here
            console.log('Auto-saving draft...');
        }, 3000);
    });
});
</script>
