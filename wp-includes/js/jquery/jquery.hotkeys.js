/******************************************************************************************************************************

<<<<<<< HEAD
 * @ Original idea by by Binny V A, Original version: 2.00.A 
 * @ http://www.openjs.com/scripts/events/keyboard_shortcuts/
 * @ Original License : BSD
 
 * @ jQuery Plugin by Tzury Bar Yochay 
        mail: tzury.by@gmail.com
        blog: evalinux.wordpress.com
        face: facebook.com/profile.php?id=513676303
        
        (c) Copyrights 2007
        
 * @ jQuery Plugin version Beta (0.0.2)
 * @ License: jQuery-License.
 
=======
 * @ Original idea by by Binny V A, Original version: 2.00.A
 * @ http://www.openjs.com/scripts/events/keyboard_shortcuts/
 * @ Original License : BSD

 * @ jQuery Plugin by Tzury Bar Yochay
        mail: tzury.by@gmail.com
        blog: evalinux.wordpress.com
        face: facebook.com/profile.php?id=513676303

        (c) Copyrights 2007

 * @ jQuery Plugin version Beta (0.0.2)
 * @ License: jQuery-License.

>>>>>>> WPHome/master
TODO:
    add queue support (as in gmail) e.g. 'x' then 'y', etc.
    add mouse + mouse wheel events.

USAGE:
    $.hotkeys.add('Ctrl+c', function(){ alert('copy anyone?');});
    $.hotkeys.add('Ctrl+c', {target:'div#editor', type:'keyup', propagate: true},function(){ alert('copy anyone?');});>
<<<<<<< HEAD
    $.hotkeys.remove('Ctrl+c'); 
    $.hotkeys.remove('Ctrl+c', {target:'div#editor', type:'keypress'}); 
    
=======
    $.hotkeys.remove('Ctrl+c');
    $.hotkeys.remove('Ctrl+c', {target:'div#editor', type:'keypress'});

>>>>>>> WPHome/master
******************************************************************************************************************************/
(function (jQuery){
    this.version = '(beta)(0.0.3)';
	this.all = {};
    this.special_keys = {
<<<<<<< HEAD
        27: 'esc', 9: 'tab', 32:'space', 13: 'return', 8:'backspace', 145: 'scroll', 20: 'capslock', 
        144: 'numlock', 19:'pause', 45:'insert', 36:'home', 46:'del',35:'end', 33: 'pageup', 
        34:'pagedown', 37:'left', 38:'up', 39:'right',40:'down', 112:'f1',113:'f2', 114:'f3', 
        115:'f4', 116:'f5', 117:'f6', 118:'f7', 119:'f8', 120:'f9', 121:'f10', 122:'f11', 123:'f12'};
        
    this.shift_nums = { "`":"~", "1":"!", "2":"@", "3":"#", "4":"$", "5":"%", "6":"^", "7":"&", 
        "8":"*", "9":"(", "0":")", "-":"_", "=":"+", ";":":", "'":"\"", ",":"<", 
        ".":">",  "/":"?",  "\\":"|" };
        
=======
        27: 'esc', 9: 'tab', 32:'space', 13: 'return', 8:'backspace', 145: 'scroll', 20: 'capslock',
        144: 'numlock', 19:'pause', 45:'insert', 36:'home', 46:'del',35:'end', 33: 'pageup',
        34:'pagedown', 37:'left', 38:'up', 39:'right',40:'down', 112:'f1',113:'f2', 114:'f3',
        115:'f4', 116:'f5', 117:'f6', 118:'f7', 119:'f8', 120:'f9', 121:'f10', 122:'f11', 123:'f12'};

    this.shift_nums = { "`":"~", "1":"!", "2":"@", "3":"#", "4":"$", "5":"%", "6":"^", "7":"&",
        "8":"*", "9":"(", "0":")", "-":"_", "=":"+", ";":":", "'":"\"", ",":"<",
        ".":">",  "/":"?",  "\\":"|" };

>>>>>>> WPHome/master
    this.add = function(combi, options, callback) {
        if (jQuery.isFunction(options)){
            callback = options;
            options = {};
        }
        var opt = {},
            defaults = {type: 'keydown', propagate: false, disableInInput: false, target: jQuery('html')[0]},
            that = this;
        opt = jQuery.extend( opt , defaults, options || {} );
<<<<<<< HEAD
        combi = combi.toLowerCase();        
        
=======
        combi = combi.toLowerCase();

>>>>>>> WPHome/master
        // inspect if keystroke matches
        var inspector = function(event) {
            // WP: not needed with newer jQuery
            // event = jQuery.event.fix(event); // jQuery event normalization.
            var element = event.target;
            // @ TextNode -> nodeType == 3
            // WP: not needed with newer jQuery
            // element = (element.nodeType==3) ? element.parentNode : element;
<<<<<<< HEAD
            
            if(opt['disableInInput']) { // Disable shortcut keys in Input, Textarea fields
                var target = jQuery(element);
                if( target.is("input") || target.is("textarea")){
                    return;
=======

            if ( opt['disableInInput'] ) { // Disable shortcut keys in Input, Textarea fields
                var target = jQuery(element);

				if ( ( target.is('input') || target.is('textarea') ) &&
					( ! opt.noDisable || ! target.is( opt.noDisable ) ) ) {

					return;
>>>>>>> WPHome/master
                }
            }
            var code = event.which,
                type = event.type,
                character = String.fromCharCode(code).toLowerCase(),
                special = that.special_keys[code],
                shift = event.shiftKey,
                ctrl = event.ctrlKey,
                alt= event.altKey,
                meta = event.metaKey,
                propagate = true, // default behaivour
                mapPoint = null;
<<<<<<< HEAD
            
            // in opera + safari, the event.target is unpredictable.
            // for example: 'keydown' might be associated with HtmlBodyElement 
            // or the element where you last clicked with your mouse.
            // WP: needed for all browsers 
=======

            // in opera + safari, the event.target is unpredictable.
            // for example: 'keydown' might be associated with HtmlBodyElement
            // or the element where you last clicked with your mouse.
            // WP: needed for all browsers
>>>>>>> WPHome/master
            // if (jQuery.browser.opera || jQuery.browser.safari){
                while (!that.all[element] && element.parentNode){
                    element = element.parentNode;
                }
            // }
            var cbMap = that.all[element].events[type].callbackMap;
            if(!shift && !ctrl && !alt && !meta) { // No Modifiers
                mapPoint = cbMap[special] ||  cbMap[character]
			}
            // deals with combinaitons (alt|ctrl|shift+anything)
            else{
                var modif = '';
                if(alt) modif +='alt+';
                if(ctrl) modif+= 'ctrl+';
                if(shift) modif += 'shift+';
                if(meta) modif += 'meta+';
                // modifiers + special keys or modifiers + characters or modifiers + shift characters
                mapPoint = cbMap[modif+special] || cbMap[modif+character] || cbMap[modif+that.shift_nums[character]]
            }
            if (mapPoint){
                mapPoint.cb(event);
                if(!mapPoint.propagate) {
                    event.stopPropagation();
                    event.preventDefault();
                    return false;
                }
            }
<<<<<<< HEAD
		};        
=======
		};
>>>>>>> WPHome/master
        // first hook for this element
        if (!this.all[opt.target]){
            this.all[opt.target] = {events:{}};
        }
        if (!this.all[opt.target].events[opt.type]){
            this.all[opt.target].events[opt.type] = {callbackMap: {}}
            jQuery.event.add(opt.target, opt.type, inspector);
<<<<<<< HEAD
        }        
        this.all[opt.target].events[opt.type].callbackMap[combi] =  {cb: callback, propagate:opt.propagate};                
        return jQuery;
	};    
=======
        }
        this.all[opt.target].events[opt.type].callbackMap[combi] =  {cb: callback, propagate:opt.propagate};
        return jQuery;
	};
>>>>>>> WPHome/master
    this.remove = function(exp, opt) {
        opt = opt || {};
        target = opt.target || jQuery('html')[0];
        type = opt.type || 'keydown';
<<<<<<< HEAD
		exp = exp.toLowerCase();        
        delete this.all[target].events[type].callbackMap[exp]        
        return jQuery;
	};
    jQuery.hotkeys = this;
    return jQuery;    
})(jQuery);
=======
		exp = exp.toLowerCase();
        delete this.all[target].events[type].callbackMap[exp]
        return jQuery;
	};
    jQuery.hotkeys = this;
    return jQuery;
})(jQuery);
>>>>>>> WPHome/master
