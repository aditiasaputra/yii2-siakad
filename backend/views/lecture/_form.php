<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\Role;
use common\widgets\Alert;

/** @var yii\web\View $this */
/** @var backend\models\LectureForm|StudentForm $formModel */
/** @var yii\widgets\ActiveForm $form */

$isLecture = isset($formModel->lecture);
$person = $isLecture ? $formModel->lecture : $formModel->student;
$user = $formModel->user;

$this->title = $isLecture ? 'Form Dosen' : 'Form Mahasiswa';

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

$assetDir = Yii::getAlias('@web/img');
$avatars = ['avatar.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png'];
?>

<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header">
        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($user, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($user, 'email')->input('email') ?>
                <?= $form->field($user, 'gender')->widget(Select2::class, [
                'data' => [1 => 'Laki-laki', 0 => 'Perempuan'],
                'options' => ['placeholder' => '-- Pilih --'],
                'pluginOptions' => ['allowClear' => true],
                ]) ?>
                <?= $form->field($user, 'status')->widget(Select2::class, [
                'data' => [10 => 'Aktif', 0 => 'Non-Aktif'],
                'options' => ['placeholder' => '-- Pilih --'],
                'pluginOptions' => ['allowClear' => true],
                ]) ?>
                <?= $form->field($user, 'address')->textarea(['rows' => 3]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($user, 'birth_date')->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'todayHighlight' => true,
                ]
                ]) ?>
                <?= $form->field($user, 'phone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>
                <label><strong>Pilih Avatar</strong></label>
                <div class="d-flex justify-content-start flex-wrap">
                    <?php foreach ($avatars as $avatar): ?>
                    <label class="mr-3 mb-2">
                        <input type="radio" name="User[avatar]" value="img/<?= $avatar ?>" style="display: none;">
                        <img src="<?= $assetDir . '/' . $avatar ?>" class="img-thumbnail avatar-choice" style="width: 70px; height: 70px; cursor: pointer;">
                    </label>
                    <?php endforeach; ?>
                </div>
                <?= $form->field($user, 'image')->widget(FileInput::class, [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                'initialPreviewAsData' => true,
                'showUpload' => false,
                'showRemove' => true,
                'overwriteInitial' => true,
                ]
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php if ($isLecture): ?>
                    <?= $form->field($person, 'employee_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($person, 'lecture_field')->textInput(['maxlength' => true]) ?>
                <?php else: ?>
                    <?= $form->field($person, 'student_nationality_number')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($person, 'program')->textInput(['maxlength' => true]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
        <div class="ml-auto">
            <?= Html::submitButton('<i class="fas fa-check"></i> Simpan', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
