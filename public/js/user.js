$(document).ready(function() {
	$('#dark_mode_toggle').click(() => {
		cookies.get('is_dark', (data) => {cookies.set('is_dark', !JSON.parse(data.value), 0)});
	});

	$('#game_mode_toggle').click(() => {
		cookies.get('is_game', (data) => {cookies.set('is_game	', !JSON.parse(data.value), 0)});
	});
});