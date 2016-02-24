(function($){

  $('.gtPoll__reset').on('click', function(e) {
    e.preventDefault();

    if (confirm('About to reset all response counts for this poll. This cannot be undone. Continue?')) {
      window.location.href = $(this).attr('href');
    } 
  });

})(jQuery);