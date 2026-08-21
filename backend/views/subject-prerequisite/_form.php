<?php
use backend\models\StudyProgramCurriculum;
use backend\models\SubjectPrerequisite;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
?>
<?= Alert::widget() ?><div class="card card-primary card-outline"><div class="card-body"><?php $form = ActiveForm::begin(); ?><div class="row">
    <div class="col-md-6"><?= $form->field($model, 'course_curriculum_id')->widget(Select2::class, ['data' => $curriculumOptions]) ?></div><div class="col-md-6"><?= $form->field($model, 'prerequisite_curriculum_id')->widget(Select2::class, ['data' => $curriculumOptions]) ?></div>
    <div class="col-md-6"><?= $form->field($model, 'requirement_type')->dropDownList(SubjectPrerequisite::typeOptions()) ?></div><div class="col-md-6"><?= $form->field($model, 'minimum_grade')->dropDownList(StudyProgramCurriculum::gradeOptions(), ['prompt' => 'Tidak Ada']) ?></div>
</div><div class="text-right"><?= Html::a('Batal', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?> <?= Html::submitButton('<i class="fas fa-check"></i> Ubah', ['class' => 'btn btn-warning']) ?></div><?php ActiveForm::end(); ?></div></div>
