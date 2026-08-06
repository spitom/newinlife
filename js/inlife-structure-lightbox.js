document.addEventListener('DOMContentLoaded', () => {
	const openBtn = document.querySelector('[data-structure-lightbox-open]');
	const dialog = document.querySelector('[data-structure-lightbox]');
	const closeBtn = document.querySelector('[data-structure-lightbox-close]');

	if (!openBtn || !dialog) {
		return;
	}

	openBtn.addEventListener('click', (event) => {
		event.preventDefault();

		if (typeof dialog.showModal === 'function') {
			dialog.showModal();
		}
	});

	if (closeBtn) {
		closeBtn.addEventListener('click', () => {
			dialog.close();
		});
	}

	dialog.addEventListener('click', (event) => {
		if (event.target === dialog) {
			dialog.close();
		}
	});
});