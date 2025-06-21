<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\Role;
use common\widgets\Alert;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var common\models\Employee $employeeModel */
/** @var common\models\Lecture $lectureModel */
/** @var yii\widgets\ActiveForm $form */

$this->registerCss(<<<CSS
    .avatar-choice {
        border: 2px solid transparent;
    }
    input[type="radio"]:checked + .avatar-choice {
        border-color: #007bff;
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

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="card card-primary card-outline mb-3">
        <div class="card-header">
            <h1 class="card-title">Form Pengguna</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($userModel, 'name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($userModel, 'username')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($userModel, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($userModel, 'personal_id')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($userModel, 'family_id')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($userModel, 'role_id')->widget(Select2::class, [
                                'data' => ArrayHelper::map(
                                    Role::find()->select(['id', 'name'])->asArray()->all(),
                                    'id', 'name'
                                ),
                                'options' => ['placeholder' => '-- Pilih Role --', 'value' => $userModel->role_id],
                                'pluginOptions' => ['allowClear' => true],
                            ])->label('Role') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($userModel, 'gender')->widget(Select2::class, [
                                'data' => [
                                    1 => 'Laki-laki',
                                    0 => 'Perempuan',
                                ],
                                'options' => ['placeholder' => '-- Pilih Jenis Kelamin --', 'value' => $userModel->gender],
                                'pluginOptions' => ['allowClear' => true],
                            ])->label('Jenis Kelamin') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($userModel, 'address')->textarea([
                                'rows' => 3,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Masukkan Alamat Lengkap...',
                            ])->label('Alamat') ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($userModel, 'status')->widget(Select2::class, [
                                'data' => [
                                    10 => 'Active',
                                    0 => 'Inactive',
                                ],
                                'options' => ['placeholder' => '-- Pilih Status --', 'value' => $userModel->status ?? 10],
                                'pluginOptions' => ['allowClear' => true],
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="row">
                        <div class="col-md-12">
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
                            ])->label('Tanggal Lahir') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($userModel, 'phone')->textInput(['maxlength' => true]) ?>
                        </div>
                        <?php if ($userModel->isNewRecord): ?>
                            <div class="col-lg-12 col-md-12 col-12">
                                <?= $form->field($userModel, 'password')->passwordInput(['maxlength' => true]) ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-12 mb-3">
                            <label class="form-label"><strong>Pilih Avatar</strong></label>
                            <div class="d-flex justify-content-evenly flex-wrap gap-4">
                                <?php foreach ($avatars as $avatar): ?>
                                    <label class="text-center">
                                        <input type="radio" name="User[avatar]" value="<?= 'img/' . $avatar ?>"
                                            <?= ($userModel->image === 'img/' . $avatar) ? 'checked' : '' ?> style="display: none;">
                                        <img src="<?= $assetDir . '/img/' . $avatar ?>" class="img-thumbnail avatar-choice" style="width: 80px; height: 80px; cursor: pointer;">
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-text text-muted mt-2">Atau upload gambar kustom di bawah ini</div>
                        </div>

                        <div class="col-md-12">
                            <?= $form->field($userModel, 'image')->widget(FileInput::class, [
                                'options' => ['accept' => 'image/*'],
                                'pluginOptions' => [
                                    'initialPreview' => ($userModel->isNewRecord || !$userModel->image
                                        ? false
                                        : [Yii::getAlias('@web/uploads/' . $userModel->image)]),
                                    'initialPreviewAsData' => true,
                                    'initialCaption' => $userModel->image,
                                    'overwriteInitial' => true,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-info card-outline mb-3">
                <div class="card-header">
                    <h1 class="card-title">Form Pegawai</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <?= $form->field($employeeModel, 'employee_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'tax_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'branch_name')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'account_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'account_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-7">
                            <?= $form->field($employeeModel, 'national_social_security_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'national_health_insurance_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'social_security_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'health_insurance_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($employeeModel, 'note')->textarea(['rows' => 2]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-info card-outline mb-3">
                <div class="card-header">
                    <h1 class="card-title">Form Dosen</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <?= $form->field($lectureModel, 'lecture_nationality_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($lectureModel, 'lecture_special_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($lectureModel, 'teacher_national_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($lectureModel, 'field_of_study')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-7">
                            <?= $form->field($lectureModel, 'is_match_field')->widget(Select2::class, [
                                'data' => [
                                    1 => 'Ya',
                                    0 => 'Tidak',
                                ],
                                'options' => ['placeholder' => '-- Pilih Ya/Tidak --', 'value' => $lectureModel->is_match_field],
                                'pluginOptions' => ['allowClear' => true],
                            ]) ?>
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
                            ]) ?>
                            <?= $form->field($lectureModel, 'certificate_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($lectureModel, 'education_number')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 my-3">
            <div class="d-flex">
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
<?php ActiveForm::end(); ?>
