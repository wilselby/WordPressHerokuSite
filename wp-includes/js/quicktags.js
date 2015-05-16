<<<<<<< HEAD
=======
/* global adminpage, wpActiveEditor, quicktagsL10n, wpLink, prompt */
>>>>>>> WPHome/master
/*
 * Quicktags
 *
 * This is the HTML editor in WordPress. It can be attached to any textarea and will
 * append a toolbar above it. This script is self-contained (does not require external libraries).
 *
 * Run quicktags(settings) to initialize it, where settings is an object containing up to 3 properties:
 * settings = {
 *   id : 'my_id',          the HTML ID of the textarea, required
 *   buttons: ''            Comma separated list of the names of the default buttons to show. Optional.
<<<<<<< HEAD
 *                          Current list of default button names: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,spell,close';
=======
 *                          Current list of default button names: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close';
>>>>>>> WPHome/master
 * }
 *
 * The settings can also be a string quicktags_id.
 *
 * quicktags_id string The ID of the textarea that will be the editor canvas
 * buttons string Comma separated list of the default buttons names that will be shown in that instance.
 */

// new edit toolbar used with permission
// by Alex King
// http://www.alexking.org/

<<<<<<< HEAD
var QTags, edButtons = [], edCanvas,
=======
var QTags, edCanvas,
	edButtons = [];

/* jshint ignore:start */
>>>>>>> WPHome/master

/**
 * Back-compat
 *
 * Define all former global functions so plugins that hack quicktags.js directly don't cause fatal errors.
 */
<<<<<<< HEAD
edAddTag = function(){},
=======
var edAddTag = function(){},
>>>>>>> WPHome/master
edCheckOpenTags = function(){},
edCloseAllTags = function(){},
edInsertImage = function(){},
edInsertLink = function(){},
edInsertTag = function(){},
edLink = function(){},
edQuickLink = function(){},
edRemoveTag = function(){},
edShowButton = function(){},
edShowLinks = function(){},
edSpell = function(){},
edToolbar = function(){};

/**
 * Initialize new instance of the Quicktags editor
 */
function quicktags(settings) {
	return new QTags(settings);
}

/**
 * Inserts content at the caret in the active editor (textarea)
 *
 * Added for back compatibility
 * @see QTags.insertContent()
 */
function edInsertContent(bah, txt) {
	return QTags.insertContent(txt);
}

/**
 * Adds a button to all instances of the editor
 *
 * Added for back compatibility, use QTags.addButton() as it gives more flexibility like type of button, button placement, etc.
 * @see QTags.addButton()
 */
<<<<<<< HEAD
function edButton(id, display, tagStart, tagEnd, access, open) {
	return QTags.addButton( id, display, tagStart, tagEnd, access, '', -1 );
}

