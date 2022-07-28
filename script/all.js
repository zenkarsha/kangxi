var countdown = Date.now(),
    currentTime = Date.now();

$(document).ready(function(){

  $('.ellipsis').dotdotdot();

  //choose background
  $(".bgItem").click(function() {
    $(this).find("input").attr("checked","checked");
    $('#styleandform').val($(this).find("input").val());
    $(".bgItem").removeClass("checked");
    $(this).addClass("checked");
    var bgver=$(this).find("input").val();
    if(bgver=="bamboo") { $(".sizeSelector").css("display","none"); }
    else { $(".sizeSelector").css("display","block"); }
    createImage();
  });

  //text size
  $(".sizeItem").click(function() {
    $(this).find("input").attr("checked","checked");
    $('#sizeandform').val($(this).find("input").val());
    $(".sizeItem").removeClass("checked");
    $(this).addClass("checked");
    createImage();
  });

  //form submit
  $("#kxgenSubmit").click(function() {
    $('#directpost').val('');
    $('#kxgenForm').attr("target","_self").submit();
  });
  $("#facebookSubmit").click(function() {
    $('#directpost').val('1');
    $('#kxgenForm').attr("target","_blank").submit();
  });

  createImage();

  //source string event
  $("#usertext").on('blur', function() {
    createImage();
  });
  $("#usertext").on('keydown', function() {
    countdown = Date.now();
  });
  $("#usertext").on('keyup', function() {
    setTimeout(function(){
      currentTime = Date.now();
      if((currentTime - countdown) >= 240 ) {
        $('#loading').show();
        createImage();
      }
    }, 250);
  });
  $('#vertical,#shadow').change(function() {
    createImage();
  });

  $("#show").click(function() {
    $(".preview").toggle();
  });
});


//ajax function
function createImage()
{
  //$('#coverprint').hide();
  $('#loading').show();
  $.ajax({
    url: 'ajax',
    dataType: 'html',
    type:'POST',
    data: {
      usertext: $("#usertext").val(),
      vertical: $("#vertical").prop('checked'),
      shadow: $("#shadow").prop('checked'),
      styleandform: $("#styleandform").val(),
      sizeandform: $("#sizeandform").val()
    },
    error: function(xhr){
      // alert(xhr);
    },
    success: function(response){
      $('#coverprint').html(response).promise().done(function(){
        $('#loading').fadeOut();
      });
    }
  });
}

// scroll to top
$(window).scroll(function (event) {
  var scroll = $(window).scrollTop();
  var height = $(window).height();
  if(scroll > height*0.5)
    $('.gototop').show();
  else
    $('.gototop').hide();
});
$('.gototop').click(function(){
  $('html,body').animate({scrollTop: 0},'fast');
});
