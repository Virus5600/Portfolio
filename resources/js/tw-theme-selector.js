/**
 * Execute a function when the DOM is ready. A replacement for jQuery's `$(document).ready()`
 * function which is called when the DOM is fully loaded.
 *
 * @param {callable} callable A function to be called when the DOM is ready.
 */
function onReady(callable) {
	document.addEventListener('DOMContentLoaded', callable);
}

function preferredTheme() {
	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function updateTheme() {
	// Check first if the user has a preferred theme.
	let localPreference = localStorage.getItem('tw-theme');

	// If there's a local preference, set the theme to the preferred theme.
	// Otherwise, just let the preferred color scheme (media query) take over.
	if (localPreference) {
		switch (localPreference) {
			case 'dark':
				themeSelector.toDark();
				break;
			case 'light':
				themeSelector.toLight();
				break;
			default:
				themeSelector.clear();
				break;
		}
	}
}

const themeSelector = {
	toDark: () => document.documentElement.setAttribute('data-tw-theme', 'dark'),
	toLight: () => document.documentElement.setAttribute('data-tw-theme', 'light'),
	clear: () => document.documentElement.setAttribute('data-tw-theme', 'none'),
};

onReady(() => {
	// Sets the initial theme.
	document.documentElement.setAttribute('data-tw-theme', 'none');

	updateTheme();

	// Listen for changes to the preferred theme (local storage).
	// Allows for manual theme selection.
	window.addEventListener('storage', (event) => {
		if (event.key !== 'tw-theme') return;
		updateTheme();
	});

	// Listen for changes to the theme dictated by the html attribute (data-tw-theme).
	// Allows for manual theme selection.
	let observer = new MutationObserver((mutation) => {
		mutation = mutation[0];

		if (mutation.type !== 'attributes' || mutation.attributeName !== 'data-tw-theme') return;

		// Update the local storage with the new theme. In doing so, the storage event listener
		// will be triggered and the theme will be set accordingly.
		let newValue = document.documentElement.getAttribute('data-tw-theme').toLowerCase();
		if (['dark', 'light'].includes(newValue))
			localStorage.setItem('tw-theme', newValue);
		else
			localStorage.removeItem('tw-theme');
	});

	observer.observe(document.documentElement, {
		attributes: true,
		attributeFilter: ['data-tw-theme'],
	});
});

// Exposes the onReady function and the themeSelector object to the global scope.
window.onReady = onReady;
window.themeSelector = themeSelector;
