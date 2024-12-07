import { Collapse } from "flowbite";

/**
 * Updates the following methods of the `Collapse` class to use a
 * custom hider class:
 *
 * - `collapse`
 * - `expand`
 * - `toggle`
 *
 * Furthermore, it will prepare a new property for the 'navbar' class;
 * allowing it to have a transition effect when expanding and collapsing.
 *
 * @param {Collapse} collapseInstance
 */
function updateMethods(collapseInstance) {
	if (!collapseInstance) return;

	/**
	 * Collapses the target element.
	 * @param {string} collapseClass The class to add to the target element when collapsing.
	 */
	collapseInstance.__proto__.collapse = (function (collapseClass) {
		this._targetEl.style.setProperty('--max-collapse-height', `${this._targetEl.scrollHeight}px`);

		if (!collapseClass)
			collapseClass = this._targetEl.classList.contains('navbar-collapse') ?
				this._defaultToggleClass : 'hidden';

		this._targetEl.classList.add(collapseClass);
		if (this._triggerEl) {
			this._triggerEl.setAttribute('aria-expanded', 'false');
		}
		this._visible = false;
		// callback function
		this._options.onCollapse(this);
	});

	/**
	 * Expands the target element.
	 * @param {string} expandClass The class to add to the target element when expanding.
	 */
	collapseInstance.__proto__.expand = (function (collapseClass) {
		this._targetEl.style.setProperty('--max-collapse-height', `${this._targetEl.scrollHeight}px`);

		if (!collapseClass)
			collapseClass = this._targetEl.classList.contains('navbar-collapse') ?
				this._defaultToggleClass : 'hidden';

		this._targetEl.classList.remove(collapseClass);
		if (this._triggerEl) {
			this._triggerEl.setAttribute('aria-expanded', 'true');
		}
		this._visible = true;
		// callback function
		this._options.onExpand(this);
	});

	/**
	 * Toggles the target element.
	 * @param {string} collapseClass The class to add to the target element when collapsing.
	 * @param {string} expandClass The class to add to the target element when expanding.
	 */
	collapseInstance.__proto__.toggle = (function (collapseClass, expandClass) {
		this._targetEl.style.setProperty('--max-collapse-height', `${this._targetEl.scrollHeight}px`);

		if (!collapseClass)
			collapseClass = this._targetEl.classList.contains('navbar-collapse') ?
				this._defaultToggleClass : 'hidden';

		if (!expandClass)
			expandClass = this._targetEl.classList.contains('navbar-collapse') ?
				this._defaultToggleClass : 'hidden';

		if (this._visible) {
			this.collapse(collapseClass);
		} else {
			this.expand(expandClass);
		}
		// callback function
		this._options.onToggle(this);
	});

	// Update the click handler
	collapseInstance._targetEl.removeEventListener('click', collapseInstance._clickHandler);

	collapseInstance._clickHandler = (function () {
		this.toggle();
	}).bind(collapseInstance);
	collapseInstance._targetEl.removeEventListener('click', collapseInstance._clickHandler);

	// Prepare the new property.
	collapseInstance._defaultToggleClass = "collapse";
}

/**
 * Fetches the height of an element.
 * @param {HTMLElement} el The element to get the height of.
 * @returns {number} The height of the element.
 */
function getHeight(el) {
	return el.scrollHeight;
}

window.addEventListener("load", function () {
	// Fetch all collapse elements using `[data-collapse-toggle]` attribute
	const COLLAPSIBLES = document.querySelectorAll("[data-collapse-toggle]");

	// Loop through all the collapse elements
	COLLAPSIBLES.forEach((triggerEl) => {
		const TARGET_ID = triggerEl.dataset.collapseToggle;
		const COLLAPSIBLE = FlowbiteInstances.getInstance("Collapse", TARGET_ID);

		// Return if there's no collapsible instance present.
		if (!COLLAPSIBLE) return;

		// Overwrite the default "collapse", "expand", and "toggle" methods.
		updateMethods(COLLAPSIBLE);

		// Set max height of the target element based on its scroll height.
		const TARGET = document.getElementById(TARGET_ID);
		const HEIGHT = getHeight(TARGET);
		TARGET.style.setProperty('--max-collapse-height', `${HEIGHT}px`);
	});
});
