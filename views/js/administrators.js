var width = $(window).width(); //the window (only) when it opens
if (width < 1200) { 
	$('.jquery-item-3:gt(2)').hide();
	$('.show_button_admins').text("Show more");
	$('.show_button_admins').show();
} else {
   		$('.jquery-item-3:gt(2)').show();
   		$('.show_button_admins').hide();

}

//the window when it changes
$(window).on('resize', function(){
    if($(this).width() != width){
        width = $(this).width();
        console.log(width);
		if (width < 1200) { 
			$('.jquery-item-3:gt(2)').hide();
			$('.show_button_admins').text("Show more");
			$('.show_button_admins').show();
		} else {
		   	$('.jquery-item-3:gt(2)').show();
		   	$('.show_button_admins').hide();

		}
    }
});

$('.show_button_admins').on('click',function () { //button for students
	if ($(".show_button_admins:contains('Show more')").length > 0) {
		console.log("success number one");
		$('.jquery-item-3:gt(2)').show();
		$('.show_button_admins').text("Show less");
	} else if ($(".show_button_admins:contains('Show less')").length > 0) {
		console.log("success number two");
		$('.jquery-item-3:gt(2)').hide();
		$('.show_button_admins').text("Show more");
	}
});
