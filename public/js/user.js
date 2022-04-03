const V_TOGGLES = {
	theme: function(data) {
		let toAppend = $('<i class="fa-solid fa-xl cursor-pointer dark-mode-toggle init"></i>'),
			toggle = $('.dark-mode-toggle'),
			obj = $('#theme'),
			href = obj.attr('href'),
			theme = href.match(/style-(light|dark)/)[1];

		if (theme == 'light' && data.is_dark) {
			obj.attr('href', href.replace(/(.+)(style-)(light)(.+)/, '$1$2dark$4'));
			toAppend.addClass('fa-moon');
			$('body').removeClass('bg-white').addClass('bg-dark');
		}
		else {
			obj.attr('href', href.replace(/(.+)(style-)(dark)(.+)/, '$1$2light$4'));
			toAppend.addClass('fa-sun');
			$('body').removeClass('bg-dark').addClass('bg-white');
		}

		toggle.attr('data-to-remove', '1');
		toggle.parent().append(toAppend);
		toggle.addClass('toggle-fall position-absolute');
	},
	game: function(data) {
	}
};

$(document).ready(function() {
	// THEME TOGGLES
	$(document).on('click', '.dark-mode-toggle', () => {
		V_COOKIES.get('is_dark', (fdata) => {
			V_COOKIES.set('is_dark', !JSON.parse(fdata.value), 0, V_TOGGLES.theme);
		});
	});

	$(document).on('animationend', '.dark-mode-toggle', function() {
		let obj = $(this);

		if (obj.hasClass('init')) {
			obj.removeClass('init');
		}
		else {
			if (obj.attr('data-to-remove') == '1') {
				obj.removeClass('toggle-rise toggle-fall');
				obj.remove();
			}
		}
	});

	// GAME TOGGLE
	$(document).on('click', '.game-mode-toggle', () => {
		V_COOKIES.get('is_game', (fdata) => {
			V_COOKIES.set('is_game', !JSON.parse(fdata.value), 0);
		});
	});

	$('.game-mode-toggle').on('animationend', function() {$(this).removeClass('toggle-rise toggle-fall');});

	// NAVBAR SCROLL UPDATE
	$(window).on('scroll load resize', (e) => {
		if ($(window).width() > 992) {
			if (e.currentTarget.pageYOffset > 20)
				$('#navbar').addClass('bg-semi-dark');
			else
				$('#navbar').removeClass('bg-semi-dark');
		}
		else
			if (!$('#navbar').hasClass('bg-semi-dark'))
				$('#navbar').addClass('bg-semi-dark');
	});

	// SIDEBAR
	$('#hamburger-menu').click(function(e) {
		const obj = $(this);
		obj.toggleClass('close');
	});
});