/*
Author @ Eric@Reinsmidt.com
This file changes the visibility of an image div.
This file creates a div dynamically from a mouse click if it does not already exist.
An image is added to the div based on information passed from the click event.
The image is overlaid on the webpage using a modal dialog as to draw the user's
attention directly to the image.
If the webpage is clicked after a modal dialog image is shown, the modal dialog image
is once again made invisible, allowing the user to choose a different image to view.
*/

$(window).resize(function() {
	$('#shadow').css('width', $(window).width()); // set shadow back to window width
	$('#shadow').css('height', $(window).height()); // set shadow back to window height
});

var spinner = new Image();
spinner.src = './spinner.gif'; // preload .gif used to show 'loading' image
function img_over(e, i) {
	if ($('#'+e).length == 0) { // if div doesn't exist create
		popspinner(); // show spinner until image is loaded
		var img = new Image();
		img.src = './images/'+i;
		img.onload = function() { // wait until img loads to add div to body and then call func to show
		  $('body').append('<div class=\'img_div\' id=\''+e+'\'><img src=\'./images/'+i+'\' /></div>');
		  popit(e);
		}
	}
	else { // div exists, call func to show
		popit(e);
	}
}
function popit(e) {
	$('#shadow').css('width', $(window).width()); // set shadow back to window width
	$('#shadow').css('height', $(window).height()); // set shadow back to window height
	$('#spinner').hide(); // hide spinner div
	if ($(window).width() > $('#'+e).outerWidth() + 100) { // image fits with >= 50px margin
		$('#'+e).css({'top': 50, 'left': ($(window).width() - $('#'+e).outerWidth()) / 2}); // position image div
	}
	else { // image larger than window, give 5px left margin
		$('#'+e).css({'top': 50, 'left': 50}); // position image div
	}
	$('#'+e).fadeIn("slow"); // fade in in image div
	$('#shadow').css('width', $(document).width() + 50); // set shadow to total width + 50px after after image is added
	$('#shadow').css('height', $(document).height() + 50); // set shadow to total height + 50px after after image is added
	$('#shadow').fadeTo("slow", .75); // fade in shadow to 75% opacity
	$('#shadow, #'+e).click(function() { // add funcs to divs when visible
		$('#'+e).fadeOut("slow"); // fade out image div
		$('#shadow').fadeOut("slow"); // fade out shadow
	});
}
function popspinner() {
	$('#spinner').css({'top': $('#wrapper').outerHeight() / 2 + 50, 'left': ($(window).width() - $('#spinner').outerWidth()) / 2}); // position spinner div
	$('#spinner').fadeIn("slow"); // fade in in spinner div
	$('#shadow').css('height', $(document).height()); // set shadow to total height after after image is added
	$('#shadow').fadeTo("slow", .75); // fade in shadow to 75% opacity
}