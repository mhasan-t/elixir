$(document).ready(function(){
	var urlPath = window.location.pathname,
    urlPathArray = urlPath.split('.'),
    tabId = urlPathArray[0].split('/').pop();
	$('#sales_people, #tasks, #contact, #leads, #opportunity, #customer_win').removeClass('active');	
	$('#'+tabId).addClass('active');


	$('div[id^="expand"]').click(function(){
		$(this).next().show();
	})

	
	/*$("#taskListing").on('click', 'span[id^="task_"]', function(){
		
		$(this).slideToggle();
	}); */

});