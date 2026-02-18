let hideScrollbarTimeout;
const sidebar = document.getElementById('sidebar');

function showScrollbar() {
    sidebar.classList.add('show-scrollbar');

    // Сбрасываем таймер
    clearTimeout(hideScrollbarTimeout);

    // Скрываем через 2 секунды
    hideScrollbarTimeout = setTimeout(() => {
        // Не скрываем, если курсор все еще над сайдбаром
        if (!sidebar.matches(':hover')) {
            sidebar.classList.remove('show-scrollbar');
        }
    }, 2000);
}

// Показываем скроллбар при скролле
sidebar.addEventListener('scroll', showScrollbar);

// Показываем при наведении
sidebar.addEventListener('mouseenter', () => {
    sidebar.classList.add('show-scrollbar');
});

// Скрываем при уходе курсора
sidebar.addEventListener('mouseleave', () => {
    hideScrollbarTimeout = setTimeout(() => {
        sidebar.classList.remove('show-scrollbar');
    }, 2000);
});

//поиск
$('.header__content_buttons-search').on('click', function(e){
    e.preventDefault();

    $('body').addClass('show-search');
})
$('.header__content_search-background').on('click', function(e){
    $('body').removeClass('show-search');
})

//сайдбар
$('#mobileMenuBtn').on('click', function(e){
    e.preventDefault();

    $('body').addClass('show-sidebar');
})
$('.sidebar__mobile-background').on('click', function(e){
    $('body').removeClass('show-sidebar');
})