/*
  jquery.popline.justify.js 1.0.0

  Version: 1.0.0
  Updated: Sep 10th, 2014

  (c) 2014 by kenshin54
*/
;(function($) {

  $.popline.addButton({
    subuper: {
      iconClass: "fa fa-cogs",
      mode: "edit",
      buttons: {
        upper: {
          iconClass: "fa fa-superscript",
          action: function(event, popline) {
            document.execCommand("superscript");
          }
        },
        sub: {
          iconClass: "fa fa-subscript",
          action: function(event, popline) {
            document.execCommand("subscript");
          }
        }
      }
    }
  });
})(jQuery);
