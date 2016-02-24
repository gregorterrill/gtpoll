;(function($) {

  //when the user submits the poll, create a cookie to indicate we've already completed the form
  $('.gtPoll__form').on('submit', function(e) {
    var pollId = $(this).find('input[name="poll"]').val(),
        cookieName = 'poll' + pollId + 'complete';
    
    document.cookie = cookieName + '=true';
    $(this).submit();
  });

  // for each poll on the page, check if the user has already completed it
  $('.gtPoll__form').each(function(e) {

    var pollId = $(this).find('input[name="poll"]').val(),
        cookieName = 'poll' + pollId + 'complete',
        re = new RegExp(cookieName + "=([^;]+)"),
        cookieValue = re.exec(document.cookie);
        
    if (cookieValue) {
      cookieValue = unescape(cookieValue[1]);
    }

    //if the cookie is set, make the poll inactive
    if (cookieValue === 'true') {
      $(this).parents('.gtPoll').removeClass('gtPoll--active').addClass('gtPoll--inactive');
    }
  });

  // animate the result bars
  setTimeout(function() {
    $('.gtPoll__result-bar').each(function() {
      $(this).css('width', $(this).data('percentage') + '%');
    }); 
  }, 500);

})(jQuery);