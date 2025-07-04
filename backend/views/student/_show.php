<?php
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Detail';

$this->params['breadcrumbs'][] = ['label' => 'Master Mahasiswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-info card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#student" data-toggle="tab">Kemahasiswaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Ganti Password</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="profil">
                        <dl class="row">
                            <dt class="col-sm-4 col-lg-3">Nama Lengkap</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Gelar Depan</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->honorific ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Gelar Belakang</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->degree ?? '-') ?></dd>

                            <?php if ($model->user->student): ?>
                                <dt class="col-sm-4 col-lg-3">Jurusan</dt>
                                <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->student->major->name ?? '-') ?></dd>
                            <?php endif; ?>

                            <dt class="col-sm-4 col-lg-3">Username</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->username ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Email</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->email ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">KTP</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->personal_id ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Kartu Keluarga</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->family_id ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Jenis Kelamin</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->getGenderLabel() ?? '-') ?></dd>
                            
                            <dt class="col-sm-4 col-lg-3">Golongan Darah</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->blood_type ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Role/Level</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode(ucfirst($model->user->role->name ?? '-')) ?></dd>

                            <dt class="col-sm-4 col-lg-3">Tanggal Registrasi</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode(Yii::$app->formatter->asDate($model->user->created_at, 'long') ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Terakhir Diperbarui</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode(Yii::$app->formatter->asDate($model->user->updated_at, 'long') ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Tanggal Lahir</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode(Yii::$app->formatter->asDate($model->user->birth_date, 'long') ?? '-') ?></dd>
                            
                            <dt class="col-sm-4 col-lg-3">Telepon</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->phone ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Agama</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->religion->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Alamat Lengkap</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->address ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Provinsi</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->province->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Kota/Kabupaten</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->regency->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Kecamatan</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->district->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Kelurahan/Desa</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->village->name ?? '-') ?></dd>

                            <dt class="col-sm-4 col-lg-3">Kode Pos</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= Html::encode($model->user->post_code ?? '-') ?></dd>
                        </dl>
                    </div>
                    <div class="tab-pane" id="student">
                        <dl class="row">
                            <dt class="col-sm-4 col-lg-3">NIM/NPM</dt>
                            <dd class="col-sm-8 col-lg-9">: <?= $model->student_nationality_number ?? '-' ?></dd>

                            <dt class="col-sm-4 col-lg-3">Status</dt>
                            <dd class="col-sm-8 col-lg-9">: 
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