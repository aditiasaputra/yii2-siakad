<?php
use yii\helpers\Html;
use common\widgets\Alert;
use yii\widgets\ActiveForm;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$this->title = 'Detail Pengguna';
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
                    <img class="profile-user-img img-fluid img-circle" src="<?= !$model->image || str_contains($model->image, 'img/') ? $assetDir . '/' . $model->image : Yii::getAlias('@web/uploads/' . $model->image) ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $model->name ?></h3>
                <p class="text-muted text-center"><?= ucfirst($model->role->name ?? '-') ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">
                            <?= $model->email ?? '-' ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fas fa-phone mr-1"></i> No. Telepon</strong>
                        <p class="text-muted">
                            <?= $model->phone ?? '-' ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fas fa-home mr-1"></i> Alamat</strong>
                        <p class="text-muted">
                            <?= $model->address ?? '-' ?>
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
                    <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Ganti Password</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="profil">
                        <dl class="row">
                            <dt class="col-sm-3">Nama Lengkap</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= $model->name ?></dd>

                            <?php if ($model->student): ?>
                                <dt class="col-sm-3">Jurusan</dt>
                            <dd class="col-sm-1">:</dd>
                                <dd class="col-sm-8"><?= $model->major->name ?? '-' ?></dd>
                            <?php endif; ?>

                            <dt class="col-sm-3">Username</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= $model->username ?></dd>

                            <dt class="col-sm-3">KTP</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= $model->personal_id ?? '-' ?></dd>

                            <dt class="col-sm-3">Kartu Keluarga</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= $model->family_id ?? '-' ?></dd>

                            <dt class="col-sm-3">Jenis Kelamin</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= Html::encode($model->getGenderLabel() ?? '-') ?></dd>

                            <dt class="col-sm-3">Role/Level</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= ucfirst($model->role->name) ?></dd>

                            <dt class="col-sm-3">Tanggal Registrasi</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= Yii::$app->formatter->asDate($model->created_at, 'long') ?></dd>

                            <dt class="col-sm-3">Terakhir Diperbarui</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8"><?= Yii::$app->formatter->asDate($model->updated_at, 'long') ?></dd>

                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-1">:</dd>
                            <dd class="col-sm-8">
                                <span class="badge badge-pill <?= $model->status == 10 ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $model->status == 10 ? 'Aktif' : 'Tidak Aktif' ?>
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
                                <?= $form->field($changePasswordmodel, 'old_password')->passwordInput([
                                    'class' => 'form-control',
                                    'placeholder' => 'Masukkan password lama',
                                    'required' => true,
                                ])->label('Password Lama') ?>
                            </div>

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
