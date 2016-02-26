;(function($) {

  //animate the bars into their percentage (and if there's an answer id, increment it first)
  var animatePollBars = function($poll, answerId) {
      var $bars = $poll.find('.gtPoll__result-bar');

      $bars.each(function() {

        var $bar = $(this),
            $text = $bar.prev('.gtPoll__result-info');

        //if THIS is the answer we're incrementing, its votes go up
        if ($bar.attr('data-answer') == answerId) {
          $bar.attr('data-votes', parseInt($bar.attr('data-votes')) + 1 );
          $text.find('.gtPoll__result-responses').html($bar.attr('data-votes'));
        }

        //if we're incrementing ANY answer, the total goes up and we recalc percentage
        if (answerId) {
          $bar.attr('data-total', parseInt($bar.attr('data-total')) + 1 );
          $bar.attr('data-percentage', ((parseInt($bar.attr('data-votes')) / parseInt($bar.attr('data-total'))) * 100).toFixed(2) );
          $text.find('.gtPoll__result-percentage').html($bar.attr('data-percentage'));
        }

        $bar.css('width', $bar.attr('data-percentage') + '%');
      });
  };

  //when the user submits the poll, create a cookie to indicate we've already completed the form
  $('.gtPoll__form').on('submit', function(e) {
    e.preventDefault();

    var $form = $(this),
        $poll = $form.parents('.gtPoll'),
        pollId = $form.find('input[name="poll"]').val(),
        answerId = $form.find('input[type="radio"]').val(),
        actionURL = $form.find('input[name="action"]').val(),
        cookieName = 'poll' + pollId + 'complete',
        data = $form.serialize()

    //submit via an AJAX call
    $.post(actionURL, function(data, response) {

      //flip the card
      $poll.removeClass('gtPoll--active').addClass('gtPoll--inactive');
      //animate the poll bars after the flip (should use onTransEnd for this)
      setTimeout(function() {
        animatePollBars($poll, answerId);
      }, 500);
      //set the cookie to indicate the poll has been completed
      document.cookie = cookieName + '=true';
    });
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

  // if poll is inactive on load, animate in the result bars
  if ($('.gtPoll--inactive').length) {
    setTimeout(function() {
      $('.gtPoll--inactive').each(function() {
        animatePollBars($(this));
      });
    }, 500);
  }

})(jQuery);