
//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('data-id')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});
