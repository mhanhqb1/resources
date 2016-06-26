$(document).ready(function () {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scroll-back-to-top-wrapper').fadeIn();
        } else {
            $('.scroll-back-to-top-wrapper').fadeOut();
        }
    });

    $('.scroll-back-to-top-wrapper').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

});

$(document).ready(function(){
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
      if (pos < winTop + 750) {
        $(this).addClass("slide");
      }
    });
  });
})
