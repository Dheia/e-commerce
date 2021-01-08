$(function () {

    $(function () {
        var body = document.getElementsByTagName('body')[0];
        var bodyScrollTop = null;
        var locked = false;


        // Определяем функцию, запрещающую скроллинг
        function preventScroll(e) {
            e.preventDefault();
            return false
        }

        window.lockScroll = function () {

            bodyScrollTop = (typeof window.pageYOffset !== 'undefined') ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
            body.classList.add('scroll-locked');
            body.style.top = -bodyScrollTop + 'px';
            locked = true;

            $(document).on('scroll', preventScroll);
        };

        window.unlockScroll = function () {

            body.classList.remove('scroll-locked');
            body.style.top = null;
            window.scrollTo(0, bodyScrollTop);

            $(document).off('scroll', preventScroll);
        };
    }());

    $('[data-show-modal]').on('click', function (e) {
        e.preventDefault();
        $('.modal-b').hide();
        var $modal = $('#' + $(this).data('show-modal'));
        $modal.fadeIn(400);
        lockScroll();
    });

    $('.js--close-modal').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.modal-b').fadeOut();
        unlockScroll();
    });

    $('.modal-b').on('click', function (e) {
        if ($(e.target).closest('.modal-b__block').length) return;
        e.preventDefault();
        $(this).closest('.modal-b').fadeOut();
        unlockScroll();
        e.stopPropagation();
    });


    $(document).on('keyup', function(e) {
        if (e.key === "Escape") {
            e.preventDefault();
            $('.modal-b').fadeOut();
            unlockScroll();
        }
    });

    // Header Mobile Bar
    $('.js--header-nav-show').on('click', function(e) {
        e.preventDefault();
        $('.header-nav-b').addClass('header-nav-b_show');
        $('.shadow').fadeIn('fast');
        lockScroll();
    });
    $('.js--header-nav-hide').on('click', function(e) {
        e.preventDefault();
        $('.header-nav-b').removeClass('header-nav-b_show');
        $('.shadow').fadeOut('fast');
        unlockScroll();
    });

    $('.header-nav-b').swipe({
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            if (direction == 'left') {
                $('.header-nav-b').removeClass('header-nav-b_show');
                $('.shadow').fadeOut('fast');
                unlockScroll();
            }
        }
    });

});
