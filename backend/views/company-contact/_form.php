<?php
use backend\models\Company; use kartik\form\ActiveForm; use yii\helpers\ArrayHelper; use yii\helpers\Html;
$companies = ArrayHelper::map(Company::find()->orderBy('name')->all(), 'id', 'name');
?>
<div class="card card-primary card-outline"><div class="card-body"><?php $form=ActiveForm::begin(['enableClientValidation'=>true]); ?><div class="row"><div class="col-md-6"><?= $form->field($model,'company_id')->dropDownList($companies,['prompt'=>'- Pilih Perusahaan -']) ?><?= $form->field($model,'name')->textInput() ?><?= $form->field($model,'phone')->textInput() ?></div><div class="col-md-6"><?= $form->field($model,'email')->textInput() ?><?= $form->field($model,'address')->textarea(['rows'=>3]) ?></div></div><?= Html::a('Batal',['index'],['class'=>'btn btn-secondary']) ?> <?= Html::submitButton($model->isNewRecord?'Simpan':'Ubah',['class'=>'btn btn-'.($model->isNewRecord?'success':'warning')]) ?><?php ActiveForm::end(); ?></div></div>
