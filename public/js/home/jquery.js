//Cazando el like
$(document).on('click', '#like_request', function (event) {
  event.preventDefault();
  $.post({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: $('#url-like').val(),
    data: { user_id2: $('#user_id2').val(), the_users: [] },
    //Lanzar evento en el controlador
  }).done(function (response) {

    $('#photo-gallery').html(response);

    $('.slider-content').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      autoplay: true,
      autoplaySpeed: 5000,
      asNavFor: '.slider-nav',
      mobileFirst: true
    });
    $('.slider-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.slider-content',
      dots: false,
      centerMode: true,
      focusOnSelect: true,
      vertical: false,
      mobileFirst: false
    });  
  });
});
//Cazando dislike
$(document).on('click', '#dislike_request', function (event) {
  event.preventDefault();
  $.post({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: $('#url-dislike').val(),
    data: {}
    //Lanzar evento en el controlador
  }).done(function (response) {

    $('#photo-gallery').html(response);

    $('.slider-content').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      autoplay: true,
      autoplaySpeed: 5000,
      asNavFor: '.slider-nav',
      mobileFirst: false
    });
    $('.slider-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.slider-content',
      dots: false,
      centerMode: true,
      focusOnSelect: true,
      vertical: false,
      mobileFirst: false
    });
  });
});
//Collapse settings panel a la izquierda de home
$(document).on('click', '.collapse-btn', function () {
  
  $('#settings').toggle();
  
});
//Slider edad - settings
$(function () {
  $("#slider-range").slider({
    range: true,
    min: 18,
    max: 90,
    values: [$('#rango_edad_min').val(), $('#rango_edad_max').val()],
    slide: function (event, ui) {
      $("#rango_edad").val(ui.values[0] + " años - " + ui.values[1] + " años");
      $("#rango_edad_min").val(ui.values[0]);
      $("#rango_edad_max").val(ui.values[1]);
    }
  });
  $("#rango_edad").val($("#slider-range").slider("values", 0) +
    " años - " + $("#slider-range").slider("values", 1) + " años");
});
//Bloqueo de la tecla enter
$(document).bind('keypress', '#formatted_address', function(e)
{
   if(e.keyCode == 13)
   {
      return false;
   }
});
//Alerts
$(document).ready(function(){

  $('.alert-success').fadeIn().delay(3000).fadeOut();
  $('.alert-danger').fadeIn().delay(3000).fadeOut();

});

/* function loadScript(src,callback){
  
  var script = document.createElement("script");
  script.type = "text/javascript";
  if(callback)script.onload=callback;
  document.getElementsByTagName("head")[0].appendChild(script);
  script.src = src;
} */

/* $(document).on('click', '#submit-settings', function (event) {
  event.preventDefault();
    $.post({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: $('#url-settings').val(),
      data: {
        place_id: $('#place_id').val(),
        formatted_address: $('#formatted_address').val(),
        lat: $('#lat').val(),
        lng: $('#lng').val(),
        rango_edad_min: $('#rango_edad_min').val(),
        rango_edad_max: $('#rango_edad_max').val(),
        muestrame: $('input[name=muestrame]:checked', '#myForm').val(),
      }
    })
}); */
