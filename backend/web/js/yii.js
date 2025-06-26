/**
 * Override Yii's default confirm dialog with SweetAlert2,
 * mirroring the structure of the provided Bootbox example.
 *
 * Ensure SweetAlert2 (Swal) and yii.js are loaded before this script.
 */
(function ($) {
    if (typeof Swal === 'undefined' || typeof yii === 'undefined') {
        console.warn("SweetAlert2 (Swal) atau yii.js belum dimuat.");
        return;
    }

    yii.confirm = function (message, $e) {
        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                yii.handleAction($e);
            }
        });

        return false;
    };
})(jQuery);