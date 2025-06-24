<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Role;
use common\models\Region;
use common\widgets\Alert;
use kartik\file\FileInput;
use common\models\Religion;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var common\models\Employee $employeeModel */
/** @var common\models\Lecture $lectureModel */
/** @var yii\widgets\ActiveForm $form */

$this->registerCss(<<<CSS
    .avatar-choice {
        border: 2px solid transparent;
        transition: border-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 10px;
    }

    .avatar-choice:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }

    .avatar-choice.selected {
        border-color: #28a745;
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
    }
CSS
);

$this->registerJs(<<<JS
    $('.avatar-choice').on('click', function () {
        $(this).siblings('input[type="radio"]').prop('checked', true).trigger('change');
        $('.avatar-choice').css('border-color', 'transparent');
        $(this).css('border-color', '#007bff');
        $('.file-preview-image').attr('src', $(this).attr('src'));
    });
JS
);

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$avatars = ['avatar.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png'];
?>

<?= Alert::widget() ?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'autocomplete' => 'off'],
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
]); ?>
    <div class="card card-primary card-outline mb-3">
        <div class="card-header">
            <h1 class="card-title">Form Pengguna</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri: Informasi Personal & Kontak -->
                <div class="col-lg-12 col-md-12">
                    <h5 class="mb-3 text-primary">Informasi Dasar</h5>
                    <hr>
                    <?= $form->field($userModel, 'name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
                    <?= $form->field($userModel, 'username')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($userModel, 'email')->textInput(['maxlength' => true]) ?>

                    <?php if ($userModel->isNewRecord): ?>
                        <?= $form->field($userModel, 'password')->passwordInput(['maxlength' => true]) ?>
                    <?php endif; ?>

                    <?= $form->field($userModel, 'role_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(
                            Role::find()->select(['id', 'name'])->asArray()->all(),
                            'id', 'name'
                        ),
                        'options' => ['placeholder' => '-- Pilih Role --', 'value' => $userModel->role_id],
                        'pluginOptions' => ['allowClear' => true],
                    ]) ?>

                    <?= $form->field($userModel, 'status')->widget(Select2::class, [
                        'data' => [
                            10 => 'Aktif',
                            0 => 'Non-aktif',
                        ],
                        'options' => ['placeholder' => '-- Pilih Status --', 'value' => $userModel->status ?? 10],
                        'pluginOptions' => ['allowClear' => true],
                    ]) ?>

                    <h5 class="mt-4 mb-3 text-primary">Detail Pribadi</h5>
                    <hr>
                    <?= $form->field($userModel, 'personal_id')->textInput(['type' => 'number', 'maxlength' => true]) ?>
                    <?= $form->field($userModel, 'family_id')->textInput(['type' => 'number', 'maxlength' => true]) ?>

                    <?= $form->field($userModel, 'gender')->widget(Select2::class, [
                        'data' => [
                            1 => 'Laki-laki',
                            0 => 'Perempuan',
                        ],
                        'options' => ['placeholder' => '-- Pilih Jenis Kelamin --'],
                        'pluginOptions' => ['allowClear' => true],
                    ]) ?>

                    <?= $form->field($userModel, 'blood_type')->widget(Select2::class, [
                        'data' => [
                            'A' => 'A',
                            'B' => 'B',
                            'AB' => 'AB',
                            'O' => 'O',
                        ],
                        'options' => ['placeholder' => '-- Pilih Golongan Darah --'],
                        'pluginOptions' => ['allowClear' => true],
                    ]) ?>

                    <?= $form->field($userModel, 'height')->textInput(['type' => 'number', 'maxlength' => true]) ?>
                    <?= $form->field($userModel, 'weight')->textInput(['type' => 'number', 'maxlength' => true]) ?>

                    <?= $form->field($userModel, 'religion_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(
                            Religion::find()->select(['id', 'name'])->asArray()->all(),
                            'id', 'name'
                        ),
                        'options' => ['placeholder' => '-- Pilih Agama --', 'value' => $userModel->religion_id],
                        'pluginOptions' => ['allowClear' => true],
                    ]) ?>

                    <?= $form->field($userModel, 'birth_date')->widget(DatePicker::class, [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'todayBtn' => true,
                            'clearBtn' => true,
                            'endDate' => date('Y-m-d'),
                        ]
                    ]) ?>

                    <?= $form->field($userModel, 'phone')->textInput(['maxlength' => true])->hint('Contoh: 081234556789 / +6281234556789') ?>
                </div>

                <!-- Kolom Kanan: Alamat & Avatar/Gambar -->
                <div class="col-lg-12 col-md-12">
                    <h5 class="mt-4 mb-3 text-primary">Alamat Lengkap</h5>
                    <hr>
                    <?= $form->field($userModel, 'province_code')->widget(Select2::class, [
                            'data' => ArrayHelper::map(
                                Region::find()->where(['level' => 1])->orderBy('name')->asArray()->all(),
                                'kode',
                                'name'
                            ),
                            'options' => ['placeholder' => 'Pilih Provinsi', 'id' => 'province-id'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>

                    <?= $form->field($userModel, 'regency_code')->widget(DepDrop::class, [
                        'type' => DepDrop::TYPE_SELECT2,
                        'options' => ['id' => 'regency-id', 'placeholder' => 'Pilih Kabupaten/Kota'],
                        'pluginOptions' => [
                            'depends' => ['province-id'],
                            'initialize' => true,
                            'url' => Url::to(['/region/regency']),
                            'loadingText' => 'Memuat Kabupaten/Kota...',
                            'allowClear' => true,
                        ],
                    ]); ?>

                    <?= $form->field($userModel, 'district_code')->widget(DepDrop::class, [
                        'type' => DepDrop::TYPE_SELECT2,
                        'options' => ['id' => 'district-id', 'placeholder' => 'Pilih Kecamatan'],
                        'pluginOptions' => [
                            'depends' => ['province-id', 'regency-id'],
                            'initialize' => true,
                            'url' => Url::to(['/region/district']),
                            'loadingText' => 'Memuat Kecamatan...',
                            'allowClear' => true,
                        ],
                    ]); ?>

                    <?= $form->field($userModel, 'village_code')->widget(DepDrop::class, [
                        'type' => DepDrop::TYPE_SELECT2,
                        'options' => ['placeholder' => 'Pilih Desa/Kelurahan'],
                        'pluginOptions' => [
                            'depends' => ['province-id', 'regency-id', 'district-id'],
                            'initialize' => true,
                            'url' => Url::to(['/region/village']),
                            'loadingText' => 'Memuat Desa/Kelurahan...',
                            'allowClear' => true,
                        ],
                    ]); ?>

                    <?= $form->field($userModel, 'address')->textarea([
                        'rows' => 3,
                        'placeholder' => 'Masukkan Alamat Lengkap...',
                    ]) ?>

                    <h5 class="mt-4 mb-3 text-primary">Avatar/Foto Pengguna</h5>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pilih Avatar</label>
                        <div class="col-sm-9">
                            <div class="d-flex justify-content-start flex-wrap gap-3">
                                <?php foreach ($avatars as $avatar): ?>
                                    <label class="text-center">
                                        <input type="radio" name="User[avatar]" value="<?= 'img/' . $avatar ?>"
                                            <?= ($userModel->image === 'img/' . $avatar) ? 'checked' : '' ?> style="display: none;" class="avatar-radio">
                                        <img src="<?= $assetDir . '/img/' . $avatar ?>" class="img-thumbnail avatar-choice <?= ($userModel->image === 'img/' . $avatar) ? 'selected' : '' ?>" style="width: 80px; height: 80px; cursor: pointer;">
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <small class="form-text text-muted mt-2">Atau unggah foto di bawah ini</small>
                        </div>
                    </div>

                    <?= $form->field($userModel, 'image')->widget(FileInput::class, [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'initialPreview' => ($userModel->image && file_exists(Yii::getAlias('@webroot/uploads/' . $userModel->image))
                                ? [Yii::getAlias('@web/uploads/' . $userModel->image)]
                                : []),
                            'initialPreviewAsData' => true,
                            'initialCaption' => $userModel->image,
                            'overwriteInitial' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                            'browseLabel' => 'Pilih Gambar',
                            'removeLabel' => 'Hapus',
                            'uploadLabel' => 'Unggah',
                        ]
                    ])->label('Unggah Foto') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info card-outline mb-3">
                <div class="card-header">
                    <h1 class="card-title">Form Pegawai</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri: Informasi Kepegawaian & Bank -->
                        <div class="col-lg-12 col-md-12">
                            <h5 class="mb-3 text-primary">Informasi Kepegawaian</h5>
                            <hr>
                            <?= $form->field($employeeModel, 'employee_number')->textInput(['maxlength' => true])->hint('Nomor unik karyawan') ?>
                            <?= $form->field($employeeModel, 'tax_number')->textInput(['maxlength' => true])->hint('Nomor Pokok Wajib Pajak (NPWP)') ?>
                            
                            <h5 class="mt-4 mb-3 text-primary">Informasi Bank</h5>
                            <hr>
                            <?= $form->field($employeeModel, 'account_name')->textInput(['maxlength' => true])->hint('Nama pemilik rekening bank') ?>
                            <?= $form->field($employeeModel, 'account_number')->textInput(['maxlength' => true])->hint('Nomor rekening bank') ?>
                            <?= $form->field($employeeModel, 'branch_name')->textInput(['maxlength' => true])->hint('Nama cabang bank') ?>
                        </div>

                        <!-- Kolom Kanan: Nomor Jaminan Sosial & Catatan -->
                        <div class="col-lg-12 col-md-12">
                            <h5 class="mb-3 text-primary">Nomor Jaminan Sosial</h5>
                            <hr>
                            <?= $form->field($employeeModel, 'national_social_security_number')->textInput(['maxlength' => true])->hint('Nomor BPJS Ketenagakerjaan (Nasional)') ?>
                            <?= $form->field($employeeModel, 'national_health_insurance_number')->textInput(['maxlength' => true])->hint('Nomor BPJS Kesehatan (Nasional)') ?>
                            <?= $form->field($employeeModel, 'social_security_number')->textInput(['maxlength' => true])->hint('Nomor Jaminan Sosial Lainnya (jika ada)') ?>
                            <?= $form->field($employeeModel, 'health_insurance_number')->textInput(['maxlength' => true])->hint('Nomor Asuransi Kesehatan Lainnya (jika ada)') ?>

                            <h5 class="mt-4 mb-3 text-primary">Lainnya</h5>
                            <hr>
                            <?= $form->field($employeeModel, 'note')->textarea(['rows' => 2])->hint('Tambahkan catatan penting mengenai karyawan ini.') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-info card-outline mb-3">
                <div class="card-header">
                    <h1 class="card-title">Form Dosen</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri: Nomor Identitas Dosen -->
                        <div class="col-lg-12 col-md-12">
                            <h5 class="mb-3 text-primary">Nomor Identitas Dosen/Pengajar</h5>
                            <hr>
                            <?= $form->field($lectureModel, 'lecture_nationality_number')->textInput(['maxlength' => true])->hint('Nomor Induk Dosen Nasional (NIDN)') ?>
                            <?= $form->field($lectureModel, 'lecture_special_number')->textInput(['maxlength' => true])->hint('Nomor Induk Dosen Khusus (NIDK)') ?>
                            <?= $form->field($lectureModel, 'teacher_national_number')->textInput(['maxlength' => true])->hint('Nomor Urut Pendidik (NUP) atau Nomor Induk Pendidik (NIP) jika PNS') ?>
                        </div>

                        <!-- Kolom Kanan: Informasi Akademik & Kualifikasi -->
                        <div class="col-lg-12 col-md-12">
                            <h5 class="mb-3 text-primary">Informasi Akademik & Kualifikasi</h5>
                            <hr>
                            <?= $form->field($lectureModel, 'field_of_study')->textInput(['maxlength' => true])->hint('Bidang Ilmu atau Spesialisasi Dosen') ?>
                            <?= $form->field($lectureModel, 'is_match_field')->widget(Select2::class, [
                                'data' => [
                                    1 => 'Ya',
                                    0 => 'Tidak',
                                ],
                                'options' => ['placeholder' => '-- Pilih Ya/Tidak --', 'value' => $lectureModel->is_match_field],
                                'pluginOptions' => ['allowClear' => true],
                            ])->hint('Apakah bidang studi dosen sesuai dengan penugasannya?') ?>

                            <?= $form->field($lectureModel, 'certificate_date')->widget(DatePicker::class, [
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                    'clearBtn' => true,
                                    'endDate' => date('Y-m-d'),
                                ]
                            ])->hint('Tanggal sertifikasi profesional atau keahlian') ?>

                            <?= $form->field($lectureModel, 'certificate_number')->textInput(['maxlength' => true])->hint('Nomor sertifikat') ?>
                            <?= $form->field($lectureModel, 'education_number')->textInput(['maxlength' => true])->hint('Nomor Unik Pendidik dan Tenaga Kependidikan') ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <?php if (!$employeeModel->isNewRecord): ?>
                        <div id="action-left">
                            <?= Html::a('Kembali', ['show', 'id' => $employeeModel->id], [
                                'class' => 'btn btn-sm btn-default'
                            ]) ?>
                        </div>
                    <?php endif; ?>
                    <div class="ml-auto" id="action-right">
                        <?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-secondary mr-1']) ?>
                        <?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($employeeModel->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($employeeModel->isNewRecord ? 'success' : 'warning')]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
