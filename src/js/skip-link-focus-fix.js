/**
 * Focus fix for the site skip link.
 *
 * Obsługuje wyłącznie główne cele skip-linka.
 * Nie przechwytuje zwykłych kotwic sekcji.
 */
(function () {
	'use strict';

	if (!window.addEventListener || !document.getElementById) {
		return;
	}

	/**
	 * Zwraca dozwolony cel skip-linka.
	 *
	 * `content` pozostaje dla zgodności z aktualnym header.php.
	 * `main-content` jest używany w customowych template'ach InLife.
	 *
	 * @param {string} targetId ID odczytane z URL.
	 * @returns {HTMLElement|null}
	 */
	function getSkipTarget(targetId) {
		if (targetId !== 'content' && targetId !== 'main-content') {
			return null;
		}

		const directTarget = document.getElementById(targetId);

		if (directTarget) {
			return directTarget;
		}

		/*
		 * Fallback dla aktualnego header.php:
		 * link prowadzi do #content, natomiast customowe template'y
		 * używają najczęściej #main-content.
		 */
		if (targetId === 'content') {
			return document.getElementById('main-content');
		}

		return document.getElementById('content');
	}

	/**
	 * Ustawia focus na celu skip-linka.
	 */
	function focusSkipTarget() {
		const targetId = window.location.hash.substring(1);
		const target = getSkipTarget(targetId);

		if (!target) {
			return;
		}

		const isNativelyFocusable = /^(?:a|button|input|select|textarea)$/i.test(
			target.tagName
		);

		if (!isNativelyFocusable && !target.hasAttribute('tabindex')) {
			target.setAttribute('tabindex', '-1');
		}

		window.requestAnimationFrame(() => {
			target.focus();
		});
	}

	window.addEventListener('hashchange', focusSkipTarget, false);

	/*
	 * Obsługa wejścia bezpośrednio na URL zakończony
	 * #content albo #main-content.
	 */
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', focusSkipTarget, {
			once: true,
		});
	} else {
		focusSkipTarget();
	}
})();