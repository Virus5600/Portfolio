import { Drawer } from "flowbite";

/**
 * Updates the following methods of the `Drawer` class to modify the
 * backdrop's position and all the button's that affects the drawer:
 *
 * - `_createBackdrop`
 *
 * Then add
 *
 * These changes will allow the drawer to be used as a part of navigation'
 * bar and allows customization of the button's animation.
 *
 * @param {Drawer} drawerInstance
 */
function updateMethods(drawerInstance) {
	if (!drawerInstance) return;

	drawerInstance.__proto__._createBackdrop = (function () {
		var _a;
		var _this = this;
		if (!this._visible) {
			var backdropEl = document.createElement('div');
			backdropEl.setAttribute('drawer-backdrop', '');
			(_a = backdropEl.classList).add.apply(_a, this._options.backdropClasses.split(' '));
			this._targetEl.insertAdjacentElement('afterend', backdropEl);
			backdropEl.addEventListener('click', function () {
				_this.hide();
			});

			// Update the status placed in the triggers.
			_this._eventListenerInstances.forEach(function (instance) {
				instance.element.dataset.drawerStatus = 'visible';
			});
		}
	});

	drawerInstance.__proto__._destroyBackdropEl = (function () {
		var _this = this;
		if (this._visible &&
			document.querySelector('[drawer-backdrop]') !== null) {
			document.querySelector('[drawer-backdrop]').remove();

			// Update the status placed in the triggers.
			_this._eventListenerInstances.forEach(function (instance) {
				instance.element.dataset.drawerStatus = 'hidden';
			});
		}
	});
}

window.addEventListener('load', function () {
	// Fetch all collapse elements using `[data-collapse-toggle]` attribute
	const DRAWERS = document.querySelectorAll("[data-drawer-target]");

	// Loop through all the collapse elements
	DRAWERS.forEach((triggerEl) => {
		const TARGET_ID = triggerEl.dataset.drawerTarget;
		const DRAWER = FlowbiteInstances.getInstance("Drawer", TARGET_ID);

		// Return if there's no drawer instance present.
		if (!DRAWER) return;

		// Updated backdrop classes.
		DRAWER._options.backdropClasses = `drawer-backdrop ${triggerEl.dataset.drawerBackdropClasses?.trim() ?? ""}`.trim();
		console.log(DRAWER._options.backdropClasses);

		// Overwrite the default "_createBackdrop", "show", and "hide" methods.
		updateMethods(DRAWER);
	});
});
