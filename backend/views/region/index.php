<?php

use common\models\Region;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Wilayah Indonesia';
$this->params['breadcrumbs'][] = $this->title;
$levels = ['province', 'regency', 'district'];
$gridUrl = Url::to(['grid']);
?>
<div class="region-index">
    <ul class="nav nav-tabs" id="region-tabs" role="tablist">
        <?php foreach ($levels as $index => $level): ?>
            <li class="nav-item">
                <a class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="<?= $level ?>-tab" data-toggle="tab" data-level="<?= $level ?>" href="#<?= $level ?>" role="tab">
                    <?= Html::encode(Region::levelLabels()[$level]) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content pt-3">
        <?php foreach ($levels as $index => $level): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="<?= $level ?>" role="tabpanel">
                <div class="region-grid-container" data-level="<?= $level ?>">
                    <div class="text-center text-muted py-5"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$this->registerJs(<<<JS
function loadRegionGrid(level) {
    const container = $('.region-grid-container[data-level="' + level + '"]');
    const previousRequest = container.data('request');
    if (previousRequest) {
        previousRequest.abort();
    }

    container.html('<div class="text-center text-muted py-5"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</div>');
    const request = $.ajax({
        url: '{$gridUrl}',
        data: {level: level},
        cache: false
    }).done(function (html) {
        container.html(html);
    }).fail(function (xhr, status) {
        if (status !== 'abort') {
            container.html('<div class="alert alert-danger">Data wilayah gagal dimuat. Silakan coba kembali.</div>');
        }
    }).always(function () {
        container.removeData('request');
    });
    container.data('request', request);
}

$('#region-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
    const level = $(event.target).data('level');
    history.replaceState(null, '', event.target.hash);
    loadRegionGrid(level);
});

const initialHash = window.location.hash;
const initialTab = initialHash ? $('#region-tabs a[href="' + initialHash + '"]') : $();
if (initialTab.length) {
    if (initialTab.hasClass('active')) {
        loadRegionGrid(initialTab.data('level'));
    } else {
        initialTab.tab('show');
    }
} else {
    loadRegionGrid('province');
}
JS);
?>
