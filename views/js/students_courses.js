var width = $(window).width(); //the window (only) when it opens
if (width < 1200) { 
	$('.jquery-item-1:gt(2)').hide();
	$('.jquery-item-2:gt(2)').hide();
	$('.show_button_1').text("Show more");
	$('.show_button_2').text("Show more");
	$('.show_button_1').show();
	$('.show_button_2').show();
} else {
   		$('.jquery-item-1:gt(2)').show();
   		$('.jquery-item-2:gt(2)').show();
   		$('.show_button_1').hide();
   		$('.show_button_2').hide();
}

//the window when it changes
$(window).on('resize', function(){
    if($(this).width() != width){
        width = $(this).width();
        console.log(width);
		if (width < 1200) { 
			$('h1').text("success");
			$('.jquery-item-1:gt(2)').hide();
			$('.jquery-item-2:gt(2)').hide();
			$('.show_button_1').text("Show more");
			$('.show_button_2').text("Show more");
			$('.show_button_1').show();
			$('.show_button_2').show();
		} else {
		   		$('.jquery-item-1:gt(2)').show();
		   		$('.jquery-item-2:gt(2)').show();
		   		$('.show_button_1').hide();
		   		$('.show_button_2').hide();
		}
    }
});

$('.show_button_1').on('click',function () { //button for students
	if ($(".show_button_1:contains('Show more')").length > 0) {
		console.log("success number one");
		$('.jquery-item-1:gt(2)').show();
		$('.show_button_1').text("Show less");
	} else if ($(".show_button_1:contains('Show less')").length > 0) {
		console.log("success number two");
		$('.jquery-item-1:gt(2)').hide();
		$('.show_button_1').text("Show more");
	}
});

$('.show_button_2').on('click',function () { //button for courses
	if ($(".show_button_2:contains('Show more')").length > 0) {
		console.log("success number one");
		$('.jquery-item-2:gt(2)').show();
		$('.show_button_2').text("Show less");
	} else if ($(".show_button_2:contains('Show less')").length > 0) {
		console.log("success number two");
		$('.jquery-item-2:gt(2)').hide();
		$('.show_button_2').text("Show more");
	}
});