(function ($) {
    'use strict';

    function styleGridActions() {
        $('.grid-view').each(function () {
            var $grid = $(this);
            $grid.find('a[title="View"],a[title="Lihat"],a[aria-label="View"],a[aria-label="Lihat"]').addClass('btn btn-sm btn-outline-info').removeClass('btn-link');
            $grid.find('a[title="Update"],a[title="Edit"],a[title="Ubah"],a[aria-label="Update"],a[aria-label="Edit"],a[aria-label="Ubah"]').addClass('btn btn-sm btn-outline-warning').removeClass('btn-link');
            $grid.find('a[title="Delete"],a[title="Hapus"],a[aria-label="Delete"],a[aria-label="Hapus"],a[data-method="post"]').addClass('btn btn-sm btn-outline-danger').removeClass('btn-link');
        });
    }

    $(function () {
        styleGridActions();
        window.setTimeout(styleGridActions, 100);
        $(document).on('pjax:end', styleGridActions);
    });
})(jQuery);
