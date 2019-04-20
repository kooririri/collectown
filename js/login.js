$(function() {
  $('#login-show').click(function() {
    $('#login-modal').fadeIn();
  });

  $('.signup-show').click(function() {
    $('#signup-modal').fadeIn();
  });

  $('.close-modal').click(function() {
    $('#login-modal').fadeOut();
    $('#signup-modal').fadeOut();
  });

  $('#login').on('click', function(){
    var username = $('#loginmail').val();
    var password = $('#loginpass').val();
  })
});
