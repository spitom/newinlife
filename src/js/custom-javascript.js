// Search panel

document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('[data-inlife-search-toggle]');
  const panel = document.querySelector('#inlife-search-panel');
  const closeBtn = document.querySelector('[data-inlife-search-close]');
  const input = document.querySelector('#inlife-search-field');

  if (!toggle || !panel) return;

  function openSearchPanel() {
    panel.hidden = false;
    toggle.setAttribute('aria-expanded', 'true');

    window.requestAnimationFrame(() => {
      panel.classList.add('is-open');
      if (input) input.focus();
    });
  }

  function closeSearchPanel(returnFocus = true) {
    panel.classList.remove('is-open');
    panel.hidden = true;
    toggle.setAttribute('aria-expanded', 'false');

    if (returnFocus) {
      toggle.focus();
    }
  }

  toggle.addEventListener('click', function () {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    expanded ? closeSearchPanel(false) : openSearchPanel();
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', function () {
      closeSearchPanel(true);
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !panel.hidden) {
      closeSearchPanel(true);
    }
  });

  document.addEventListener('click', function (event) {
    if (panel.hidden) return;

    const clickedInsidePanel = panel.contains(event.target);
    const clickedToggle = toggle.contains(event.target);

    if (!clickedInsidePanel && !clickedToggle) {
      closeSearchPanel(false);
    }
  });
});

// Sticky header

document.addEventListener('DOMContentLoaded', function () {
  const siteHeader = document.querySelector('.site-header');

  if (!siteHeader) return;

  function updateStickyHeader() {
    if (window.scrollY > 24) {
      siteHeader.classList.add('is-scrolled');
    } else {
      siteHeader.classList.remove('is-scrolled');
    }
  }

  updateStickyHeader();
  window.addEventListener('scroll', updateStickyHeader, { passive: true });
});


// Primary menu - custom Navwalker

document.addEventListener('DOMContentLoaded', () => {
	const navs = document.querySelectorAll('.inlife-primary-nav, .offcanvas-primary-menu');

	if (!navs.length) return;

	navs.forEach((nav) => {
		const toggles = nav.querySelectorAll('[data-submenu-toggle]');

		if (!toggles.length) return;

		const getSubmenu = (toggle) => {
			const submenuId = toggle.getAttribute('aria-controls');
			if (!submenuId) return null;
			return document.getElementById(submenuId);
		};

		const getParentItem = (toggle) => toggle.closest('.nav-item-has-children');

		const getLabel = (toggle, expanded) => {
			const srText = toggle.querySelector('.visually-hidden');
			if (!srText) return '';

			const current = srText.textContent.trim();
			if (!current) return '';

			if (expanded) {
				return current
					.replace(/^Rozwiń podmenu:/, 'Zwiń podmenu:')
					.replace(/^Expand submenu:/, 'Collapse submenu:');
			}

			return current
				.replace(/^Zwiń podmenu:/, 'Rozwiń podmenu:')
				.replace(/^Collapse submenu:/, 'Expand submenu:');
		};

		const setToggleText = (toggle, text) => {
			toggle.setAttribute('aria-label', text);

			const srText = toggle.querySelector('.visually-hidden');
			if (srText) {
				srText.textContent = text;
			}
		};

		const closeSubmenu = (toggle, restoreFocus = false) => {
			const submenu = getSubmenu(toggle);
			const parentItem = getParentItem(toggle);

			if (!submenu || !parentItem) return;

			parentItem.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
			setToggleText(toggle, getLabel(toggle, false));

			const nestedToggles = submenu.querySelectorAll('[data-submenu-toggle][aria-expanded="true"]');
			nestedToggles.forEach((nestedToggle) => {
				closeSubmenu(nestedToggle, false);
			});

			window.setTimeout(() => {
				if (toggle.getAttribute('aria-expanded') === 'false') {
					submenu.hidden = true;
				}
			}, 180);

			if (restoreFocus) {
				toggle.focus();
			}
		};

		const closeSiblings = (toggle) => {
			const currentItem = getParentItem(toggle);
			if (!currentItem || !currentItem.parentElement) return;

			const siblings = currentItem.parentElement.querySelectorAll(':scope > .nav-item-has-children');

			siblings.forEach((item) => {
				if (item === currentItem) return;

				const siblingToggle = item.querySelector(':scope > .nav-link-group > [data-submenu-toggle]');
				if (siblingToggle) {
					closeSubmenu(siblingToggle, false);
				}
			});
		};

		const openSubmenu = (toggle) => {
			const submenu = getSubmenu(toggle);
			const parentItem = getParentItem(toggle);

			if (!submenu || !parentItem) return;

			closeSiblings(toggle);

			submenu.hidden = false;
			toggle.setAttribute('aria-expanded', 'true');
			setToggleText(toggle, getLabel(toggle, true));

			window.requestAnimationFrame(() => {
				parentItem.classList.add('is-open');
			});
		};

		toggles.forEach((toggle) => {
			toggle.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();

				const expanded = toggle.getAttribute('aria-expanded') === 'true';

				if (expanded) {
					closeSubmenu(toggle, false);
				} else {
					openSubmenu(toggle);
				}
			});

			toggle.addEventListener('keydown', (e) => {
				const expanded = toggle.getAttribute('aria-expanded') === 'true';

				if (e.key === ' ' || e.key === 'Enter') {
					e.preventDefault();

					if (expanded) {
						closeSubmenu(toggle, false);
					} else {
						openSubmenu(toggle);
					}
				}

				if (e.key === 'ArrowDown') {
					e.preventDefault();

					if (!expanded) {
						openSubmenu(toggle);
					}

					const submenu = getSubmenu(toggle);
					if (!submenu) return;

					const firstFocusable = submenu.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
					if (firstFocusable) {
						firstFocusable.focus();
					}
				}

				if (e.key === 'Escape') {
					e.preventDefault();
					closeSubmenu(toggle, true);
				}
			});
		});

		nav.addEventListener('keydown', (e) => {
			if (e.key !== 'Escape') return;

			const openToggles = nav.querySelectorAll('[data-submenu-toggle][aria-expanded="true"]');
			if (!openToggles.length) return;

			const lastOpenToggle = openToggles[openToggles.length - 1];
			closeSubmenu(lastOpenToggle, true);
		});

		document.addEventListener('click', (e) => {
			if (nav.contains(e.target)) return;

			const openToggles = nav.querySelectorAll('[data-submenu-toggle][aria-expanded="true"]');
			openToggles.forEach((toggle) => closeSubmenu(toggle, false));
		});

		nav.addEventListener('focusout', (e) => {
			const relatedTarget = e.relatedTarget;

			if (relatedTarget && nav.contains(relatedTarget)) return;

			const openToggles = nav.querySelectorAll('[data-submenu-toggle][aria-expanded="true"]');
			openToggles.forEach((toggle) => closeSubmenu(toggle, false));
		});
	});
});