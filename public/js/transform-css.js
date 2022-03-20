const $window = $(window);

function applyTransform(obj) {
	let tAttrib = [],
		tAttribValue = [],
		hasMetCond = [];

	// Fetch lsit of classes this object has.
	let classList = obj.attr('class').split(/\s+/);
	// Iterate through the list then filter which contains "transform-" in their class names.
	$(classList).each((k, v) => {
		// Determine what transform attribute it uses.
		if (v.match(/(?:^|\s)transform-/)) {
			let splice = v.split(/-/);

			if ($window.width() >= 1200 && splice[1] == 'xl' && !tAttrib.includes(splice[2])) {
				tAttrib.push(splice[2]);
				tAttribValue.push(splice[3].replace(/n/, '-'));
			}
			else if ($window.width() >= 992 && splice[1] == 'lg' && !tAttrib.includes(splice[2])) {
				tAttrib.push(splice[2]);
				tAttribValue.push(splice[3].replace(/n/, '-'));
			}
			else if ($window.width() >= 768 && splice[1] == 'md' && !tAttrib.includes(splice[2])) {
				tAttrib.push(splice[2]);
				tAttribValue.push(splice[3].replace(/n/, '-'));
			}
			else if ($window.width() >= 576 && splice[1] == 'sm' && !tAttrib.includes(splice[2])) {
				tAttrib.push(splice[2]);
				tAttribValue.push(splice[3].replace(/n/, '-'));
			}
			else if (!tAttrib.includes(splice[1])) {
				tAttrib.push(splice[1]);
				tAttribValue.push(splice[2].replace(/n/, '-'));
			}
		}
	});
	
	// Put the transform attributes together for the final piece.
	let finalTransform = "";
	for (let i =0; i < tAttrib.length; i++) {
		if (!tAttrib[i].match(/xl|lg|md|sm|xs/)) {
			finalTransform += tAttrib[i] + "(" + tAttribValue[i] + ") ";
		}
	}
	// Trims excess white space.
	finalTransform.trim();
	// Insert the transform as a CSS style for this object.
	obj.css('transform', finalTransform);
}

$(document).ready(function() {
	let transform = $('*[class*="transform-"]').filter(function () {
		return this.className.match(/(?:^|\s)transform-/);
	});

	transform.each((k, v) => {
		// Adds an event listener that updates the transform of the object
		$window.resize((e) => {
			applyTransform($(v));
		});
		
		$(v).change((e) => {
			applyTransform($(v));
		});
		applyTransform($(v));
	});
});