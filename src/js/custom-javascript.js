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

  let isScrolled = false;
  let ticking = false;

  const addThreshold = 36;
  const removeThreshold = 8;

  function setScrolledState(nextState) {
    if (isScrolled === nextState) return;

    isScrolled = nextState;
    siteHeader.classList.toggle('is-scrolled', isScrolled);
  }

  function updateStickyHeader() {
    const scrollY = window.scrollY || window.pageYOffset || 0;

    if (!isScrolled && scrollY > addThreshold) {
      setScrolledState(true);
    }

    if (isScrolled && scrollY < removeThreshold) {
      setScrolledState(false);
    }

    ticking = false;
  }

  function requestStickyUpdate() {
    if (ticking) return;

    ticking = true;
    window.requestAnimationFrame(updateStickyHeader);
  }

  updateStickyHeader();

  window.addEventListener('scroll', requestStickyUpdate, { passive: true });
  window.addEventListener('resize', requestStickyUpdate);
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

	const updateLanguageSwitcherUrls = (filterValue) => {
		const languageLinks = document.querySelectorAll(
			'.language-switcher__link[href][hreflang]'
		);

		languageLinks.forEach((link) => {
			const targetUrl = new URL(
				link.href,
				window.location.origin
			);

			if (filterValue === 'all') {
				targetUrl.searchParams.delete('area');
			} else {
				targetUrl.searchParams.set('area', filterValue);
			}

			link.href = targetUrl.toString();
		});
	};

	const applyFilter = (filterValue, updateHistory = true) => {
		const normalizedValue = filterValue || 'all';

		updateButtons(normalizedValue);
		updateHero(normalizedValue);
		updateListing(normalizedValue);
		updateLanguageSwitcherUrls(normalizedValue);

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

	const legacyAreaAliases = {
		zywnosc: 'food',
		zwierzeta: 'animals',
		zdrowie: 'health',
	};

	const requestedArea = url.searchParams.get('area') || 'all';

	const initialArea = Object.prototype.hasOwnProperty.call(
		legacyAreaAliases,
		requestedArea
	)
		? legacyAreaAliases[requestedArea]
		: requestedArea;

	const allowedFilters = Array.from(buttons).map((button) =>
		button.getAttribute('data-team-filter')
	);

	const validInitialArea = allowedFilters.includes(initialArea)
		? initialArea
		: 'all';

	/*
	* Old URLs such as ?area=zwierzeta remain usable,
	* then normalize in the browser to ?area=animals.
	*/
	if (
		validInitialArea !== 'all' &&
		validInitialArea !== requestedArea
	) {
		updateUrl(validInitialArea);
	}

	applyFilter(validInitialArea, false);
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

// Single Team menu - przełączanie sekcji / tabs WCAG / automatic activation

document.addEventListener('DOMContentLoaded', () => {
	const triggers = Array.from(document.querySelectorAll('[data-team-panel-trigger]'));
	const panels = Array.from(document.querySelectorAll('[data-team-panel-content]'));

	if (!triggers.length || !panels.length) return;

	const validPanels = ['badania', 'projekty', 'publikacje', 'aktualnosci'];
	const url = new URL(window.location.href);

	const activatePanel = (panelName, updateUrl = true, moveFocus = false) => {
		if (!validPanels.includes(panelName)) return;

		triggers.forEach((trigger) => {
			const isActive = trigger.getAttribute('data-team-panel-trigger') === panelName;

			trigger.classList.toggle('is-active', isActive);
			trigger.setAttribute('aria-selected', isActive ? 'true' : 'false');
			trigger.setAttribute('tabindex', isActive ? '0' : '-1');

			if (isActive && moveFocus) {
				trigger.focus();
			}
		});

		panels.forEach((panel) => {
			const isActive = panel.getAttribute('data-team-panel-content') === panelName;

			panel.classList.toggle('is-active', isActive);
			panel.hidden = !isActive;
		});

		if (updateUrl) {
			const nextUrl = new URL(window.location.href);
			nextUrl.searchParams.set('team_section', panelName);
			nextUrl.hash = '';
			window.history.replaceState(null, '', nextUrl.toString());
		}
	};

	const getTriggerIndex = (trigger) => triggers.indexOf(trigger);

	const focusAndActivateByIndex = (index) => {
		const normalizedIndex = (index + triggers.length) % triggers.length;
		const trigger = triggers[normalizedIndex];
		const panelName = trigger.getAttribute('data-team-panel-trigger');

		activatePanel(panelName, true, true);
	};

	triggers.forEach((trigger) => {
		trigger.addEventListener('click', () => {
			const panelName = trigger.getAttribute('data-team-panel-trigger');
			activatePanel(panelName, true, false);
		});

		trigger.addEventListener('keydown', (event) => {
			const currentIndex = getTriggerIndex(trigger);

			switch (event.key) {
				case 'ArrowRight':
				case 'Right': {
					event.preventDefault();
					focusAndActivateByIndex(currentIndex + 1);
					break;
				}

				case 'ArrowLeft':
				case 'Left': {
					event.preventDefault();
					focusAndActivateByIndex(currentIndex - 1);
					break;
				}

				case 'Home': {
					event.preventDefault();
					focusAndActivateByIndex(0);
					break;
				}

				case 'End': {
					event.preventDefault();
					focusAndActivateByIndex(triggers.length - 1);
					break;
				}

				default:
					break;
			}
		});
	});

	const initialSectionFromQuery = url.searchParams.get('team_section');
	const initialHash = window.location.hash.replace('#', '');

	if (validPanels.includes(initialSectionFromQuery)) {
		activatePanel(initialSectionFromQuery, false, false);
		return;
	}

	if (validPanels.includes(initialHash)) {
		activatePanel(initialHash, false, false);
		return;
	}

	activatePanel('badania', false, false);
});


// Team publications year filter — no page reload

document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('[data-team-publication-year]');
    const groups = document.querySelectorAll('[data-team-publication-group]');

    if (!links.length || !groups.length) return;

    const setActiveYear = (year) => {
        links.forEach((link) => {
            const isActive = link.getAttribute('data-team-publication-year') === year;

            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });

        groups.forEach((group) => {
            const isActive = group.getAttribute('data-team-publication-group') === year;

            group.hidden = !isActive;
            group.classList.toggle('is-hidden', !isActive);
        });
    };

    links.forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const year = link.getAttribute('data-team-publication-year');
            if (!year) return;

            setActiveYear(year);

            const url = new URL(link.href);
            window.history.pushState({}, '', url);
        });
    });
});

