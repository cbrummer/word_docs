(function() {

  // categoryRows custom layout mode
  $.extend( $.Isotope.prototype, {
  
    _categoryRowsReset : function() {
      this.categoryRows = {
        x : 0,
        y : 0,
        height : 0,
        currentCategory : null
      };
    },
  
    _categoryRowsLayout : function( $elems ) {
      var instance = this,
          containerWidth = this.element.width(),
          sortBy = this.options.sortBy,
          props = this.categoryRows;
      
      $elems.each( function() {
        var $this = $(this),
            atomW = $this.outerWidth(true),
            atomH = $this.outerHeight(true),
            category = $.data( this, 'isotope-sort-data' )[ sortBy ],
            x, y;
      
        if ( category !== props.currentCategory ) {
          // new category, new row
          props.x = 0;
          props.height += props.currentCategory ? instance.options.categoryRows.gutter : 0;
          props.y = props.height;
          props.currentCategory = category;
        } else if ( props.x !== 0 && atomW + props.x > containerWidth ) {
          // if this element cannot fit in the current row
          props.x = 0;
          props.y = props.height;
        } 
      
        // position the atom
        instance._pushPosition( $this, props.x, props.y );
  
        props.height = Math.max( props.y + atomH, props.height );
        props.x += atomW;
  
      });
    },
  
    _categoryRowsGetContainerSize : function () {
      return { height : this.categoryRows.height };
    },
  
    _categoryRowsResizeChanged : function() {
      return true;
    }
  
  });
  
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
					checkbox.parent().addClass("multiselect-on");
				} else {
					checkbox.parent().removeClass("multiselect-on");
				}
			});
		});
	});
};

//Generate a mapping of all item attributes to sync the dropdown list with elements that are actually on the page
//If there aren't any red blocks, then hide the red filter option
jQuery.removeExtraFilterOptions = function(blockSelector, optionSelector)  {
	var allClasses = { "*" : 1};  //Add * so we don't remove the default options from the dropdowns
	jQuery(blockSelector).each(function () {
		var classes = this.className.split(/\s+/);
		for (var i in classes) {
			allClasses['.' + classes[i]] = 1;
		}
	});
	
	jQuery(optionSelector).each(function() {
		var $this = jQuery(this),
			val = $this.val();
		if (!val)
			return;
		if (!allClasses[val]) {
			$this.remove();
		}
	});
};



})();