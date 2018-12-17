jQuery(document).ready(function($) {

	// The number of the next page to load (/page/x/).
	var pageNum = parseInt(pbd_alp.startPageLatestGrid) + 1;
	
	// The maximum number of pages the current query can return.
	var max = parseInt(pbd_alp.maxPagesLatestGrid);
	
	// The link of the next page of posts.
	var nextLink = pbd_alp.nextLinkLatestGrid;
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
	if(pageNum <= max) {
		// Insert the "More Posts" link.
		$('.latest-ads-holder')
			.append('<p id="pbd-alp-load-posts" class="full"><a href="#">Load the next 8 ads...</a></p>');
			
		// Remove the traditional navigation.
		$('.pagination').remove();
	}
	
	
	/**
	 * Load new posts when the link is clicked.
	 */
	$('.latest-ads-holder #pbd-alp-load-posts a').click(function() {
	
		// Are there more posts to load?
		if(pageNum <= max) {
		
			// Show that we're working.
			$(this).text('Loading ads...');

			$.get(nextLink, function(data){ 

			  	var $newItems = $(data).find('.latest-posts-grid')

				$('.latest-ads-grid-holder').append( $newItems );

				// Update page number and nextLink.
				pageNum++;
				nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);
						
				// Update the button message.
				if(pageNum <= max) {
					$('#pbd-alp-load-posts a').text('Load the next 8 ads...');
				} else {
					$('#pbd-alp-load-posts a').text('No more ads to load.');
				}

			});

		} else {
			$('#pbd-alp-load-posts a').append('.');
		}	
		
		return false;
	});
});