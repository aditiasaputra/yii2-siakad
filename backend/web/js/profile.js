$('.menu-header').on('click', function() {
    const icon = $(this).find('.toggle-icon');
    icon.toggleClass('rotate');
});