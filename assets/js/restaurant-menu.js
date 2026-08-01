(() => {
	'use strict';

	document.addEventListener('DOMContentLoaded', () => {
		document.querySelectorAll('.wprm-menu__item.is-sold-out a').forEach((link) => {
			link.setAttribute('tabindex', '-1');
			link.setAttribute('aria-disabled', 'true');
		});
	});
})();
