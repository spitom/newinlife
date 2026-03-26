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

// Career menu - aktywny stan podczas scrollowania

document.addEventListener('DOMContentLoaded', () => {
	const nav = document.querySelector('.career-op-nav');
	if (!nav) return;

	const links = Array.from(nav.querySelectorAll('[data-section-target]'));
	if (!links.length) return;

	const sections = links
		.map((link) => {
			const id = link.getAttribute('data-section-target');
			if (!id) return null;

			const section = document.getElementById(id);
			if (!section) return null;

			return { link, section, id };
		})
		.filter(Boolean);

	if (!sections.length) return;

	const setActiveLink = (activeId) => {
		sections.forEach(({ link, id }) => {
			const isActive = id === activeId;

			link.classList.toggle('is-active', isActive);
			link.setAttribute('aria-selected', isActive ? 'true' : 'false');
		});
	};

	const getStickyOffset = () => {
		const root = document.documentElement;
		const cssOffset = getComputedStyle(root)
			.getPropertyValue('--inlife-header-offset')
			.trim();

		const parsed = parseInt(cssOffset, 10);
		return Number.isNaN(parsed) ? 120 : parsed + 60;
	};

	const handleScroll = () => {
		const offset = getStickyOffset();
		let currentId = sections[0].id;

		sections.forEach(({ section, id }) => {
			const rect = section.getBoundingClientRect();

			if (rect.top <= offset) {
				currentId = id;
			}
		});

		setActiveLink(currentId);
	};

	links.forEach((link) => {
		link.addEventListener('click', () => {
			const targetId = link.getAttribute('data-section-target');
			if (targetId) {
				setActiveLink(targetId);
			}
		});
	});

	window.addEventListener('scroll', handleScroll, { passive: true });
	window.addEventListener('resize', handleScroll);

	handleScroll();
});

// Archive Teams - filtrowanie obszarów + dynamiczny hero

document.addEventListener('DOMContentLoaded', () => {
	const filterWrap = document.querySelector('[data-team-filters]');
	const items = document.querySelectorAll('[data-team-item]');
	const emptyState = document.querySelector('[data-team-empty]');

	const heroWrap = document.getElementById('teamsArchiveHero');
	const heroKicker = document.getElementById('teamsArchiveHeroKicker');
	const heroTitle = document.getElementById('teamsArchiveHeroTitle');
	const heroDescription = document.getElementById('teamsArchiveHeroDescription');
	const heroDataElement = document.getElementById('teamsArchiveHeroData');

	if (!filterWrap) return;

	const buttons = filterWrap.querySelectorAll('[data-team-filter]');
	if (!buttons.length) return;

	let heroData = {};

	if (heroDataElement) {
		try {
			heroData = JSON.parse(heroDataElement.textContent);
		} catch (error) {
			console.error('Invalid teams hero JSON data.', error);
		}
	}

	const updateButtons = (filterValue) => {
		buttons.forEach((button) => {
			const isActive = button.getAttribute('data-team-filter') === filterValue;
			button.classList.toggle('is-active', isActive);
			button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
		});
	};

	const updateHero = (filterValue) => {
		if (!heroWrap || !heroDescription || !heroData) return;

		const content = heroData[filterValue] || heroData.all;
		if (!content) return;

		if (heroKicker && content.kicker) {
			heroKicker.textContent = content.kicker;
		}

		if (heroTitle && content.title) {
			heroTitle.textContent = content.title;
		}

		if (content.description) {
			heroDescription.textContent = content.description;
		}

		heroWrap.setAttribute('data-current-area', filterValue);
	};

	const updateListing = (filterValue) => {
		if (!items.length) return;

		let visibleCount = 0;

		items.forEach((item) => {
			const areas = (item.getAttribute('data-team-area') || '')
				.split(' ')
				.map((value) => value.trim())
				.filter(Boolean);

			const isVisible = filterValue === 'all' || areas.includes(filterValue);

			item.hidden = !isVisible;

			if (isVisible) {
				visibleCount += 1;
			}
		});

		if (emptyState) {
			emptyState.hidden = visibleCount !== 0;
		}
	};

	const updateUrl = (filterValue) => {
		const url = new URL(window.location.href);

		if (filterValue === 'all') {
			url.searchParams.delete('area');
		} else {
			url.searchParams.set('area', filterValue);
		}

		window.history.replaceState({}, '', url);
	};

	const applyFilter = (filterValue, updateHistory = true) => {
		const normalizedValue = filterValue || 'all';

		updateButtons(normalizedValue);
		updateHero(normalizedValue);
		updateListing(normalizedValue);

		if (updateHistory) {
			updateUrl(normalizedValue);
		}
	};

	buttons.forEach((button) => {
		button.addEventListener('click', () => {
			const filterValue = button.getAttribute('data-team-filter') || 'all';
			applyFilter(filterValue, true);
		});
	});

	const url = new URL(window.location.href);
	const initialArea = url.searchParams.get('area') || 'all';
	const allowedFilters = Array.from(buttons).map((button) => button.getAttribute('data-team-filter'));

	applyFilter(allowedFilters.includes(initialArea) ? initialArea : 'all', false);
});


// Single Team - Pokaż więcej/mniej

document.addEventListener('DOMContentLoaded', () => {
	const description = document.querySelector('[data-team-description]');
	const toggle = document.querySelector('[data-team-description-toggle]');

	if (!description || !toggle) return;

	const setExpanded = (expanded) => {
		description.classList.toggle('is-collapsed', !expanded);
		description.classList.toggle('is-expanded', expanded);
		toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
	};

	toggle.addEventListener('click', () => {
		const expanded = toggle.getAttribute('aria-expanded') === 'true';
		setExpanded(!expanded);
	});

	setExpanded(false);
});

// Single Team menu - przełączanie sekcji

document.addEventListener('DOMContentLoaded', () => {
	const triggers = document.querySelectorAll('[data-team-panel-trigger]');
	const panels = document.querySelectorAll('[data-team-panel-content]');

	if (!triggers.length || !panels.length) return;

	const validPanels = ['badania', 'projekty', 'publikacje', 'aktualnosci'];

	const activatePanel = (panelName, updateHash = true) => {
		if (!validPanels.includes(panelName)) return;

		triggers.forEach((trigger) => {
			const isActive = trigger.getAttribute('data-team-panel-trigger') === panelName;
			trigger.classList.toggle('is-active', isActive);
			trigger.setAttribute('aria-selected', isActive ? 'true' : 'false');
		});

		panels.forEach((panel) => {
			const isActive = panel.getAttribute('data-team-panel-content') === panelName;
			panel.classList.toggle('is-active', isActive);
			panel.hidden = !isActive;
		});

		if (updateHash) {
			history.replaceState(null, '', `#${panelName}`);
		}
	};

	triggers.forEach((trigger) => {
		trigger.addEventListener('click', () => {
			const panelName = trigger.getAttribute('data-team-panel-trigger');
			activatePanel(panelName, true);
		});
	});

	const initialHash = window.location.hash.replace('#', '');
	if (validPanels.includes(initialHash)) {
		activatePanel(initialHash, false);
	}
});