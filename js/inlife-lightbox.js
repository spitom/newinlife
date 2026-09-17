document.addEventListener('DOMContentLoaded', () => {
	const dialogs = document.querySelectorAll('[data-inlife-lightbox]');

	if (!dialogs.length) {
		return;
	}

	dialogs.forEach((dialog) => {
		const lightboxId = dialog.dataset.inlifeLightbox;

		if (!lightboxId) {
			return;
		}

		const triggers = document.querySelectorAll(
			`[data-inlife-lightbox-open="${lightboxId}"]`
		);

		const sources = Array.from(
			dialog.querySelectorAll('[data-inlife-lightbox-source]')
		);

		const image = dialog.querySelector('[data-inlife-lightbox-image]');
		const closeBtn = dialog.querySelector('[data-inlife-lightbox-close]');
		const prevBtn = dialog.querySelector('[data-inlife-lightbox-prev]');
		const nextBtn = dialog.querySelector('[data-inlife-lightbox-next]');
		const counter = dialog.querySelector('[data-inlife-lightbox-counter]');

		if (!triggers.length || !sources.length || !image) {
			return;
		}

		let currentIndex = 0;
		let lastTrigger = null;

		const updateImage = () => {
			const source = sources[currentIndex];

			if (!source) {
				return;
			}

			const src = source.dataset.src || '';
			const srcset = source.dataset.srcset || '';
			const sizes = source.dataset.sizes || '';
			const alt = source.dataset.alt || '';

			image.src = src;
			image.alt = alt;

			if (srcset) {
				image.srcset = srcset;
			} else {
				image.removeAttribute('srcset');
			}

			if (sizes) {
				image.sizes = sizes;
			} else {
				image.removeAttribute('sizes');
			}

			if (counter) {
				counter.textContent = `${currentIndex + 1} / ${sources.length}`;
			}
		};

		const showPrevious = () => {
			currentIndex =
				(currentIndex - 1 + sources.length) % sources.length;

			updateImage();
		};

		const showNext = () => {
			currentIndex = (currentIndex + 1) % sources.length;

			updateImage();
		};

		triggers.forEach((trigger) => {
			trigger.addEventListener('click', () => {
				const requestedIndex = Number.parseInt(
					trigger.dataset.inlifeLightboxIndex || '0',
					10
				);

				currentIndex = Number.isNaN(requestedIndex)
					? 0
					: Math.min(
							Math.max(requestedIndex, 0),
							sources.length - 1
						);

				lastTrigger = trigger;

				updateImage();

				if (typeof dialog.showModal === 'function') {
					dialog.showModal();
				}
			});
		});

		if (closeBtn) {
			closeBtn.addEventListener('click', () => {
				dialog.close();
			});
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', showPrevious);
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', showNext);
		}

		dialog.addEventListener('click', (event) => {
			if (event.target === dialog) {
				dialog.close();
			}
		});

		dialog.addEventListener('keydown', (event) => {
			if (event.key === 'ArrowLeft' && sources.length > 1) {
				event.preventDefault();
				showPrevious();
			}

			if (event.key === 'ArrowRight' && sources.length > 1) {
				event.preventDefault();
				showNext();
			}
		});

		dialog.addEventListener('close', () => {
			if (lastTrigger instanceof HTMLElement) {
				lastTrigger.focus();
			}
		});

		const hasMultipleImages = sources.length > 1;

		if (prevBtn) {
			prevBtn.hidden = !hasMultipleImages;
		}

		if (nextBtn) {
			nextBtn.hidden = !hasMultipleImages;
		}

		if (counter) {
			counter.hidden = !hasMultipleImages;
		}
	});

});