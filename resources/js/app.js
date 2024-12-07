// Axios
import "./libs/axios";

// AlpineJS
import "./libs/alpine";

// Font Awesome
import "./libs/fontawesome";

// SweetAlert2
import "./libs/swal";

// Flowbite
import "./libs/flowbite/index";

// Tailwind Theme Selector
import "./tw-theme-selector";

try {
	// Setting user language
	window.lang = (window.navigator.userLanguage || window.navigator.language);
} catch (e) {
	console.error(e);
}
