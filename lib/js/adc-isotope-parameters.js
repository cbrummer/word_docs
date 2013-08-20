// Author: Cindy Brummer
// Date: July 16, 2013
// Description: Isotope script, scrubbed for WordPress theme.
// Source: http://wordpress.damien.co/2012/06/wordpress-isotope-filtering-by-categories/
//

(function() {

//Keep track of control state
var $container = jQuery('#adc-grid-content'),
	state = {
		gender : '',
		care: '',
		provider : '',
		specialty : '',
		location : ''
	};
	
var get_filter = function() {
	var filter = '';
	for(var i in state) {
		filter += state[i];
	};
	return filter || '*';
};
	
//Set initial isotope settings
jQuery(function(){
	$container = $container || jQuery('#adc-grid-content');
	$container.isotope({
		itemSelector : '.adc-provider',
		filter: get_filter(),         
		animationOptions: {             
			duration: 750,             
			easing: 'linear',             
			queue: false        
			}, 
		layoutMode : 'categoryRows',
		categoryRows : {
			gutter : 20,
			height : 420,
		},
		getSortData : {
			category : function( $elem ) {
			  return $elem.attr('data-category');
			}
		},
		sortBy: 'category'
	});
});

jQuery(".multiselect").multiselect();

jQuery.removeExtraFilterOptions('.adc-provider', '#filters option');

//This next section binds events to sync isotope with the filter controls.
jQuery('#filters input[type="radio"]').change(function(){
	var $this = jQuery(this),
		name = $this.attr('name'),
		value = $this.val();
		
	state[name] = value;
	jQuery.bbq.pushState(state);
	$container.isotope({ filter: get_filter() });
});

jQuery("#adc-specialty-select").change(function(){
	state.specialty = "";
	jQuery("#adc-specialty-select option:selected").each(function () {
		state.specialty += $(this).val();
	});
	jQuery.bbq.pushState(state);
	$container.isotope({ filter: get_filter() });	
});

jQuery("#adc-location-select").change(function(){
	state.location = "";
	jQuery("#adc-location-select option:selected").each(function () {
		state.location += $(this).val();
	});
	jQuery.bbq.pushState(state);
	$container.isotope({ filter: get_filter() });	
});

jQuery('#adc-clear-filters').click(function () {
	jQuery("#adc-location-select")[0].selectedIndex = 0;
	jQuery("#adc-specialty-select")[0].selectedIndex = 0;
	jQuery(".multiselect input[type='checkbox']").prop('checked', false);
	jQuery("#filters .multiselect-on").removeClass("multiselect-on");
	jQuery(".multiselect input[type='radio']:first").prop('checked', true);
	
	state.gender = state.provider = state.specialty = state.location = '';
	$container.isotope({ filter: get_filter() });	
	event.preventDefault();
	return false;
});


//jQuery(window).smartresize(function(){
//  $container = $container || jQuery('#adc-grid-content');
//  $container.isotope({
    // update columnWidth to a percentage of container width
//    fitRows: { columnWidth: $container.width() / 3 }
//  });
//});

})();