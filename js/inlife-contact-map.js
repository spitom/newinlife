document.addEventListener('DOMContentLoaded', () => {
	const mapEl = document.querySelector('[data-contact-map]');

	if (!mapEl || typeof L === 'undefined') {
		return;
	}

	const lat = Number.parseFloat(mapEl.dataset.lat);
	const lng = Number.parseFloat(mapEl.dataset.lng);

	const title = mapEl.dataset.title || '';

	const zoomInLabel =
		mapEl.dataset.zoomInLabel || 'Powiększ mapę';

	const zoomOutLabel =
		mapEl.dataset.zoomOutLabel || 'Pomniejsz mapę';

	const markerLabel =
		mapEl.dataset.markerLabel ||
		'Pokaż lokalizację Instytutu na mapie';

	if (Number.isNaN(lat) || Number.isNaN(lng)) {
		return;
	}

	const map = L.map(mapEl, {
		scrollWheelZoom: false,
		zoomControl: false,
	}).setView([lat, lng], 16);

	L.control.zoom({
		zoomInTitle: zoomInLabel,
		zoomOutTitle: zoomOutLabel,
	}).addTo(map);

	L.tileLayer(
		'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
		{
			maxZoom: 19,
			attribution: '&copy; OpenStreetMap',
		}
	).addTo(map);

	const marker = L.marker([lat, lng], {
		alt: markerLabel,
		title: markerLabel,
		keyboard: true,
	}).addTo(map);

	if (title) {
		marker.bindPopup(title);
	}

	window.setTimeout(() => {
		map.invalidateSize();
	}, 250);
});