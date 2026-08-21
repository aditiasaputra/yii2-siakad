<?php

use backend\models\StudyProgramCurriculum;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline"><div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8"><?= $form->field($model, 'subject_id')->widget(Select2::class, ['data' => $subjects, 'options' => ['disabled' => true]]) ?><?= Html::hiddenInput('StudyProgramCurriculum[subject_id]', $model->subject_id, ['id' => 'curriculum-subject-id-hidden']) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'semester')->textInput(['type' => 'number', 'min' => 1, 'max' => 14]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'minimum_grade')->dropDownList(StudyProgramCurriculum::gradeOptions()) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'is_mandatory')->checkbox() ?></div><div class="col-md-3"><?= $form->field($model, 'is_package')->checkbox() ?></div>
        <div class="col-md-3"><?= $form->field($model, 'minimum_credits')->textInput(['type' => 'number', 'min' => 0, 'step' => '.5']) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'topic')->textarea(['rows' => 4]) ?></div><div class="col-md-6"><?= $form->field($model, 'basic_competencies')->textarea(['rows' => 4]) ?></div>
    </div>
    <div class="text-right"><?= Html::a('Batal', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?> <?= Html::submitButton('<i class="fas fa-check"></i> Ubah', ['class' => 'btn btn-warning']) ?></div>
    <?php ActiveForm::end(); ?>
</div></div>