// Single Laboratory - Pokaż więcej / mniej

document.addEventListener('DOMContentLoaded', () => {
	const description = document.querySelector('[data-lab-profile-description]');
	const toggle = document.querySelector('[data-lab-profile-toggle]');

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

	// Initial state
	setExpanded(false);
});


// Network map

document.addEventListener('DOMContentLoaded', () => {
	const mapElement = document.querySelector('[data-network-map]');
	const filterButtons = document.querySelectorAll('[data-network-filter]');
	const gridItems = document.querySelectorAll('[data-network-item]');

	if (!mapElement) return;
	if (typeof L === 'undefined') return;

	const rawData = mapElement.dataset.networkMapData || '[]';
	const emptyLabel = mapElement.dataset.networkMapEmptyLabel || '';
	const linkLabel = mapElement.dataset.networkMapLinkLabel || 'Zobacz partnera';

	let partners = [];

	try {
		partners = JSON.parse(rawData);
	} catch (error) {
		console.error('Network map JSON parse error:', error);
		partners = [];
	}

	if (!Array.isArray(partners) || !partners.length) {
		mapElement.innerHTML = `<p class="network-map__empty">${emptyLabel}</p>`;
		return;
	}

	const map = L.map(mapElement, {
		scrollWheelZoom: false,
		worldCopyJump: true,
	}).setView([20, 10], 2);

	L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
		maxZoom: 18,
		attribution: '&copy; OpenStreetMap &copy; CARTO',
	}).addTo(map);

	const defaultIcon = L.divIcon({
		className: 'network-map-marker',
		html: '<span class="network-map-marker__dot" aria-hidden="true"></span>',
		iconSize: [16, 16],
		iconAnchor: [8, 8],
		popupAnchor: [0, -10],
	});

	const markers = [];

	const escapeHtml = (value) => {
		if (!value) return '';
		return String(value)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#039;');
	};

	const escapeAttribute = (value) => {
		if (!value) return '';
		return String(value).replace(/"/g, '&quot;');
	};

	partners.forEach((partner) => {
		if (typeof partner.lat !== 'number' || typeof partner.lng !== 'number') return;

		const marker = L.marker([partner.lat, partner.lng], {
			icon: defaultIcon,
			keyboard: true,
			title: partner.title || '',
		});

		const title = escapeHtml(partner.title || '');
		const location = escapeHtml(partner.location || '');
		const short = escapeHtml(partner.short || '');
		const permalink = partner.permalink || '#';
		const logo = partner.logo ? escapeAttribute(partner.logo) : '';

		const popupHtml = `
			<div class="network-map-popup">

				<div class="network-map-popup__top">
					${logo ? `
						<div class="network-map-popup__logo">
							<img src="${logo}" alt="">
						</div>
					` : ''}

					<div class="network-map-popup__head">
						<h3 class="network-map-popup__title">${title}</h3>
						${location ? `<p class="network-map-popup__location">${location}</p>` : ''}
					</div>
				</div>

				${short ? `<p class="network-map-popup__excerpt">${short}</p>` : ''}

				<div class="network-map-popup__footer">
					<a href="${permalink}" class="network-map-popup__cta">
						${escapeHtml(linkLabel)}
					</a>
				</div>

			</div>
		`;

		marker.bindPopup(popupHtml, {
			maxWidth: 300,
			closeButton: true,
			autoPan: true,
		});

		marker.partnerRegions = Array.isArray(partner.region_slugs) ? partner.region_slugs : [];
		marker.addTo(map);
		markers.push(marker);
	});

	const fitMapToVisibleMarkers = () => {
		const visibleMarkers = markers.filter((marker) => map.hasLayer(marker));

		if (!visibleMarkers.length) {
			map.setView([20, 10], 2);
			return;
		}

		if (visibleMarkers.length === 1) {
			map.setView(visibleMarkers[0].getLatLng(), 4);
			return;
		}

		const bounds = L.latLngBounds(visibleMarkers.map((marker) => marker.getLatLng()));
		map.fitBounds(bounds, {
			padding: [40, 40],
		});
	};

	const filterGrid = (filterValue) => {
		gridItems.forEach((item) => {
			const itemRegions = (item.dataset.networkRegions || '').split(' ').filter(Boolean);
			const matches = filterValue === 'all' || itemRegions.includes(filterValue);
			item.hidden = !matches;
		});
	};

	const filterMap = (filterValue) => {
		markers.forEach((marker) => {
			const matches = filterValue === 'all' || marker.partnerRegions.includes(filterValue);

			if (matches) {
				if (!map.hasLayer(marker)) {
					marker.addTo(map);
				}
			} else if (map.hasLayer(marker)) {
				map.removeLayer(marker);
			}
		});

		fitMapToVisibleMarkers();
	};

	const setActiveFilter = (activeButton) => {
		filterButtons.forEach((button) => {
			const isActive = button === activeButton;
			button.classList.toggle('is-active', isActive);
			button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
		});
	};

	filterButtons.forEach((button) => {
		button.addEventListener('click', () => {
			const filterValue = button.dataset.networkFilter || 'all';
			setActiveFilter(button);
			filterGrid(filterValue);
			filterMap(filterValue);
		});
	});

	fitMapToVisibleMarkers();

	mapElement.addEventListener('focusin', () => {
		map.scrollWheelZoom.enable();
	});

	mapElement.addEventListener('focusout', () => {
		map.scrollWheelZoom.disable();
	});

	mapElement.addEventListener('mouseenter', () => {
		map.scrollWheelZoom.enable();
	});

	mapElement.addEventListener('mouseleave', () => {
		map.scrollWheelZoom.disable();
	});
});

