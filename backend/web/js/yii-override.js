// web/js/yii-override.js

/**
 * Override Yii's default confirm dialog with SweetAlert2.
 * Ensure SweetAlert2 library (Swal) is loaded before this script.
 * Ensure yii.js is loaded before this script.
 */
(function ($) {
    if (typeof Swal === 'undefined' || typeof yii === 'undefined') {
        console.warn("SweetAlert2 atau yii.js belum dimuat. yii.confirm override tidak dapat diterapkan.");
        alert("SweetAlert2 atau yii.js belum dimuat. yii.confirm override tidak dapat diterapkan.");
        return;
    }

    yii.confirm = function (message, okCallback, cancelCallback) {
        Swal.fire({
            title: message,
            icon: 'warning', // Menggunakan 'icon' bukan 'type' untuk SweetAlert2
            showCancelButton: true,
            confirmButtonColor: '#3085d6', // Warna default biru SweetAlert2
            cancelButtonColor: '#d33',     // Warna default merah SweetAlert2
            confirmButtonText: 'Ya, Lanjutkan!', // Teks tombol konfirmasi
            cancelButtonText: 'Batal',       // Teks tombol batal
            reverseButtons: true,            // Opsional: Membalik urutan tombol (Cancel di kiri, Confirm di kanan)
            allowOutsideClick: false,        // Disarankan false agar user lebih fokus pada dialog
            allowEscapeKey: false            // Disarankan false
            // Jika ingin menggunakan kelas Bootstrap untuk tombol:
            // customClass: {
            //     confirmButton: 'btn btn-success', // Kelas Bootstrap
            //     cancelButton: 'btn btn-danger'   // Kelas Bootstrap
            // },
            // buttonsStyling: false // Penting: Matikan styling default SweetAlert2 agar customClass berfungsi
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik "Ya, Lanjutkan!"
                if (okCallback) {
                    okCallback();
                }
            } else if (result.dismiss) {
                // Jika user membatalkan (klik "Batal", Esc, atau klik di luar)
                // result.dismiss bisa 'cancel', 'backdrop', 'esc', 'timer'
                if (cancelCallback) {
                    cancelCallback();
                }
            }
        });
    };
})(jQuery);