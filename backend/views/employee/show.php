<?php

use yii\helpers\Html;
use common\widgets\Alert;
use yii\widgets\ActiveForm;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$this->title = 'Detail';

$this->params['breadcrumbs'][] = ['label' => 'Master Pegawai', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->registerJs(<<<JS
$('#change-password-form').on('beforeSubmit', function(e) {
    e.preventDefault();

    const form = $(this);
    const data = form.serialize();
    const btnSubmit = form.find(':submit');

    let btnSubmitText = btnSubmit.text();

    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();

    form.find('.form-control').attr('readonly', true);
    btnSubmit.attr('disabled', true);

    btnSubmit.text('Processing..');

    $.post(form.attr('action'), data)
        .done(function(response) {
            if (response.success) {
                toastr.success(response.message);
                form[0].reset();
                form.find('.form-control').removeAttr('readonly');
                btnSubmit.removeAttr('disabled');
                btnSubmit.text(btnSubmitText);
            }
        })
        .fail(function(jqXHR) {
            const response = jqXHR.responseJSON;

            if (jqXHR.status === 422) {
                const errors = response.errors || {};

                Object.entries(errors).forEach(([attribute, messages]) => {
                    const input = form.find('[name*="[' + attribute + ']"]');
                    input.addClass('is-invalid');

                    const feedback = $('<div class="invalid-feedback"></div>');
                    feedback.text(messages[0]);

                    input.after(feedback);
                });
            }

            toastr.error(response.message);
            form.find('.form-control').removeAttr('readonly');
            btnSubmit.removeAttr('disabled');
            btnSubmit.text(btnSubmitText);
        });

    return false;
});

JS);
?>

<?= Alert::widget() ?>

<div class="d-flex mb-3">
    <div id="action-left">
        <?= Html::a('Kembali', ['index'], [
            'class' => 'btn btn-sm btn-default'
        ]) ?>
        <?= Html::a('Buat Pengguna', ['create'], [
            'class' => 'btn btn-sm btn-success ml-1'
        ]) ?>
    </div>
    <div class="ml-auto" id="action-right">
        <?= Html::a('Edit', ['update', 'id' => $model->id], [
            'class' => 'btn btn-sm btn-warning'
        ]) ?>

        <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-sm btn-danger mx-1',
            'data' => [
                'method' => 'post',
                'confirm' => 'Yakin ingin hapus?',
            ]
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="<?= !$model->user->image || str_contains($model->user->image, 'img/') ? $assetDir . '/' . $model->user->image : Yii::getAlias('@web/uploads/' . $model->user->image) ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $model->user->name ?></h3>
                <p class="text-muted text-center"><?= ucfirst($model->user->role->name ?? '-') ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">
                            <?= $model->user->email ?? '-' ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fas fa-phone mr-1"></i> No. Telepon</strong>
                        <p class="text-muted">
                            <?= $model->user->phone ?? '-' ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fas fa-home mr-1"></i> Alamat</strong>
                        <p class="text-muted">
                            <?= $model->user->address ?? '-' ?>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#employee" data-toggle="tab">Kepegawaian</a></li>
                    <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Ganti Password</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="profil">
                        <dl class="row">
                            <dt class="col-sm-4 col-lg-4">Nama Lengkap</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Gelar Depan</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->honorific ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Gelar Belakang</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->degree ?? '-') ?></dd>

                            <?php if ($model->user->student): ?>
                                <dt class="col-sm-4 col-lg-4">Jurusan</dt>
                                <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->student->major->name ?? '-') ?></dd>
                            <?php endif; ?>

                            <dt class="col-sm-4 col-lg-4">Username</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->username ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Email</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->email ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">KTP</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->personal_id ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Kartu Keluarga</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->family_id ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Jenis Kelamin</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->getGenderLabel() ?? '-') ?></dd>
                            
                            <dt class="col-sm-4 col-lg-4">Golongan Darah</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->blood_type ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Role/Level</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode(ucfirst($model->user->role->name ?? '-')) ?></dd>

                            <dt class="col-sm-4 col-lg-4">Tanggal Registrasi</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode(Yii::$app->formatter->asDate($model->user->created_at, 'long') ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Terakhir Diperbarui</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode(Yii::$app->formatter->asDate($model->user->updated_at, 'long') ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Tanggal Lahir</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode(Yii::$app->formatter->asDate($model->user->birth_date, 'long') ?? '-') ?></dd>
                            
                            <dt class="col-sm-4 col-lg-4">Telepon</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->phone ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Agama</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->religion->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Alamat Lengkap</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->address ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Provinsi</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->province->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Kota/Kabupaten</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->regency->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Kecamatan</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->district->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Kelurahan/Desa</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->village->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-4">Kode Pos</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= Html::encode($model->user->post_code ?? '-') ?></dd>
                        </dl>
                    </div>
                    <div class="tab-pane" id="employee">
                        <dl class="row">
                            <dt class="col-sm-4 col-lg-4">NIP</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->employee_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">NPWP</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->tax_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">Cabang Bank</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->branch_name ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">Nomor Rekening</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->account_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">Nama Pemilik Rekening</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->account_name ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">No BPJS Ketenagakerjaan</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->national_social_security_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">No BPJS Kesehatan</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->national_health_insurance_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">Asuransi Pegawai (Swasta)</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->social_security_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">Asuransi Kesehatan (Swasta)</dt>
                            <dd class="col-sm-8 col-lg-8">: <?= $model->health_insurance_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-4">Status</dt>
                            <dd class="col-sm-8 col-lg-8">: 
                                <span class="badge badge-pill <?= $model->user->status == 10 ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $model->user->status == 10 ? 'Aktif' : 'Tidak Aktif' ?>
                                </span>
                            </dd>
                        </dl>
                    </div>
                    <div class="tab-pane" id="change-password">
                        <?php $form = ActiveForm::begin([
                            'id' => 'change-password-form',
                            'action' => ['change-password/validate'],
                            'enableClientValidation' => false,
                            'enableAjaxValidation' => false,
                            'options' => ['class' => 'needs-validation', 'novalidate' => true],
                        ]); ?>

                        <?= Html::activeHiddenInput($changePasswordmodel, 'id', [
                            'value' => $model->id
                        ]) ?>

                        <div class="form-group">
                            <?= $form->field($changePasswordmodel, 'new_password')->passwordInput([
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan password baru',
                                'required' => true,
                            ])->label('Password Baru') ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($changePasswordmodel, 'repeat_password')->passwordInput([
                                'class' => 'form-control',
                                'placeholder' => 'Ulangi password baru',
                                'required' => true,
                            ])->label('Ulangi Password Baru') ?>
                        </div>
                        <hr>
                        <div class="form-group">
                            <?= Html::submitButton('Ubah Password', ['class' => 'btn btn-sm btn-info btn-block']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>