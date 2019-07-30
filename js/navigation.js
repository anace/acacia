/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, button, dropdown, parentLink, menu, submenu, links, i, len;

	container = document.getElementById( 'main-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	parentLink = container.querySelectorAll( '.menu-item-has-children, .page_item_has_children' );

	for ( i = 0, len = parentLink.length; i < len; i++ ) {
		var dropdown = document.createElement('button');
		var submenu = parentLink[i].querySelector('.sub-menu');
		var icon = document.createElement('span');
		var screenreadertext = document.createElement('span');

		parentLink[i].insertBefore( dropdown, submenu );

		dropdown.classList.add('dropdown-toggle');
		dropdown.setAttribute('aria-controls', 'sub-menu');
		dropdown.setAttribute( 'aria-expanded', 'false' );
		submenu.setAttribute( 'aria-expanded', 'false' );
		dropdown.appendChild(icon);
		dropdown.appendChild(screenreadertext);
		icon.classList.add('dashicons');
		icon.setAttribute( 'aria-hidden', 'true' );
		screenreadertext.classList.add('screen-reader-text');
		screenreadertext.textContent = acaciaScreenReaderText.expand;
		

		dropdown.onclick = function() {
			parentLink = this.parentElement;
			submenu = parentLink.querySelector('.sub-menu');
			screenreadertext = this.childNodes[1];

		if ( -1 !== parentLink.className.indexOf( 'toggled-on' ) ) {
			parentLink.className = parentLink.className.replace( ' toggled-on', '' );
			this.setAttribute( 'aria-expanded', 'false' );
			screenreadertext.textContent = acaciaScreenReaderText.expand;
			submenu.setAttribute( 'aria-expanded', 'false' );
			
		} else {
			parentLink.className += ' toggled-on';
			this.setAttribute( 'aria-expanded', 'true' );
			screenreadertext.textContent = acaciaScreenReaderText.collapse;
			submenu.setAttribute( 'aria-expanded', 'true' );
		}
	}
		
	}

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();