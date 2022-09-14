// Slide in elements on scroll
$(window).scroll(function() {
    $(".slideanim").each(function(){
        var pos = $(this).offset().top;

        var winTop = $(window).scrollTop();
        if (pos < winTop + 800) {
            $(this).addClass("slide1");
        }
    });
});

$(window).scroll(function() {
    $(".slideanim2").each(function(){
        var pos = $(this).offset().top;

        var winTop = $(window).scrollTop();
        if (pos < winTop + 800) {
            $(this).addClass("slide2");
        }
    });
});

$(document).on("click", ".navbar-toggle-arch", function(event){
    $("#arc-menu").fadeTo(100,1);
});

if (typeof randomIntFromInterval === "undefined")
{
    function randomIntFromInterval(min,max)
    {
        return Math.floor(Math.random()*(max-min+1)+min);
    }
};