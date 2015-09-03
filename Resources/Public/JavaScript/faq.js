$.fn.faq = function (settings) {
	var defaults = {
		'element': 'li',
		'header': '.header',
		'content': '.content',
		'ratingUp': '.rating a.up',
		'ratingDown': '.rating a.down',
		'ratingList': 'ul.rating',
		'messageWrap': $('<p class="blue" />')
	};
	var options = $.extend(true, defaults, settings);

	return this.each(function () {
		var $that = $(this), $li = $that.find(options.element);

		$li.each(function () {
			var $eachLi = $(this), $header = $eachLi.find(options.header), $content = $eachLi.find(options.content), $linkUp = $content.find(options.ratingUp), $linkDown = $content.find(options.ratingDown), $msgWrp = options.messageWrap;

			$header.click(function () {
				jQuery(this).toggleClass('act');
				$content.slideToggle('fast');
			});

			// top rating
			$linkUp.click(function (event) {
				event.preventDefault();

				var questionUid = $(this).attr('data-uid');

				$.ajax({
					url: '/?eID=FaqTopFlop&mode=top&question=' + questionUid, dataType: 'json', success: function (data) {
						var message = $msgWrp.html(data.description);
						$content.find(options.ratingList).replaceWith(message);
					}
				});
			});

			// flop rating
			$linkDown.click(function (event) {
				event.preventDefault();

				var questionUid = $(this).attr('data-uid');

				jQuery.ajax({
					url: '/?eID=FaqTopFlop&mode=flop&question=' + questionUid, dataType: 'json', success: function (data) {
						var message = $msgWrp.html(data.description);
						$content.find(options.ratingList).replaceWith(message);
					}
				});
			});
		});
	});
};

jQuery(window).load(function () {
	jQuery('.ext-faq').faq();
});
