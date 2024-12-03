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

const themeSelector = {
	toDark: (targetElement) => {
		if (targetElement && targetElement instanceof HTMLElement)
			targetElement.setAttribute('data-tw-theme', 'dark');
		else
			document.documentElement.setAttribute('data-tw-theme', 'dark')
	},
	toLight: (targetElement) => {
		if (targetElement && targetElement instanceof HTMLElement)
			targetElement.setAttribute('data-tw-theme', 'light');
		else
			document.documentElement.setAttribute('data-tw-theme', 'light')
	},
	clear: (targetElement) => {
		if (targetElement && targetElement instanceof HTMLElement)
			targetElement.removeAttribute('data-tw-theme');
		else
			document.documentElement.setAttribute('data-tw-theme', 'none')
	},
};

onReady(() => {
	// Sets the initial theme.
	document.documentElement.setAttribute('data-tw-theme', 'none');

	// Checks if the user has a preferred theme.
	let localPreference = localStorage.getItem('tw-theme');

	// If there's a local preference, set the theme to the preferred theme.
	// Otherwise, just use the preferred color scheme (media query).
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

	// Listen for changes to the preferred theme (local storage).
	// Allows for manual theme selection.
	window.addEventListener('storage', (event) => {
		if (event.key !== 'tw-theme') return;

		switch (event.newValue) {
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
	});

	// Listen for changes to the theme dictated by the html attribute (data-tw-theme).
	// Allows for manual theme selection.
	let observer = new MutationObserver((mutation) => {
		if (mutation.type !== 'attributes' || mutation.attributeName !== 'data-tw-theme') return;

		// Update the local storage with the new theme. In doing so, the storage event listener
		// will be triggered and the theme will be set accordingly.
		let newValue = document.documentElement.getAttribute('data-tw-theme');
		if (!['dark', 'light'].includes(newValue))
			localStorage.setItem('tw-theme', newValue);
		else
			localStorage.removeItem('tw-theme');
	});
});

// Exposes the onReady function and the themeSelector object to the global scope.
window.onReady = onReady;
window.themeSelector = themeSelector;
