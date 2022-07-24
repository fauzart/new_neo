(function($) {
	"use strict";
	
	//P-scrolling
	const ps = new PerfectScrollbar('.app-sidebar', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	
	const ps1 = new PerfectScrollbar('.default-combsidebar', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	
})(jQuery);