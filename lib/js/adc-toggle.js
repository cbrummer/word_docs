// Author: Cindy Brummer
// Date: April 3, 2012
// Description: Rewritten 'adc-toggle.js' for the 'twentyeleven-child'
// WordPress theme.
//

jQuery(document).ready(function() {
  jQuery(".toggle-list dd").hide();
  //toggle the componenet with class msg_body
  jQuery("dt").click(function()
  {
    jQuery(this).toggleClass("expanded").next("dd").slideToggle(500);
  });
});