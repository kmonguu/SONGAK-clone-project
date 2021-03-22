
jQuery.ajaxSetup({cache:false});
// browser check
var isie6 = (navigator.userAgent.toLowerCase().indexOf('msie 6') != -1);

$.fn.slideBox = function (option) {
	var opt = $.extend({
			animation : 500,
			interval : 3000
		}, option);

	$(this).each(function(){
		var $container = $(this),
			$items = $('.item', $container),
			isImage = $items.is('a'),
			w, h,
			bannerIndex = 1,
			maxPaging = $items.length,
			action = true;

		if (isImage) {
			w = parseInt($items.find('img').width());
			h = parseInt($items.find('img').height());
		} else {
			w = parseInt($items.width());
			h = parseInt($items.height());
		}

		if ($items.length == 0) {return false;}

		var paginate = function() {
			var setPaginate = $('<div class="paginate"></div>');
			if (maxPaging > 0) {
				for (var i = 0 ; i < (maxPaging); i++) {
					var btn = $('<button type="button"></button>');
					setPaginate.append(btn);
					if (i == 0) { setPaginate.find('button').eq(0).addClass('on') }
				}
			}
			$container.append(setPaginate);
		};


		paginate();

		var $animationController = $('.banner', $container);
		var $mask = $('<div style="overflow:hidden; position:relative; width:' + w + 'px; height:' + h + 'px">');
		$animationController.wrap($mask);

		$animationController.css('width', w * maxPaging + 'px');
		$items.css('float','left');

		var autorun = function(){
			if (!action) return;

			$animationController.stop().animate({'marginLeft':'-' + w * bannerIndex + 'px'}, opt.animation);
			$container.find('.paginate button').removeClass('on').eq(bannerIndex).addClass('on');
			(bannerIndex >= (maxPaging - 1)) ? bannerIndex = 0 : bannerIndex += 1;

			setTimeout(function() {autorun()}, opt.interval);
		};

		if (action) {
			setTimeout(function() {autorun()}, opt.interval);
			//setInterval(function() {autorun()}, opt.interval);
			$animationController.hover(
				function(){action = false;},
				function(){action = true;}
			);
		}

		$container.find('.paginate button').click(function() {
			bannerIndex = $(this).index();
			$animationController.stop().animate({'marginLeft':'-' + w * bannerIndex + 'px'}, opt.animation);
			$container.find('.paginate button').removeClass('on').eq(bannerIndex).addClass('on');
			(bannerIndex >= (maxPaging - 1)) ? bannerIndex = 0 : bannerIndex += 1;
		});

		var iphoneChk = navigator.userAgent.toLowerCase().indexOf('iphone') != -1,
			ipod = navigator.userAgent.toLowerCase().indexOf('ipod') != -1,
			ipad = navigator.userAgent.toLowerCase().indexOf('ipad') != -1;

		var pX = 0;
		var endpX = 0;

	    if (iphoneChk || ipod || ipad){
	    	$animationController[0].ontouchstart = function(event) {
	    		var touch = event.touches[0];
	    		pX = touch.pageX;
	    	};

	    	$animationController[0].ontouchmove = function(event) {
	    		var touch = event.touches[0];
	    		endpX = touch.pageX;
	    	};

	    	$animationController[0].ontouchend = function(event) {
	    		if (Math.abs(pX - endpX) > 50) {
	    			if ((pX - endpX) < 0) {
						bannerIndex == 0 ? bannerIndex = maxPaging - 1 : bannerIndex -= 1;
	    			} else {
	    				(bannerIndex >= (maxPaging - 1)) ? bannerIndex = 0 : bannerIndex += 1;
					}
		    		$animationController.stop().animate({'marginLeft':'-' + w * bannerIndex + 'px'}, opt.animation);
					$container.find('.paginate button').removeClass('on').eq(bannerIndex).addClass('on');
				}
	    	}
	    }
	});


}

// Google Analytics 2012.9.12 KJH
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-34563949-1']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
