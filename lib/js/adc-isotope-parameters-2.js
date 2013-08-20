// Author: Cindy Brummer
// Date: July 16, 2013
// Description: Isotope script, scrubbed for WordPress theme.
// Source: http://wordpress.damien.co/2012/06/wordpress-isotope-filtering-by-categories/
//

(function() {
var 
	gender = '',
	provider = '',
	specialty = '',
	location = '',
	$container = jQuery('#adc-grid-content'),
	allClasses = { "*" : 1};
	
var get_filter = function() {
	var filter = gender + provider + specialty + location;
	return filter || '*';
};
	
jQuery(function(){
	$container = $container || jQuery('#adc-grid-content');
	$container.isotope({
		itemSelector : '.adc-service',
		filter: get_filter(),         
		animationOptions: {             
			duration: 750,             
			easing: 'linear',             
			queue: false        
			}, 
		layoutMode : 'fitRows',
		//fitRows : {
			//gutter : 10,
			//height : 200,
		//},
		getSortData : {
			category : function( $elem ) {
			  return $elem.attr('data-category');
			}
		},
		sortBy: 'category'
	});
});

// filter items when filter link is clicked
jQuery('#filters input[type="radio"]').change(function(){
	gender = jQuery(this).attr('value');
	jQuery('#adc-grid-content').isotope({ filter: get_filter() });
	return false;
});

jQuery('.adc-service').each(function () {
	var classes = this.className.split(/\s+/);
	for (var i in classes) {
		allClasses['.' + classes[i]] = 1;
	}
});

jQuery('#filters option').each(function() {
	var $this = jQuery(this),
		val = $this.val();
	if (!val)
		return;
	if (!allClasses[val]) {
		$this.remove();
	}
});



var filter = [];

jQuery(function(){
		jQuery("#adc-specialty-select").change(function(){
			specialty = "";
			jQuery("#adc-specialty-select option:selected").each(function () {
			specialty += $(this).val();
			});
			$container.isotope({ filter: get_filter() });	
		}
	)
});

jQuery(function(){
		jQuery("#adc-location-select").change(function(){
			location = "";
			jQuery("#adc-location-select option:selected").each(function () {
			location += $(this).val();
			});
			$container.isotope({ filter: get_filter() });	
		}
	)
});

jQuery('#adc-clear-filters').click(function () {
	jQuery("#adc-location-select")[0].selectedIndex = 0;
	jQuery("#adc-specialty-select")[0].selectedIndex = 0;
	jQuery(".multiselect input[type='checkbox']").prop('checked', false);
	jQuery("#filters .multiselect-on").removeClass("multiselect-on");
	jQuery(".multiselect input[type='radio']:first").prop('checked', true);
	gender = provider = specialty = location = '';
	$container.isotope({ filter: get_filter() });	
	event.preventDefault();
	return false;
});

jQuery(function() {
	jQuery(".multiselect").multiselect();
});

//jQuery(window).smartresize(function(){
//  $container = $container || jQuery('#adc-grid-content');
//  $container.isotope({
    // update columnWidth to a percentage of container width
//    fitRows: { columnWidth: $container.width() / 3 }
//  });
//});

})();