// Kopiowanie linku (post share)

document.addEventListener('click', function (e) {
	const btn = e.target.closest('.js-copy-link');
	if (!btn) return;

	const url = btn.dataset.url;

	navigator.clipboard.writeText(url).then(() => {
		btn.classList.add('is-copied');

		setTimeout(() => {
			btn.classList.remove('is-copied');
		}, 2000);
	});
});

// Career opportunities - current offers filter
document.addEventListener('DOMContentLoaded', () => {
	const filterWrap = document.querySelector('[data-career-filters]');
	const items = document.querySelectorAll('[data-career-item]');
	const emptyState = document.querySelector('[data-career-empty]');

	if (!filterWrap || !items.length) return;

	const buttons = filterWrap.querySelectorAll('[data-career-filter]');
	if (!buttons.length) return;

	const updateButtons = (filterValue) => {
		buttons.forEach((button) => {
			const isActive = button.getAttribute('data-career-filter') === filterValue;

			button.classList.toggle('is-active', isActive);
			button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
		});
	};

	const updateListing = (filterValue) => {
		let visibleCount = 0;

		items.forEach((item) => {
			const itemType = item.getAttribute('data-career-type') || '';
			const isVisible = filterValue === 'all' || itemType === filterValue;

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
			url.searchParams.delete('career_type');
		} else {
			url.searchParams.set('career_type', filterValue);
		}

		window.history.replaceState({}, '', url);
	};

	const applyFilter = (filterValue, updateHistory = true) => {
		const normalizedValue = filterValue || 'all';

		updateButtons(normalizedValue);
		updateListing(normalizedValue);

		if (updateHistory) {
			updateUrl(normalizedValue);
		}
	};

	buttons.forEach((button) => {
		button.addEventListener('click', () => {
			const filterValue = button.getAttribute('data-career-filter') || 'all';
			applyFilter(filterValue, true);
		});
	});

	const url = new URL(window.location.href);
	const initialType = url.searchParams.get('career_type') || 'all';
	const allowedFilters = Array.from(buttons).map((button) => button.getAttribute('data-career-filter'));

	applyFilter(allowedFilters.includes(initialType) ? initialType : 'all', false);
});


// Slider

document.addEventListener('DOMContentLoaded', () => {
	const sliders = document.querySelectorAll('.js-hero-slider');

	if (!sliders.length) return;

	sliders.forEach((slider) => {
		const track = slider.querySelector('.js-hero-track');
		const slides = Array.from(slider.querySelectorAll('[data-slide]'));
		const nextBtn = slider.querySelector('.js-next');
		const prevBtn = slider.querySelector('.js-prev');
		const toggleBtn = slider.querySelector('.js-toggle');

		if (!slides.length) return;

		const parsedInterval = Number.parseInt(
			slider.dataset.interval || '7000',
			10
		);

		const interval =
			Number.isFinite(parsedInterval) && parsedInterval > 0
				? parsedInterval
				: 7000;

		const reducedMotionQuery = window.matchMedia(
			'(prefers-reduced-motion: reduce)'
		);

		const hasMultipleSlides = slides.length > 1;
		const hasVideo = slides.some((slide) => slide.querySelector('video'));

		const autoplayRequested =
			slider.dataset.autoplay === 'true' &&
			hasMultipleSlides;

		const pauseLabel =
			toggleBtn?.dataset.labelPause ||
			toggleBtn?.getAttribute('aria-label') ||
			'Zatrzymaj slider';

		const playLabel =
			toggleBtn?.dataset.labelPlay ||
			'Odtwórz slider';

		const focusableSelector = [
			'a[href]',
			'button:not([disabled])',
			'input:not([disabled])',
			'select:not([disabled])',
			'textarea:not([disabled])',
			'[tabindex]',
		].join(',');

		let index = slides.findIndex((slide) =>
			slide.classList.contains('is-active')
		);

		if (index < 0) {
			index = 0;
		}

		let timer = null;
		let pointerInside = false;
		let focusInside = false;
		let pageHidden = document.hidden;

		let autoplayEnabled =
			autoplayRequested && !reducedMotionQuery.matches;

		let userPaused = !autoplayEnabled;

		const normalizeIndex = (newIndex) => {
			return (newIndex + slides.length) % slides.length;
		};

		const pauseAllVideos = (reset = false) => {
			slides.forEach((slide) => {
				const video = slide.querySelector('video');

				if (!video) return;

				video.pause();

				if (reset) {
					try {
						video.currentTime = 0;
					} catch (error) {
						// Metadane filmu mogą nie być jeszcze załadowane.
					}
				}
			});
		};

		const playActiveVideo = () => {
			const activeSlide = slides[index];
			const video = activeSlide?.querySelector('video');

			if (!video) return;

			video.muted = true;
			video.playsInline = true;

			const playPromise = video.play();

			if (
				playPromise &&
				typeof playPromise.catch === 'function'
			) {
				playPromise.catch(() => {
					// Przeglądarka może zablokować autoplay.
				});
			}
		};

		const setSlideInteractivity = (slide, isActive) => {
			if ('inert' in slide) {
				slide.inert = !isActive;
			}

			slide
				.querySelectorAll(focusableSelector)
				.forEach((element) => {
					if (!isActive) {
						if (
							!element.hasAttribute(
								'data-inlife-original-tabindex'
							)
						) {
							const originalTabindex =
								element.getAttribute('tabindex');

							element.setAttribute(
								'data-inlife-original-tabindex',
								originalTabindex === null
									? ''
									: originalTabindex
							);
						}

						element.setAttribute('tabindex', '-1');
						return;
					}

					if (
						!element.hasAttribute(
							'data-inlife-original-tabindex'
						)
					) {
						return;
					}

					const originalTabindex = element.getAttribute(
						'data-inlife-original-tabindex'
					);

					element.removeAttribute(
						'data-inlife-original-tabindex'
					);

					if (originalTabindex === '') {
						element.removeAttribute('tabindex');
					} else {
						element.setAttribute(
							'tabindex',
							originalTabindex
						);
					}
				});
		};

		const stopTimer = () => {
			if (!timer) return;

			window.clearInterval(timer);
			timer = null;
		};

		const isTemporarilyPaused = () => {
			return pointerInside || focusInside || pageHidden;
		};

		const shouldPlay = () => {
			return !userPaused && !isTemporarilyPaused();
		};

		const updateControls = () => {
			if (toggleBtn) {
				toggleBtn.classList.toggle(
					'is-paused',
					userPaused
				);

				toggleBtn.setAttribute(
					'aria-pressed',
					userPaused ? 'true' : 'false'
				);

				toggleBtn.setAttribute(
					'aria-label',
					userPaused ? playLabel : pauseLabel
				);
			}

			if (track) {
				track.setAttribute(
					'aria-live',
					shouldPlay() ? 'off' : 'polite'
				);
			}
		};

		const startTimer = () => {
			stopTimer();

			if (
				!autoplayEnabled ||
				!hasMultipleSlides ||
				!shouldPlay()
			) {
				return;
			}

			timer = window.setInterval(() => {
				setSlide(index + 1);
			}, interval);
		};

		const syncPlayback = () => {
			stopTimer();
			updateControls();

			if (!shouldPlay()) {
				pauseAllVideos(false);
				return;
			}

			playActiveVideo();
			startTimer();
		};

		function setSlide(newIndex) {
			const normalizedIndex = normalizeIndex(newIndex);

			pauseAllVideos(true);

			slides.forEach((slide, slideIndex) => {
				const isActive = slideIndex === normalizedIndex;

				slide.classList.toggle('is-active', isActive);

				slide.setAttribute(
					'aria-hidden',
					isActive ? 'false' : 'true'
				);

				setSlideInteractivity(slide, isActive);
			});

			index = normalizedIndex;

			syncPlayback();
		}

		const pauseByUser = () => {
			userPaused = true;
			autoplayEnabled = false;

			syncPlayback();
		};

		const playByUser = () => {
			userPaused = false;
			autoplayEnabled = true;

			syncPlayback();
		};

		if (nextBtn) {
			nextBtn.addEventListener('click', () => {
				pauseByUser();
				setSlide(index + 1);
			});
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', () => {
				pauseByUser();
				setSlide(index - 1);
			});
		}

		if (toggleBtn) {
			if (!hasMultipleSlides && !hasVideo) {
				toggleBtn.hidden = true;
			}

			toggleBtn.addEventListener('click', () => {
				if (userPaused) {
					playByUser();
				} else {
					pauseByUser();
				}
			});
		}

		slider.addEventListener('mouseenter', () => {
			pointerInside = true;
			syncPlayback();
		});

		slider.addEventListener('mouseleave', () => {
			pointerInside = false;
			syncPlayback();
		});

		slider.addEventListener('focusin', () => {
			focusInside = true;
			syncPlayback();
		});

		slider.addEventListener('focusout', (event) => {
			const nextFocusedElement = event.relatedTarget;

			if (
				nextFocusedElement &&
				slider.contains(nextFocusedElement)
			) {
				return;
			}

			focusInside = false;
			syncPlayback();
		});

		document.addEventListener('visibilitychange', () => {
			pageHidden = document.hidden;
			syncPlayback();
		});

		const handleReducedMotionChange = (event) => {
			if (event.matches) {
				userPaused = true;
				autoplayEnabled = false;
			}

			syncPlayback();
		};

		if (
			typeof reducedMotionQuery.addEventListener === 'function'
		) {
			reducedMotionQuery.addEventListener(
				'change',
				handleReducedMotionChange
			);
		} else if (
			typeof reducedMotionQuery.addListener === 'function'
		) {
			reducedMotionQuery.addListener(
				handleReducedMotionChange
			);
		}

		setSlide(index);
	});
});

// Reveal cards on viewport

document.addEventListener('DOMContentLoaded', () => {
    const revealCards = document.querySelectorAll(
        '.front-area-card, .research-nav-card, .team-card, .laboratory-card, .business-service-card'
    );

    if (!revealCards.length) return;

    if (!('IntersectionObserver' in window)) {
        revealCards.forEach((card) => card.classList.add('is-visible'));
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        revealCards.forEach((card) => card.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.08,
            rootMargin: '0px 0px -8% 0px',
        }
    );

    revealCards.forEach((card, index) => {
        card.style.transitionDelay = `${index * 40}ms`;
        observer.observe(card);
    });
});

// Front Stats animation

document.addEventListener('DOMContentLoaded', () => {
  const stats = document.querySelector('.about-intro__stats');

  if (!stats || !('IntersectionObserver' in window)) {
    if (stats) stats.classList.add('is-visible');
    return;
  }

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        entry.target.classList.add('is-visible');
        obs.unobserve(entry.target);
      });
    },
    {
      threshold: 0.25,
      rootMargin: '0px 0px -8% 0px',
    }
  );

  observer.observe(stats);
});