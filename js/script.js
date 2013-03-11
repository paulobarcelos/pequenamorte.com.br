
$(function() {

	function getUrlParams () {
		var urlParams;
		var match,
			pl     = /\+/g,  // Regex for replacing addition symbol with a space
			search = /([^&=]+)=?([^&]*)/g,
			decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
			query  = window.location.search.substring(1);

		urlParams = {};
		while (match = search.exec(query))
			urlParams[decode(match[1])] = decode(match[2]);

		return urlParams;
	}

	var urlParams = getUrlParams();

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

	$('.no-touch .inner').hide().slideDown('slow');
	$('.no-touch a[href^="'+websiteUrl+'"]:not(.no-inner-slide), .no-touch a[href^="/"]:not(.no-inner-slide)').on('click', function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		$('.inner').slideUp('normal', function(){
			window.location = url;
		});
		
	});
});