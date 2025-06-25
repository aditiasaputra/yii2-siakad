<?php
use yii\helpers\Html;
use common\widgets\Alert;
use yii\widgets\ActiveForm;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$this->title = 'Detail';

$this->params['breadcrumbs'][] = ['label' => 'Master Agama', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
        <?= Html::a('Tambah Agama', ['create'], [
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nama Agama</dt>
                    <dd class="col-sm-8">: <?= $model->name ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
