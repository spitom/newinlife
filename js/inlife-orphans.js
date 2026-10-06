/**
 * InLife typography helpers.
 *
 * Prevents Polish one-letter conjunctions and prepositions
 * from being left at the end of a line.
 *
 * English intentionally has no equivalent rule.
 */
(() => {
	'use strict';

	const applyPolishOrphans = () => {
		const lang = document.documentElement.lang.toLowerCase();

		if ( ! lang.startsWith( 'pl' ) ) {
			return;
		}

		const excludedSelector = [
			'script',
			'style',
			'noscript',
			'pre',
			'code',
			'kbd',
			'samp',
			'textarea',
			'input',
			'select',
			'option',
			'button',
			'svg',
			'math',
			'dialog',
			'[contenteditable]',
			'[data-no-orphans]',
			'#wpadminbar',
			'[hidden]',
			'[aria-hidden="true"]',
			'.screen-reader-text',
			'.visually-hidden',
		].join( ',' );

		const walker = document.createTreeWalker(
			document.body,
			NodeFilter.SHOW_TEXT,
			{
				acceptNode( node ) {
					const parent = node.parentElement;

					if (
						! parent ||
						parent.closest( excludedSelector ) ||
						! node.nodeValue.trim()
					) {
						return NodeFilter.FILTER_REJECT;
					}

					return NodeFilter.FILTER_ACCEPT;
				},
			}
		);

		const textNodes = [];

		while ( walker.nextNode() ) {
			textNodes.push( walker.currentNode );
		}

		textNodes.forEach( ( node ) => {
			node.nodeValue = node.nodeValue.replace(
				/(^|[\s([{"'„«—–])([aiouwzAIUOWZ])\s+/g,
				'$1$2\u00A0'
			);
		} );
	};

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', applyPolishOrphans );
	} else {
		applyPolishOrphans();
	}
})();
