jQuery.noConflict();
jQuery(document).ready(function() {
	//make external links open in a new window - content div only
	jQuery('a').filter(function() {
        	return this.hostname && this.hostname !== location.hostname;
    	}).addClass("external").attr({target: "_blank"});
});