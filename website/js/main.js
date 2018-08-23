// Slide in elements on scroll
$(window).scroll(function() {
    $(".slideanim").each(function(){
        var pos = $(this).offset().top;

        var winTop = $(window).scrollTop();
        if (pos < winTop + 500) {
            $(this).addClass("slide1");
        }
    });
});

$(window).scroll(function() {
    $(".slideanim2").each(function(){
        var pos = $(this).offset().top;

        var winTop = $(window).scrollTop();
        if (pos < winTop + 500) {
            $(this).addClass("slide2");
        }
    });
});