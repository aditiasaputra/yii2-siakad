<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Detail';

$this->params['breadcrumbs'][] = ['label' => 'Master Dosen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-info card-outline">
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
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Informasi Detail Pengguna</h5>
                        <hr class="mb-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">Nama Lengkap</th>
                                    <td><?= Html::encode($model->user->name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Gelar Depan</th>
                                    <td><?= Html::encode($model->user->honorific ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Gelar Belakang</th>
                                    <td><?= Html::encode($model->user->degree ?? '-') ?></td>
                                </tr>
                                <?php if ($model->user->student): ?>
                                <tr>
                                    <th>Jurusan</th>
                                    <td><?= Html::encode($model->user->student->major->name ?? '-') ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Username</th>
                                    <td><?= Html::encode($model->user->username ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= Html::encode($model->user->email ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>KTP</th>
                                    <td><?= Html::encode($model->user->personal_id ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Kartu Keluarga</th>
                                    <td><?= Html::encode($model->user->family_id ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>NPWP</th>
                                    <td><?= Html::encode($model->employee->tax_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td><?= Html::encode($model->user->getGenderLabel() ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Golongan Darah</th>
                                    <td><?= Html::encode($model->user->blood_type ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Role/Level</th>
                                    <td><?= Html::encode(ucfirst($model->user->role->name ?? '-')) ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-pill <?= $model->user->status == 10 ? 'badge-success' : 'badge-danger' ?>">
                                            <?= $model->user->status == 10 ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td><?= Html::encode(Yii::$app->formatter->asDate($model->user->birth_date, 'long') ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td><?= Html::encode($model->user->phone ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td><?= Html::encode($model->user->religion->name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat Lengkap</th>
                                    <td><?= Html::encode($model->user->address ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td><?= Html::encode($model->user->province->name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Kota/Kabupaten</th>
                                    <td><?= Html::encode($model->user->regency->name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td><?= Html::encode($model->user->district->name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Kelurahan/Desa</th>
                                    <td><?= Html::encode($model->user->village->name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td><?= Html::encode($model->user->post_code ?? '-') ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="mb-3 mt-4 text-primary">Informasi Bank</h5>
                        <hr class="mb-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">Nama Bank</th>
                                    <td><?= Html::encode($model->employee->bank->name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Kantor Cabang</th>
                                    <td><?= Html::encode($model->employee->branch_name ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Nomor Rekening</th>
                                    <td><?= Html::encode($model->employee->account_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Pemilik Rekening</th>
                                    <td><?= Html::encode($model->employee->account_name ?? '-') ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="mb-3 mt-4 text-primary">Perlindungan Karyawan</h5>
                        <hr class="mb-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">BPJS Ketenagakerjaan</th>
                                    <td><?= Html::encode($model->employee->national_social_security_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>BPJS Kesehatan</th>
                                    <td><?= Html::encode($model->employee->national_health_insurance_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Asuransi Ketenagakerjaan</th>
                                    <td><?= Html::encode($model->employee->social_security_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Asuransi Kesehatan</th>
                                    <td><?= Html::encode($model->employee->health_insurance_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Catatan Karyawan</th>
                                    <td><?= Html::encode($model->employee->note ?? '-') ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="mb-3 mt-4 text-primary">Informasi Audit</h5>
                        <hr class="mb-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">Tanggal Registrasi</th>
                                    <td><?= Html::encode(Yii::$app->formatter->asDatetime($model->user->created_at, 'long') ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Dibuat Oleh</th>
                                    <td><?= Html::encode($model->user->createdBy->username ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diperbarui</th>
                                    <td><?= Html::encode(Yii::$app->formatter->asDatetime($model->user->updated_at, 'long') ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Diperbarui Oleh</th>
                                    <td><?= Html::encode($model->user->updatedBy->username ?? '-') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="employee">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Informasi Identitas Dosen</h5>
                        <hr class="mb-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">NIDN</th>
                                    <td><?= Html::encode($model->lecture_nationality_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>NIDK</th>
                                    <td><?= Html::encode($model->lecture_special_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>NUPN / NIP</th>
                                    <td><?= Html::encode($model->teacher_national_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>NIP (dari Employee)</th>
                                    <td><?= Html::encode($model->employee->employee_number ?? '-') ?></td> <!-- Asumsi NIP diambil dari employee_number di relasi employee -->
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="mb-3 mt-4 text-primary">Kualifikasi Akademik & Sertifikasi</h5>
                        <hr class="mb-4">
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Rumpun Ilmu</th>
                                    <td><?= Html::encode($model->field_of_study ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Sesuai Rumpun</th>
                                    <td>
                                        <?php
                                            if ($model->is_match_field !== null) {
                                                echo Html::encode($model->is_match_field == 1 ? 'Ya' : 'Tidak');
                                            } else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kompetensi</th>
                                    <td><?= Html::encode($model->competence ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Sertifikat</th>
                                    <td><?= Html::encode(Yii::$app->formatter->asDate($model->certificate_date, 'long') ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Nomor Sertifikat</th>
                                    <td><?= Html::encode($model->certificate_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Nomor Pendidikan (NUPTK)</th>
                                    <td><?= Html::encode($model->education_number ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Status Dosen</th>
                                    <td>
                                        <?php
                                            $userStatus = $model->user->status ?? null;
                                            if ($userStatus !== null) {
                                                $badgeClass = $userStatus == 10 ? 'badge-success' : 'badge-danger';
                                                $statusText = $userStatus == 10 ? 'Aktif' : 'Tidak Aktif';
                                                echo '<span class="badge badge-pill ' . $badgeClass . '">' . $statusText . '</span>';
                                            } else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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