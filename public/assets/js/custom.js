$(window).scroll(function() {
if ($(this).scrollTop() > 1){  
    $('header').addClass("sticky");
  }
  else{
    $('header').removeClass("sticky");
  }
});

var counted = 0;
$(window).scroll(function() {

  var oTop = $('#counter').offset().top - window.innerHeight;
  if (counted == 0 && $(window).scrollTop() > oTop) {
    $('.count').each(function() {
      var $this = $(this),
        countTo = $this.attr('data-count');
      $({
        countNum: $this.text()
      }).animate({
          countNum: countTo
        },
        {
          duration: 50000,
          easing: 'swing',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
          complete: function() {
            $this.text(this.countNum);
            //alert('finished');
          }

        });
    });
    counted = 1;
  }

});

// $(".video-box-inner").mouseenter(function(e){
//   $(".video-box-inner").css('left', '-15px');
//   $(".video-box-inner").css('right', '-15px');
//   document.getElementById("fullscreen-bg__video").controls = true;
// });

// $(".video-box-inner").mouseleave(function(e){
//   $(".video-box-inner").css('left', '-68px');
//   $(".video-box-inner").css('right', '-68px');
//   document.getElementById("fullscreen-bg__video").controls = false;
// });

$(".VideoPopup").on('hidden.bs.modal', function (e) {
     $(".VideoPopup iframe").attr("src",   $(".VideoPopup iframe").attr("src"));
});


$('#inputDate').datepicker({
  uiLibrary: 'bootstrap4',
  format: 'yyyy-mm-dd'
});


  var btn = $('#button');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });
  
  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });




$('.client_slider_wrp').slick({
  dots: false,
  infinite: true,
  arrows: true,
  speed: 300,
  autoplay: false,
  slidesToShow: 3.2,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2.2,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

$('.services_slide').slick({
  dots: false,
  infinite: true,
  arrows: true,
  speed: 300,
   autoplay: false,
  centerPadding: '10px',
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

