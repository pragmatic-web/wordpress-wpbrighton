//
//	Wrapper function.
//
(function(){

	//
	// Intra-global variables
	//
	$ = jQuery;

	$(window).load(function(){

		//
		//	Remove the border-bottom property, margin & padding of the last post of class .hentry in any WordPress post output list
		//
		var lastPost = $('.hentry');
		var lastPostIndex = (lastPost.length - 1);
		
		//
		//	Only if there is no navigation below
		//
		if (($('#nav-below .nav-previous a').length === 0) && ($('#nav-below .nav-next a').length === 0)) {

			$(lastPost[lastPostIndex]).css('border-bottom', 'none');
			$(lastPost[lastPostIndex]).css('margin', 0);

			//
			//	Don't remove the padding on pages
			//
			if ($('.entry-utility').length === 0) {
				$(lastPost[lastPostIndex]).css('padding', 0);
			}
			
		};
		
	});
	
})();
