<?php
use yii\helpers\Html;
use common\widgets\Alert;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>

<?= Alert::widget() ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Pengguna</h5>
    </div>
    <div class="card-body">

        <!-- Foto Profil -->
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-center flex-wrap">
                <a href="<?= !$model->image || str_contains($model->image, 'img/') ? $assetDir . $model->image : Yii::getAlias('@web/uploads/' . $model->image) ?>" target="_blank" class="mb-2">
                <img src="<?= !$model->image || str_contains($model->image, 'img/') ? $assetDir . $model->image : Yii::getAlias('@web/uploads/' . $model->image) ?>" alt="User Photo" class="img-thumbnail" style="max-width: 150px;">
                </a>
            </div>
        </div>

        <!-- Informasi Pribadi -->
        <h5 class="text-muted text-center mb-4">Informasi Pribadi</h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Lengkap:</strong><br> 
                    <span class="text-secondary"><?= Html::encode($model->name) ?></span>
                </p>
                <p><strong>Username:</strong><br> 
                    <span class="text-secondary"><?= Html::encode($model->username) ?></span>
                </p>
                <p><strong>Email:</strong><br> 
                    <span class="text-secondary"><?= Html::encode($model->email) ?></span>
                </p>
                <p><strong>Nomor Telepon:</strong><br> 
                    <span class="text-secondary"><?= Html::encode($model->phone ?? '-') ?></span>
                </p>
                <p><strong>Alamat:</strong><br> 
                    <span class="text-secondary"><?= Html::encode($model->address ?? '-') ?></span>
                </p>
            </div>

            <div class="col-md-6">
                <p><strong>Jenis Kelamin:</strong><br> 
                    <span class="text-secondary"><?= Html::encode($model->gender ?? '-') ?></span>
                </p>
                <p><strong>Tanggal Lahir:</strong><br> 
                    <span class="text-secondary"><?= Yii::$app->formatter->asDate($model->birth_date ?? null, 'long') ?></span>
                </p>
                <p><strong>Role/Level:</strong><br> 
                    <span class="text-secondary"><?= Html::encode($model->role->name ?? '-') ?></span>
                </p>
                <p><strong>Status Akun:</strong><br> 
                    <span class="text-secondary <?= $model->status == 10 ? 'text-success' : 'text-danger' ?>">
                        <?= $model->status == 10 ? 'Aktif' : 'Tidak Aktif' ?>
                    </span>
                </p>
                <p><strong>Tanggal Registrasi:</strong><br> 
                    <span class="text-secondary"><?= Yii::$app->formatter->asDate($model->created_at, 'long') ?></span>
                </p>
            </div>
        </div>

    </div>
    <div class="card-footer d-flex">
        <div id="action-left">
            <?= Html::a('Kembali', ['index'], [
                'class' => 'btn btn-default'
            ]) ?>
            <?= Html::a('Buat Pengguna', ['create'], [
                'class' => 'btn btn-success ml-1'
            ]) ?>
        </div>
        <div class="ml-auto" id="action-right">
            <?= Html::a('Edit', ['update', 'id' => $model->id], [
                'class' => 'btn btn-warning'
            ]) ?>

            <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger mx-1',
                'data' => [
                    'method' => 'post',
                    'confirm' => 'Yakin ingin hapus?',
                ]
            ]) ?>

            <?= Html::a('Kembali', ['index'], [
                'class' => 'btn btn-secondary'
            ]) ?>
        </div>
    </div>
</div>
