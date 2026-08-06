document.addEventListener('DOMContentLoaded', () => {
	const timeline = document.querySelector('[data-history-timeline]');

	if (!timeline) {
		return;
	}

	const items = Array.from(timeline.querySelectorAll('[data-history-timeline-item]'));

	if (!items.length) {
		return;
	}

	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (prefersReducedMotion || !('IntersectionObserver' in window)) {
		items.forEach((item) => {
			item.classList.add('is-visible');
		});

		return;
	}

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (!entry.isIntersecting) {
					return;
				}

				entry.target.classList.add('is-visible');
				observer.unobserve(entry.target);
			});
		},
		{
			threshold: 0.18,
			rootMargin: '0px 0px -8% 0px',
		}
	);

	items.forEach((item, index) => {
		item.style.transitionDelay = `${Math.min(index * 80, 320)}ms`;
		observer.observe(item);
	});
});