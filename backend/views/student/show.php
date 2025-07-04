<?php
use yii\helpers\Html;
use common\widgets\Alert;
?>

<?php
$this->registerCssFile("@web/css/profile.css");
$this->registerJsFile("@web/css/profile.js");
if(Yii::$app->controller->action->id == 'show') {
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
}
?>

<?= Alert::widget() ?>

<div class="d-flex mb-3">
    <div id="action-left">
        <?= Html::a('Kembali', ['index'], [
            'class' => 'btn btn-sm btn-default'
        ]) ?>
        <?= Html::a('Buat Pengguna', ['create'], [
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
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="<?= !$model->user->image || str_contains($model->user->image, 'img/') ? $assetDir . '/' . $model->user->image : Yii::getAlias('@web/uploads/' . $model->user->image) ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $model->user->name ?></h3>
                <p class="text-muted text-center"><?= ucfirst($model->user->role->name ?? '-') ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">
                            <?= $model->user->email ?? '-' ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fas fa-phone mr-1"></i> No. Telepon</strong>
                        <p class="text-muted">
                            <?= $model->user->phone ?? '-' ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fas fa-home mr-1"></i> Alamat</strong>
                        <p class="text-muted">
                            <?= $model->user->address ?? '-' ?>
                        </p>
                    </li>
                </ul>

                <div class="profile-sidebar">
                    <div class="menu-section mb-1">
                        <span class="menu-header d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#generalMenu" aria-expanded="true">
                            <h6><strong>LIST MENU</strong></h6>
                        </span>
                    </div>
                    <div class="menu-section">
                        <?= Html::a(
                            '<span><i class="fas fa-user-graduate mr-2"></i>Detail</span>',
                            ['show', 'id' =>$model->id],
                            [
                                'class' => 'menu-link d-flex justify-content-between align-items-center ' . 
                                    (Yii::$app->controller->action->id == 'show' ? 'active' : '')
                            ]
                        ) ?>
                    </div>

                    <div class="menu-section">
                        <?= Html::a(
                            '<span><i class="fas fa-calendar-alt mr-2"></i>Jadwal</span>',
                            ['schedule', 'id' => $model->id],
                            [
                                'class' => 'menu-link d-flex justify-content-between align-items-center ' . 
                                    (Yii::$app->controller->action->id == 'schedule' ? 'active' : '')
                            ]
                        ) ?>
                    </div>

                    <div class="menu-section">
                        <?= Html::a(
                            '<span><i class="fas fa-calendar-check mr-2"></i>Kehadiran</span>',
                            ['presence', 'id' => $model->id],
                            [
                                'class' => 'menu-link d-flex justify-content-between align-items-center ' . 
                                    (Yii::$app->controller->action->id == 'presence' ? 'active' : '')
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <?php if(Yii::$app->controller->action->id == 'show'): ?>
            <?= $this->render('_show', compact('model', 'changePasswordmodel')) ?>
        <?php endif; ?>
        <?php if(Yii::$app->controller->action->id == 'schedule'): ?>
            <?= $this->render('_schedule', compact('model')) ?>
        <?php endif; ?>
        <?php if(Yii::$app->controller->action->id == 'presence'): ?>
            <?= $this->render('_presence', compact('model')) ?>
        <?php endif; ?>
    </div>
</div>
