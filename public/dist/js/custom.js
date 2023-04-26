$('#dark-mode').on('click', function () {
    $('body').toggleClass('dark-mode');
    localStorage.setItem('dark-mode', $('body').hasClass('dark-mode'));
})

if (localStorage.getItem('dark-mode') == 'true') {
    $('body').addClass('dark-mode');
}
