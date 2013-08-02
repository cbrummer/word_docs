// Author: Cindy Brummer
// Date: July 16, 2013
// Description: Isotope script, scrubbed for WordPress theme.
// Source: http://wordpress.damien.co/2012/06/wordpress-isotope-filtering-by-categories/
//
jQuery(window).load(function() {
var 
	provider = '',
	specialty = '',
	location = '',
	$container = jQuery('#adc-grid-content');
	
var get_filter = function() {
	var filter = provider + specialty + location;
	return filter || '*';
};

	
jQuery(function(){
	$container = $container || jQuery('#adc-grid-content');
	$container.isotope({
		itemSelector : '.adc-provider',
		layoutMode : 'fitRows',
		masonry: {
    		columnWidth: 250,
			rowHeight: 360
  		},
		filter: get_filter(),         
	    fitRows: { columnWidth: $container.width() / 3 },
		animationOptions: {             
			duration: 750,             
			easing: 'linear',             
			queue: false        
			} 
	});
});

// filter items when filter link is clicked
//jQuery('#filters a').click(function(){
//	var selector = jQuery(this).attr('data-filter');
//	jQuery('#adc-grid-content').isotope({ filter: selector });
//	return false;
//});

var filter = [];
jQuery.fn.multiselect = function() {
	jQuery(this).each(function() {
		var checkboxes = jQuery(this).find("input:checkbox");
		checkboxes.each(function() {
			var checkbox = $(this);
			// Highlight pre-selected checkboxes
			if (checkbox.attr("checked"))
				checkbox.parent().addClass("multiselect-on");
 
			// Highlight checkboxes that the user selects
			checkbox.click(function() {
				var value = checkbox.val();
				if (checkbox.attr("checked")) {
					filter.push(value);
					checkbox.parent().addClass("multiselect-on");
				} else {
					filter = jQuery.grep(filter, function(val) { return val != value; });  
					checkbox.parent().removeClass("multiselect-on");
				}
				provider = filter.join("");
				$container.isotope({ filter: get_filter() });
			});
		});
	});
};

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
	jQuery(".multiselect input").prop('checked', false);
	provider = specialty = location = '';
	$container.isotope({ filter: get_filter() });	
	event.preventDefault();
	return false;
});

jQuery(function() {
	jQuery(".multiselect").multiselect();
});

jQuery(window).smartresize(function(){
  $container = $container || jQuery('#adc-grid-content');
  $container.isotope({
    // update columnWidth to a percentage of container width
    fitRows: { columnWidth: $container.width() / 3 }
  });
});

})();