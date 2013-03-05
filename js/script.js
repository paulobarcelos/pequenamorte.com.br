$(function() {

	$body = $('body');

	$('#menu-main .menu-item a').on('mouseenter', function(e){
		var index = $(this).parent().index() + 1;
		$body.addClass('hovering');
		$body.addClass('hover-mod-two-' + (index % 2 + 1));
		$body.addClass('hover-mod-three-' + (index % 3 + 1));
		$body.addClass('hover-mod-four-' + (index % 4 + 1));
		$body.addClass('hover-mod-five-' + (index % 5 + 1));
	});

	$('#menu-main .menu-item a').on('mouseout', function(e){
		var index = $(this).parent().index() + 1;
		$body.removeClass('hovering');
		$body.removeClass('hover-mod-two-' + (index % 2 + 1));
		$body.removeClass('hover-mod-three-' + (index % 3 + 1));
		$body.removeClass('hover-mod-four-' + (index % 4 + 1));
		$body.removeClass('hover-mod-five-' + (index % 5 + 1));
	});
});