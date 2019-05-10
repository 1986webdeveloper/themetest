jQuery(document).ready(function ($) {
  window.startPos = window.endPos = {};

  makeDraggable(); 

  $('.drophere').droppable({
    hoverClass: 'hoverClass',
    drop: function(event, ui) {
      var $from = $(ui.draggable),
          $fromParent = $from.parent(),
          $to = $(this).children(),
          $toParent = $(this);

      window.endPos = $to.offset();

      swap($from, $from.offset(), window.endPos, 0);
      swap($to, window.endPos, window.startPos, 200, function() {
        $toParent.html($from.css({position: 'relative', left: '', top: '', 'z-index': ''}));
        $fromParent.html($to.css({position: 'relative', left: '', top: '', 'z-index': ''}));
        makeDraggable();
      });
    }
  });

  function makeDraggable() {
    $('.draghere').draggable({
      zIndex: 99999,
      revert: 'invalid',
      start: function(event, ui) {
        window.startPos = $(this).offset();
      }
    });
  }

  function swap($el, fromPos, toPos, duration, callback) {
    $el.css('position', 'absolute')
      .css(fromPos)
      .animate(toPos, duration, function() {
        if (callback) callback();
      });
  }

  $('#save_settings').on('click', function(){
    $('.error-msg').remove();
    var sections_settings = [];
    $('.section-order').each(function(){
      sections_settings.push($(this).find('.draghere').attr('id'));
    });
    var product_display = $('#product_display').val();
    var simple_text_1 = $('#simple_text_1').val();
    var simple_text_2 = $('#simple_text_2').val();
    var ajaxurl = $('#ajaxurl').val();
    var error = '';
    if(product_display == '') {
      $('.product-settings').append('<span class="error-msg">Please enter number of product display per row.');
      error = 'yes';
    } else if(product_display < 1) {
      $('.product-settings').append('<span class="error-msg">Please enter number more than 0.');
      error = 'yes';
    }

    if(simple_text_1 == '') {
      $('.simple-text-1-settings').append('<span class="error-msg">Please enter simple text 1.');
      error = 'yes';
    }
    if(simple_text_2 == '') {
      $('.simple-text-2-settings').append('<span class="error-msg">Please enter simple text 2.');
      error = 'yes';
    }
    if(error == 'yes') {
      return false;
    } else {
      $.ajax({
        type : "post",
        dataType : "json",
        url : ajaxurl,
        data : {
          action: "save_home_page_settings",
          sections_settings : sections_settings.join(),
          product_display : product_display,
          simple_text_1 : simple_text_1,
          simple_text_2 : simple_text_2
        },
        success: function(response) {
          $('#setting-error-settings_updated').html('<p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>');
          $('#setting-error-settings_updated').show();
        }
      });
    }
  });

  $(document).on('click', '.notice-dismiss', function(){
    $('#setting-error-settings_updated').hide();
  });
});