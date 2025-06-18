<?php
use yii\helpers\Html;
use common\widgets\Alert;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$this->title = 'Detail Karyawan';
?>

<?= Alert::widget() ?>

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
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#employee" data-toggle="tab">Kepegawaian</a></li>
                    <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Ganti Password</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="profil">
                        <dl class="row">
                            <dt class="col-sm-4">KTP</dt>
                            <dd class="col-sm-8"><?= $model->user->personal_id ?? '-' ?></dd>

                            <dt class="col-sm-4">Nama Lengkap</dt>
                            <dd class="col-sm-8"><?= $model->user->name ?></dd>

                            <dt class="col-sm-4">Username</dt>
                            <dd class="col-sm-8"><?= $model->user->username ?></dd>

                            <dt class="col-sm-4">Jenis Kelamin</dt>
                            <dd class="col-sm-8"><?= Html::encode($model->user->getGenderLabel() ?? '-') ?></dd>

                            <dt class="col-sm-4">Role/Level</dt>
                            <dd class="col-sm-8"><?= ucfirst($model->user->role->name) ?></dd>

                            <dt class="col-sm-4">Tanggal Registrasi</dt>
                            <dd class="col-sm-8"><?= Yii::$app->formatter->asDate($model->user->created_at, 'long') ?></dd>

                            <dt class="col-sm-4">Terakhir Diperbarui</dt>
                            <dd class="col-sm-8"><?= Yii::$app->formatter->asDate($model->user->updated_at, 'long') ?></dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8"><span class="badge badge-pill <?= $model->user->status == 10 ? 'badge-success' : 'badge-danger' ?>">
                        <?= $model->user->status == 10 ? 'Aktif' : 'Tidak Aktif' ?>
                    </span></dd>
                        </dl>
                    </div>
                    <div class="tab-pane" id="employee">
                        <dl class="row">
                            <dt class="col-sm-4">NIP</dt>
                            <dd class="col-sm-8"><?= $model->employee_number ?? '-' ?></dd>

                            <dt class="col-sm-4">NIP</dt>
                            <dd class="col-sm-8"><?= $model->employee_id ?? '-' ?></dd>
                        </dl>
                    </div>
                    <div class="tab-pane" id="change-password">
                        <div class="row">
                            Ganti Password
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex">
                <div id="action-left">
                    <?= Html::a('Kembali', ['index'], [
                        'class' => 'btn btn-sm btn-default'
                    ]) ?>
                    <?= Html::a('Buat Pengguna', ['create'], [
                        'class' => 'btn btn-sm btn-success ml-1'
                    ]) ?>
                </div>
                <div class="ml-auto" id="action-right">
                    <?= Html::a('Edit', ['update', 'id' => $model->user->id], [
                        'class' => 'btn btn-sm btn-warning'
                    ]) ?>

                    <?= Html::a('Hapus', ['delete', 'id' => $model->user->id], [
                        'class' => 'btn btn-sm btn-danger mx-1',
                        'data' => [
                            'method' => 'post',
                            'confirm' => 'Yakin ingin hapus?',
                        ]
                    ]) ?>

                    <?= Html::a('Kembali', ['index'], [
                        'class' => 'btn btn-sm btn-secondary'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>