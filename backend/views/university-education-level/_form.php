<?php

use backend\models\EducationLevel;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$levels = ArrayHelper::map(EducationLevel::find()->where(['is_university' => true])->orderBy('sort_order')->all(), 'id', static fn($item) => $item->level . ' - ' . $item->name);
?>

<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Tingkat Pendidikan Universitas' : 'Form Ubah Tingkat Pendidikan Universitas' ?></h3></div>
    <?php $form = ActiveForm::begin([
        'id' => 'university-education-level-form',
        'options' => ['autocomplete' => 'off'],
        'enableClientValidation' => true,
        'validateOnChange' => true,
        'validateOnSubmit' => true,
    ]); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="mb-3 text-primary">Jenjang Pendidikan</h5><hr>
                <?= $form->field($model, 'education_level_id')->dropDownList($levels, ['prompt' => '- Pilih Jenjang -']) ?>
                <?= $form->field($model, 'study_period_semesters')->input('number', ['min' => 1, 'autofocus' => true]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="mb-3 text-primary">Batas Studi</h5><hr>
                <?= $form->field($model, 'max_leave_semesters')->input('number', ['min' => 1]) ?>
                <?= $form->field($model, 'max_study_semesters')->input('number', ['min' => 1]) ?>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex">
        <?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Kembali</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?>
        <div class="ml-auto" id="action-right">
            <?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', $model->isNewRecord ? Url::to(['index']) : Url::to(['view', 'id' => $model->id]), ['class' => 'btn btn-sm btn-secondary mr-1']) ?>
            <?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
