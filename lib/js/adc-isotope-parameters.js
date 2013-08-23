// Author: Cindy Brummer
// Date: July 16, 2013
// Description: Isotope script, scrubbed for WordPress theme.
// Source: http://wordpress.damien.co/2012/06/wordpress-isotope-filtering-by-categories/
//

(function() {

//Keep track of control state
var $container = jQuery('#adc-grid-content'),
	defaultState = {
		gender : '',
		care: '',
		provider: '',
		specialty : '',
		location : '',
		loc: [ ],
		option: [ ]
	},
	state = jQuery.extend(true, {}, defaultState);
	
var get_filter = function() {
	var filter = '';
	for(var i in state) {
		var val = state[i];
		if (jQuery.isArray(val)) {
			filter += val.join('');
		} else {
			filter += val;
		}
	};
	return filter || '*';
};

var watch_select = function(selector, stateKey) {
	jQuery(selector).change(function() {
		state[stateKey] = "";
		jQuery(selector + " option:selected").each(function () {
			state[stateKey] += this.value == '*' ? '' : this.value;
		});
		jQuery.bbq.pushState(state);
		$container.isotope({ filter: get_filter() });	
	});
}
	
//Set initial isotope settings
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

jQuery('#filters input[type="checkbox"]').change(function(){
	var $this = jQuery(this),
		name = $this.attr('name'),
		value = $this.val();

	var filter = state[name] || [];		
	if ($this.attr("checked")) {
		filter.push(value);
	} else {
		filter = jQuery.grep(filter, function(val) { return val != value; });  
	}
		
	state[name] = filter;
	jQuery.bbq.pushState(state);
	$container.isotope({ filter: get_filter() });
});

watch_select("#adc-specialty-select", "specialty");
watch_select("#adc-location-select", "location");

jQuery('#adc-clear-filters').click(function () {
	jQuery("#adc-location-select")[0].selectedIndex = 0;
	jQuery("#adc-specialty-select")[0].selectedIndex = 0;
	jQuery(".multiselect input[type='checkbox']").prop('checked', false);
	jQuery("#filters .multiselect-on").removeClass("multiselect-on");
	jQuery(".multiselect input[name='gender']:first").prop('checked', true);
	jQuery(".multiselect input[name='care']:first").prop('checked', true);
	
	state = jQuery.extend(true, {}, defaultState);
	jQuery.bbq.pushState(state);
	$container.isotope({ filter: get_filter() });	
	event.preventDefault();
	return false;
});

jQuery(window).bind('hashchange', function(e) {
	var newState = jQuery.extend(true, {}, defaultState, e.getState());
	if (newState.gender != state.gender) {
		state.gender = newState.gender;
		jQuery("input[name='gender'][value='" + state.gender + "']").attr('checked', true);
	}
	if (newState.care != state.care) {
		state.care = newState.care;
		jQuery("input[name='care'][value='" + state.care + "']").attr('checked', true);
	}
	if (newState.specialty != state.specialty) {
		state.specialty = newState.specialty;
		jQuery("#adc-specialty-select").val(state.specialty);
	}
	if (newState.location != state.location) {
		state.location = newState.location;
		jQuery("#adc-location-select").val(state.location);
	}
	if (newState.loc != state.loc) {
		state.loc = newState.loc;
		jQuery.bindCheckboxes("input[name='loc']", state.loc);
	}
	if (newState.option != state.option) {
		state.option = newState.option;
		jQuery.bindCheckboxes("input[name='option']", state.option);
	}
	$container.isotope({ filter: get_filter() });	
});


jQuery(window).trigger('hashchange');


//jQuery(window).smartresize(function(){
//  $container = $container || jQuery('#adc-grid-content');
//  $container.isotope({
    // update columnWidth to a percentage of container width
//    fitRows: { columnWidth: $container.width() / 3 }
//  });
//});

})();