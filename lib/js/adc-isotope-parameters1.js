// Author: Cindy Brummer
// Date: July 16, 2013
// Description: Isotope script, scrubbed for WordPress theme.
// Source: http://wordpress.damien.co/2012/06/wordpress-isotope-filtering-by-categories/
//
jQuery(document).ready(function(){
	  jQuery('#adc-grid-content').isotope({
  // options
		itemSelector : '.adc-provider',
		layoutMode : 'fitRows',
		filter: '*',         
		animationOptions: {             
			duration: 750,             
			easing: 'linear',             
			queue: false        
			} 
	});
});
// filter items when filter link is clicked
jQuery('#filters a').click(function(){
var selector = jQuery(this).attr('data-filter');
jQuery('#adc-grid-content').isotope({ filter: selector });
return false;
});