(function(){
	// private stuff is prefixed with an underscore
	var _domReady = function(func) {
		var t, i,  DOMContentLoaded;

		if ( typeof jQuery != 'undefined' ) {
=======
function edButton(id, display, tagStart, tagEnd, access) {
	return QTags.addButton( id, display, tagStart, tagEnd, access, '', -1 );
}

/* jshint ignore:end */

(function(){
	// private stuff is prefixed with an underscore
	var _domReady = function(func) {
		var t, i, DOMContentLoaded, _tryReady;

		if ( typeof jQuery !== 'undefined' ) {
>>>>>>> WPHome/master
			jQuery(document).ready(func);
		} else {
			t = _domReady;
			t.funcs = [];

			t.ready = function() {
				if ( ! t.isReady ) {
					t.isReady = true;
					for ( i = 0; i < t.funcs.length; i++ ) {
						t.funcs[i]();
					}
				}
			};

			if ( t.isReady ) {
				func();
			} else {
				t.funcs.push(func);
			}

			if ( ! t.eventAttached ) {
				if ( document.addEventListener ) {
					DOMContentLoaded = function(){document.removeEventListener('DOMContentLoaded', DOMContentLoaded, false);t.ready();};
					document.addEventListener('DOMContentLoaded', DOMContentLoaded, false);
					window.addEventListener('load', t.ready, false);
				} else if ( document.attachEvent ) {
					DOMContentLoaded = function(){if (document.readyState === 'complete'){ document.detachEvent('onreadystatechange', DOMContentLoaded);t.ready();}};
					document.attachEvent('onreadystatechange', DOMContentLoaded);
					window.attachEvent('onload', t.ready);

<<<<<<< HEAD
					(function(){
						try {
							document.documentElement.doScroll("left");
						} catch(e) {
							setTimeout(arguments.callee, 50);
=======
					_tryReady = function() {
						try {
							document.documentElement.doScroll('left');
						} catch(e) {
							setTimeout(_tryReady, 50);
>>>>>>> WPHome/master
							return;
						}

						t.ready();
<<<<<<< HEAD
					})();
=======
					};
					_tryReady();
>>>>>>> WPHome/master
				}

				t.eventAttached = true;
			}
		}
	},

	_datetime = (function() {
		var now = new Date(), zeroise;

		zeroise = function(number) {
			var str = number.toString();

<<<<<<< HEAD
			if ( str.length < 2 )
				str = "0" + str;

			return str;
		}
=======
			if ( str.length < 2 ) {
				str = '0' + str;
			}

			return str;
		};
>>>>>>> WPHome/master

		return now.getUTCFullYear() + '-' +
			zeroise( now.getUTCMonth() + 1 ) + '-' +
			zeroise( now.getUTCDate() ) + 'T' +
			zeroise( now.getUTCHours() ) + ':' +
			zeroise( now.getUTCMinutes() ) + ':' +
			zeroise( now.getUTCSeconds() ) +
			'+00:00';
	})(),
	qt;

	qt = QTags = function(settings) {
<<<<<<< HEAD
		if ( typeof(settings) == 'string' )
			settings = {id: settings};
		else if ( typeof(settings) != 'object' )
			return false;
=======
		if ( typeof(settings) === 'string' ) {
			settings = {id: settings};
		} else if ( typeof(settings) !== 'object' ) {
			return false;
		}
>>>>>>> WPHome/master

		var t = this,
			id = settings.id,
			canvas = document.getElementById(id),
			name = 'qt_' + id,
			tb, onclick, toolbar_id;

<<<<<<< HEAD
		if ( !id || !canvas )
			return false;
=======
		if ( !id || !canvas ) {
			return false;
		}
>>>>>>> WPHome/master

		t.name = name;
		t.id = id;
		t.canvas = canvas;
		t.settings = settings;

<<<<<<< HEAD
		if ( id == 'content' && typeof(adminpage) == 'string' && ( adminpage == 'post-new-php' || adminpage == 'post-php' ) ) {
=======
		if ( id === 'content' && typeof(adminpage) === 'string' && ( adminpage === 'post-new-php' || adminpage === 'post-php' ) ) {
>>>>>>> WPHome/master
			// back compat hack :-(
			edCanvas = canvas;
			toolbar_id = 'ed_toolbar';
		} else {
			toolbar_id = name + '_toolbar';
		}

		tb = document.createElement('div');
		tb.id = toolbar_id;
		tb.className = 'quicktags-toolbar';
<<<<<<< HEAD
=======
		tb.onclick = function() {
			window.wpActiveEditor = id;
		};
>>>>>>> WPHome/master

		canvas.parentNode.insertBefore(tb, canvas);
		t.toolbar = tb;

		// listen for click events
		onclick = function(e) {
			e = e || window.event;
			var target = e.target || e.srcElement, visible = target.clientWidth || target.offsetWidth, i;

			// don't call the callback on pressing the accesskey when the button is not visible
<<<<<<< HEAD
			if ( !visible )
				return;
=======
			if ( !visible ) {
				return;
			}
>>>>>>> WPHome/master

			// as long as it has the class ed_button, execute the callback
			if ( / ed_button /.test(' ' + target.className + ' ') ) {
				// we have to reassign canvas here
				t.canvas = canvas = document.getElementById(id);
				i = target.id.replace(name + '_', '');

<<<<<<< HEAD
				if ( t.theButtons[i] )
					t.theButtons[i].callback.call(t.theButtons[i], target, canvas, t);
=======
				if ( t.theButtons[i] ) {
					t.theButtons[i].callback.call(t.theButtons[i], target, canvas, t);
				}
>>>>>>> WPHome/master
			}
		};

		if ( tb.addEventListener ) {
			tb.addEventListener('click', onclick, false);
		} else if ( tb.attachEvent ) {
			tb.attachEvent('onclick', onclick);
		}

		t.getButton = function(id) {
			return t.theButtons[id];
		};

		t.getButtonElement = function(id) {
			return document.getElementById(name + '_' + id);
		};

		qt.instances[id] = t;

<<<<<<< HEAD
		if ( !qt.instances[0] ) {
			qt.instances[0] = qt.instances[id];
=======
		if ( ! qt.instances['0'] ) {
			qt.instances['0'] = qt.instances[id];
>>>>>>> WPHome/master
			_domReady( function(){ qt._buttonsInit(); } );
		}
	};

	qt.instances = {};

	qt.getInstance = function(id) {
		return qt.instances[id];
	};

	qt._buttonsInit = function() {
		var t = this, canvas, name, settings, theButtons, html, inst, ed, id, i, use,
<<<<<<< HEAD
			defaults = ',strong,em,link,block,del,ins,img,ul,ol,li,code,more,spell,close,';

		for ( inst in t.instances ) {
			if ( inst == 0 )
				continue;
=======
			defaults = ',strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,';

		for ( inst in t.instances ) {
			if ( '0' === inst ) {
				continue;
			}
>>>>>>> WPHome/master

			ed = t.instances[inst];
			canvas = ed.canvas;
			name = ed.name;
			settings = ed.settings;
			html = '';
			theButtons = {};
			use = '';

			// set buttons
<<<<<<< HEAD
			if ( settings.buttons )
				use = ','+settings.buttons+',';

			for ( i in edButtons ) {
				if ( !edButtons[i] )
					continue;

				id = edButtons[i].id;
				if ( use && defaults.indexOf(','+id+',') != -1 && use.indexOf(','+id+',') == -1 )
					continue;

				if ( !edButtons[i].instance || edButtons[i].instance == inst ) {
					theButtons[id] = edButtons[i];

					if ( edButtons[i].html )
						html += edButtons[i].html(name + '_');
				}
			}

			if ( use && use.indexOf(',fullscreen,') != -1 ) {
				theButtons['fullscreen'] = new qt.FullscreenButton();
				html += theButtons['fullscreen'].html(name + '_');
			}


			if ( 'rtl' == document.getElementsByTagName('html')[0].dir ) {
				theButtons['textdirection'] = new qt.TextDirectionButton();
				html += theButtons['textdirection'].html(name + '_');
=======
			if ( settings.buttons ) {
				use = ','+settings.buttons+',';
			}

			for ( i in edButtons ) {
				if ( !edButtons[i] ) {
					continue;
				}

				id = edButtons[i].id;
				if ( use && defaults.indexOf( ',' + id + ',' ) !== -1 && use.indexOf( ',' + id + ',' ) === -1 ) {
					continue;
				}

				if ( !edButtons[i].instance || edButtons[i].instance === inst ) {
					theButtons[id] = edButtons[i];

					if ( edButtons[i].html ) {
						html += edButtons[i].html(name + '_');
					}
				}
			}

			if ( use && use.indexOf(',fullscreen,') !== -1 ) {
				theButtons.fullscreen = new qt.FullscreenButton();
				html += theButtons.fullscreen.html(name + '_');
			}

			if ( use && use.indexOf(',dfw,') !== -1 ) {
				theButtons.dfw = new qt.DFWButton();
				html += theButtons.dfw.html( name + '_' );
			}

			if ( 'rtl' === document.getElementsByTagName('html')[0].dir ) {
				theButtons.textdirection = new qt.TextDirectionButton();
				html += theButtons.textdirection.html(name + '_');
>>>>>>> WPHome/master
			}

			ed.toolbar.innerHTML = html;
			ed.theButtons = theButtons;
<<<<<<< HEAD
=======

			if ( typeof jQuery !== 'undefined' ) {
				jQuery( document ).triggerHandler( 'quicktags-init', [ ed ] );
			}
>>>>>>> WPHome/master
		}
		t.buttonsInitDone = true;
	};

	/**
	 * Main API function for adding a button to Quicktags
	 *
	 * Adds qt.Button or qt.TagButton depending on the args. The first three args are always required.
	 * To be able to add button(s) to Quicktags, your script should be enqueued as dependent
	 * on "quicktags" and outputted in the footer. If you are echoing JS directly from PHP,
	 * use add_action( 'admin_print_footer_scripts', 'output_my_js', 100 ) or add_action( 'wp_footer', 'output_my_js', 100 )
	 *
	 * Minimum required to add a button that calls an external function:
	 *     QTags.addButton( 'my_id', 'my button', my_callback );
	 *     function my_callback() { alert('yeah!'); }
	 *
	 * Minimum required to add a button that inserts a tag:
	 *     QTags.addButton( 'my_id', 'my button', '<span>', '</span>' );
	 *     QTags.addButton( 'my_id2', 'my button', '<br />' );
	 *
<<<<<<< HEAD
	 * @param id string required Button HTML ID
	 * @param display string required Button's value="..."
	 * @param arg1 string || function required Either a starting tag to be inserted like "<span>" or a callback that is executed when the button is clicked.
	 * @param arg2 string optional Ending tag like "</span>"
	 * @param access_key string optional Access key for the button.
	 * @param title string optional Button's title="..."
	 * @param priority int optional Number representing the desired position of the button in the toolbar. 1 - 9 = first, 11 - 19 = second, 21 - 29 = third, etc.
	 * @param instance string optional Limit the button to a specifric instance of Quicktags, add to all instances if not present.
=======
	 * @param string id Required. Button HTML ID
	 * @param string display Required. Button's value="..."
	 * @param string|function arg1 Required. Either a starting tag to be inserted like "<span>" or a callback that is executed when the button is clicked.
	 * @param string arg2 Optional. Ending tag like "</span>"
	 * @param string access_key Deprecated Not used
	 * @param string title Optional. Button's title="..."
	 * @param int priority Optional. Number representing the desired position of the button in the toolbar. 1 - 9 = first, 11 - 19 = second, 21 - 29 = third, etc.
	 * @param string instance Optional. Limit the button to a specific instance of Quicktags, add to all instances if not present.
>>>>>>> WPHome/master
	 * @return mixed null or the button object that is needed for back-compat.
	 */
	qt.addButton = function( id, display, arg1, arg2, access_key, title, priority, instance ) {
		var btn;

<<<<<<< HEAD
		if ( !id || !display )
			return;
=======
		if ( !id || !display ) {
			return;
		}
>>>>>>> WPHome/master

		priority = priority || 0;
		arg2 = arg2 || '';

		if ( typeof(arg1) === 'function' ) {
			btn = new qt.Button(id, display, access_key, title, instance);
			btn.callback = arg1;
		} else if ( typeof(arg1) === 'string' ) {
			btn = new qt.TagButton(id, display, arg1, arg2, access_key, title, instance);
		} else {
			return;
		}

<<<<<<< HEAD
		if ( priority == -1 ) // back-compat
			return btn;

		if ( priority > 0 ) {
			while ( typeof(edButtons[priority]) != 'undefined' ) {
				priority++
=======
		if ( priority === -1 ) { // back-compat
			return btn;
		}

		if ( priority > 0 ) {
			while ( typeof(edButtons[priority]) !== 'undefined' ) {
				priority++;
>>>>>>> WPHome/master
			}

			edButtons[priority] = btn;
		} else {
			edButtons[edButtons.length] = btn;
		}

<<<<<<< HEAD
		if ( this.buttonsInitDone )
			this._buttonsInit(); // add the button HTML to all instances toolbars if addButton() was called too late
=======
		if ( this.buttonsInitDone ) {
			this._buttonsInit(); // add the button HTML to all instances toolbars if addButton() was called too late
		}
>>>>>>> WPHome/master
	};

	qt.insertContent = function(content) {
		var sel, startPos, endPos, scrollTop, text, canvas = document.getElementById(wpActiveEditor);

<<<<<<< HEAD
		if ( !canvas )
			return false;
=======
		if ( !canvas ) {
			return false;
		}
>>>>>>> WPHome/master

		if ( document.selection ) { //IE
			canvas.focus();
			sel = document.selection.createRange();
			sel.text = content;
			canvas.focus();
<<<<<<< HEAD
		} else if ( canvas.selectionStart || canvas.selectionStart == '0' ) { // FF, WebKit, Opera
=======
		} else if ( canvas.selectionStart || canvas.selectionStart === 0 ) { // FF, WebKit, Opera
>>>>>>> WPHome/master
			text = canvas.value;
			startPos = canvas.selectionStart;
			endPos = canvas.selectionEnd;
			scrollTop = canvas.scrollTop;

			canvas.value = text.substring(0, startPos) + content + text.substring(endPos, text.length);

<<<<<<< HEAD
			canvas.focus();
			canvas.selectionStart = startPos + content.length;
			canvas.selectionEnd = startPos + content.length;
			canvas.scrollTop = scrollTop;
=======
			canvas.selectionStart = startPos + content.length;
			canvas.selectionEnd = startPos + content.length;
			canvas.scrollTop = scrollTop;
			canvas.focus();
>>>>>>> WPHome/master
		} else {
			canvas.value += content;
			canvas.focus();
		}
		return true;
	};

	// a plain, dumb button
	qt.Button = function(id, display, access, title, instance) {
		var t = this;
		t.id = id;
		t.display = display;
<<<<<<< HEAD
		t.access = access;
=======
		t.access = '';
>>>>>>> WPHome/master
		t.title = title || '';
		t.instance = instance || '';
	};
	qt.Button.prototype.html = function(idPrefix) {
<<<<<<< HEAD
		var access = this.access ? ' accesskey="' + this.access + '"' : '';
		return '<input type="button" id="' + idPrefix + this.id + '"' + access + ' class="ed_button" title="' + this.title + '" value="' + this.display + '" />';
=======
		var title = this.title ? ' title="' + this.title + '"' : '',
			active, on, wp,
			dfw = ( wp = window.wp ) && wp.editor && wp.editor.dfw;

		if ( this.id === 'fullscreen' ) {
			return '<button type="button" id="' + idPrefix + this.id + '" class="ed_button qt-dfw qt-fullscreen"' + title + '></button>';
		} else if ( this.id === 'dfw' ) {
			active = dfw && dfw.isActive() ? '' : ' disabled="disabled"';
			on = dfw && dfw.isOn() ? ' active' : '';

			return '<button type="button" id="' + idPrefix + this.id + '" class="ed_button qt-dfw' + on + '"' + title + active + '></button>';
		}

		return '<input type="button" id="' + idPrefix + this.id + '" class="ed_button button button-small"' + title + ' value="' + this.display + '" />';
>>>>>>> WPHome/master
	};
	qt.Button.prototype.callback = function(){};

	// a button that inserts HTML tag
	qt.TagButton = function(id, display, tagStart, tagEnd, access, title, instance) {
		var t = this;
		qt.Button.call(t, id, display, access, title, instance);
		t.tagStart = tagStart;
		t.tagEnd = tagEnd;
	};
	qt.TagButton.prototype = new qt.Button();
	qt.TagButton.prototype.openTag = function(e, ed) {
		var t = this;

		if ( ! ed.openTags ) {
			ed.openTags = [];
		}
		if ( t.tagEnd ) {
			ed.openTags.push(t.id);
			e.value = '/' + e.value;
		}
	};
	qt.TagButton.prototype.closeTag = function(e, ed) {
		var t = this, i = t.isOpen(ed);

		if ( i !== false ) {
			ed.openTags.splice(i, 1);
		}

		e.value = t.display;
	};
	// whether a tag is open or not. Returns false if not open, or current open depth of the tag
	qt.TagButton.prototype.isOpen = function (ed) {
		var t = this, i = 0, ret = false;
		if ( ed.openTags ) {
			while ( ret === false && i < ed.openTags.length ) {
<<<<<<< HEAD
				ret = ed.openTags[i] == t.id ? i : false;
=======
				ret = ed.openTags[i] === t.id ? i : false;
>>>>>>> WPHome/master
				i ++;
			}
		} else {
			ret = false;
		}
		return ret;
	};
	qt.TagButton.prototype.callback = function(element, canvas, ed) {
		var t = this, startPos, endPos, cursorPos, scrollTop, v = canvas.value, l, r, i, sel, endTag = v ? t.tagEnd : '';

		if ( document.selection ) { // IE
			canvas.focus();
			sel = document.selection.createRange();
			if ( sel.text.length > 0 ) {
<<<<<<< HEAD
				if ( !t.tagEnd )
					sel.text = sel.text + t.tagStart;
				else
					sel.text = t.tagStart + sel.text + endTag;
=======
				if ( !t.tagEnd ) {
					sel.text = sel.text + t.tagStart;
				} else {
					sel.text = t.tagStart + sel.text + endTag;
				}
>>>>>>> WPHome/master
			} else {
				if ( !t.tagEnd ) {
					sel.text = t.tagStart;
				} else if ( t.isOpen(ed) === false ) {
					sel.text = t.tagStart;
					t.openTag(element, ed);
				} else {
					sel.text = endTag;
					t.closeTag(element, ed);
				}
			}
			canvas.focus();
<<<<<<< HEAD
		} else if ( canvas.selectionStart || canvas.selectionStart == '0' ) { // FF, WebKit, Opera
=======
		} else if ( canvas.selectionStart || canvas.selectionStart === 0 ) { // FF, WebKit, Opera
>>>>>>> WPHome/master
			startPos = canvas.selectionStart;
			endPos = canvas.selectionEnd;
			cursorPos = endPos;
			scrollTop = canvas.scrollTop;
			l = v.substring(0, startPos); // left of the selection
			r = v.substring(endPos, v.length); // right of the selection
			i = v.substring(startPos, endPos); // inside the selection
<<<<<<< HEAD
			if ( startPos != endPos ) {
=======
			if ( startPos !== endPos ) {
>>>>>>> WPHome/master
				if ( !t.tagEnd ) {
					canvas.value = l + i + t.tagStart + r; // insert self closing tags after the selection
					cursorPos += t.tagStart.length;
				} else {
					canvas.value = l + t.tagStart + i + endTag + r;
					cursorPos += t.tagStart.length + endTag.length;
				}
			} else {
				if ( !t.tagEnd ) {
					canvas.value = l + t.tagStart + r;
					cursorPos = startPos + t.tagStart.length;
				} else if ( t.isOpen(ed) === false ) {
					canvas.value = l + t.tagStart + r;
					t.openTag(element, ed);
					cursorPos = startPos + t.tagStart.length;
				} else {
					canvas.value = l + endTag + r;
					cursorPos = startPos + endTag.length;
					t.closeTag(element, ed);
				}
			}

<<<<<<< HEAD
			canvas.focus();
			canvas.selectionStart = cursorPos;
			canvas.selectionEnd = cursorPos;
			canvas.scrollTop = scrollTop;
=======
			canvas.selectionStart = cursorPos;
			canvas.selectionEnd = cursorPos;
			canvas.scrollTop = scrollTop;
			canvas.focus();
>>>>>>> WPHome/master
		} else { // other browsers?
			if ( !endTag ) {
				canvas.value += t.tagStart;
			} else if ( t.isOpen(ed) !== false ) {
				canvas.value += t.tagStart;
				t.openTag(element, ed);
			} else {
				canvas.value += endTag;
				t.closeTag(element, ed);
			}
			canvas.focus();
		}
	};

<<<<<<< HEAD
	// the spell button
	qt.SpellButton = function() {
		qt.Button.call(this, 'spell', quicktagsL10n.lookup, '', quicktagsL10n.dictionaryLookup);
	};
	qt.SpellButton.prototype = new qt.Button();
	qt.SpellButton.prototype.callback = function(element, canvas, ed) {
		var word = '', sel, startPos, endPos;

		if ( document.selection ) {
			canvas.focus();
			sel = document.selection.createRange();
			if ( sel.text.length > 0 ) {
				word = sel.text;
			}
		} else if ( canvas.selectionStart || canvas.selectionStart == '0' ) {
			startPos = canvas.selectionStart;
			endPos = canvas.selectionEnd;
			if ( startPos != endPos ) {
				word = canvas.value.substring(startPos, endPos);
			}
		}

		if ( word === '' ) {
			word = prompt(quicktagsL10n.wordLookup, '');
		}

		if ( word !== null && /^\w[\w ]*$/.test(word)) {
			window.open('http://www.answers.com/' + encodeURIComponent(word));
		}
	};
=======
	// removed
	qt.SpellButton = function() {};
>>>>>>> WPHome/master

	// the close tags button
	qt.CloseButton = function() {
		qt.Button.call(this, 'close', quicktagsL10n.closeTags, '', quicktagsL10n.closeAllOpenTags);
	};

	qt.CloseButton.prototype = new qt.Button();

	qt._close = function(e, c, ed) {
		var button, element, tbo = ed.openTags;

		if ( tbo ) {
			while ( tbo.length > 0 ) {
				button = ed.getButton(tbo[tbo.length - 1]);
				element = document.getElementById(ed.name + '_' + button.id);

<<<<<<< HEAD
				if ( e )
					button.callback.call(button, element, c, ed);
				else
					button.closeTag(element, ed);
=======
				if ( e ) {
					button.callback.call(button, element, c, ed);
				} else {
					button.closeTag(element, ed);
				}
>>>>>>> WPHome/master
			}
		}
	};

	qt.CloseButton.prototype.callback = qt._close;

	qt.closeAllTags = function(editor_id) {
		var ed = this.getInstance(editor_id);
		qt._close('', ed.canvas, ed);
	};

	// the link button
	qt.LinkButton = function() {
<<<<<<< HEAD
		qt.TagButton.call(this, 'link', 'link', '', '</a>', 'a');
=======
		qt.TagButton.call(this, 'link', 'link', '', '</a>');
>>>>>>> WPHome/master
	};
	qt.LinkButton.prototype = new qt.TagButton();
	qt.LinkButton.prototype.callback = function(e, c, ed, defaultValue) {
		var URL, t = this;

<<<<<<< HEAD
		if ( typeof(wpLink) != 'undefined' ) {
			wpLink.open();
			return;
		}

		if ( ! defaultValue )
			defaultValue = 'http://';
=======
		if ( typeof wpLink !== 'undefined' ) {
			wpLink.open( ed.id );
			return;
		}

		if ( ! defaultValue ) {
			defaultValue = 'http://';
		}
>>>>>>> WPHome/master

		if ( t.isOpen(ed) === false ) {
			URL = prompt(quicktagsL10n.enterURL, defaultValue);
			if ( URL ) {
				t.tagStart = '<a href="' + URL + '">';
				qt.TagButton.prototype.callback.call(t, e, c, ed);
			}
		} else {
			qt.TagButton.prototype.callback.call(t, e, c, ed);
		}
	};

	// the img button
	qt.ImgButton = function() {
<<<<<<< HEAD
		qt.TagButton.call(this, 'img', 'img', '', '', 'm');
=======
		qt.TagButton.call(this, 'img', 'img', '', '');
>>>>>>> WPHome/master
	};
	qt.ImgButton.prototype = new qt.TagButton();
	qt.ImgButton.prototype.callback = function(e, c, ed, defaultValue) {
		if ( ! defaultValue ) {
			defaultValue = 'http://';
		}
		var src = prompt(quicktagsL10n.enterImageURL, defaultValue), alt;
		if ( src ) {
			alt = prompt(quicktagsL10n.enterImageDescription, '');
			this.tagStart = '<img src="' + src + '" alt="' + alt + '" />';
			qt.TagButton.prototype.callback.call(this, e, c, ed);
		}
	};

	qt.FullscreenButton = function() {
		qt.Button.call(this, 'fullscreen', quicktagsL10n.fullscreen, 'f', quicktagsL10n.toggleFullscreen);
	};
	qt.FullscreenButton.prototype = new qt.Button();
	qt.FullscreenButton.prototype.callback = function(e, c) {
<<<<<<< HEAD
		if ( !c.id || typeof(fullscreen) == 'undefined' )
			return;

		fullscreen.on();
	};

	qt.TextDirectionButton = function() {
		qt.Button.call(this, 'textdirection', quicktagsL10n.textdirection, '', quicktagsL10n.toggleTextdirection)
	};
	qt.TextDirectionButton.prototype = new qt.Button();
	qt.TextDirectionButton.prototype.callback = function(e, c) {
		var isRTL = ( 'rtl' == document.getElementsByTagName('html')[0].dir ),
			currentDirection = c.style.direction;

		if ( ! currentDirection )
			currentDirection = ( isRTL ) ? 'rtl' : 'ltr';

		c.style.direction = ( 'rtl' == currentDirection ) ? 'ltr' : 'rtl';
		c.focus();
	}

	// ensure backward compatibility
	edButtons[10] = new qt.TagButton('strong','b','<strong>','</strong>','b');
	edButtons[20] = new qt.TagButton('em','i','<em>','</em>','i'),
	edButtons[30] = new qt.LinkButton(), // special case
	edButtons[40] = new qt.TagButton('block','b-quote','\n\n<blockquote>','</blockquote>\n\n','q'),
	edButtons[50] = new qt.TagButton('del','del','<del datetime="' + _datetime + '">','</del>','d'),
	edButtons[60] = new qt.TagButton('ins','ins','<ins datetime="' + _datetime + '">','</ins>','s'),
	edButtons[70] = new qt.ImgButton(), // special case
	edButtons[80] = new qt.TagButton('ul','ul','<ul>\n','</ul>\n\n','u'),
	edButtons[90] = new qt.TagButton('ol','ol','<ol>\n','</ol>\n\n','o'),
	edButtons[100] = new qt.TagButton('li','li','\t<li>','</li>\n','l'),
	edButtons[110] = new qt.TagButton('code','code','<code>','</code>','c'),
	edButtons[120] = new qt.TagButton('more','more','<!--more-->','','t'),
	edButtons[130] = new qt.SpellButton(),
	edButtons[140] = new qt.CloseButton()
=======
		if ( ! c.id || typeof wp === 'undefined' || ! wp.editor || ! wp.editor.fullscreen ) {
			return;
		}

		wp.editor.fullscreen.on();
	};

	qt.DFWButton = function() {
		qt.Button.call( this, 'dfw', '', 'f', quicktagsL10n.dfw );
	};
	qt.DFWButton.prototype = new qt.Button();
	qt.DFWButton.prototype.callback = function() {
		var wp;

		if ( ! ( wp = window.wp ) || ! wp.editor || ! wp.editor.dfw ) {
			return;
		}

		window.wp.editor.dfw.toggle();
	};

	qt.TextDirectionButton = function() {
		qt.Button.call(this, 'textdirection', quicktagsL10n.textdirection, '', quicktagsL10n.toggleTextdirection);
	};
	qt.TextDirectionButton.prototype = new qt.Button();
	qt.TextDirectionButton.prototype.callback = function(e, c) {
		var isRTL = ( 'rtl' === document.getElementsByTagName('html')[0].dir ),
			currentDirection = c.style.direction;

		if ( ! currentDirection ) {
			currentDirection = ( isRTL ) ? 'rtl' : 'ltr';
		}

		c.style.direction = ( 'rtl' === currentDirection ) ? 'ltr' : 'rtl';
		c.focus();
	};

	// ensure backward compatibility
	edButtons[10] = new qt.TagButton('strong','b','<strong>','</strong>');
	edButtons[20] = new qt.TagButton('em','i','<em>','</em>'),
	edButtons[30] = new qt.LinkButton(), // special case
	edButtons[40] = new qt.TagButton('block','b-quote','\n\n<blockquote>','</blockquote>\n\n'),
	edButtons[50] = new qt.TagButton('del','del','<del datetime="' + _datetime + '">','</del>'),
	edButtons[60] = new qt.TagButton('ins','ins','<ins datetime="' + _datetime + '">','</ins>'),
	edButtons[70] = new qt.ImgButton(), // special case
	edButtons[80] = new qt.TagButton('ul','ul','<ul>\n','</ul>\n\n'),
	edButtons[90] = new qt.TagButton('ol','ol','<ol>\n','</ol>\n\n'),
	edButtons[100] = new qt.TagButton('li','li','\t<li>','</li>\n'),
	edButtons[110] = new qt.TagButton('code','code','<code>','</code>'),
	edButtons[120] = new qt.TagButton('more','more','<!--more-->\n\n',''),
	edButtons[140] = new qt.CloseButton();
>>>>>>> WPHome/master

})();
