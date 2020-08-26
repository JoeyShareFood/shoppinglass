/*! Magnific Popup - v0.9.4 - 2013-08-07
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2013 Dmitry Semenov; */
;(function(j203) {

/*>>core*/
/**
 *
 * Magnific Popup Core JS file
 *
 */


/**
 * Private static constants
 */
var CLOSE_EVENT = 'Close',
  BEFORE_CLOSE_EVENT = 'BeforeClose',
  AFTER_CLOSE_EVENT = 'AfterClose',
  BEFORE_APPEND_EVENT = 'BeforeAppend',
  MARKUP_PARSE_EVENT = 'MarkupParse',
  OPEN_EVENT = 'Open',
  CHANGE_EVENT = 'Change',
  NS = 'mfp',
  EVENT_NS = '.' + NS,
  READY_CLASS = 'mfp-ready',
  REMOVING_CLASS = 'mfp-removing',
  PREVENT_CLOSE_CLASS = 'mfp-prevent-close';


/**
 * Private vars
 */
var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
  MagnificPopup = function(){},
  _isJQ = !!(window.jQuery),
  _prevStatus,
  _window = j203(window),
  _body,
  _document,
  _prevContentType,
  _wrapClasses,
  _currPopupType;


/**
 * Private functions
 */
var _mfpOn = function(name, f) {
    mfp.ev.on(NS + name + EVENT_NS, f);
  },
  _getEl = function(className, appendTo, html, raw) {
    var el = document.createElement('div');
    el.className = 'mfp-'+className;
    if(html) {
      el.innerHTML = html;
    }
    if(!raw) {
      el = j203(el);
      if(appendTo) {
        el.appendTo(appendTo);
      }
    } else if(appendTo) {
      appendTo.appendChild(el);
    }
    return el;
  },
  _mfpTrigger = function(e, data) {
    mfp.ev.triggerHandler(NS + e, data);

    if(mfp.st.callbacks) {
      // converts "mfpEventName" to "eventName" callback and triggers it if it's present
      e = e.charAt(0).toLowerCase() + e.slice(1);
      if(mfp.st.callbacks[e]) {
        mfp.st.callbacks[e].apply(mfp, j203.isArray(data) ? data : [data]);
      }
    }
  },
  _setFocus = function() {
    (mfp.st.focus ? mfp.content.find(mfp.st.focus).eq(0) : mfp.wrap).trigger('focus');
  },
  _getCloseBtn = function(type) {
    if(type !== _currPopupType || !mfp.currTemplate.closeBtn) {
      mfp.currTemplate.closeBtn = j203( mfp.st.closeMarkup.replace('%title%', mfp.st.tClose ) );
      _currPopupType = type;
    }
    return mfp.currTemplate.closeBtn;
  },
  // Initialize Magnific Popup only when called at least once
  _checkInstance = function() {
    if(!j203.magnificPopup.instance) {
      mfp = new MagnificPopup();
      mfp.init();
      j203.magnificPopup.instance = mfp;
    }
  },
  // Check to close popup or not
  // "target" is an element that was clicked
  _checkIfClose = function(target) {

    if(j203(target).hasClass(PREVENT_CLOSE_CLASS)) {
      return;
    }

    var closeOnContent = mfp.st.closeOnContentClick;
    var closeOnBg = mfp.st.closeOnBgClick;

    if(closeOnContent && closeOnBg) {
      return true;
    } else {

      // We close the popup if click is on close button or on preloader. Or if there is no content.
      if(!mfp.content || j203(target).hasClass('mfp-close') || (mfp.preloader && target === mfp.preloader[0]) ) {
        return true;
      }

      // if click is outside the content
      if(  (target !== mfp.content[0] && !j203.contains(mfp.content[0], target))  ) {
        if(closeOnBg) {
          // last check, if the clicked element is in DOM, (in case it's removed onclick)
          if( j203.contains(document, target) ) {
            return true;
          }
        }
      } else if(closeOnContent) {
        return true;
      }

    }
    return false;
  },
  // CSS transition detection, http://stackoverflow.com/questions/7264899/detect-css-transitions-using-javascript-and-without-modernizr
  supportsTransitions = function() {
    var s = document.createElement('p').style, // 's' for style. better to create an element if body yet to exist
      v = ['ms','O','Moz','Webkit']; // 'v' for vendor

    if( s['transition'] !== undefined ) {
      return true;
    }

    while( v.length ) {
      if( v.pop() + 'Transition' in s ) {
        return true;
      }
    }

    return false;
  };



/**
 * Public functions
 */
MagnificPopup.prototype = {

  constructor: MagnificPopup,

  /**
   * Initializes Magnific Popup plugin.
   * This function is triggered only once when j203.fn.magnificPopup or j203.magnificPopup is executed
   */
  init: function() {
    var appVersion = navigator.appVersion;
    mfp.isIE7 = appVersion.indexOf("MSIE 7.") !== -1;
    mfp.isIE8 = appVersion.indexOf("MSIE 8.") !== -1;
    mfp.isLowIE = mfp.isIE7 || mfp.isIE8;
    mfp.isAndroid = (/android/gi).test(appVersion);
    mfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
    mfp.supportsTransition = supportsTransitions();

    // We disable fixed positioned lightbox on devices that don't handle it nicely.
    // If you know a better way of detecting this - let me know.
    mfp.probablyMobile = (mfp.isAndroid || mfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
    _body = j203(document.body);
    _document = j203(document);

    mfp.popupsCache = {};
  },

  /**
   * Opens popup
   * @param  data [description]
   */
  open: function(data) {

    var i;

    if(data.isObj === false) {
      // convert jQuery collection to array to avoid conflicts later
      mfp.items = data.items.toArray();

      mfp.index = 0;
      var items = data.items,
        item;
      for(i = 0; i < items.length; i++) {
        item = items[i];
        if(item.parsed) {
          item = item.el[0];
        }
        if(item === data.el[0]) {
          mfp.index = i;
          break;
        }
      }
    } else {
      mfp.items = j203.isArray(data.items) ? data.items : [data.items];
      mfp.index = data.index || 0;
    }

    // if popup is already opened - we just update the content
    if(mfp.isOpen) {
      mfp.updateItemHTML();
      return;
    }

    mfp.types = [];
    _wrapClasses = '';
    if(data.mainEl && data.mainEl.length) {
      mfp.ev = data.mainEl.eq(0);
    } else {
      mfp.ev = _document;
    }

    if(data.key) {
      if(!mfp.popupsCache[data.key]) {
        mfp.popupsCache[data.key] = {};
      }
      mfp.currTemplate = mfp.popupsCache[data.key];
    } else {
      mfp.currTemplate = {};
    }



    mfp.st = j203.extend(true, {}, j203.magnificPopup.defaults, data );
    mfp.fixedContentPos = mfp.st.fixedContentPos === 'auto' ? !mfp.probablyMobile : mfp.st.fixedContentPos;

    if(mfp.st.modal) {
      mfp.st.closeOnContentClick = false;
      mfp.st.closeOnBgClick = false;
      mfp.st.showCloseBtn = false;
      mfp.st.enableEscapeKey = false;
    }


    // Building markup
    // main containers are created only once
    if(!mfp.bgOverlay) {

      // Dark overlay
      mfp.bgOverlay = _getEl('bg').on('click'+EVENT_NS, function() {
        mfp.close();
      });

      mfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click'+EVENT_NS, function(e) {
        if(_checkIfClose(e.target)) {
          mfp.close();
        }
      });

      mfp.container = _getEl('container', mfp.wrap);
    }

    mfp.contentContainer = _getEl('content');
    if(mfp.st.preloader) {
      mfp.preloader = _getEl('preloader', mfp.container, mfp.st.tLoading);
    }


    // Initializing modules
    var modules = j203.magnificPopup.modules;
    for(i = 0; i < modules.length; i++) {
      var n = modules[i];
      n = n.charAt(0).toUpperCase() + n.slice(1);
      mfp['init'+n].call(mfp);
    }
    _mfpTrigger('BeforeOpen');


    if(mfp.st.showCloseBtn) {
      // Close button
      if(!mfp.st.closeBtnInside) {
        mfp.wrap.append( _getCloseBtn() );
      } else {
        _mfpOn(MARKUP_PARSE_EVENT, function(e, template, values, item) {
          values.close_replaceWith = _getCloseBtn(item.type);
        });
        _wrapClasses += ' mfp-close-btn-in';
      }
    }

    if(mfp.st.alignTop) {
      _wrapClasses += ' mfp-align-top';
    }



    if(mfp.fixedContentPos) {
      mfp.wrap.css({
        overflow: mfp.st.overflowY,
        overflowX: 'hidden',
        overflowY: mfp.st.overflowY
      });
    } else {
      mfp.wrap.css({
        top: _window.scrollTop(),
        position: 'absolute'
      });
    }
    if( mfp.st.fixedBgPos === false || (mfp.st.fixedBgPos === 'auto' && !mfp.fixedContentPos) ) {
      mfp.bgOverlay.css({
        height: _document.height(),
        position: 'absolute'
      });
    }



    if(mfp.st.enableEscapeKey) {
      // Close on ESC key
      _document.on('keyup' + EVENT_NS, function(e) {
        if(e.keyCode === 27) {
          mfp.close();
        }
      });
    }

    _window.on('resize' + EVENT_NS, function() {
      mfp.updateSize();
    });


    if(!mfp.st.closeOnContentClick) {
      _wrapClasses += ' mfp-auto-cursor';
    }

    if(_wrapClasses)
      mfp.wrap.addClass(_wrapClasses);


    // this triggers recalculation of layout, so we get it once to not to trigger twice
    var windowHeight = mfp.wH = _window.height();


    var windowStyles = {};

    if( mfp.fixedContentPos ) {
            if(mfp._hasScrollBar(windowHeight)){
                var s = mfp._getScrollbarSize();
                if(s) {
                    windowStyles.paddingRight = s;
                }
            }
        }

    if(mfp.fixedContentPos) {
      if(!mfp.isIE7) {
        windowStyles.overflow = 'hidden';
      } else {
        // ie7 double-scroll bug
        j203('body, html').css('overflow', 'hidden');
      }
    }



    var classesToadd = mfp.st.mainClass;
    if(mfp.isIE7) {
      classesToadd += ' mfp-ie7';
    }
    if(classesToadd) {
      mfp._addClassToMFP( classesToadd );
    }

    // add content
    mfp.updateItemHTML();

    _mfpTrigger('BuildControls');


    // remove scrollbar, add padding e.t.c
    j203('html').css(windowStyles);

    // add everything to DOM
    mfp.bgOverlay.add(mfp.wrap).prependTo( document.body );



    // Save last focused element
    mfp._lastFocusedEl = document.activeElement;

    // Wait for next cycle to allow CSS transition
    setTimeout(function() {

      if(mfp.content) {
        mfp._addClassToMFP(READY_CLASS);
        _setFocus();
      } else {
        // if content is not defined (not loaded e.t.c) we add class only for BG
        mfp.bgOverlay.addClass(READY_CLASS);
      }

      // Trap the focus in popup
      _document.on('focusin' + EVENT_NS, function (e) {
        if( e.target !== mfp.wrap[0] && !j203.contains(mfp.wrap[0], e.target) ) {
          _setFocus();
          return false;
        }
      });

    }, 16);

    mfp.isOpen = true;
    mfp.updateSize(windowHeight);
    _mfpTrigger(OPEN_EVENT);
  },

  /**
   * Closes the popup
   */
  close: function() {
    if(!mfp.isOpen) return;
    _mfpTrigger(BEFORE_CLOSE_EVENT);

    mfp.isOpen = false;
    // for CSS3 animation
    if(mfp.st.removalDelay && !mfp.isLowIE && mfp.supportsTransition )  {
      mfp._addClassToMFP(REMOVING_CLASS);
      setTimeout(function() {
        mfp._close();
      }, mfp.st.removalDelay);
    } else {
      mfp._close();
    }
  },

  /**
   * Helper for close() function
   */
  _close: function() {
    _mfpTrigger(CLOSE_EVENT);

    var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

    mfp.bgOverlay.detach();
    mfp.wrap.detach();
    mfp.container.empty();

    if(mfp.st.mainClass) {
      classesToRemove += mfp.st.mainClass + ' ';
    }

    mfp._removeClassFromMFP(classesToRemove);

    if(mfp.fixedContentPos) {
      var windowStyles = {paddingRight: ''};
      if(mfp.isIE7) {
        j203('body, html').css('overflow', '');
      } else {
        windowStyles.overflow = '';
      }
      j203('html').css(windowStyles);
    }

    _document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
    mfp.ev.off(EVENT_NS);

    // clean up DOM elements that aren't removed
    mfp.wrap.attr('class', 'mfp-wrap').removeAttr('style');
    mfp.bgOverlay.attr('class', 'mfp-bg');
    mfp.container.attr('class', 'mfp-container');

    // remove close button from target element
    if(mfp.st.showCloseBtn &&
    (!mfp.st.closeBtnInside || mfp.currTemplate[mfp.currItem.type] === true)) {
      if(mfp.currTemplate.closeBtn)
        mfp.currTemplate.closeBtn.detach();
    }


    if(mfp._lastFocusedEl) {
      j203(mfp._lastFocusedEl).trigger('focus'); // put tab focus back
    }
    mfp.currItem = null;
    mfp.content = null;
    mfp.currTemplate = null;
    mfp.prevHeight = 0;

    _mfpTrigger(AFTER_CLOSE_EVENT);
  },

  updateSize: function(winHeight) {

    if(mfp.isIOS) {
      // fixes iOS nav bars https://github.com/dimsemenov/Magnific-Popup/issues/2
      var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
      var height = window.innerHeight * zoomLevel;
      mfp.wrap.css('height', height);
      mfp.wH = height;
    } else {
      mfp.wH = winHeight || _window.height();
    }
    // Fixes #84: popup incorrectly positioned with position:relative on body
    if(!mfp.fixedContentPos) {
      mfp.wrap.css('height', mfp.wH);
    }

    _mfpTrigger('Resize');

  },

  /**
   * Set content of popup based on current index
   */
  updateItemHTML: function() {
    var item = mfp.items[mfp.index];

    // Detach and perform modifications
    mfp.contentContainer.detach();

    if(mfp.content)
      mfp.content.detach();

    if(!item.parsed) {
      item = mfp.parseEl( mfp.index );
    }

    var type = item.type;

    _mfpTrigger('BeforeChange', [mfp.currItem ? mfp.currItem.type : '', type]);
    // BeforeChange event works like so:
    // _mfpOn('BeforeChange', function(e, prevType, newType) { });

    mfp.currItem = item;





    if(!mfp.currTemplate[type]) {
      var markup = mfp.st[type] ? mfp.st[type].markup : false;

      // allows to modify markup
      _mfpTrigger('FirstMarkupParse', markup);

      if(markup) {
        mfp.currTemplate[type] = j203(markup);
      } else {
        // if there is no markup found we just define that template is parsed
        mfp.currTemplate[type] = true;
      }
    }

    if(_prevContentType && _prevContentType !== item.type) {
      mfp.container.removeClass('mfp-'+_prevContentType+'-holder');
    }

    var newContent = mfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, mfp.currTemplate[type]);
    mfp.appendContent(newContent, type);

    item.preloaded = true;

    _mfpTrigger(CHANGE_EVENT, item);
    _prevContentType = item.type;

    // Append container back after its content changed
    mfp.container.prepend(mfp.contentContainer);

    _mfpTrigger('AfterChange');
  },


  /**
   * Set HTML content of popup
   */
  appendContent: function(newContent, type) {
    mfp.content = newContent;

    if(newContent) {
      if(mfp.st.showCloseBtn && mfp.st.closeBtnInside &&
        mfp.currTemplate[type] === true) {
        // if there is no markup, we just append close button element inside
        if(!mfp.content.find('.mfp-close').length) {
          mfp.content.append(_getCloseBtn());
        }
      } else {
        mfp.content = newContent;
      }
    } else {
      mfp.content = '';
    }

    _mfpTrigger(BEFORE_APPEND_EVENT);
    mfp.container.addClass('mfp-'+type+'-holder');

    mfp.contentContainer.append(mfp.content);
  },




  /**
   * Creates Magnific Popup data object based on given data
   * @param  {int} index Index of item to parse
   */
  parseEl: function(index) {
    var item = mfp.items[index],
      type = item.type;

    if(item.tagName) {
      item = { el: j203(item) };
    } else {
      item = { data: item, src: item.src };
    }

    if(item.el) {
      var types = mfp.types;

      // check for 'mfp-TYPE' class
      for(var i = 0; i < types.length; i++) {
        if( item.el.hasClass('mfp-'+types[i]) ) {
          type = types[i];
          break;
        }
      }

      item.src = item.el.attr('data-mfp-src');
      if(!item.src) {
        item.src = item.el.attr('href');
      }
    }

    item.type = type || mfp.st.type || 'inline';
    item.index = index;
    item.parsed = true;
    mfp.items[index] = item;
    _mfpTrigger('ElementParse', item);

    return mfp.items[index];
  },


  /**
   * Initializes single popup or a group of popups
   */
  addGroup: function(el, options) {
    var eHandler = function(e) {
      e.mfpEl = this;
      mfp._openClick(e, el, options);
    };

    if(!options) {
      options = {};
    }

    var eName = 'click.magnificPopup';
    options.mainEl = el;

    if(options.items) {
      options.isObj = true;
      el.off(eName).on(eName, eHandler);
    } else {
      options.isObj = false;
      if(options.delegate) {
        el.off(eName).on(eName, options.delegate , eHandler);
      } else {
        options.items = el;
        el.off(eName).on(eName, eHandler);
      }
    }
  },
  _openClick: function(e, el, options) {
    var midClick = options.midClick !== undefined ? options.midClick : j203.magnificPopup.defaults.midClick;


    if(!midClick && ( e.which === 2 || e.ctrlKey || e.metaKey ) ) {
      return;
    }

    var disableOn = options.disableOn !== undefined ? options.disableOn : j203.magnificPopup.defaults.disableOn;

    if(disableOn) {
      if(j203.isFunction(disableOn)) {
        if( !disableOn.call(mfp) ) {
          return true;
        }
      } else { // else it's number
        if( _window.width() < disableOn ) {
          return true;
        }
      }
    }

    if(e.type) {
      e.preventDefault();

      // This will prevent popup from closing if element is inside and popup is already opened
      if(mfp.isOpen) {
        e.stopPropagation();
      }
    }


    options.el = j203(e.mfpEl);
    if(options.delegate) {
      options.items = el.find(options.delegate);
    }
    mfp.open(options);
  },


  /**
   * Updates text on preloader
   */
  updateStatus: function(status, text) {

    if(mfp.preloader) {
      if(_prevStatus !== status) {
        mfp.container.removeClass('mfp-s-'+_prevStatus);
      }

      if(!text && status === 'loading') {
        text = mfp.st.tLoading;
      }

      var data = {
        status: status,
        text: text
      };
      // allows to modify status
      _mfpTrigger('UpdateStatus', data);

      status = data.status;
      text = data.text;

      mfp.preloader.html(text);

      mfp.preloader.find('a').on('click', function(e) {
        e.stopImmediatePropagation();
      });

      mfp.container.addClass('mfp-s-'+status);
      _prevStatus = status;
    }
  },


  /*
    "Private" helpers that aren't private at all
   */
  _addClassToMFP: function(cName) {
    mfp.bgOverlay.addClass(cName);
    mfp.wrap.addClass(cName);
  },
  _removeClassFromMFP: function(cName) {
    this.bgOverlay.removeClass(cName);
    mfp.wrap.removeClass(cName);
  },
  _hasScrollBar: function(winHeight) {
    return (  (mfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()) );
  },
  _parseMarkup: function(template, values, item) {
    var arr;
    if(item.data) {
      values = j203.extend(item.data, values);
    }
    _mfpTrigger(MARKUP_PARSE_EVENT, [template, values, item] );

    j203.each(values, function(key, value) {
      if(value === undefined || value === false) {
        return true;
      }
      arr = key.split('_');
      if(arr.length > 1) {
        var el = template.find(EVENT_NS + '-'+arr[0]);

        if(el.length > 0) {
          var attr = arr[1];
          if(attr === 'replaceWith') {
            if(el[0] !== value[0]) {
              el.replaceWith(value);
            }
          } else if(attr === 'img') {
            if(el.is('img')) {
              el.attr('src', value);
            } else {
              el.replaceWith( '<img src="'+value+'" class="' + el.attr('class') + '" />' );
            }
          } else {
            el.attr(arr[1], value);
          }
        }

      } else {
        template.find(EVENT_NS + '-'+key).html(value);
      }
    });
  },

  _getScrollbarSize: function() {
    // thx David
    if(mfp.scrollbarSize === undefined) {
      var scrollDiv = document.createElement("div");
      scrollDiv.id = "mfp-sbm";
      scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
      document.body.appendChild(scrollDiv);
      mfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
      document.body.removeChild(scrollDiv);
    }
    return mfp.scrollbarSize;
  }

}; /* MagnificPopup core prototype end */




/**
 * Public static functions
 */
j203.magnificPopup = {
  instance: null,
  proto: MagnificPopup.prototype,
  modules: [],

  open: function(options, index) {
    _checkInstance();

    if(!options)
      options = {};

    options.isObj = true;
    options.index = index || 0;
    return this.instance.open(options);
  },

  close: function() {
    return j203.magnificPopup.instance.close();
  },

  registerModule: function(name, module) {
    if(module.options) {
      j203.magnificPopup.defaults[name] = module.options;
    }
    j203.extend(this.proto, module.proto);
    this.modules.push(name);
  },

  defaults: {

    // Info about options is in docs:
    // http://dimsemenov.com/plugins/magnific-popup/documentation.html#options

    disableOn: 0,

    key: null,

    midClick: false,

    mainClass: '',

    preloader: true,

    focus: '', // CSS selector of input to focus after popup is opened

    closeOnContentClick: false,

    closeOnBgClick: true,

    closeBtnInside: true,

    showCloseBtn: true,

    enableEscapeKey: true,

    modal: false,

    alignTop: false,

    removalDelay: 0,

    fixedContentPos: 'auto',

    fixedBgPos: 'auto',

    overflowY: 'auto',

    closeMarkup: '<button title="%title%" type="button" class="mfp-close">&times;</button>',

    tClose: 'Close (Esc)',

    tLoading: 'Loading...'

  }
};



j203.fn.magnificPopup = function(options) {
  _checkInstance();

  var jqEl = j203(this);

  // We call some API method of first param is a string
  if (typeof options === "string" ) {

    if(options === 'open') {
      var items,
        itemOpts = _isJQ ? jqEl.data('magnificPopup') : jqEl[0].magnificPopup,
        index = parseInt(arguments[1], 10) || 0;

      if(itemOpts.items) {
        items = itemOpts.items[index];
      } else {
        items = jqEl;
        if(itemOpts.delegate) {
          items = items.find(itemOpts.delegate);
        }
        items = items.eq( index );
      }
      mfp._openClick({mfpEl:items}, jqEl, itemOpts);
    } else {
      if(mfp.isOpen)
        mfp[options].apply(mfp, Array.prototype.slice.call(arguments, 1));
    }

  } else {

    /*
     * As Zepto doesn't support .data() method for objects
     * and it works only in normal browsers
     * we assign "options" object directly to the DOM element. FTW!
     */
    if(_isJQ) {
      jqEl.data('magnificPopup', options);
    } else {
      jqEl[0].magnificPopup = options;
    }

    mfp.addGroup(jqEl, options);

  }
  return jqEl;
};


//Quick benchmark
/*
var start = performance.now(),
  i,
  rounds = 1000;

for(i = 0; i < rounds; i++) {

}
console.log('Test #1:', performance.now() - start);

start = performance.now();
for(i = 0; i < rounds; i++) {

}
console.log('Test #2:', performance.now() - start);
*/


/*>>core*/

/*>>inline*/

var INLINE_NS = 'inline',
  _hiddenClass,
  _inlinePlaceholder,
  _lastInlineElement,
  _putInlineElementsBack = function() {
    if(_lastInlineElement) {
      _inlinePlaceholder.after( _lastInlineElement.addClass(_hiddenClass) ).detach();
      _lastInlineElement = null;
    }
  };

j203.magnificPopup.registerModule(INLINE_NS, {
  options: {
    hiddenClass: 'hide', // will be appended with `mfp-` prefix
    markup: '',
    tNotFound: 'Content not found'
  },
  proto: {

    initInline: function() {
      mfp.types.push(INLINE_NS);

      _mfpOn(CLOSE_EVENT+'.'+INLINE_NS, function() {
        _putInlineElementsBack();
      });
    },

    getInline: function(item, template) {

      _putInlineElementsBack();

      if(item.src) {
        var inlineSt = mfp.st.inline,
          el = j203(item.src);

        if(el.length) {

          // If target element has parent - we replace it with placeholder and put it back after popup is closed
          var parent = el[0].parentNode;
          if(parent && parent.tagName) {
            if(!_inlinePlaceholder) {
              _hiddenClass = inlineSt.hiddenClass;
              _inlinePlaceholder = _getEl(_hiddenClass);
              _hiddenClass = 'mfp-'+_hiddenClass;
            }
            // replace target inline element with placeholder
            _lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
          }

          mfp.updateStatus('ready');
        } else {
          mfp.updateStatus('error', inlineSt.tNotFound);
          el = j203('<div>');
        }

        item.inlineElement = el;
        return el;
      }

      mfp.updateStatus('ready');
      mfp._parseMarkup(template, {}, item);
      return template;
    }
  }
});

/*>>inline*/

/*>>ajax*/
var AJAX_NS = 'ajax',
  _ajaxCur,
  _removeAjaxCursor = function() {
    if(_ajaxCur) {
      _body.removeClass(_ajaxCur);
    }
  };

j203.magnificPopup.registerModule(AJAX_NS, {

  options: {
    settings: null,
    cursor: 'mfp-ajax-cur',
    tError: '<a href="%url%">The content</a> could not be loaded.'
  },

  proto: {
    initAjax: function() {
      mfp.types.push(AJAX_NS);
      _ajaxCur = mfp.st.ajax.cursor;

      _mfpOn(CLOSE_EVENT+'.'+AJAX_NS, function() {
        _removeAjaxCursor();
        if(mfp.req) {
          mfp.req.abort();
        }
      });
    },

    getAjax: function(item) {

      if(_ajaxCur)
        _body.addClass(_ajaxCur);

      mfp.updateStatus('loading');

      var opts = j203.extend({
        url: item.src,
        success: function(data, textStatus, jqXHR) {
          var temp = {
            data:data,
            xhr:jqXHR
          };

          _mfpTrigger('ParseAjax', temp);

          mfp.appendContent( j203(temp.data), AJAX_NS );

          item.finished = true;

          _removeAjaxCursor();

          _setFocus();

          setTimeout(function() {
            mfp.wrap.addClass(READY_CLASS);
          }, 16);

          mfp.updateStatus('ready');

          _mfpTrigger('AjaxContentAdded');
        },
        error: function() {
          _removeAjaxCursor();
          item.finished = item.loadError = true;
          mfp.updateStatus('error', mfp.st.ajax.tError.replace('%url%', item.src));
        }
      }, mfp.st.ajax.settings);

      mfp.req = j203.ajax(opts);

      return '';
    }
  }
});







/*>>ajax*/

/*>>image*/
var _imgInterval,
  _getTitle = function(item) {
    if(item.data && item.data.title !== undefined)
      return item.data.title;

    var src = mfp.st.image.titleSrc;

    if(src) {
      if(j203.isFunction(src)) {
        return src.call(mfp, item);
      } else if(item.el) {
        return item.el.attr(src) || '';
      }
    }
    return '';
  };

j203.magnificPopup.registerModule('image', {

  options: {
    markup: '<div class="mfp-figure">'+
          '<div class="mfp-close"></div>'+
          '<div class="mfp-img"></div>'+
          '<div class="mfp-bottom-bar">'+
            '<div class="mfp-title"></div>'+
            '<div class="mfp-counter"></div>'+
          '</div>'+
        '</div>',
    cursor: 'mfp-zoom-out-cur',
    titleSrc: 'title',
    verticalFit: true,
    tError: '<a href="%url%">The image</a> could not be loaded.'
  },

  proto: {
    initImage: function() {
      var imgSt = mfp.st.image,
        ns = '.image';

      mfp.types.push('image');

      _mfpOn(OPEN_EVENT+ns, function() {
        if(mfp.currItem.type === 'image' && imgSt.cursor) {
          _body.addClass(imgSt.cursor);
        }
      });

      _mfpOn(CLOSE_EVENT+ns, function() {
        if(imgSt.cursor) {
          _body.removeClass(imgSt.cursor);
        }
        _window.off('resize' + EVENT_NS);
      });

      _mfpOn('Resize'+ns, mfp.resizeImage);
      if(mfp.isLowIE) {
        _mfpOn('AfterChange', mfp.resizeImage);
      }
    },
    resizeImage: function() {
      var item = mfp.currItem;
      if(!item || !item.img) return;

      if(mfp.st.image.verticalFit) {
        var decr = 0;
        // fix box-sizing in ie7/8
        if(mfp.isLowIE) {
          decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'),10);
        }
        item.img.css('max-height', mfp.wH-decr);
      }
    },
    _onImageHasSize: function(item) {
      if(item.img) {

        item.hasSize = true;

        if(_imgInterval) {
          clearInterval(_imgInterval);
        }

        item.isCheckingImgSize = false;

        _mfpTrigger('ImageHasSize', item);

        if(item.imgHidden) {
          if(mfp.content)
            mfp.content.removeClass('mfp-loading');

          item.imgHidden = false;
        }

      }
    },

    /**
     * Function that loops until the image has size to display elements that rely on it asap
     */
    findImageSize: function(item) {

      var counter = 0,
        img = item.img[0],
        mfpSetInterval = function(delay) {

          if(_imgInterval) {
            clearInterval(_imgInterval);
          }
          // decelerating interval that checks for size of an image
          _imgInterval = setInterval(function() {
            if(img.naturalWidth > 0) {
              mfp._onImageHasSize(item);
              return;
            }

            if(counter > 200) {
              clearInterval(_imgInterval);
            }

            counter++;
            if(counter === 3) {
              mfpSetInterval(10);
            } else if(counter === 40) {
              mfpSetInterval(50);
            } else if(counter === 100) {
              mfpSetInterval(500);
            }
          }, delay);
        };

      mfpSetInterval(1);
    },

    getImage: function(item, template) {

      var guard = 0,

        // image load complete handler
        onLoadComplete = function() {
          if(item) {
            if (item.img[0].complete) {
              item.img.off('.mfploader');

              if(item === mfp.currItem){
                mfp._onImageHasSize(item);

                mfp.updateStatus('ready');
              }

              item.hasSize = true;
              item.loaded = true;

              _mfpTrigger('ImageLoadComplete');

            }
            else {
              // if image complete check fails 200 times (20 sec), we assume that there was an error.
              guard++;
              if(guard < 200) {
                setTimeout(onLoadComplete,100);
              } else {
                onLoadError();
              }
            }
          }
        },

        // image error handler
        onLoadError = function() {
          if(item) {
            item.img.off('.mfploader');
            if(item === mfp.currItem){
              mfp._onImageHasSize(item);
              mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
            }

            item.hasSize = true;
            item.loaded = true;
            item.loadError = true;
          }
        },
        imgSt = mfp.st.image;


      var el = template.find('.mfp-img');
      if(el.length) {
        var img = document.createElement('img');
        img.className = 'mfp-img';
        item.img = j203(img).on('load.mfploader', onLoadComplete).on('error.mfploader', onLoadError);
        img.src = item.src;

        // without clone() "error" event is not firing when IMG is replaced by new IMG
        // TODO: find a way to avoid such cloning
        if(el.is('img')) {
          item.img = item.img.clone();
        }
        if(item.img[0].naturalWidth > 0) {
          item.hasSize = true;
        }
      }

      mfp._parseMarkup(template, {
        title: _getTitle(item),
        img_replaceWith: item.img
      }, item);

      mfp.resizeImage();

      if(item.hasSize) {
        if(_imgInterval) clearInterval(_imgInterval);

        if(item.loadError) {
          template.addClass('mfp-loading');
          mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
        } else {
          template.removeClass('mfp-loading');
          mfp.updateStatus('ready');
        }
        return template;
      }

      mfp.updateStatus('loading');
      item.loading = true;

      if(!item.hasSize) {
        item.imgHidden = true;
        template.addClass('mfp-loading');
        mfp.findImageSize(item);
      }

      return template;
    }
  }
});



/*>>image*/

/*>>zoom*/
var hasMozTransform,
  getHasMozTransform = function() {
    if(hasMozTransform === undefined) {
      hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
    }
    return hasMozTransform;
  };

j203.magnificPopup.registerModule('zoom', {

  options: {
    enabled: false,
    easing: 'ease-in-out',
    duration: 300,
    opener: function(element) {
      return element.is('img') ? element : element.find('img');
    }
  },

  proto: {

    initZoom: function() {
      var zoomSt = mfp.st.zoom,
        ns = '.zoom';

      if(!zoomSt.enabled || !mfp.supportsTransition) {
        return;
      }

      var duration = zoomSt.duration,
        getElToAnimate = function(image) {
          var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('mfp-animated-image'),
            transition = 'all '+(zoomSt.duration/1000)+'s ' + zoomSt.easing,
            cssObj = {
              position: 'fixed',
              zIndex: 9999,
              left: 0,
              top: 0,
              '-webkit-backface-visibility': 'hidden'
            },
            t = 'transition';

          cssObj['-webkit-'+t] = cssObj['-moz-'+t] = cssObj['-o-'+t] = cssObj[t] = transition;

          newImg.css(cssObj);
          return newImg;
        },
        showMainContent = function() {
          mfp.content.css('visibility', 'visible');
        },
        openTimeout,
        animatedImg;

      _mfpOn('BuildControls'+ns, function() {
        if(mfp._allowZoom()) {

          clearTimeout(openTimeout);
          mfp.content.css('visibility', 'hidden');

          // Basically, all code below does is clones existing image, puts in on top of the current one and animated it

          image = mfp._getItemToZoom();

          if(!image) {
            showMainContent();
            return;
          }

          animatedImg = getElToAnimate(image);

          animatedImg.css( mfp._getOffset() );

          mfp.wrap.append(animatedImg);

          openTimeout = setTimeout(function() {
            animatedImg.css( mfp._getOffset( true ) );
            openTimeout = setTimeout(function() {

              showMainContent();

              setTimeout(function() {
                animatedImg.remove();
                image = animatedImg = null;
                _mfpTrigger('ZoomAnimationEnded');
              }, 16); // avoid blink when switching images

            }, duration); // this timeout equals animation duration

          }, 16); // by adding this timeout we avoid short glitch at the beginning of animation


          // Lots of timeouts...
        }
      });
      _mfpOn(BEFORE_CLOSE_EVENT+ns, function() {
        if(mfp._allowZoom()) {

          clearTimeout(openTimeout);

          mfp.st.removalDelay = duration;

          if(!image) {
            image = mfp._getItemToZoom();
            if(!image) {
              return;
            }
            animatedImg = getElToAnimate(image);
          }


          animatedImg.css( mfp._getOffset(true) );
          mfp.wrap.append(animatedImg);
          mfp.content.css('visibility', 'hidden');

          setTimeout(function() {
            animatedImg.css( mfp._getOffset() );
          }, 16);
        }

      });

      _mfpOn(CLOSE_EVENT+ns, function() {
        if(mfp._allowZoom()) {
          showMainContent();
          if(animatedImg) {
            animatedImg.remove();
          }
        }
      });
    },

    _allowZoom: function() {
      return mfp.currItem.type === 'image';
    },

    _getItemToZoom: function() {
      if(mfp.currItem.hasSize) {
        return mfp.currItem.img;
      } else {
        return false;
      }
    },

    // Get element postion relative to viewport
    _getOffset: function(isLarge) {
      var el;
      if(isLarge) {
        el = mfp.currItem.img;
      } else {
        el = mfp.st.zoom.opener(mfp.currItem.el || mfp.currItem);
      }

      var offset = el.offset();
      var paddingTop = parseInt(el.css('padding-top'),10);
      var paddingBottom = parseInt(el.css('padding-bottom'),10);
      offset.top -= ( j203(window).scrollTop() - paddingTop );


      /*

      Animating left + top + width/height looks glitchy in Firefox, but perfect in Chrome. And vice-versa.

       */
      var obj = {
        width: el.width(),
        // fix Zepto height+padding issue
        height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
      };

      // I hate to do this, but there is no another option
      if( getHasMozTransform() ) {
        obj['-moz-transform'] = obj['transform'] = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
      } else {
        obj.left = offset.left;
        obj.top = offset.top;
      }
      return obj;
    }

  }
});



/*>>zoom*/

/*>>iframe*/

var IFRAME_NS = 'iframe',
  _emptyPage = '//about:blank',

  _fixIframeBugs = function(isShowing) {
    if(mfp.currTemplate[IFRAME_NS]) {
      var el = mfp.currTemplate[IFRAME_NS].find('iframe');
      if(el.length) {
        // reset src after the popup is closed to avoid "video keeps playing after popup is closed" bug
        if(!isShowing) {
          el[0].src = _emptyPage;
        }

        // IE8 black screen bug fix
        if(mfp.isIE8) {
          el.css('display', isShowing ? 'block' : 'none');
        }
      }
    }
  };

j203.magnificPopup.registerModule(IFRAME_NS, {

  options: {
    markup: '<div class="mfp-iframe-scaler">'+
          '<div class="mfp-close"></div>'+
          '<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+
        '</div>',

    srcAction: 'iframe_src',

    // we don't care and support only one default type of URL by default
    patterns: {
      youtube: {
        index: 'youtube.com',
        id: 'v=',
        src: '//www.youtube.com/embed/%id%?autoplay=1'
      },
      vimeo: {
        index: 'vimeo.com/',
        id: '/',
        src: '//player.vimeo.com/video/%id%?autoplay=1'
      },
      gmaps: {
        index: '//maps.google.',
        src: '%id%&output=embed'
      }
    }
  },

  proto: {
    initIframe: function() {
      mfp.types.push(IFRAME_NS);

      _mfpOn('BeforeChange', function(e, prevType, newType) {
        if(prevType !== newType) {
          if(prevType === IFRAME_NS) {
            _fixIframeBugs(); // iframe if removed
          } else if(newType === IFRAME_NS) {
            _fixIframeBugs(true); // iframe is showing
          }
        }// else {
          // iframe source is switched, don't do anything
        //}
      });

      _mfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function() {
        _fixIframeBugs();
      });
    },

    getIframe: function(item, template) {
      var embedSrc = item.src;
      var iframeSt = mfp.st.iframe;

      j203.each(iframeSt.patterns, function() {
        if(embedSrc.indexOf( this.index ) > -1) {
          if(this.id) {
            if(typeof this.id === 'string') {
              embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
            } else {
              embedSrc = this.id.call( this, embedSrc );
            }
          }
          embedSrc = this.src.replace('%id%', embedSrc );
          return false; // break;
        }
      });

      var dataObj = {};
      if(iframeSt.srcAction) {
        dataObj[iframeSt.srcAction] = embedSrc;
      }
      mfp._parseMarkup(template, dataObj, item);

      mfp.updateStatus('ready');

      return template;
    }
  }
});



/*>>iframe*/

/*>>gallery*/
/**
 * Get looped index depending on number of slides
 */
var _getLoopedId = function(index) {
    var numSlides = mfp.items.length;
    if(index > numSlides - 1) {
      return index - numSlides;
    } else  if(index < 0) {
      return numSlides + index;
    }
    return index;
  },
  _replaceCurrTotal = function(text, curr, total) {
    return text.replace('%curr%', curr + 1).replace('%total%', total);
  };

j203.magnificPopup.registerModule('gallery', {

  options: {
    enabled: false,
    arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
    preload: [0,2],
    navigateByImgClick: true,
    arrows: true,

    tPrev: 'Previous (Left arrow key)',
    tNext: 'Next (Right arrow key)',
    tCounter: '%curr% of %total%'
  },

  proto: {
    initGallery: function() {

      var gSt = mfp.st.gallery,
        ns = '.mfp-gallery',
        supportsFastClick = Boolean(j203.fn.mfpFastClick);

      mfp.direction = true; // true - next, false - prev

      if(!gSt || !gSt.enabled ) return false;

      _wrapClasses += ' mfp-gallery';

      _mfpOn(OPEN_EVENT+ns, function() {

        if(gSt.navigateByImgClick) {
          mfp.wrap.on('click'+ns, '.mfp-img', function() {
            if(mfp.items.length > 1) {
              mfp.next();
              return false;
            }
          });
        }

        _document.on('keydown'+ns, function(e) {
          if (e.keyCode === 37) {
            mfp.prev();
          } else if (e.keyCode === 39) {
            mfp.next();
          }
        });
      });

      _mfpOn('UpdateStatus'+ns, function(e, data) {
        if(data.text) {
          data.text = _replaceCurrTotal(data.text, mfp.currItem.index, mfp.items.length);
        }
      });

      _mfpOn(MARKUP_PARSE_EVENT+ns, function(e, element, values, item) {
        var l = mfp.items.length;
        values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
      });

      _mfpOn('BuildControls' + ns, function() {
        if(mfp.items.length > 1 && gSt.arrows && !mfp.arrowLeft) {
          var markup = gSt.arrowMarkup,
            arrowLeft = mfp.arrowLeft = j203( markup.replace('%title%', gSt.tPrev).replace('%dir%', 'left') ).addClass(PREVENT_CLOSE_CLASS),
            arrowRight = mfp.arrowRight = j203( markup.replace('%title%', gSt.tNext).replace('%dir%', 'right') ).addClass(PREVENT_CLOSE_CLASS);

          var eName = supportsFastClick ? 'mfpFastClick' : 'click';
          arrowLeft[eName](function() {
            mfp.prev();
          });
          arrowRight[eName](function() {
            mfp.next();
          });

          // Polyfill for :before and :after (adds elements with classes mfp-a and mfp-b)
          if(mfp.isIE7) {
            _getEl('b', arrowLeft[0], false, true);
            _getEl('a', arrowLeft[0], false, true);
            _getEl('b', arrowRight[0], false, true);
            _getEl('a', arrowRight[0], false, true);
          }

          mfp.container.append(arrowLeft.add(arrowRight));
        }
      });

      _mfpOn(CHANGE_EVENT+ns, function() {
        if(mfp._preloadTimeout) clearTimeout(mfp._preloadTimeout);

        mfp._preloadTimeout = setTimeout(function() {
          mfp.preloadNearbyImages();
          mfp._preloadTimeout = null;
        }, 16);
      });


      _mfpOn(CLOSE_EVENT+ns, function() {
        _document.off(ns);
        mfp.wrap.off('click'+ns);

        if(mfp.arrowLeft && supportsFastClick) {
          mfp.arrowLeft.add(mfp.arrowRight).destroyMfpFastClick();
        }
        mfp.arrowRight = mfp.arrowLeft = null;
      });

    },
    next: function() {
      mfp.direction = true;
      mfp.index = _getLoopedId(mfp.index + 1);
      mfp.updateItemHTML();
    },
    prev: function() {
      mfp.direction = false;
      mfp.index = _getLoopedId(mfp.index - 1);
      mfp.updateItemHTML();
    },
    goTo: function(newIndex) {
      mfp.direction = (newIndex >= mfp.index);
      mfp.index = newIndex;
      mfp.updateItemHTML();
    },
    preloadNearbyImages: function() {
      var p = mfp.st.gallery.preload,
        preloadBefore = Math.min(p[0], mfp.items.length),
        preloadAfter = Math.min(p[1], mfp.items.length),
        i;

      for(i = 1; i <= (mfp.direction ? preloadAfter : preloadBefore); i++) {
        mfp._preloadItem(mfp.index+i);
      }
      for(i = 1; i <= (mfp.direction ? preloadBefore : preloadAfter); i++) {
        mfp._preloadItem(mfp.index-i);
      }
    },
    _preloadItem: function(index) {
      index = _getLoopedId(index);

      if(mfp.items[index].preloaded) {
        return;
      }

      var item = mfp.items[index];
      if(!item.parsed) {
        item = mfp.parseEl( index );
      }

      _mfpTrigger('LazyLoad', item);

      if(item.type === 'image') {
        item.img = j203('<img class="mfp-img" />').on('load.mfploader', function() {
          item.hasSize = true;
        }).on('error.mfploader', function() {
          item.hasSize = true;
          item.loadError = true;
          _mfpTrigger('LazyLoadError', item);
        }).attr('src', item.src);
      }


      item.preloaded = true;
    }
  }
});

/*
Touch Support that might be implemented some day

addSwipeGesture: function() {
  var startX,
    moved,
    multipleTouches;

    return;

  var namespace = '.mfp',
    addEventNames = function(pref, down, move, up, cancel) {
      mfp._tStart = pref + down + namespace;
      mfp._tMove = pref + move + namespace;
      mfp._tEnd = pref + up + namespace;
      mfp._tCancel = pref + cancel + namespace;
    };

  if(window.navigator.msPointerEnabled) {
    addEventNames('MSPointer', 'Down', 'Move', 'Up', 'Cancel');
  } else if('ontouchstart' in window) {
    addEventNames('touch', 'start', 'move', 'end', 'cancel');
  } else {
    return;
  }
  _window.on(mfp._tStart, function(e) {
    var oE = e.originalEvent;
    multipleTouches = moved = false;
    startX = oE.pageX || oE.changedTouches[0].pageX;
  }).on(mfp._tMove, function(e) {
    if(e.originalEvent.touches.length > 1) {
      multipleTouches = e.originalEvent.touches.length;
    } else {
      //e.preventDefault();
      moved = true;
    }
  }).on(mfp._tEnd + ' ' + mfp._tCancel, function(e) {
    if(moved && !multipleTouches) {
      var oE = e.originalEvent,
        diff = startX - (oE.pageX || oE.changedTouches[0].pageX);

      if(diff > 20) {
        mfp.next();
      } else if(diff < -20) {
        mfp.prev();
      }
    }
  });
},
*/


/*>>gallery*/

/*>>retina*/

var RETINA_NS = 'retina';

j203.magnificPopup.registerModule(RETINA_NS, {
  options: {
    replaceSrc: function(item) {
      return item.src.replace(/\.\w+j203/, function(m) { return '@2x' + m; });
    },
    ratio: 1 // Function or number.  Set to 1 to disable.
  },
  proto: {
    initRetina: function() {
      if(window.devicePixelRatio > 1) {

        var st = mfp.st.retina,
          ratio = st.ratio;

        ratio = !isNaN(ratio) ? ratio : ratio();

        if(ratio > 1) {
          _mfpOn('ImageHasSize' + '.' + RETINA_NS, function(e, item) {
            item.img.css({
              'max-width': item.img[0].naturalWidth / ratio,
              'width': '100%'
            });
          });
          _mfpOn('ElementParse' + '.' + RETINA_NS, function(e, item) {
            item.src = st.replaceSrc(item, ratio);
          });
        }
      }

    }
  }
});

/*>>retina*/

/*>>fastclick*/
/**
 * FastClick event implementation. (removes 300ms delay on touch devices)
 * Based on https://developers.google.com/mobile/articles/fast_buttons
 *
 * You may use it outside the Magnific Popup by calling just:
 *
 * j203('.your-el').mfpFastClick(function() {
 *     console.log('Clicked!');
 * });
 *
 * To unbind:
 * j203('.your-el').destroyMfpFastClick();
 *
 *
 * Note that it's a very basic and simple implementation, it blocks ghost click on the same element where it was bound.
 * If you need something more advanced, use plugin by FT Labs https://github.com/ftlabs/fastclick
 *
 */

(function() {
  var ghostClickDelay = 1000,
    supportsTouch = 'ontouchstart' in window,
    unbindTouchMove = function() {
      _window.off('touchmove'+ns+' touchend'+ns);
    },
    eName = 'mfpFastClick',
    ns = '.'+eName;


  // As Zepto.js doesn't have an easy way to add custom events (like jQuery), so we implement it in this way
  j203.fn.mfpFastClick = function(callback) {

    return j203(this).each(function() {

      var elem = j203(this),
        lock;

      if( supportsTouch ) {

        var timeout,
          startX,
          startY,
          pointerMoved,
          point,
          numPointers;

        elem.on('touchstart' + ns, function(e) {
          pointerMoved = false;
          numPointers = 1;

          point = e.originalEvent ? e.originalEvent.touches[0] : e.touches[0];
          startX = point.clientX;
          startY = point.clientY;

          _window.on('touchmove'+ns, function(e) {
            point = e.originalEvent ? e.originalEvent.touches : e.touches;
            numPointers = point.length;
            point = point[0];
            if (Math.abs(point.clientX - startX) > 10 ||
              Math.abs(point.clientY - startY) > 10) {
              pointerMoved = true;
              unbindTouchMove();
            }
          }).on('touchend'+ns, function(e) {
            unbindTouchMove();
            if(pointerMoved || numPointers > 1) {
              return;
            }
            lock = true;
            e.preventDefault();
            clearTimeout(timeout);
            timeout = setTimeout(function() {
              lock = false;
            }, ghostClickDelay);
            callback();
          });
        });

      }

      elem.on('click' + ns, function() {
        if(!lock) {
          callback();
        }
      });
    });
  };

  j203.fn.destroyMfpFastClick = function() {
    j203(this).off('touchstart' + ns + ' click' + ns);
    if(supportsTouch) _window.off('touchmove'+ns+' touchend'+ns);
  };
})();

/*>>fastclick*/
})(window.jQuery || window.Zepto);

/*
 * Use mfp-TYPE CSS class (where TYPE is desired content type).
 * E.g.: <a class="mfp-image image-link">Open image</a>,
 * j203('.image-link').magnificPopup().
 *
 * Inline Type
 * http://dimsemenov.com/plugins/magnific-popup/documentation.html#inline_type
 *
 * Image Type
 * http://dimsemenov.com/plugins/magnific-popup/documentation.html#image_type
 *
 * Iframe Type
 * http://dimsemenov.com/plugins/magnific-popup/documentation.html#iframe_type
 *
 * Ajax Type
 * http://dimsemenov.com/plugins/magnific-popup/documentation.html#ajax_type
 *
 * Set public callbacks on elements (Events: data-onopen / data-onclose):
 * <a data-onclose="wm.estimateShipping.clearAll"
 *    href="#estimate-shipping-modal" class="wm-lightbox link">
 *
 */

wm.lightbox = (function() {
  "use strict";

  var elems = j203(".wm-lightbox"),
    options = {
      tClose: "Fechar (Esc)",
      callbacks: {
        open: function() {
          var target = this.currItem.el && this.currItem.el[0] || null;

          if (target) {
            var elemData = target.getAttribute("data-onopen") || null,
                callback = elemData && evalObject(elemData) || null;

            if (callback) {
              callback();
            }
          }
        },
        close: function() {
          var target = this.currItem.el && this.currItem.el[0] || null;

          if (target) {
            var elemData = target.getAttribute("data-onclose") || null,
                callback = elemData && evalObject(elemData) || null;

            if (callback) {
              callback();
            }
          }
        }
      }
    };

  function evalObject(str) {
    var objs = str.split("."),
        obj = window;

    for (var i = 0; i < objs.length; i++) {
      obj = obj[objs[i]];
    }

    return obj;
  }

  function bindEvents() {
    elems.magnificPopup(options);
  }

  return {
    init: function() {
      bindEvents();
    }
  };
})();

wm.lightbox.init();


var UNAUTHORIZED_ERROR = 401;

wm.utils.get = function (url, data, callback, type) {
	"use strict";

	if (typeof data ===  "function") {
		type = type || callback;
		callback = data;
		data = undefined;
	}

	return wm.utils.ajax({
		url: url,
		type: "get",
		dataType: type,
		data: data,
		success: callback
	});
};

wm.utils.getJson = function (url, data, callback) {
	"use strict";

	return wm.utils.get(url, data, callback, "json");
};

wm.utils.getJsonp = function (url, data, callback) {
	"use strict";

	if (typeof data ===  "function") {
		callback = data;
		data = undefined;
	}

	return wm.utils.ajax({
		url: url,
		type: "get",
		dataType: "jsonp",
		data: data,
		success: callback,
		jsonp : "jsonpCallback"
	});
};

wm.utils.post = function (url, data, callback, type) {
	"use strict";

	if (typeof data ===  "function") {
		type = type || callback;
		callback = data;
		data = undefined;
	}

	return wm.utils.ajax({
		url: url,
		type: "post",
		dataType: type,
		data: data,
		success: callback
	});
};

wm.utils.ajax = function (url, options) {
	"use strict";

	// If url is an object, simulate pre-1.5 signature
	if ( typeof url === "object" ) {
		options = url;
		url = undefined;
	}

	var settings = j203.extend({}, options);

	settings.xhrFields = {
    withCredentials: true
  };

	// Function to set the ajax header.
	settings.beforeSend = function (request) {
		if (typeof request.setRequestHeader !== "undefined") {
			request.setRequestHeader("ajax", "true");
		}

		request.withCredentials = true;

		if (options.beforeSend) {
			options.beforeSend(request);
		}
	};

	settings.error = function (xhr, ajaxOptions, thrownError) {
		var location = null;

		if (xhr.status === UNAUTHORIZED_ERROR) {
			var locationRegexp = /LoginLocation=(.*)/;

			location = xhr.getResponseHeader("LoginLocation") ||
				locationRegexp.exec(xhr.responseText)[1];
		}

		if (xhr.status === UNAUTHORIZED_ERROR && location !== null) {
			if (options.securityHandler) {
				options.securityHandler(location);
			} else {
				wm.utils.handleLoginRequest(url, options, location);
			}
		} else if (options.error) {
			options.error(xhr, ajaxOptions, thrownError);
		}

		/* else {
			// TODO Handle this error in case....
		}*/
	};

	return j203.ajax(settings);
};







wm.utils.requestStack = [];

wm.utils.handleLoginRequest = function (url, options) {
	"use strict";

	wm.utils.requestStack.push({url: url, options : options});

	wm.login.goToLoginPage();
};

// Event that occurs when the user logs in.
j203(document).on("logged-in", function () {
	"use strict";

	// After loging in, we must send all enqueued requests.
	var request = wm.utils.requestStack.shift(),
		iterations = 0;

	wm.utils.closeLoginDialog();

	while (request){
		wm.utils.ajax(request.url, request.options);
		request = wm.utils.requestStack.shift();
		iterations++;
	}
});

wm.utils.openLoginDialog = function (location, targetPage) {
	"use strict";

	j203.magnificPopup.close(); // Closing previous windows...

	j203.magnificPopup.open({
		mainClass: "mfp-" + targetPage,
		items: {
			src : "<div class='loginModal mfp-iframe-scaler'><iframe style='width:100%;scroll:none;border:0;' class='mfp-iframe'  name='iframeLogin' id='iframeLogin' src='" + location + "'></div>",
			type: "inline",
			closeBtnInside: true
		}
	}, 0);
};

wm.utils.closeLoginDialog = function () {
	"use strict";

	j203.magnificPopup.close();
};


wm.login = {


	/**
	 * Goes to the login page, choosing whether the login modal or the login
	 * redirect approach.
	 */
	goToLoginPage : function (location) {
		"use strict";
		var url = "";
		var lastUrl = location || window.location.href;

		if (wm.login.shouldUseRedirectApproach()) {
			url += window.wm.constants.LOGIN_PATH;
			url += "/sign-in-alt";
			url += "?redirect_to=" + lastUrl;
			window.location.href = url;
		} else {
			url += window.wm.constants.LOGIN_PATH_MODAL;
			url += "/api/webstore/auth/login?modal=true";
			//url += "/login?modal=true";
			wm.utils.openLoginDialog(url, "login");
		}
	},

	goToSignUpPage : function (location) {
		"use strict";
		var url = window.wm.constants.LOGIN_PATH;

		if (wm.login.shouldUseRedirectApproach()) {
			url += "/sign-up-alt";
			url += "?redirect_to=" + (location || window.location.href);

			window.location.href = url;
		} else {
			url += "/sign-up?modal=true";
			wm.utils.openLoginDialog(url, "signup");
		}
	},

	/**
	 * Tells us when to use the redirect (alternative) appproach for the login
	 * flow.
	 */
	shouldUseRedirectApproach : function () {
		"use strict";
		return wm.utils.isSafari();
	},

	logout : function () {
		"use strict";
		wm.utils.logout();
	}
};


wm.utils.checkLogin = function (callback, securityHandler) {
	"use strict";

	wm.utils.ajax({
		url: wm.constants.API_ENDPOINT + "/webstore/v1/checklogin",
		type : "get",
		success : callback,
		securityHandler : securityHandler
	});
};

wm.utils.logout = function (location) {
	"use strict";

	// Checkout logout.
	wm.utils.ajax({
		url: wm.constants.CHECKOUT_ENDPOINT + "/checkout/services/oauth/logout",
		dataType: "jsonp",
		crossDomain: true,
		timeout: 10000
	});

	// The first step is to logout from the api.
	wm.utils.post(wm.constants.API_ENDPOINT +  "/webstore/auth/logout",
		function () {
		/*
		// Making sure the cookie will be removed.
		document.cookie = wm.constants.LOGGED_IN_COOKIE +
				"=false;domain=.walmart.com.br";
		*/

		j203(document).trigger("logged-out");

		// The only way to assure the logout is the redirect.
		document.location.href = wm.constants.AUTH_ENDPOINT +
				"/connect/logout?redirect_to=" +
				encodeURIComponent(location || document.location.href);
	});
};

wm.utils.isSafari = function () {
	"use strict";

	return typeof navigator.vendor !== "undefined" &&
			navigator.vendor.toLowerCase().indexOf("apple") !== -1;
};

j203(document).ready(function () {
	"use strict";

	var callback = function (event) {
		if (event.data === "loggedIn"){
			j203(document).trigger("logged-in");
		}
		else
		{
			wm.utils.iframeModalControl(event.data);
		}
	};

	// Registering fot logged-in events.
	if (typeof window.addEventListener !== "undefined"){
		window.addEventListener("message", callback, false);
	} else if (typeof window.attachEvent !== "undefined"){
		window.attachEvent("onmessage", callback);
	}
});


wm.utils.iframeModalControl = function(data)
{
	"use strict";

	function setSize(width, height)
	{
		j203(".mfp-content").css("width", width);
    j203(".mfp-inline-holder .mfp-content>div").css("width", width);
    j203(".mfp-iframe-scaler").css("height", height);
    j203(".mfp-iframe").attr("scrolling","no");
	}

	function close()
	{
		j203.magnificPopup.instance.close();
	}

	if(data === "closeModal")
	{
		close();
	}
	else if(data.indexOf("{") === 0)
	{
		data = JSON.parse(data);
		if(data && data.width && data.height)
		{
			setSize(data.width, data.height);
		}
	}
};

// Event that is triggered when the user log in.
j203(document).on("logged-in", function () {
	"use strict";

	j203(document.body).addClass(wm.constants.LOGGED_IN_CLASS);
});

//Event that is triggered when the user log out.
j203(document).on("logged-out", function () {
	"use strict";

	// Removing the logged-in class from the body.
	j203(document.body).removeClass(wm.constants.LOGGED_IN_CLASS);
	/*
	// Erasing the cookie.
	document.cookie = wm.constants.LOGGED_IN_COOKIE +
			"=false;domain=.walmart.com.br; expires=Thu, 01-Jan-70 00:00:01 GMT;";
		*/
});

wm.menu = (function() {
  "use strict";

  var component = j203("#site-menu"),
      items = component.find(".menu-item"),
      page = j203(".page"),
      menuHeight = component.outerHeight(),
      menuBorderWidth = "3px",
      scrollTopBefore = j203(window).scrollTop(),
      scrollLimit = menuHeight,
      topBarHeight = j203("#site-topbar").height(),
      toolbar = j203("#product-toolbar"),
      toolbarHeight = toolbar.outerHeight(),
      toolbarAlternatePosition = topBarHeight + component.outerHeight(),
      activatedMenuItem = null,
      alwaysHiddenFlag = false,
      allShoppingSignUp = component.find(".allShoppingSignUp");

  function deactivateMenus() {
    component.removeClass("active");
    items.removeClass("active");
  }

  function activateMenu(target) {
    loadBanner(target);
    wm.topbar.closeDropdowns();
    component.addClass("active");
    target.addClass("active");
    activatedMenuItem = target;
  }

  function loadBanner(target) {
    var img = target.find(".lazy-load"),
    src = img.attr("data-src") || null;

    if (src) {
      img.attr("src", src);
      img.attr("data-src", ""); // Avoid banner to load twice.
    }
  }

  function resizeComponent() {
    //component.width(page.width()); // width adjust
  }

  function showMainMenu() {
    component.addClass("animate");
    component.css({
      "top": topBarHeight + "px"
    });
    if (wm.productToolbar) {
      wm.productToolbar.setVerticalPosition(
        toolbarAlternatePosition + "px"
      );
    }
  }

  function hideMainMenu() {
    component.css({
      "top": menuBorderWidth
    });
    if (wm.productToolbar) {
      wm.productToolbar.setVerticalPosition(
        toolbarHeight + "px"
      );
    }
  }

  function setMenuPosition() {
    var scrollTop = j203(window).scrollTop();

    if (scrollTop >= scrollLimit) {
      //component.addClass("fixed");

      // Scroll toward to the top
      if (
          ( scrollTopBefore > scrollTop ||
            scrollTop + j203(window).height() === j203(document).height()
          ) && !alwaysHiddenFlag
        ){
        showMainMenu();
      }

      // Scroll toward to the bottom
      // Cannot be just an else because IE8
      // gets the same scrollTop value sometimes.
      else if (scrollTopBefore < scrollTop) {
        if (activatedMenuItem && !activatedMenuItem.hasClass("todo-shopping")) {
          deactivateMenus();
        }
        hideMainMenu();
      }
    }

    // Top of the page.
    else if (scrollTop === 0) {
      component.removeClass("fixed");
      component.removeClass("animate");
      component.css({
        "top": "auto"
      });

      alwaysHiddenFlag = false;
    }

    scrollTopBefore = scrollTop;
  }

  function alwaysHidden(hide)
  {
    alwaysHiddenFlag = (hide === false?false:true);
  }

  function bindEvents() {

    // Set menu's size and position.
    j203(window).bind("resize", resizeComponent)
             .bind("scroll", setMenuPosition);

    if (Modernizr.touch) {

      // Tablets
      var submenuWrapper = component.find(".submenu-wrapper");

      items.not(".seasonal").bind("touchstart", function(e) {
        e.preventDefault();

        var target = j203(this),
            isTargetActive = target.hasClass("active");

        deactivateMenus();

        if (!isTargetActive) {
          activateMenu(target);
          wm.adserverLoading.loadBannerMenu(target);
        }
      });

      submenuWrapper.bind("touchstart", function(e) {
        e.stopPropagation();
      });
    } else {

      // Desktops
      var timeout;

      // Deactivate menus when ESC key is pressed.
      j203(window).keyup(function(e) {
        if (e.keyCode === 27) {
          deactivateMenus();
        }
      });

      items.hover(function() {
        var target = j203(this);

        timeout = window.setTimeout(function() {
          activateMenu(target);
          wm.adserverLoading.loadBannerMenu(target);
        }, 150);
      },
      function() {
        window.clearTimeout(timeout);
        deactivateMenus();
      });
    }

    allShoppingSignUp.bind("click", function(e){
      e.preventDefault();
      wm.login.goToSignUpPage();
      return false;
    });
  }

  return {
    init: function() {
      resizeComponent();
      bindEvents();
    },
    deactivateMenus: deactivateMenus,
    showMainMenu: showMainMenu,
    alwaysHidden: alwaysHidden
  };
})();

wm.menu.init();

wm.topbar = (function() {
  "use strict";

  var component = j203("#site-topbar"),
      buttons = component.find(".topbar-buttons"),
      dropdowns = component.find(".dropdown"),
      closeButtons = component.find(".close-dropdown"),
      buttonLogin = j203("#topbar-login-link"),
      buttonSignup = j203("#topbar-signup-link"),
      siteMenu = j203("#site-menu"),
      dropdownProfile = component.find("#dropdown-profile"),
      profileTitle = dropdownProfile.find(".title-dropdown"),
      timerDropdownIn,
      timerDropdownOut,
      pathApi = wm.constants.API_ENDPOINT;

  function openDropdown(target, timer) {
    if (typeof timer === "number") {
      timerDropdownIn = setTimeout(function() {
        wm.menu.deactivateMenus();
        target.next(".dropdown").fadeIn();
        target.addClass("active");
        j203(".dropdown.search").stop().fadeOut(200);
        if (j203(target).is(".cart-link")) {
          wm.miniCart.update();
        }
        if (shouldLoadProfile(target)) {
          loadProfile(target);
        }
      }, timer);
    } else {
      wm.menu.deactivateMenus();
      target.next(".dropdown").fadeIn();
      target.addClass("active");
      j203(".dropdown.search").stop().fadeOut(200);
      if (j203(target).is(".cart-link")) {
        wm.miniCart.update();
      }
      if (shouldLoadProfile(target)) {
        loadProfile(target);
      }
    }
  }

  function closeDropdowns(timer) {
    if (typeof timer === "number") {

      // Timer to close
      timerDropdownOut = setTimeout(function() {
        var buttonsBlured = component.find(".topbar-buttons:not(.over)");
        buttonsBlured.parent().find(".dropdown").stop().fadeOut(200);
        buttonsBlured.removeClass("active");
      }, timer);
    } else {
      var buttonsBlured = component.find(".topbar-buttons:not(.over)");
      buttonsBlured.parent().find(".dropdown").stop().fadeOut(200);
      buttonsBlured.removeClass("active");
    }
  }

  function shouldLoadProfile(target) {
    return target.hasClass("icon-topbar-link") && !target.hasClass("loaded");
  }

  function loadProfile(target) {
    wm.utils.post(pathApi + "/webstore/v1/topbar/profile", function (result) {
      if (result) {
        profileTitle.html(result.customer ? result.customer.name || "" : "");

        j203(".orders-list ul", "#dropdown-profile").html("");

        // for (var i = 0; result.orders && i < result.orders.length; i++) {
        //   var orderItem = j203("<li li class='order-item'>");

        //   // TODO Get the appropriate status
        //   orderItem.append("<span class='status-icon status-aguardando-coleta'></span>");
        //   orderItem.append("<a class='order-number' href=''>Pedido " + result.orders[i].orderId + "</a>");

        //   for (var j = 0; result.orders[i].deliveries && j < result.orders[i].deliveries.length; j++) {
        //     var delivery = result.orders[i].deliveries[j];

        //     for (var k = 0; delivery.items && k < delivery.items.length; k++) {
        //       orderItem.append("<a class='order-product'  href='/produto/idSku/" +
        //           delivery.items[k].skuId +  "'>"  +
        //           delivery.items[k].name  + "</a>");
        //     }
        //   }
        //   j203(".orders-list ul").append(orderItem);
        // }
        // j203(".dropdown-orders").addClass("visible");
      }
      target.addClass("loaded");
      openDropdown(target);
    });
  }

  function toggleDropdown(target) {
    // Toggle dropdown
    if (target.hasClass("active")) {
      closeDropdowns();
    } else {
      closeDropdowns();

      if (shouldLoadProfile(target)) {
        loadProfile(target);
      } else {
        openDropdown(target);
        if (j203(target).is(".cart-link")) {
          wm.miniCart.update();
        }
      }
    }
  }

  // function openLoginSignup(targetPage) {
  //   var urlLogin = wm.constants.API_ENDPOINT + "/webstore/v1/checklogin",
  //     urlSignup = "/login/sign-up",
  //     url = targetPage === "login" ? urlLogin : urlSignup;

  //   j203.magnificPopup.open({
  //     items: {
  //       src: url
  //     },
  //     type: "iframe",
  //     mainClass: "mfp-" + targetPage,
  //     closeOnBgClick: false,
  //     closeBtnInside: true
  //   });
  // }

  function bindEvents() {
    // Deactivate menus when ESC key is pressed.
    j203(window).keyup(function(e) {
      if (e.keyCode === 27) {
        closeDropdowns();
      }
    });

    component.hover(function() {
      if (siteMenu.hasClass("fixed")) {
        wm.menu.showMainMenu();
      }
    });

    buttonLogin.click(function(e) {
      e.preventDefault();

      // Checking if the user is logged in.
      wm.login.goToLoginPage();
    });

    buttonSignup.click(function(e) {
      e.preventDefault();

      wm.login.goToSignUpPage();
    });

    buttons.hover(function() {
      var target = j203(this);
      target.addClass("over");
      if (!target.is(".button-link")) {
        closeDropdowns();
        // Delay to open
        openDropdown(target, 250);
      }
    }, function() {
      clearTimeout(timerDropdownIn);
      var target = j203(this);
      target.removeClass("over");
    });

    buttons.click(function(e) {
      e.preventDefault();
      var target = j203(this);
      if (target.is(".button-link")) {
        toggleDropdown(target);
      }
      if (target.is(".open-link") && !Modernizr.touch) {
        window.location = target.attr("href");
      }
    });

    closeButtons.click(function(e) {
      e.preventDefault();
      closeDropdowns();
    });

    // Reset timer on mouseover dropdowns
    dropdowns.mouseover(function() {
      clearTimeout(timerDropdownOut);
    });

    // Closing dropdowns on mouseleave buttons
    buttons.mouseleave(function() {
      clearTimeout(timerDropdownOut);
      closeDropdowns(500);
    });

    // Closing dropdowns on mouseleave dropdown
    dropdowns.mouseleave(function() {
      clearTimeout(timerDropdownOut);
      closeDropdowns(500);
    });
  }

  return {
    init: function() {
      bindEvents();
    },
    closeDropdowns: closeDropdowns,
    openDropdown: function(target) {
      openDropdown(target);
    },
    toggleDropdown : toggleDropdown
  };

})();

wm.topbar.init();

wm.adserverLoading = (function() {
  "use strict";

  var loadAreas = [],
      bannerAreas = [],
      owlCarousels = [];

  function positioning() {
    bannerAreas.each(function(i, e) {
      var target = j203(e),
          rawTarget = e,
          position = target.data("ad-position"),
          sitepage = target.data("ad-sitepage");

      var origin = loadAreas.filter("[data-ad-position='" + position + "']" +
                                 "[data-ad-sitepage='" + sitepage + "']");

      if(origin.length > 0) {
        var content = origin.eq(0).children(":not(script)");

        //IE FIX
        if(content.length === 0) {
          origin = origin.parent(".banner-ie-fix");
          origin.find(".load-adserver").remove();
          content = origin.eq(0).children(":not(script)");
        }

        if(target.parent(".owl-item").length > 0) {
          owlCarousels.each(function(i, e){
            if(j203.contains(e, rawTarget)) {
              var container = j203(e),
                  owl = container.data("owlCarousel"),
                  options = owl.options;

              owl.destroy();
              container.html(content);
              container.owlCarousel(options);
            }
          });
        } else {
          target.append(content);
        }

        origin.remove();
      }
    });
  }


  function loadBannerMenu(target) {
    var bannerMenu = target.find(".lazy-image-menu.loading");

    if(bannerMenu.length > 0){
      bannerMenu.attr("src", bannerMenu.data("src"));

      bannerMenu.load(function(){
        j203(this).removeClass("loading");
      });
    }
  }


  function bindEvents() {
    j203(document).ready(function() {
      loadAreas = j203(".load-adserver");
      bannerAreas = j203(".banner-adserver");
      owlCarousels = j203(".owl-carousel");


      positioning();
    });
  }

  return {
    init : function() {
      bindEvents();
    },
    positioning    : positioning,
    loadBannerMenu : loadBannerMenu
  };

})();

wm.adserverLoading.init();
wm.loader = (function() {
  "use strict";

  function append() {
    j203("body").prepend("<div class='wm-loader'><b></b><i></i></div>");
  }

  function remove() {
    j203(".wm-loader").remove();
  }

  function show() {
    remove();
    append();
    j203(".wm-loader").show().removeClass("out").addClass("in");
  }

  function hide() {
    j203(".wm-loader").removeClass("in").addClass("out");
    window.setTimeout(function() {
      remove();
    }, 300);
  }

  function bindEvents() {
    j203(document).ajaxStart(function () {
      show();
    }).ajaxStop(function () {
      hide();
    });
  }

  return {
    init: function() {
      bindEvents();
    },
    show: show,
    hide: hide
  };
})();

wm.loader.init();

wm.storeLocator = (function() {
  "use strict";

  var component = j203(".store-locator-form"),
    field = component.find(".text-field");

  function openStoreLocator() {
    var location = field.val();

    if (location !== "") {
      j203.magnificPopup.open({
        items: {
          src: "http://images.walmart.com.br/lojas/?origem=" + location
        },
        type: "iframe",
        mainClass: "mfp-store-locator",
        closeBtnInside: false
      });
    }
  }

  function bindEvents() {
    component.submit(function(e){
      e.preventDefault();
      openStoreLocator();
      return false;
    });
  }

  return {
    init: function() {
      bindEvents();
    },
    open: openStoreLocator
  };
})();

wm.storeLocator.init();
wm.countrySelector = (function() {
  "use strict";

  var component = j203(".country-selector"),
    list = component.find(".country-selector-list"),
    item = component.find(".selector-br");

  function toggleList() {
    list.toggleClass("active");
  }

  function deactivateList() {
    list.removeClass("active");
  }

  function bindEvents() {
    item.click(function(e){
      e.preventDefault();
      toggleList();
    });
    list.on("mouseleave", function() {
      deactivateList();
    });
  }

  return {
    init: function() {
      bindEvents();
    }
  };
})();

wm.countrySelector.init();
/* TODO:
  replace data.categorys to data.categories on jsonp
*/

wm.taxesOnProducts = (function() {
  "use strict";

  var container = j203("#taxes-on-products-modal"),
      searchForm = container.find(".taxes-form"),
      searchFormField = searchForm.find(".taxes-field"),

      // taxesContent = container.find(".taxes-content"),

      tableContainer = j203("#taxes-table"),
      tableBody = tableContainer.find("tbody"),
      tableHead = tableContainer.find("thead"),

      paginationContainer = container.find(".pagination"),

      modalButton = j203("#taxes-products-button"),

      // currentPage = 1,
      itemsPerPage = 10,
      urlCategory = "http://www.walmart.com.br/getTaxesOnCategory/[[PAGE]]/[[ITEMSPERPAGE]]/",
      urlProduct = "http://www.walmart.com.br/getTaxesOnProducts/[[PRODUCT]]/[[PAGE]]/[[ITEMSPERPAGE]]/";


  // Shortcuts
  function getCategoryTaxes(page) {
    return getTaxes(urlCategory, page);
  }

  function getProductTaxes(page, searchTerm) {
    return getTaxes(urlProduct, page, searchTerm);
  }

  // Get Taxes
  function getTaxes(url, page, searchTerm) {
    page = page || 1;
    searchTerm = searchTerm || "";

    //Replace
    url = url.replace("[[ITEMSPERPAGE]]", itemsPerPage);
    url = url.replace("[[PAGE]]", page);
    url = url.replace("[[PRODUCT]]", searchTerm);

    j203.ajax({
      url: url,
      dataType: "jsonp",
      success: function(data) {
        makeTable(data);
        makePagination(data);
      }
    });

  }

  //New search
  function searchProductTaxes(e) {
    e.preventDefault();
    var searchTerm = searchFormField.val();

    if(searchTerm && j203.trim(searchTerm).length >= 1) {
      getProductTaxes(1, searchTerm);
    }

    return false;
  }

  // Make tables
  function makeTable(data) {
    var html = "";

    if(data.categorys) {
      html = makeTableCategories(data);
    }

    if(data.products) {
      //html = makeTableProducts(data);
    }

   // tableBody.html(html);
  }

  // Make category table
  function makeTableCategories(data) {
    var body = "";
    tableHead.html(
      "<tr>"+
      "  <th class='category-column'>Categoria</th>"+
      "  <th class='taxe-category-column'>Imposto (%)</th>"+
      "</tr>"
    );

    j203.each(data.categorys, function(i, line) {
      body +=
        "<tr>"+
        "  <td class='category-column'><p>" + line.category + "</p></td>"+
        "  <td class='taxe-category-column'><p>" + line.tax + "</p></td>"+
        "</tr>";
    });

    return body;
  }

  // Make product table
  function makeTableProducts(data) {
    var body = "";
    tableHead.html(
      "<tr>"+
      "  <th class='sku-column'>Cod. Produto</th>"+
      "  <th class='description-column'>Descrição</th>"+
      "  <th class='department-column'>Departamento</th>"+
      "  <th class='taxe-column'>Alíquota IBPT (%)</th>"+
      "</tr>"
    );

    j203.each(data.products, function(i, line) {
      body +=
        "<tr>"+
        "  <td class='sku-column'><p>" + line.sku + "</p></td>"+
        "  <td class='description-column' title='" + line.name + "'><p>" + line.name + "</p></td>"+
        "  <td class='department-column' title='" + line.department + "'><p>" + line.department + "</p></td>"+
        "  <td class='taxe-column'><p>" + line.tax + "</p></td>"+
        "</tr>";
    });

    return body;
  }







  function makePagination(data) {
    var totalShowingLinks = 5, // 2 links + current page + 2 links
        showFirstAndLast = true,
        showNextAndPrevious = true,
        totalPages = parseInt(data.pagination.totalPage, 10),
        currentPage = parseInt(data.pagination.currentPage, 10),
        type = data.products ? "products" : "category";

    if(totalPages <= 1) {
      paginationContainer.html("");
      return false;
    }

    var container = j203("<ul></ul>"),
        item,
        link,
        linkTemplate = "<a class='btn btn-pag link-pagination' href='#'></a>",
        itemTemplate = "<li class='pagination-item'></li>";


    //Link Range
    var firstLinkKey = currentPage - Math.floor(totalShowingLinks / 2),
        lastLinkKey = firstLinkKey + totalShowingLinks - 1;

    if(firstLinkKey < 1) {
      firstLinkKey = 1;
      lastLinkKey = firstLinkKey + (totalShowingLinks - 1);
    }

    if(lastLinkKey > totalPages) {
      lastLinkKey = totalPages;
    }

    if(lastLinkKey - firstLinkKey < totalShowingLinks - 1) {
      firstLinkKey = lastLinkKey - (totalShowingLinks - 1);

      if(firstLinkKey < 1) {
        firstLinkKey = 1;
      }
    }

    // Pagination links
    for(var i = firstLinkKey; i <= lastLinkKey; i++) {
      item = j203(itemTemplate);
      link = j203(linkTemplate).html(i);

      if(i === currentPage) {
        link.addClass("active");
      } else {
        link = makePaginationBind(link, type, i, data);
      }

      //item.append(link);
      //container.append(item);
    }

    // First and Last
    if(showFirstAndLast) {

      //First
      if(firstLinkKey > 1) {
        item = j203(itemTemplate);
        link = j203(linkTemplate).html(1);
        link = makePaginationBind(link, type, 1, data);

        if(firstLinkKey - 1 !== 1) {
          item.addClass("first");
        }

        //item.append(link);
        //container.prepend(item);
      }

      //Last
      if(lastLinkKey < totalPages) {
        item = j203(itemTemplate);
        link = j203(linkTemplate).html(totalPages);
        link = makePaginationBind(link, type, totalPages, data);

        if(totalPages - lastLinkKey !== 1) {
          item.addClass("last");
        }

        //item.append(link);
        //container.append(item);
      }
    }

    // Next and Previous
    if(showNextAndPrevious) {
      var next = currentPage + 1,
          previous = currentPage - 1;

      // Previous
      item = j203(itemTemplate);
      link = j203(linkTemplate).html("&#171; Anterior");

      if(previous >= 1) {
        link = makePaginationBind(link, type, previous, data);
      } else {
        link.addClass("btn-disabled");
      }

      //item.append(link);
      //container.prepend(item);

      // Next
      item = j203(itemTemplate);
      link = j203(linkTemplate).html("Próximo &#187;");

      if(next <= totalPages) {
        link = makePaginationBind(link, type, next, data);
      } else {
        link.addClass("btn-disabled");
      }

      //item.append(link);
      //container.append(item);
    }

    paginationContainer.html(container);
  }


  function makePaginationBind(el, type, page, data) {
    el.bind("click", function(e) {
      e.preventDefault();
      if(type === "category") {
        getCategoryTaxes(page);
      } else {
        getProductTaxes(page, data.searchTerm);
      }
      return false;
    });

    return el;
  }


  function bindEvents() {
    modalButton.bind("click", function() {
      getCategoryTaxes();
    });

    searchForm.bind("submit", searchProductTaxes);
  }

  return {
    init: function() {
      bindEvents();
    }
  };
})();

wm.taxesOnProducts.init();
wm.gotoTop = (function() {
  "use strict";
  var component = j203(".go-to-top"),
  win = j203(window);

  function gotoTop() {
    j203("body, html").stop(true, true).animate({
      scrollTop: 0
    }, 1000);
  }

  function bindEvents() {
    component.click(function(){
      gotoTop();
    });
    win.scroll(function(){
      if(win.scrollTop() < 100){
        if(!component.is(".hide")) {
          component.addClass("hide");
        }
      } else {
        if(component.is(".hide")) {
          component.removeClass("hide");
        }
      }
    });
  }

  return {
    init: function() {
      bindEvents();
    },
    start: gotoTop
  };
})();
wm.gotoTop.init();
wm.getDatalayerData = function() {
  "use strict";

  function init() {
    /*var url = wm.constants.API_HOST_ENDPOINT + "/api/webstore/v1/datalayer";

    j203.ajax({
      url: url,
      dataType: "jsonp",
      success: function(data) {
        updateDatalayer(data);
      },
      error: showErrorMessage
    });*/
  }

  function showErrorMessage() {
   /* for (var x in dataLayer) {
      if(dataLayer[x].hasOwnProperty("visitorIdentify") && 
        dataLayer[x].hasOwnProperty("visitorName")){
        dataLayer[x].errorOnLoad = "true";
      }
    }*/
  }

  /**
  * This function is responsible for create the datalayer of users
  *
  * @obj datalayer
  **/
  function updateDatalayer(dataLayerObj) {
    /*dataLayer.push({
      "event" : "visitorLoad",
      "visitorIdentify" : dataLayerObj.visitorIdentify,
      "visitorName" : dataLayerObj.visitorName,
      "visitorLoginState" : dataLayerObj.visitorLoginState
    });*/
  }

  init();
};

wm.getDatalayerData();
/**
*  Ajax Autocomplete for jQuery, version 1.2.5
*  (c) 2013 Tomas Kirda
*
*  Ajax Autocomplete for jQuery is freely distributable under the terms of an MIT-style license.
*  For details, see the web site: http://www.devbridge.com/projects/autocomplete/jquery/
*
*/
// Expose plugin as an AMD module if AMD loader is present:
(function (factory) {
  "use strict";

  // Browser globals
  factory(window.jQuery);
}


(function (j203) {
  "use strict";

  var dropdownSearch = j203(".dropdown.search"),
  utils = (function () {
    return {

      extend: function (target, source) {
        return j203.extend(target, source);
      },

      addEvent: function (element, eventType, handler) {
        if (element.addEventListener) {
          element.addEventListener(eventType, handler, false);
        } else if (element.attachEvent) {
          element.attachEvent("on" + eventType, handler);
        } else {
          throw new Error("Browser doesn't support addEventListener or attachEvent");
        }
      },

      removeEvent: function (element, eventType, handler) {
        if (element.removeEventListener) {
          element.removeEventListener(eventType, handler, false);
        } else if (element.detachEvent) {
          element.detachEvent("on" + eventType, handler);
        }
      },

      createNode: function (html) {
        var div = document.createElement("div");
        div.innerHTML = html;
        return div.firstChild;
      }

    };
  }()),

  keys = {
    ESC: 27,
    TAB: 9,
    RETURN: 13,
    UP: 38,
    DOWN: 40
  };

  function Autocomplete(el, options) {
    var noop = function () { },
    that = this,
    defaults = {
      autoSelectFirst: false,
      appendTo: "body",
      serviceUrl: null,
      serviceTopUrl: null,
      timeoutUrl: 2000,
      timeoutTopUrl: 2000,
      lookup: null,
      onSelect: null,
      width: "auto",
      minChars: 0,
      maxHeight: null,
      maxTimeEditDistance: 100,
      deferRequestBy: 0,
      params: {},
      formatResult: Autocomplete.formatResult,
      normalize : Autocomplete.normalize,
      regExpHighLighing: Autocomplete.regExpHighLighing,
      delimiter: null,
      zIndex: 9999,
      type: "GET",
      noCache: false,
      onSearchStart: noop,
      onSearchComplete: noop,
      containerClass: "autocomplete-suggestions",
      tabDisabled: false,
      dataType: "text",
      lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
        return suggestion.toLowerCase().indexOf(queryLowerCase) !== -1;
      },
      paramName: "q",
      transformResult: function (response) {
        return typeof response === "string" ? j203.parseJSON(response) : response;
      }
    };

    // Shared variables:
    that.element = el;
    that.el = j203(el);
    that.suggestions = {};
    that.top = [];
    that.suggestions.keywords = [];
    that.suggestions.brands = [];
    that.suggestions.departments = [];
    that.suggestions.suggestedTerm = "";
    that.badQueries = [];
    that.selectedIndex = -1;
    that.currentValue = that.element.value;
    that.intervalId = 0;
    that.cachedResponse = [];
    that.cachedTopResponse = [];
    that.cachedEditDistance = [];
    that.onChangeInterval = null;
    that.onChange = null;
    that.ignoreValueChange = false;
    that.isLocal = false;
    that.suggestionsContainer = null;
    that.options = j203.extend({}, defaults, options);
    that.classes = {
      selected: "autocomplete-selected",
      suggestion: "autocomplete-suggestion"
    };

    // Initialize and set options:
    that.initialize();
    that.setOptions(options);
  }

  Autocomplete.utils = utils;

  j203.Autocomplete = Autocomplete;

  Autocomplete.normalize = function (term) {
    term = j203.trim(term).toLowerCase();
    term = term.replace(/\s+/gi, " ").
    replace(/[\u00E0\u00E1\u00E2\u00E3]/gi, "a").
    replace(/[\u00E8\u00E9\u00EA]/gi, "e").
    replace(/[\u00EC\u00ED\u00EE]/gi, "i").
    replace(/[\u00F2\u00F3\u00F4\u00F5]/gi, "o").
    replace(/[\u00F9\u00FA\u00FB]/gi, "u").
    replace(/[\u00E7]/gi, "c");
    return term;
  };

  Autocomplete.regExpHighLighing = function (autocomplete, currentValue) {
    var values = autocomplete.options.normalize(currentValue).replace(/[^a-zA-Z0-9]/, " ").split(" ");
    var index, index2;
    var valuesSimple = [];

    //For para não gerar Regexp prar o mesmo termo na caixa de busca
    for(index in values){
      if(valuesSimple.length === 0){
        valuesSimple[index] = values[index];
      }else{
        var useTerm = false;
        for(index2 in valuesSimple){
          if(valuesSimple[index2].indexOf(values[index]) !== 0){
            useTerm = true;
            break;
          }
        }
        if(useTerm === true){
          valuesSimple[index] = values[index];
        }
      }

    }
    var terms = "";
    for(index in valuesSimple) {
      if (valuesSimple.hasOwnProperty(index)) {
        terms += "(^|\\s|-)" + values[index].replace(/[aàáãâ]/gi, "[aàáãâ]").
        replace(/[eéèê]/gi, "[eéèê]").
        replace(/[iíìî]/gi, "[iíìî]").
        replace(/[oóòôõ]/gi, "[oóòôõ]").
        replace(/[uúùû]/gi, "[uúùû]").
        replace(/[-]/gi, " ").
        replace(/[cç]/gi, "[cç]") + "|";
      }
    }
    terms = terms.substring(0, terms.length - 1);
    return new RegExp("(" + terms + ")", "gi");
  };

  Autocomplete.formatResult = function (index, suggestion, regExp) {
    suggestion = suggestion.replace(regExp, "<strong>j2031</strong>") + " ";
    return suggestion;
  };

  Autocomplete.prototype = {

    killerFn: null,

    initialize: function () {
      var that = this,
      suggestionSelector = "." + that.classes.suggestion,
      selected = that.classes.selected,
      options = that.options,
      container;
      // Remove autocomplete attribute to prevent native suggestions:
      that.element.setAttribute("autocomplete", "off");

      that.killerFn = function (e) {
        if (j203(e.target).closest("." + that.options.containerClass).length === 0) {
          that.killSuggestions();
          that.disableKillerFn();
        }
      };

      // Determine suggestions width:
      if (!options.width || options.width === "auto") {
        options.width = that.el.outerWidth();
      }

      that.suggestionsContainer = Autocomplete.utils.createNode("<div class=\"" + options.containerClass + "\" style=\"display: none;\"></div>");

      container = j203(that.suggestionsContainer);

      container.appendTo(options.appendTo);

      // Listen for mouse over event on suggestions list:
      container.on("mouseover.autocomplete", suggestionSelector, function () {
        that.activate(j203(this).data("index"));
      });

      // Deselect active element when mouse leaves suggestions container:
      container.on("mouseout.autocomplete", function () {
        that.selectedIndex = -1;
        container.children("." + selected).removeClass(selected);
      });

      // Listen for click event on suggestions list:
      container.on("click.autocomplete", suggestionSelector, function () {
        that.select(j203(this).data("index"), false);
      });

      container.on("submit.autocomplete", suggestionSelector, function () {
        that.select(j203(this).data("index"), false);
      });

      that.fixPosition();

      that.fixPositionCapture = function () {
        if (that.visible) {
          that.fixPosition();
        }
      };

      // Opera does not like keydown:
      if (window.opera) {
        that.el.on("keypress.autocomplete", function (e) { that.onKeyPress(e); });
      } else {
        that.el.on("keydown.autocomplete", function (e) { that.onKeyPress(e); });
      }

      that.el.on("keyup.autocomplete", function (e) { that.onKeyUp(e); });
      that.el.on("blur.autocomplete", function () { that.onBlur(); });
      that.el.on("click.autocomplete", function () { that.fixPosition(); }).on("focus.autocomplete", function () { that.showTopSuggestions(); });
    },

    onBlur: function () {
      this.enableKillerFn();
    },

    setOptions: function (suppliedOptions) {
      var that = this,
      options = that.options;

      utils.extend(options, suppliedOptions);

      that.isLocal = j203.isArray(options.lookup);

      if (that.isLocal) {
        options.lookup = that.verifySuggestionsFormat(options.lookup);
      }

      // Adjust height, width and z-index:
      j203(that.suggestionsContainer).css({
        "max-height": options.maxHeight + "px",
        "width": "100%",
        "z-index": options.zIndex
      });
    },

    clearCache: function () {
      this.cachedResponse = [];
      this.cachedTopResponse = [];
      this.badQueries = [];
    },

    disable: function () {
      this.disabled = true;
    },

    enable: function () {
      this.disabled = false;
    },

    showTopSuggestions: function () {
      var that = this;
      var value = that.getQuery(that.currentValue);
      if(value === ""){
        that.getTopSuggestions();
        that.visibleTop = true;
        dropdownSearch.fadeIn(300);
      }
    },

    fixPosition: function () {
      var that = this,
      offset;

      // Don"t adjsut position if custom container has been specified:
      if (that.options.appendTo !== "body") {
        return;
      }

      offset = that.el.offset();

      j203(that.suggestionsContainer).css({
        top: (offset.top + that.el.outerHeight()) + "px",
        left: offset.left + "px"
      });
    },

    enableKillerFn: function () {
      var that = this;
      j203(document).on("click.autocomplete", that.killerFn);
    },

    disableKillerFn: function () {
      var that = this;
      j203(document).off("click.autocomplete", that.killerFn);
    },

    killSuggestions: function () {
      var that = this;
      that.stopKillSuggestions();
      that.intervalId = window.setInterval(function () {
        that.hide();
        that.stopKillSuggestions();
      }, 300);
    },

    stopKillSuggestions: function () {
      window.clearInterval(this.intervalId);
    },

    onKeyPress: function (e) {
      var that = this;
      // If suggestions are hidden and user presses arrow down, display suggestions:
      if (!that.disabled && !that.visible && !that.visibleTop && (e.keyCode === keys.DOWN || e.keyCode === keys.UP)&& that.currentValue) {
        that.suggest();
        return;
      }

      if ((that.disabled)) {
        return;
      }
      switch (e.keyCode) {
      case keys.ESC:
        that.el.val(that.currentValue);
        that.hide();
        break;
      case keys.TAB:
      case keys.RETURN:
        if (that.selectedIndex === -1) {
          that.hide();
          return;
        }
        that.select(that.selectedIndex, e.keyCode === keys.RETURN);
        if (e.keyCode === keys.TAB && this.options.tabDisabled === false) {
          return;
        }
        break;
      case keys.UP:
        that.moveUp();
        break;
      case keys.DOWN:
        that.moveDown();
        break;
      default:
        that.hideTop();
        return;
      }

      // Cancel event if function did not return:
      e.stopImmediatePropagation();
      e.preventDefault();
    },

    onKeyUp: function (e) {
      var that = this;

      if (that.disabled) {
        return;
      }

      switch (e.keyCode) {
      case keys.UP:
      case keys.DOWN:
        return;
      }

      clearInterval(that.onChangeInterval);

      if (that.currentValue !== that.el.val()) {
        if (that.options.deferRequestBy > 0) {
          // Defer lookup in case when value changes very quickly:
          that.onChangeInterval = setInterval(function () {
            that.onValueChange();
          }, that.options.deferRequestBy);
        } else {
          that.onValueChange();
        }
      }
    },

    onValueChange: function () {
      var that = this,
      q;

      clearInterval(that.onChangeInterval);
      that.currentValue = that.element.value;
      q = that.getQuery(that.element.value);
      that.selectedIndex = -1;

      if (that.ignoreValueChange) {
        that.ignoreValueChange = false;
        return;
      }
      if (q.length < that.options.minChars) {
        that.hide();
      } else {
        that.getSuggestions(q);
      }
    },

    getQuery: function (value) {
      var delimiter = this.options.delimiter,
      parts;
      var that = this,
      normalize = that.options.normalize,
      sortQuery = that.sortQuery;

      if (!delimiter) {
        return sortQuery(normalize(value));
      }
      parts = value.split(delimiter);
      return sortQuery(normalize(parts[parts.length - 1]));
    },

    sortQuery: function (value) {
      value = j203.trim(value.replace(/[^a-zA-Z0-9]/, " "));
      return value.split(" ").sort().join(" ");
    },

    getSuggestionsLocal: function (query) {
      var that = this,
      queryLowerCase = query.toLowerCase(),
      filter = that.options.lookupFilter;

      return {
        suggestions: j203.grep(that.options.lookup, function (suggestion) {
          return filter(suggestion, query, queryLowerCase);
        })
      };
    },

    getTopSuggestions: function () {
      var that = this,
      options = that.options;
      if (that.cachedTopResponse.length > 0) {
        that.top  = that.cachedTopResponse;
        that.suggestTop();
      } else {
        j203.ajax({
          url: options.serviceTopUrl,
          type: options.type,
          dataType: options.dataType,
          timeout: options.timeoutTopUrl
        }).done(function (data) {
          var result = options.transformResult(data);
          that.top = result.terms;
          that.cachedTopResponse = that.top;
          that.suggestTop();
        });
      }
    },

    getSuggestions: function (q) {
      var response,
      that = this,
      options = that.options;

      response = that.isLocal ? that.getSuggestionsLocal(q) : that.cachedResponse[q];

      if (response && j203.isArray(response.suggestions)) {
        that.suggestions.keywords = response.suggestions;
        that.suggest();
      } else if (!that.isBadQuery(q)) {
        options.params[options.paramName] = q;
        options.onSearchStart.call(that.element, options.params);
        j203.ajax({
          url: options.serviceUrl,
          data: options.params,
          type: options.type,
          timeout: options.timeoutUrl,
          dataType: options.dataType
        }).done(function (data) {
          that.processResponse(data, q);
          options.onSearchComplete.call(that.element, q);
        });
      }
    },

    isBadQuery: function (q) {
      var badQueries = this.badQueries,
      i = badQueries.length;

      while (i--) {
        if (q.indexOf(badQueries[i]) === 0) {
          return true;
        }
      }

      return false;
    },

    hide: function () {
      var that = this;
      that.visible = false;
      if(that.visibleTop){
        j203(that.suggestionsContainer).html("");
      }
      j203(that.suggestionsContainer).hide();
      that.visibleTop = false;
      that.selectedIndex = -1;
      dropdownSearch.hide();
    },

    hideTop: function () {
      var that = this;
      that.visibleTop = false;
      that.selectedIndex = -1;
    },

    suggest: function () {

      var that = this,
      regExp = that.options.regExpHighLighing,
      formatResult = that.options.formatResult,
      value = that.getQuery(that.currentValue),
      className = that.classes.suggestion,
      classSelected = that.classes.selected,
      container = j203(that.suggestionsContainer),
      html = "";

      if (value.length < that.options.minChars || ( this.suggestions === undefined || this.suggestions.suggestedTerm === undefined ) && (this.suggestions.keywords === undefined || this.suggestions.keywords.length === 0) && (this.suggestions.brands === undefined || this.suggestions.brands.length === 0) && (this.suggestions.departments === undefined || this.suggestions.departments.length === 0)) {
        this.hide();
        return;
      }

      // Build suggestions inner HTML:
      var j = 0;
      var countSuggest = 1;
      var regExpHighLighting = regExp(that, value);
      var suggestedTerm = formatResult(0, that.suggestions.suggestedTerm, regExpHighLighting);
      var template;
      /* aqui html += "<div class=\"" + className + "\" data-index=\"" + j++ + "\">" + formatResult(0, suggestedTerm, regExpHighLighting) + "</div>";*/

      html += "<li class='item " + className + "' data-index='" + j++ + "'>" +
        "<span class='icon'></span>" +
        formatResult(0, suggestedTerm, regExpHighLighting) + "</li>";


      if(that.suggestions.departments !== undefined){
        for (var i = 0; i < that.suggestions.departments.length; i++) {
          var suggestedTermContent = suggestedTerm +" em " + that.suggestions.departments[i];
          /* aqui html += "<div class=\"" + className + "\" data-index=\"" + j++ + "\">" + suggestedTermContent + "</div>";*/

          html += "<li class='item department " + className + "' data-index='" +
          j++ + "'>" + "<span class='icon " + Autocomplete
          .normalize(that.suggestions.departments[i]).replace(/\s+/g,"-") +
          "'></span>" + suggestedTermContent + "</li>";

          ++countSuggest;
        }
      }
      if(that.suggestions.keywords !== undefined){
        j203.each(that.suggestions.keywords, function (i, suggestion) {
          if(countSuggest < that.options.params.size){
            /* aqui html += "<div class=\"" + className + "\" data-index=\"" + j++ + "\">" + formatResult(i , suggestion, regExpHighLighting) + "</div>";*/

            html += "<li class='item " + className + "' data-index='" +
            j++ + "'>" + "<span class='icon " + that.suggestions.departments[i] +
            "'></span>" + formatResult(i , suggestion, regExpHighLighting) +
            "</li>";

            ++countSuggest;
          }
        });
      }

      template = "<ul class='list-suggestions'>" + html + "</ul>";
      container.html(template);
      container.show();
      dropdownSearch.fadeIn(300);
      that.visible = true;

      // Select first value by default:
      if (that.options.autoSelectFirst) {
        that.selectedIndex = 0;
        container.children().first().addClass(classSelected);
      }
    },

    suggestTop: function () {
      if ((!this.top || this.top.length === 0)) {
        this.hide();
        return;
      }

      var that = this,
      className = that.classes.suggestion,
      container = j203(that.suggestionsContainer),
      html = "",
      template;


      // Build suggestions inner HTML:
      var j = 0;
      j203.each(that.top, function (i, suggestion) {
        if(i < that.options.params.size){
          html += "<li class='item " + className + "' data-index='" +
            ((j++)-i) + "'><span class='index'>" + ((j++)-i) + "</span>" +
            suggestion + "</li>";
        }
      });
      template = "<strong class='title-dropdown'>Termos mais buscados</strong>"+
      "<ul class='list'>" + html + "</ul>";
      container.html(template).show();
      that.visibleTop = true;
    },

    verifySuggestionsFormat: function (suggestions) {
      // If suggestions is string array, convert them to supported format:
      if (suggestions.length && typeof suggestions[0] === "string") {
        suggestions.terms = suggestions;
        return suggestions;
      }

      return suggestions;
    },

    processResponse: function (response, originalQuery) {
      var that = this,
      options = that.options,
      result = options.transformResult(response, originalQuery);

      //result.keywords = that.verifySuggestionsFormat(result.keywords);

      // Cache results if cache is not disabled:
      if (!options.noCache) {
        that.cachedResponse[result.searchedTerm] = result;
        if (result.terms === undefined || result.terms.length === 0 ) {
          that.badQueries.push(result[options.paramName]);
        }
      }

      // Display suggestions only if returned query matches current value:
      if (originalQuery === that.getQuery(that.currentValue)) {
        that.suggestions.suggestedTerm = result.suggestedTerm;
        if(result.terms !== undefined ){
          that.suggestions.keywords = result.terms;
        }else{
          that.suggestions.keywords = [];
        }
        if(result.brands !== undefined){
          that.suggestions.brands = result.brands;
        }else{
          that.suggestions.brands = [];
        }
        if(result.departments !== undefined){
          that.suggestions.departments = result.departments;
        }else{
          that.suggestions.departments = [];
        }
        that.suggest();
      }
    },

    activate: function (index) {
      var that = this,
      activeItem,
      selected = that.classes.selected,
      container = j203(that.suggestionsContainer).find("ul"),
      children = container.children();
      container.children("." + selected).removeClass(selected);

      that.selectedIndex = index;

      if (that.selectedIndex !== -1 && children.length > that.selectedIndex) {
        activeItem = children.get(that.selectedIndex);
        j203(activeItem).addClass(selected);
        return activeItem;
      }

      return null;
    },

    select: function (i, shouldIgnoreNextValueChange) {
      var that = this,
      selectedValue = that.getSuggestionByIndex(i);
      if (selectedValue) {
        that.el.val(selectedValue.suggestionItem);
        that.ignoreValueChange = shouldIgnoreNextValueChange;
        that.onSelect(i);
        that.hide();
      }
    },

    moveUp: function () {
      var that = this;
      if (that.selectedIndex === -1) {
        that.selectedIndex = that.getSuggestionLength();
      }
      if (that.selectedIndex === 0) {
        j203(that.suggestionsContainer).find("ul").children().first()
          .removeClass(that.classes.selected);
        that.selectedIndex = -1;
        that.el.val(that.currentValue);
        return;
      }
      that.adjustScroll(that.selectedIndex - 1);
    },

    moveDown: function () {
      var that = this;
      if (that.selectedIndex === -1) {
        that.selectedIndex = -1;
      }
      if (that.selectedIndex === (that.getSuggestionLength() - 1)) {
        j203(that.suggestionsContainer).find("ul").children().last()
          .removeClass(that.classes.selected);
        that.selectedIndex = -1;
        that.el.val(that.currentValue);
        return;
      }
      that.adjustScroll(that.selectedIndex + 1);
    },

    adjustScroll: function (index) {
      var that = this,
      activeItem = that.activate(index),
      offsetTop,
      upperBound,
      lowerBound,
      heightDelta = 25;
      if (!activeItem) {
        return;
      }
      offsetTop = activeItem.offsetTop;
      upperBound = j203(that.suggestionsContainer).scrollTop();
      lowerBound = upperBound + that.options.maxHeight - heightDelta;

      if (offsetTop < upperBound) {
        j203(that.suggestionsContainer).scrollTop(offsetTop);
      } else if (offsetTop > lowerBound) {
        j203(that.suggestionsContainer).scrollTop(offsetTop - that.options.maxHeight + heightDelta);
      }
      that.el.val(that.getValue(that.getSuggestionByIndex(index).suggestionItem));
    },

    onSelect: function (index) {
      var that = this,
      onSelectCallback = that.options.onSelect,
      suggestion = that.getSuggestionByIndex(index);
      that.el.val(that.getValue(suggestion.suggestionItem));
      if (j203.isFunction(onSelectCallback)) {
        onSelectCallback.call(that.element, suggestion);
      }
    },

    getSuggestionByIndex: function (index) {

      var that = this;
      var suggestion = {"suggestionItem": "", "department":""};
      if(!that.visibleTop){
        var keyIndex = that.suggestions.keywords.length ;
        var deptIndex = 0;
        if(that.suggestions.departments !== undefined){
          deptIndex = that.suggestions.departments.length;
        }

        if(index === 0){
          suggestion.suggestionItem = that.suggestions.suggestedTerm;
        }else{
          if(deptIndex > 0 && index <= deptIndex){
            suggestion.suggestionItem = that.suggestions.suggestedTerm;
            suggestion.department = that.suggestions.departments[index - 1];
          }else{
            if(index >= deptIndex-1 && index <= keyIndex + deptIndex){
              suggestion.suggestionItem = that.suggestions.keywords[index - deptIndex - 1];
            }
          }

        }
      }else{
        suggestion.suggestionItem = that.top[index];
      }
      return suggestion;
    },

    getSuggestionLength: function () {
      var that = this,
      length = that.top.length,
      size = that.options.params.size;
      if(!that.visibleTop || that.visibleTop === false){
        length = 0;
        if(that.suggestions.suggestedTerm !== undefined){
          length += 1;
        }
        length += that.suggestions.keywords.length;
        length += that.suggestions.departments.length;
        length += that.suggestions.brands.length;
      }
      if(length >= size){
        length = size;
      }
      return length;
    },

    getValue: function (value) {
      var that = this,
      delimiter = that.options.delimiter,
      currentValue,
      parts;

      if (!delimiter) {
        return value;
      }

      currentValue = that.currentValue;
      parts = currentValue.split(delimiter);

      if (parts.length === 1) {
        return value;
      }

      return currentValue.substr(0, currentValue.length - parts[parts.length - 1].length) + value;
    }
  };

  // Create chainable jQuery plugin:
  j203.fn.autocomplete = function (options, args) {
    return this.each(function () {
      var dataKey = "autocomplete",
      inputElement = j203(this),
      instance;

      if (typeof options === "string") {
        instance = inputElement.data(dataKey);
        if (typeof instance[options] === "function") {
          instance[options](args);
        }
      } else {
        instance = new Autocomplete(this, options);
        inputElement.data(dataKey, instance);
      }
    });
  };
}));
wm.autocomplete = (function() {
  "use strict";

  function loadComponent() {
    j203("#suggestion-search").autocomplete({
      serviceUrl: "/ws/suggest",
      serviceTopUrl: "/ws/top",
      minChars: 2,
      deferRequestBy: 100,
      appendTo: ".topbar-search .body-dropdown.top-search",
      params: {
        "fields": "departments",
        "size": 10
      },
      onSelect: function(element) {

        var URL = "http://www.walmart.com.br/busca/?ft=" + element.suggestionItem;
        if (element.department !== undefined && element.department !== "") {
          URL += "&fq=DN:" + element.department;
        }
        window.location = URL;
      }
    });
  }

  return {
    init: function() {
      loadComponent();
    }
  };

})();

wm.autocomplete.init();
wm.search = (function() {
  "use strict";

  var form = j203(".topbar-search"),
  component = form.find("#suggestion-search");

  function validate(e) {
    if(component.val() === ""){
      e.preventDefault();
      return false;
    }
  }

  function messagePlaceholder(str) {
    j203("#suggestion-search").attr("placeholder", str);
  }

  function bindEvents() {
    form.submit(function(e){
      validate(e);
    });
    j203("#suggestion-search").focus(function() {
      wm.topbar.closeDropdowns();
    });
  }

  return {
    init: function() {
      bindEvents();
    },
    messagePlaceholder: function(str) {
      messagePlaceholder(str);
    }
  };
})();
wm.search.init();

wm.track = (function() {
  /*"use strict";

  var query = location.search,
      documentReferrer = window.escape(document.referrer).replace(/\//g, "%2F"),
      url = window.escape(document.location.href).replace(/\//g, "%2F"),
      UrlTrack = "/Site/Track.aspx";

  function callTrack() {
    if (query === "") {
      query = "?";
    } else {
      query += "&";
    }

    query += "referrer=" + documentReferrer;
    query += "&url=" + url;

    j203.ajax({
      url: UrlTrack + query,
      success: function (data) {
        var htmlComments = /<!--[\s\S]*?-->/g,
            script = data.replace(htmlComments, "");
        j203("body").append("<div id='divDataLayerScript'>" + script + "</div>");
      },
      dataType: "html"
    });
  }

  function bindEvents() {
    callTrack();
  }

  return {
    init: function() {
      bindEvents();
    }
  };
*/
  return
  {
  };
})();

//wm.track.init();


var miniCartTimerPreview = null;
wm.miniCart = (function() {
  "use strict";

  var cart = j203("#wm-cart"),
      cartList = cart.find(".cart-list"),
      cartInfo = cart.find(".cart-info"),
      emptyMessage = cart.find(".empty-cart"),
      errorMessage = cart.find(".error-cart"),
      miniCartButton = j203(".topbar-buttons.cart-link"),
      imagesPath = wm.constants.HTTP_IMAGES_PATH || "/",
      hostWebstore = wm.constants.WEBSTORE_ENDPOINT || "/";

  function loadCartInfo() {
    var hostCheckout = wm.constants.CHECKOUT_ENDPOINT,
      url = hostCheckout + "/checkout/services/cart/getCart";

    j203.ajax({
      url: url,
      dataType: "jsonp",
      crossDomain: true,
      success: updateCartInfo,
      timeout: 10000,
      error: function() {
        showErrorMessage();
      }
    });
  }

  function showCartInfo() {
    errorMessage.addClass("hidden");
    emptyMessage.addClass("hidden");
    cartInfo.removeClass("hidden");
  }

  function showEmptyCart() {
    errorMessage.addClass("hidden");
    cartInfo.addClass("hidden");
    emptyMessage.removeClass("hidden");
  }

  function showErrorMessage() {
    cartInfo.addClass("hidden");
    emptyMessage.addClass("hidden");
    errorMessage.removeClass("hidden");
  }

  function updateCartInfo(results) {

    var quantityElem = cart.find(".quantity"),
      data = JSON.parse(results),
      items = data.items || null,
      quantity = items.length || 0,
      html = "",
      htmlItem = "<li class='product-item' title='{{title}}'>" +
      "<img src='{{imageUrl}}' class='product-image'>" +
      "<p class='product-title'>{{description}}</p>" +
      "<p class='product-quantity'>Quantidade: {{quantity}}</p>" +
      "</li>",
      imgFallback = imagesPath + "/cart/garantia-estendida.png",
      regexWarranty = /garantia estendida/;

    cartList.addClass("loading");

    if (items) {
      for (var i = 0; i < items.length; i++) {
        var item = items[i],
            isWarranty = regexWarranty.test(item.description.toLowerCase()),
            image = item.imageUrl + "-40-40",
            url = item.detailUrl ? hostWebstore + item.detailUrl : "#",
            description = "<a href='" + url + "'>" +
              item.description + "</a>";

        if (isWarranty) {
          image = imgFallback;
          description = "<a>" + item.description + "</a>";
        }

        html += htmlItem.replace("{{imageUrl}}", image)
            .replace("{{url}}", url)
            .replace("{{description}}", description)
            .replace("{{title}}", item.description)
            .replace("{{quantity}}", item.quantity);
      }
    }

    quantityElem.html(quantity);
    cartList.removeClass("loading");
    cartList.html(html);
    if (quantity === 0) {
      showEmptyCart();
    } else {
      showCartInfo();
    }
  }


  function open() {
    wm.topbar.openDropdown(miniCartButton);
    // loadCartInfo();
  }

  function close() {
    wm.topbar.closeDropdowns();
  }

  function preview(timer) {
    open();
    clearTimeout(miniCartTimerPreview);
    miniCartTimerPreview = setTimeout(close, timer);
  }

  return {
    close: close,
    open: open,
    preview: function(timer) {
      preview(timer);
    },
    update: loadCartInfo,
    updateCartInfo: updateCartInfo

  };
})();
wm.selfHelp = (function() {
  "use strict";

  var headerComponent = j203("#self-help-header"),
    headerForm = headerComponent.find(".help-form"),
    headerField = headerComponent.find(".input-box"),

    footerComponent = j203("#self-help-footer"),
    chat = footerComponent.find(".btn-chat"),
    email = footerComponent.find(".btn-email"),
    footerForm = footerComponent.find(".self-help-form"),
    footerField = footerComponent.find(".text-field"),
    searchUrl = wm.constants.WEBSTORE_ENDPOINT + "/atendimento?q=";

  function openChat() {
    var url = "http://vipcom-pc:90/webim/client.php?locale=en__&amp;style=simplicity",
      left = (screen.width/2)-(406/2),
      top = (screen.height/2)-(466/2);

    window.open(url, "Chat", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=406, height=466, top="+top+", left="+left);
  }

  function openEmail() {
    wm.selfHelpEmail.open();
    /*j203.magnificPopup.open({
      items: {
        src: wm.constants.WEBSTORE_ENDPOINT + "/FaleConosco?hiddenhf=true"
        //src: "http://www2.walmart.com.br/FaleConosco?hiddenhf=true"
      },
      type: "iframe",
      callbacks: {
        open: function() {
          j203(".mfp-iframe-scaler").css("height", "500px");
        },
        change: function() {
          var iframeContents = j203("iframe.mfp-iframe").contents();
          var css = "<style type=\"text/css\">" +
                    "body{overflow-x: hidden;} " +
                    ".btn-voltar{visibility: hidden;} " +
                    "</style>";
          iframeContents.find("head").append(css);
        }
      }
    });*/
  }

  function submitSearch(searchText) {
    if (searchText !== "") {
      window.location.href = searchUrl + searchText;
    }
  }

  function bindEvents() {
    chat.click(function() {
      openChat();
    });

    email.click(function() {
      openEmail();
    });

    headerForm.submit(function(e){
      e.preventDefault();
      submitSearch(headerField.val());
      return false;
    });

    footerForm.submit(function(e){
      e.preventDefault();
      submitSearch(footerField.val());
      return false;
    });
  }

  return {
    init: function() {
      bindEvents();
    }
  };
})();

wm.selfHelp.init();
/*
  Markup Example:
    <span class="wm-tooltip bottom">
      <span class="wm-tooltip-arrow"></span>
      <span class="wm-tooltip-arrow-shadow"></span>
      <span class="wm-tooltip-content">Content here!</span>
    </span>

  Optional styles classes:
     Arrows positions: top || bottom || left || right
     Message type: error || warning || success

  Usage:
    // To open:
    wm.tooltip.open({
      target: ".product-notifyme-client-name", // Target to append tooltip
      content: "Content here",
      style: {top: "50px", left: "10px", "text-align: center"}, // Optional
      className: "bottom error", // Optional
      timeToClose: 3000 // Optional
    });
    // To close
    wm.tooltip.close({
      target:".product-notifyme-client-name",
      timeToClose: 3000 // Optional
    });
*/

wm.tooltip = (function() {
  "use strict";

  function open(options) {
    var target = j203(options.target);
    var classAdded = options.className !== undefined ? options.className : "";
    var markup = "<span class='wm-tooltip " + classAdded + "'>" +
      "<span class='wm-tooltip-arrow'></span>" +
      "<span class='wm-tooltip-arrow-shadow'></span>" +
      "<span class='wm-tooltip-content'>" + options.content + "</span>" +
      "</span>";
    close(options);
    if(options.content !== undefined) {
      target.append(markup);
      if(options.style !== undefined) {
        target.find(".wm-tooltip").css(options.style);
      }
      target.find(".wm-tooltip").fadeIn();
    }
    if(typeof options.timeToClose === "number") {
      close(options);
    }
  }

  function close(options) {
    var elem = j203(".wm-tooltip", options.target);
    if(typeof options.timeToClose === "number") {
      setTimeout(function() {
        elem.fadeOut(function() {
          elem.remove();
        });
      }, options.timeToClose);
    } else {
      elem.fadeOut(function() {
        elem.remove();
      });
    }
  }

  return {
    open: function(options) {
      open(options);
    },
    close: function(options) {
      close(options);
    }
  };
})();
// jQuery Mask Plugin v1.3.2
// github.com/igorescobar/jQuery-Mask-Plugin
(function(c){var w=function(a,d,e){var f=this;a=c(a);var l;d="function"==typeof d?d(a.val(),void 0,a,e):d;f.init=function(){e=e||{};f.byPassKeys=[8,9,16,36,37,38,39,40,46,91];f.translation={0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}};f.translation=c.extend({},f.translation,e.translation);f=c.extend(!0,{},f,e);a.each(function(){!1!==e.maxlength&&a.attr("maxlength",d.length);a.attr("autocomplete","off");g.destroyEvents();
g.events();g.val(g.getMasked())})};var g={events:function(){a.on("keydown.mask",function(){l=g.val()});a.on("keyup.mask",g.behaviour);a.on("paste.mask",function(){setTimeout(function(){a.keydown().keyup()},100)})},destroyEvents:function(){a.off("keydown.mask").off("keyup.mask").off("paste.mask")},val:function(v){var d="input"===a.get(0).tagName.toLowerCase();return 0<arguments.length?d?a.val(v):a.text(v):d?a.val():a.text()},behaviour:function(a){a=a||window.event;if(-1===c.inArray(a.keyCode||a.which,
f.byPassKeys))return g.val(g.getMasked()),g.callbacks(a)},getMasked:function(){var a=[],c=g.val(),b=0,q=d.length,h=0,l=c.length,k=1,r="push",m=-1,n,s;e.reverse?(r="unshift",k=-1,n=0,b=q-1,h=l-1,s=function(){return-1<b&&-1<h}):(n=q-1,s=function(){return b<q&&h<l});for(;s();){var t=d.charAt(b),u=c.charAt(h),p=f.translation[t];p?(u.match(p.pattern)?(a[r](u),p.recursive&&(-1==m?m=b:b==n&&(b=m-k),n==m&&(b-=k)),b+=k):p.optional&&(b+=k,h-=k),h+=k):(a[r](t),u==t&&(h+=k),b+=k)}return a.join("")},callbacks:function(f){var c=
g.val(),b=g.val()!==l;if(!0===b&&"function"==typeof e.onChange)e.onChange(c,f,a,e);if(!0===b&&"function"==typeof e.onKeyPress)e.onKeyPress(c,f,a,e);if("function"===typeof e.onComplete&&c.length===d.length)e.onComplete(c,f,a,e)}};f.remove=function(){g.destroyEvents();g.val(f.getCleanVal()).removeAttr("maxlength")};f.getCleanVal=function(){for(var a=[],c=g.val(),b=0,e=d.length;b<e;b++)f.translation[d.charAt(b)]&&a.push(c.charAt(b));return a.join("")};f.init()};c.fn.mask=function(a,d){return this.each(function(){c(this).data("mask",
new w(this,a,d))})};c.fn.unmask=function(){return this.each(function(){try{c(this).data("mask").remove()}catch(a){}})};c("input[data-mask]").each(function(){var a=c(this),d={};"true"===a.attr("data-mask-reverse")&&(d.reverse=!0);"false"===a.attr("data-mask-maxlength")&&(d.maxlength=!1);a.mask(a.attr("data-mask"),d)})})(window.jQuery||window.Zepto);

wm.selfHelpEmail = (function() {
  "use strict";

  var RequestTypes = [
    {
      key: "entrega",
      value: "Entrega",
      subjects: [
        {
          subject: "2ª via de Nota Fiscal",
          subjectCoopera: "Segunda via de Nota Fiscal"
        },
        {
          subject: "Alteração de endereço",
          subjectCoopera: "Alteração de endereço"
        },
        {
          subject: "Entrega agendada",
          subjectCoopera: "Entrega agendada"
        },
        {
          subject: "Minha entrega está atrasada",
          subjectCoopera: "Atraso na Entrega"
        },
        {
          subject: "Recebi meu pedido incompleto",
          subjectCoopera: "Recebimento de pedido incompleto"
        },
        {
          subject: "Recebi meu produto avariado/violado",
          subjectCoopera: "Produto Avariado / Violado"
        },
        {
          subject: "Recebi meu produto divergente",
          subjectCoopera: "Entrega de produto divergente"
        },
        {
          subject: "Status da entrega",
          subjectCoopera: "Status de Entrega"
        }
      ]
    },
    {
      key: "financeiro",
      value: "Financeiro",
      subjects: [
        {
          subject: "Confirmação de dados",
          subjectCoopera: "Confirmação de dados cadastrais"
        },
        {
          subject: "Fui cobrado indevidamente do valor do frete",
          subjectCoopera: "Frete - Cobrança indevida"
        },
        {
          subject: "Meu reembolso está atrasado",
          subjectCoopera: "Ressarcimento atrasado"
        },
        {
          subject: "Não visualizo o Boleto para impressão",
          subjectCoopera: "Boleto não visualizado no site"
        },
        {
          subject: "Pagamento não reconhecido Boleto/Débito",
          subjectCoopera: "Pagamento não reconhecido boleto / debito"
        },
        {
          subject: "Paguei pela embalagem de presente e não recebi",
          subjectCoopera: "Estornar valor da embalagem"
        },
        {
          subject: "Problema na utilização de vales",
          subjectCoopera: "Problemas com vale"
        },
        {
          subject: "Recebi uma cobrança indevida",
          subjectCoopera: "Cobrança indevida"
        },
        {
          subject: "Status do meu pagamento",
          subjectCoopera: "Status Pagamento"
        }
      ]
    },
    {
      key: "lojas-fisicas",
      value: "Lojas físicas",
      subjects: [
        {
          subject: "Lojas físicas"
        }
      ]
    },
    {
      key: "sua-conta",
      value: "Sua conta",
      subjects: [
        {
          subject: "Sua conta"
        }
      ]
    },
    {
      key: "outros",
      value: "Outros",
      subjects: [
        {
          subject: "Outros"
        }
      ]
    },
    {
      key: "produtos",
      value: "Produtos",
      subjects: [
        {
          subject: "Dúvidas sobre produtos",
          subjectCoopera: "Dúvida sobre Produtos"
        }
      ]
    },
    {
      key: "servicos",
      value: "Serviços",
      subjects: [
        {
          subject: "Garantia estendida"
        }
      ]
    },
    {
      key: "trocas-e-devolucoes",
      value: "Trocas e Devoluções",
      subjects: [
        {
          subject: "Comprei errado",
          subjectCoopera: "Comprou produto errado"
        },
        {
          subject: "Defeito",
          subjectCoopera: "Defeito"
        },
        {
          subject: "Desisti da compra",
          subjectCoopera: "Desistencia"
        },
        {
          subject: "Devolvi meu produto e não recebi o reembolso",
          subjectCoopera: "Ressarcimento atrasado"
        },
        {
          subject: "Devolvi meu produto e não recebi outro",
          subjectCoopera: "Atraso na troca"
        },
        {
          subject: "Minha coleta está atrasada",
          subjectCoopera: "Coleta atrasada"
        },
        {
          subject: "Problema com a postagem",
          subjectCoopera: "Problemas com postagem"
        },
        {
          subject: "Status de devolução",
          subjectCoopera: "Status trocas e devoluções"
        },
        {
          subject: "Status da troca",
          subjectCoopera: "Status trocas e devoluções"
        }
      ]
    }
  ]; 
  var emailDialog = j203("#self-help-email"),
      emailForm = emailDialog.find("form[name=form-email]"),
      cancelButton = emailDialog.find("#form-email-cancel"),
      requestTypeSelect = emailDialog.find("select[name=request-type]"),
      orderNumberSelect = emailDialog.find("select[name=order-number]"),
      productsList = emailDialog.find("#products-list"),
      subjectSelect = emailDialog.find("select[name=subject]"),
      commentTextarea = emailDialog.find("textarea[name=user-comment]"),
      firstNameInput = emailDialog.find("input[name=first-name]"),
      lastNameInput = emailDialog.find("input[name=last-name]"),
      emailInput = emailDialog.find("input[name=email]"),
      phoneInput = emailDialog.find("input[name=phone]"),
      emailFilter =
        /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+j203/,
      hasReceivedOrders = false;

  function optionTemplate(value, name) {
    return j203("<option value=\"" + value + "\">" + name + "</option>");
  }

  function bindEvents() {
    emailForm.submit(function(e){
      e.preventDefault();
      submitForm(j203(e.currentTarget));
      return false;
    });

    cancelButton.click(function(e) {
      e.preventDefault();
      closeEmailDialog();
    });

    orderNumberSelect.change(function(e) {
      var orderId = j203(e.currentTarget).val();
      changeOrderNumberSelect(orderId);
    });

    requestTypeSelect.change(changeRequestTypeSelect);

    subjectSelect.change(function() {
      hideErrorMessages(subjectSelect);
    });

    commentTextarea.keyup(function() {
      if (commentTextarea.val().length) {
        hideErrorMessages(commentTextarea);
      }
    });
    firstNameInput.keyup(function() {
      if (firstNameInput.val().length) {
        hideErrorMessages(firstNameInput);
      }
    });
    lastNameInput.keyup(function() {
      if (lastNameInput.val().length) {
        hideErrorMessages(lastNameInput);
      }
    });
    emailInput.keyup(function() {
      if (emailInput.val().length) {
        hideErrorMessages(emailInput);
      }
    });
    phoneInput.keyup(function() {
      if (phoneInput.val().length) {
        hideErrorMessages(phoneInput);
      }
    });

    var phoneMaskOptions = {
      onKeyPress: function(phone, e, currentField, options) {
        j203(currentField).mask(processPhoneMask(phone), options);
      }
    };
    phoneInput
      .mask(processPhoneMask, phoneMaskOptions)
      .on("keyup", function(e) {
        if (e.keyCode === 8) {
          j203(e.currentTarget).mask(processPhoneMask(e.currentTarget.value),
            phoneMaskOptions);
        }
      });
  }

  function processPhoneMask(phone) {
    return phone.replace(/[\(\)\- ]/g, "").length === 11?
      "(00) 00000-0000" : "(00) 0000-00009";
  }

  function openEmailDialog() {
    j203.magnificPopup.open({
      items: {
        src: emailDialog
      },
      type: "inline"
    });
  }

  function closeEmailDialog() {
    j203.magnificPopup.instance.close();
  }

  function buildEmailDialog() {
    renderRequestTypes();
    renderSubjects(null);
  }

  function renderRequestTypes() {
    var requestTypesFragment = j203(document.createDocumentFragment());

    j203.each(RequestTypes, function(index, requestType) {
      var option = optionTemplate(requestType.value, requestType.value);
      option = option.attr("data-key", requestType.key);
      requestTypesFragment.append(option);
    });

    requestTypeSelect.append(requestTypesFragment);
  }

  function changeRequestTypeSelect() {
    hideErrorMessages(requestTypeSelect);

    var requestTypeValue = requestTypeSelect.find("option:selected")
      .attr("data-key");

	  /*
    if (requestTypeValue === "entrega" ||
      requestTypeValue === "financeiro" ||
      requestTypeValue === "produtos" ||
      requestTypeValue === "trocas-e-devolucoes") {

      toggleNotLoggedInUserFields(false);
      wm.utils.checkLogin(prepareLoggedInUserFields);
    }
    else if (requestTypeValue === "lojas-fisicas" ||
      requestTypeValue === "sua-conta" ||
      requestTypeValue === "outros" ||
      requestTypeValue === "servicos") {

      toggleLoggedInUserFields(false);
      if (wm.isLoggedIn() === false) {
        toggleNotLoggedInUserFields(true);
      }
      else {
        toggleNotLoggedInUserFields(false);
      }
	  
    }
    else {
      toggleNotLoggedInUserFields(false);
      toggleLoggedInUserFields(false);
    }*/

    renderSubjects(requestTypeValue);
  }

  function prepareLoggedInUserFields() {
    if (hasReceivedOrders === false) {
      wm.utils.getJson(wm.constants.API_ENDPOINT + "/selfhelp/v1/email",
        function(result) {
        if (result && result.ordersList && result.ordersList.length > 0) {
          hasReceivedOrders = true;

          // Order ids list
          var selectFragment = j203(document.createDocumentFragment());
          selectFragment.append(optionTemplate("", "Selecione"));
          j203.each(result.ordersList, function(index, orderId) {
            selectFragment.append(optionTemplate(orderId, orderId));
          });
          orderNumberSelect.html(selectFragment);

          // Continue rendering
          toggleLoggedInUserFields(true);
        }
      });
    }
    else {
      toggleLoggedInUserFields(true);
    }
  }

  function toggleLoggedInUserFields(showUserFields) {
    var loggedInFields = emailDialog.find("div.logged-in-fields");

    if (showUserFields) {
      loggedInFields.removeClass("hide");
    }
    else {
      loggedInFields.addClass("hide");
    }
  }

  function toggleNotLoggedInUserFields(showUserFields) {
    var notLoggedInFields = emailDialog.find("div.not-logged-in-fields");

    if (showUserFields) {
      notLoggedInFields.removeClass("hide");
    }
    else {
      notLoggedInFields.addClass("hide");
    }
  }

  function changeOrderNumberSelect(orderId) {
    hideErrorMessages(orderNumberSelect);
    displayProducts(orderId);
  }

  function displayProducts(orderId) {
    productsList.html("");

    // Displaying only the product from an order
    if (orderId) {
      wm.utils.get(wm.constants.API_ENDPOINT + "/selfhelp/v1/products/" +
        orderId, function(data) {
        productsList.html(data);

        // Tooltip handler
        var products = productsList.find("span");
        products.hover(productHoverIn, productHoverOut);

        // Select handler
        products.click(toggleProduct);
      });
    }
  }

  function productHoverIn(e) {
    wm.tooltip.open({
      target: e.currentTarget,
      content: j203(e.currentTarget).attr("data-content"),
      className: "top seller"
    });
  }

  function productHoverOut(e){
    wm.tooltip.close({
      target: e.currentTarget,
    });
  }

  function toggleProduct(e) {
    var el = j203(e.currentTarget);

    // Unselect
    if (el.hasClass("active")) {
      unselectProduct(el);
    }
    // Select
    else {
      hideErrorMessages(productsList);
      selectProduct(el);
    }
  }

  function selectProduct(el) {
    var deliveryId = el.attr("data-delivery-id");

    // Select the delivery if
    // no other product from the same delivery is selected
    var otherProductsFromSameDelivery =
      productsList.find("span[data-delivery-id=" + deliveryId + "].active");

    if (otherProductsFromSameDelivery.length === 0) {
      // Disable products from other deliveries
      productsList.find("span:not(span[data-delivery-id=" + deliveryId + "])")
        .addClass("disabled");

      // Render request types
      hideErrorMessages();
    }

    // Select the product
    el.addClass("active");
  }

  function unselectProduct(el) {
    var deliveryId = el.attr("data-delivery-id");

    // Unselect the product
    el.removeClass("active");

    // Unselect the delivery if
    // no other product from the same delivery is selected
    var otherProductsFromSameDelivery =
      productsList.find("span[data-delivery-id=" + deliveryId + "].active");

    if (otherProductsFromSameDelivery.length === 0) {
      productsList.find("span").removeClass("disabled");
    }
  }

  function renderSubjects(requestTypeValue) {
    var subjectsFragment = j203(document.createDocumentFragment());
    subjectsFragment.append(optionTemplate("", "Selecione"));

    var options = getSubjects(requestTypeValue);
    j203.each(options, function(index, item) {
      var option = optionTemplate(item.subject, item.subject);
      if (item.subjectCoopera) {
        option.attr("data-subject-coopera", item.subjectCoopera);
      }
      subjectsFragment.append(option);
    });

    subjectSelect.html(subjectsFragment);
  }

  function getSubjects(requestTypeValue) {
    var subjects = [];

    if (requestTypeValue) {
      var requestType = findWhere(RequestTypes, "key", requestTypeValue);
      subjects = requestType.subjects || [];
    }

    return subjects;
  }

  function submitForm(form) {
    var values = form.serializeArray();

    // Validating
    //translateSkus(values);
    var isValid = validateSubmission(form, values);

    if (isValid) {
      // Preparing data
     // insertMissingData(values);
     // encodeExistingData(values);
      // Submitting data
      postEmail(values);
    }
  }

  function translateSkus(values) {
    var skuIds = j203.map(productsList.find("span.active"), function(el) {
      return j203(el).attr("data-sku-id");
    });
    values.push({
      name: "sku-ids",
      value: skuIds.toString()
    });
  }

  function insertMissingData(values) {
    // Inserting seller-name
    var firstProduct = productsList.find("span.active:first");
    var sellerName = firstProduct.attr("data-seller-name") || "";
    values.push({
      name: "seller-name",
      value: encodeURIComponent(sellerName)
    });

    // Inserting delivery-id
    var deliveryNumber = firstProduct.attr("data-delivery-id") || "";
    values.push({
      name: "delivery-number",
      value: deliveryNumber
    });

    // Inserting subject-coopera
    var subjectCoopera = subjectSelect.find("option:selected")
      .attr("data-subject-coopera") || "";
    values.push({
      name: "subject-coopera",
      value: encodeURIComponent(subjectCoopera)
    });
  }

  function encodeExistingData(values) {
    // Encoding request-type
    var requestType = findWhere(values, "name", "request-type");
    requestType.value = encodeURIComponent(requestType.value);
  
    // Encoding user-comments
    var userComments = findWhere(values, "name", "user-comment");
    userComments.value = encodeURIComponent(userComments.value);

    // Encoding first-name
    var firstName = findWhere(values, "name", "first-name");
    firstName.value = encodeURIComponent(firstName.value);

    // Encoding user-comments 

    // Encoding user-comments
    var email = findWhere(values, "name", "email");
    email.value = encodeURIComponent(email.value);

    // Encoding user-comments
    var phone = findWhere(values, "name", "phone");
    phone.value = encodeURIComponent(phone.value);
  }

  function validateSubmission(form, values) {
    // Step 0: Cleaning previous validation
    hideErrorMessages();

    // Step 1: Request Type
    var requestType = findWhere(values, "name", "request-type");
    if (requestType.value.length === 0) {
      showErrorMessage(form, "select[name=request-type]");
      return false;
    }
 
	// Step 6: First name
      var firstName = findWhere(values, "name", "first-name");
      if (firstName.value.length === 0) {
        showErrorMessage(form, "input[name=first-name]");
        return false;
      } 

      // Step 6: Email
      var email = findWhere(values, "name", "email");
      if (email.value.length === 0) {
        showErrorMessage(form, "input[name=email]");
        return false;
      }/*
      else if (!emailFilter.test(email.value)) {
        showErrorMessage(form, "input[name=email]", "E-mail inválido");
        return false;
      }*/

      // Step 7: Phone
      var phone = findWhere(values, "name", "phone");
      if (phone.value.length === 0) {
        showErrorMessage(form, "input[name=phone]");
        return false;
      }
      else if (phone.value.length < 14) {
        showErrorMessage(form, "input[name=phone]", "Telefone inválido");
        return false;
      }
	    
 
    // Step 5: User comments
    var userComments = findWhere(values, "name", "user-comment");
    if (userComments.value.length === 0) {
      showErrorMessage(form, "textarea[name=user-comment]", null,
        {top: "140px", left: "188px"});
      return false;
    }
  
    return true;
  }

  function showErrorMessage(form, selector, message, style) {
    var element = form.find(selector);
    var parentElement = element.closest(".col-value");
    message = message || "Campo obrigatório";
    style = style || {top: "45px", left: "148px"};

    wm.tooltip.open({
      target: parentElement,
      content: message,
      style: style,
      className: "bottom error"
    });

    element.addClass("error-field");
  }

  function hideErrorMessages(element) {
    if (element) {
      var parentElement = element.closest(".col-value");
      parentElement.find(".wm-tooltip").remove();
      element.removeClass("error-field");
    }
    else {
      emailDialog.find(".error-field").removeClass("error-field");
      emailDialog.find(".wm-tooltip").remove();
    }
  }

  function postEmail(values) {
    if (!values.length) {
      return true;
    } 
    wm.utils.ajax({
      url: URLWEB + "/include/funcoes.php?acao=emailcontato",
      type: "POST",
      contentType: "application/x-www-form-urlencoded; charset=ISO-88591",
      data: values,
      success: function(response) { 
        if (jQuery.trim(response) == "OK") {
          resetEmailDialog();
          wm.modalMessage.show({
            type: "success",
            title: "Atendimento por e-mail"
          });
        }
        else { 
          wm.modalMessage.show({
            type: "error",
            title: "Atendimento por e-mail",
            buttonCallback: openEmailDialog
          }); 
        }
      },
      error: function() {
        wm.modalMessage.show({
          type: "error",
          title: "Atendimento por e-mail",
          buttonCallback: openEmailDialog
        });
      }
    });
  }

  function resetEmailDialog() {
    requestTypeSelect.val("");
    orderNumberSelect.val("");
    displayProducts(null);
    renderSubjects(null);
    commentTextarea.val("");
    firstNameInput.val("");
    lastNameInput.val("");
    emailInput.val("");
    phoneInput.val("");
    toggleLoggedInUserFields(false);
    toggleNotLoggedInUserFields(false);
    hideErrorMessages();
  }

  function findWhere(array, field, value) {
    var result = null;

    var resultList = j203(array).filter(function(){
      return this[field] === value;
    });

    if (resultList.length) {
      result = resultList[0];
    }

    return result;
  }

  return {
    init: function() {
      bindEvents();
      buildEmailDialog();

      //should I auto open selfhelp?
      if (window.location.hash.indexOf("#faleconosco") !== -1) {
        openEmailDialog();
      }
    },

    open: function() {
      openEmailDialog();
    },

    close: function() {
      closeEmailDialog();
    }
  };
})();

wm.selfHelpEmail.init();
/*
  Modal message component.
  @author tgarci4

  Usage:
    // To open:
    wm.modalMessage.open({
      type: "success" || "error",
      title: "Message title", // Optional, default is "Mensagem"
      message: "Message",     // Optional, default is "Ok! Esta ação foi um sucesso ;)" when type = "success"
                              // or "Ops! Esta ação não deu certo :(" when type = "error"
      buttonText: "Button",   // Optional, default is "Voltar para o Shopping" when type = "success"
                              // or "Tentar novamente" when type = "error"
      buttonCallback: fn      // Optional, callback function for the button action.
                              // PS: Button will always close the modal message, regardless this callback.
    });
*/

wm.modalMessage = (function() {
  "use strict";

  var MESSAGE_TYPES = {
      SUCCESS: "success",
      ERROR: "error"
		},
		validMessageTypes = j203.map(MESSAGE_TYPES, function(value) {
      return value;
		}),
		content = j203("#modal-message"),
		title = content.find("strong.title"),
		icon = content.find("span.icon"),
		message = content.find("span.message"),
		button = content.find("input[type=submit]");

	function prepareContent(options) {
		// Title
		options.title = options.title || "Mensagem";
		title.html(options.title);

		// Icon
		var iconClass;
		switch(options.type) {
		case MESSAGE_TYPES.SUCCESS:
			iconClass = "icon-wm-ok";
			options.message = options.message || "Ok! Esta ação foi um sucesso ;)";
			options.buttonText = options.buttonText || "Voltar para o Shopping";
			break;

		case MESSAGE_TYPES.ERROR:
			iconClass = "icon-wm-remove";
			options.message = options.message || "Ops! Esta ação não deu certo :(";
			options.buttonText = options.buttonText || "Tentar novamente";
			break;
		}
		icon.addClass(iconClass);

		// Message
		message.html(options.message);

		// Button text
		button.val(options.buttonText);

		// Button callback
		button.click(function() {
			j203.magnificPopup.instance.close();
      if (options.buttonCallback &&
        typeof options.buttonCallback === "function") {
        options.buttonCallback.apply();
      }
		});

		return content;
	}

	function cleanContent() {
    title.html("");
    icon.removeClass();
    icon.addClass("icon");
    message.html("");
    button.val("");
    button.off("click");
	}

	function displayModal(content) {
		j203.magnificPopup.open({
      items: {
        src: content,
      },
      type: "inline"
    });
	}

	return {
		show: function(options) {
			if (options && options.type && validMessageTypes.indexOf(options.type) !== -1) {
				cleanContent();
				var content = prepareContent(options);
				displayModal(content);
			}
		}
	};
})();
/*
  This is a constructor, you should use it this way:
    var lazy = new wm.utils.lazyLoad();
    lazy.init(elements, callback);

    Everytime an element turns visible the callback will be called with this
    element as argument

    Once a callback with this element is called this element will be removed
    from the list

    Usage example:
    var lazy = new wm.utils.lazyLoad();
    lazy.init(j203("#my-element"), function(element){
      j203(element).show();
    });
*/

wm.utils.lazyLoad = function() {
  "use strict";

  var elements = [],
      callback = function(){};

  function isElementInViewport(elem) {
    var rect = elem.getBoundingClientRect();

    return rect.top >= 0 && rect.left >= 0 && rect.top <= (window.innerHeight ||
        document.documentElement.clientHeight);
  }

  function handler() {
    var newElements = [];
    j203(elements).each(function(i,e)
    {
      if(isElementInViewport(e)){
        callback(e);
      }
      else
      {
        newElements.push(e);
      }

      if(elements.length === 0){
        j203(window).unbind("scroll", handler);
      }
    });
    elements = newElements;
  }

  function bindEvents() {
    j203(window).bind("scroll", handler);
    setTimeout(handler, 100);
    j203(handler);
  }

  return {

    // @param {DOM Element} elem
    // @param {Function} callback
    init: function(els, cal) {
      elements = [];
      j203(els).each(function(i, e){
        elements.push(e);
      });
      callback = cal;
      bindEvents();
    }
  };
};

wm.utils.lazyImages = (function() {
  "use strict";

  var images = [];

  function loadImage(element)
  {
    var image = j203(element);
    image.attr("src", image.data("src"));
    image.removeClass("lazy-image");
    //image.removeClass("loading");
  }

  return {
    init: function() {
      images = j203(".lazy-image");
      var lazy = new wm.utils.lazyLoad();
      lazy.init(images, loadImage);
    }
  };
})();

wm.utils.lazyImages.init();

// Validate Google organic search

wm.utils.checkOrganicSearch = (function() {
  "use strict";

  var referrer = document.referrer,
    location = document.location.search + document.location.hash;

  function validate() {
    if (referrer.indexOf("google.com") !== -1 && location.indexOf("utm_source") === -1) {
      j203.ajax({
        type: "POST",
        url: "/Client/BuscaOrganica"
      });
    }
  }

  return {
    init: function() {
      validate();
    }
  };
})();
wm.utils.checkOrganicSearch.init();
/*

  wm.utils.cookies.setItem(name, value[, end[, path[, domain[, secure]]]])
  wm.utils.cookies.getItem(name)
  wm.utils.cookies.removeItem(name[, path], domain)
  wm.utils.cookies.hasItem(name)
  wm.utils.cookies.keys()

*/


wm.utils.cookies = (function() {
  "use strict";

  function getItem(sKey) {
    return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\j203&") + "\\s*\\=\\s*([^;]*).*j203)|^.*j203"), "j2031")) || null;
  }

  function setItem(sKey, sValue, vEnd, sPath, sDomain, bSecure) {
    if (!sKey || /^(?:expires|max\-age|path|domain|secure)j203/i.test(sKey)) {
      return false;
    }

    var sExpires = "";

    if (vEnd) {
      switch (vEnd.constructor) {
      case Number:
        sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
        break;
      case String:
        sExpires = "; expires=" + vEnd;
        break;
      case Date:
        sExpires = "; expires=" + vEnd.toUTCString();
        break;
      }
    }
    document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
    return true;
  }

  function removeItem(sKey, sPath, sDomain) {
    if (!sKey || !hasItem(sKey)) { return false; }
    document.cookie = encodeURIComponent(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + ( sDomain ? "; domain=" + sDomain : "") + ( sPath ? "; path=" + sPath : "");
    return true;
  }

  function hasItem(sKey) {
    return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\j203&") + "\\s*\\=")).test(document.cookie);
  }

  function keys() {
    var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|j203)|^\s*|\s*(?:\=[^;]*)?(?:\1|j203)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
    for (var nIdx = 0; nIdx < aKeys.length; nIdx++) { aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]); }
    return aKeys;
  }

  function get(cookieName) {
    var cookieStart, cookieEnd;
    if (document.cookie.length > 0) {
      cookieStart = document.cookie.indexOf(cookieName + "=");
      if (cookieStart !== -1) {
        cookieStart = cookieStart + cookieName.length + 1;
        cookieEnd = document.cookie.indexOf(";", cookieStart);
        if (cookieEnd === -1) {
          cookieEnd = document.cookie.length;
        }
        return window.unescape(document.cookie.substring(cookieStart, cookieEnd));
      }
    }
    return "";
  }


  return {
    getItem : getItem,
    setItem : setItem,
    removeItem : removeItem,
    hasItem : hasItem,
    keys : keys,
    get: get
  };
})();
/*
* EASYDROPDOWN - A Drop-down Builder for Styleable Inputs and Menus
* Version: 2.1.4
* License: Creative Commons Attribution 3.0 Unported - CC BY 3.0
* http://creativecommons.org/licenses/by/3.0/
* This software may be used freely on commercial and non-commercial projects with attribution to the author/copyright holder.
* Author: Patrick Kunka
* Copyright 2013 Patrick Kunka, All Rights Reserved
*/


(function(j203){

	function EasyDropDown(){
		this.isField = true,
		this.down = false,
		this.inFocus = false,
		this.disabled = false,
		this.cutOff = false,
		this.hasLabel = false,
		this.keyboardMode = false,
		this.nativeTouch = true,
		this.wrapperClass = 'dropdown',
		this.onChange = null;
	};

	EasyDropDown.prototype = {
		constructor: EasyDropDown,
		instances: {},
		init: function(domNode, settings){
			var	self = this;

			j203.extend(self, settings);
			self.j203select = j203(domNode);
			self.id = domNode.id;
			self.options = [];
			self.j203options = self.j203select.find('option');
			self.isTouch = 'ontouchend' in document;
			self.j203select.removeClass(self.wrapperClass+' dropdown');
			if(self.j203select.is(':disabled')){
				self.disabled = true;
			};
			if(self.j203options.length){
				self.j203options.each(function(i){
					var j203option = j203(this);
					if(j203option.is(':selected')){
						self.selected = {
							index: i,
							title: j203option.text()
						}
						self.focusIndex = i;
					};
					if(j203option.hasClass('label') && i == 0){
						self.hasLabel = true;
						self.label = j203option.text();
						j203option.attr('value','');
					} else {
						self.options.push({
							domNode: j203option[0],
							title: j203option.text(),
							value: j203option.val(),
							selected: j203option.is(':selected')
						});
					};
				});
				if(!self.selected){
					self.selected = {
						index: 0,
						title: self.j203options.eq(0).text()
					}
					self.focusIndex = 0;
				};
				self.render();
			};
		},

		render: function(){
			var	self = this,
				touchClass = self.isTouch && self.nativeTouch ? ' touch' : '',
				disabledClass = self.disabled ? ' disabled' : '';

			self.j203container = self.j203select.wrap('<div class="initial '+self.wrapperClass+touchClass+disabledClass+'"><span class="old"/></div>').parent().parent();
			self.j203active = j203('<span class="selected">'+self.selected.title+'</span>').appendTo(self.j203container);
			self.j203carat = j203('<span class="carat"/>').appendTo(self.j203container);
			self.j203scrollWrapper = j203('<div><ul/></div>').appendTo(self.j203container);
			self.j203dropDown = self.j203scrollWrapper.find('ul');
			self.j203form = self.j203container.closest('form');
			j203.each(self.options, function(){
				var	option = this,
					active = option.selected ? ' class="active"':'';
				self.j203dropDown.append('<li'+active+'>'+option.title+'</li>');
			});
			self.j203items = self.j203dropDown.find('li');

			if(self.cutOff && self.j203items.length > self.cutOff)self.j203container.addClass('scrollable');

			self.getMaxHeight();

			if(self.isTouch && self.nativeTouch){
				self.bindTouchHandlers();
			} else {
				self.bindHandlers();
			};
		},

		getMaxHeight: function(){
			var self = this;

			self.maxHeight = 0;

			for(i = 0; i < self.j203items.length; i++){
				var j203item = self.j203items.eq(i);
				self.maxHeight += j203item.outerHeight();
				if(self.cutOff == i+1){
					break;
				};
			};
		},

		bindTouchHandlers: function(){
			var	self = this;
			self.j203container.on('click.easyDropDown',function(){
				self.j203select.focus();
			});
			self.j203select.on({
				change: function(){
					var	j203selected = j203(this).find('option:selected'),
						title = j203selected.text(),
						value = j203selected.val();

					self.j203active.text(title);
					if(typeof self.onChange === 'function'){
						self.onChange.call(self.j203select[0],{
							title: title,
							value: value
						});
					};
				},
				focus: function(){
					self.j203container.addClass('focus');
				},
				blur: function(){
					self.j203container.removeClass('focus');
				}
			});
		},

		bindHandlers: function(){
			var	self = this;
			self.query = '';
			self.j203container.on({
				'click.easyDropDown': function(){
					if(!self.down && !self.disabled){
						self.open();
					} else {
						self.close();
					};
				},
				'mousemove.easyDropDown': function(){
					if(self.keyboardMode){
						self.keyboardMode = false;
					};
				}
			});

			j203('body').on('click.easyDropDown.'+self.id,function(e){
				var j203target = j203(e.target),
					classNames = self.wrapperClass.split(' ').join('.');

				if(!j203target.closest('.'+classNames).length && self.down){
					self.close();
				};
			});

			self.j203items.on({
				'click.easyDropDown': function(){
					var index = j203(this).index();
					self.select(index);
					self.j203select.focus();
				},
				'mouseover.easyDropDown': function(){
					if(!self.keyboardMode){
						var j203t = j203(this);
						j203t.addClass('focus').siblings().removeClass('focus');
						self.focusIndex = j203t.index();
					};
				},
				'mouseout.easyDropDown': function(){
					if(!self.keyboardMode){
						j203(this).removeClass('focus');
					};
				}
			});

			self.j203select.on({
				'focus.easyDropDown': function(){
					self.j203container.addClass('focus');
					self.inFocus = true;
				},
				'blur.easyDropDown': function(){
					self.j203container.removeClass('focus');
					self.inFocus = false;
				},
				'keydown.easyDropDown': function(e){
					if(self.inFocus){
						self.keyboardMode = true;
						var key = e.keyCode;

						if(key == 38 || key == 40 || key == 32){
							e.preventDefault();
							if(key == 38){
								self.focusIndex--
								self.focusIndex = self.focusIndex < 0 ? self.j203items.length - 1 : self.focusIndex;
							} else if(key == 40){
								self.focusIndex++
								self.focusIndex = self.focusIndex > self.j203items.length - 1 ? 0 : self.focusIndex;
							};
							if(!self.down){
								self.open();
							};
							self.j203items.removeClass('focus').eq(self.focusIndex).addClass('focus');
							if(self.cutOff){
								self.scrollToView();
							};
							self.query = '';
						};
						if(self.down){
							if(key == 9 || key == 27){
								self.close();
							} else if(key == 13){
								e.preventDefault();
								self.select(self.focusIndex);
								self.close();
								return false;
							} else if(key == 8){
								e.preventDefault();
								self.query = self.query.slice(0,-1);
								self.search();
								clearTimeout(self.resetQuery);
								return false;
							} else if(key != 38 && key != 40){
								var letter = String.fromCharCode(key);
								self.query += letter;
								self.search();
								clearTimeout(self.resetQuery);
							};
						};
					};
				},
				'keyup.easyDropDown': function(){
					self.resetQuery = setTimeout(function(){
						self.query = '';
					},1200);
				}
			});

			self.j203dropDown.on('scroll.easyDropDown',function(e){
				if(self.j203dropDown[0].scrollTop >= self.j203dropDown[0].scrollHeight - self.maxHeight){
					self.j203container.addClass('bottom');
				} else {
					self.j203container.removeClass('bottom');
				};
			});

			if(self.j203form.length){
				self.j203form.on('reset.easyDropDown', function(){
					var active = self.hasLabel ? self.label : self.options[0].title;
					self.j203active.text(active);
				});
			};
		},

		unbindHandlers: function(){
			var self = this;

			self.j203container
				.add(self.j203select)
				.add(self.j203items)
				.add(self.j203form)
				.add(self.j203dropDown)
				.off('.easyDropDown');
			j203('body').off('.'+self.id);
		},

		open: function(){
			var self = this,
				scrollTop = window.scrollY || document.documentElement.scrollTop,
				scrollLeft = window.scrollX || document.documentElement.scrollLeft,
				scrollOffset = self.notInViewport(scrollTop);

			self.closeAll();
			self.getMaxHeight();
			self.j203select.focus();
			window.scrollTo(scrollLeft, scrollTop+scrollOffset);
			self.j203container.addClass('open');
			self.j203scrollWrapper.css('height',self.maxHeight+'px');
			self.down = true;
		},

		close: function(){
			var self = this;
			self.j203container.removeClass('open');
			self.j203scrollWrapper.css('height','0px');
			self.focusIndex = self.selected.index;
			self.query = '';
			self.down = false;
		},

		closeAll: function(){
			var self = this,
				instances = Object.getPrototypeOf(self).instances;
			for(var key in instances){
				var instance = instances[key];
				instance.close();
			};
		},

		select: function(index){
			var self = this;

			if(typeof index === 'string'){
				index = self.j203select.find('option[value='+index+']').index() - 1;
			};

			var	option = self.options[index],
				selectIndex = self.hasLabel ? index + 1 : index;
			self.j203items.removeClass('active').eq(index).addClass('active');
			self.j203active.text(option.title);
			self.j203select
				.find('option')
				.removeAttr('selected')
				.eq(selectIndex)
				.prop('selected',true)
				.parent()
				.trigger('change');

			self.selected = {
				index: index,
				title: option.title
			};
			self.focusIndex = i;
			if(typeof self.onChange === 'function'){
				self.onChange.call(self.j203select[0],{
					title: option.title,
					value: option.value
				});
			};
			if(self.j203container.has(".initial")) {
				self.j203container.removeClass("initial");
			}
		},

		search: function(){
			var self = this,
				lock = function(i){
					self.focusIndex = i;
					self.j203items.removeClass('focus').eq(self.focusIndex).addClass('focus');
					self.scrollToView();
				},
				getTitle = function(i){
					return self.options[i].title.toUpperCase();
				};

			for(i = 0; i < self.options.length; i++){
				var title = getTitle(i);
				if(title.indexOf(self.query) == 0){
					lock(i);
					return;
				};
			};

			for(i = 0; i < self.options.length; i++){
				var title = getTitle(i);
				if(title.indexOf(self.query) > -1){
					lock(i);
					break;
				};
			};
		},

		scrollToView: function(){
			var self = this;
			if(self.focusIndex >= self.cutOff){
				var j203focusItem = self.j203items.eq(self.focusIndex),
					scroll = (j203focusItem.outerHeight() * (self.focusIndex + 1)) - self.maxHeight;

				self.j203dropDown.scrollTop(scroll);
			};
		},

		notInViewport: function(scrollTop){
			var self = this,
				range = {
					min: scrollTop,
					max: scrollTop + (window.innerHeight || document.documentElement.clientHeight)
				},
				menuBottom = self.j203dropDown.offset().top + self.maxHeight;

			if(menuBottom >= range.min && menuBottom <= range.max){
				return 0;
			} else {
				return (menuBottom - range.max) + 5;
			};
		},

		destroy: function(){
			var self = this;
			self.unbindHandlers();
			//self.j203select.unwrap().siblings().remove();
			self.j203select.unwrap();
			delete Object.getPrototypeOf(self).instances[self.j203select[0].id];
		},

		disable: function(){
			var self = this;
			self.disabled = true;
			self.j203container.addClass('disabled');
			self.j203select.attr('disabled',true);
			if(!self.down)self.close();
		},

		enable: function(){
			var self = this;
			self.disabled = false;
			self.j203container.removeClass('disabled');
			self.j203select.attr('disabled',false);
		}
	};

	var instantiate = function(domNode, settings){
			domNode.id = !domNode.id ? 'EasyDropDown'+rand() : domNode.id;
			var instance = new EasyDropDown();
			if(!instance.instances[domNode.id]){
				instance.instances[domNode.id] = instance;
				instance.init(domNode, settings);
			};
		},
		rand = function(){
			return ('00000'+(Math.random()*16777216<<0).toString(16)).substr(-6).toUpperCase();
		};

	j203.fn.easyDropDown = function(){
		var args = arguments,
			dataReturn = [],
			eachReturn;

		eachReturn = this.each(function(){
			if(args && typeof args[0] === 'string'){
				var data = EasyDropDown.prototype.instances[this.id][args[0]](args[1], args[2]);
				if(data)dataReturn.push(data);
			} else {
				instantiate(this, args[0]);
			};
		});

		if(dataReturn.length){
			return dataReturn.length > 1 ? dataReturn : dataReturn[0];
		} else {
			return eachReturn;
		};
	};

	j203(function(){
		if(typeof Object.getPrototypeOf !== 'function'){
			if(typeof 'test'.__proto__ === 'object'){
				Object.getPrototypeOf = function(object){
					return object.__proto__;
				};
			} else {
				Object.getPrototypeOf = function(object){
					return object.constructor.prototype;
				};
			};
		};

		j203('select.dropdown').each(function(){
			var json = j203(this).attr('data-settings');
				settings = json ? j203.parseJSON(json) : {};
			instantiate(this, settings);
		});
	});
})(jQuery);
// Get utms cookies

wm.utils.getUTMCookie = (function() {
  "use strict";

  function getUTMCookie() {
    var utms = location.host.indexOf("qa") >= 0 ?
      wm.utils.cookies.get("IPS-QA -NOVAPLAT") :
      wm.utils.cookies.get("IPS-WalMartSite"),
        data = {};
    if(utms) {
      utms = utms.replace("Parceiro","utm_source")
        .replace("Campanha", "utm_campaign")
        .replace("Midia","utm_medium").split("&");
      for(var i =0; i < utms.length; i++) {
        data[utms[i].substring(0,utms[i].indexOf("="))] = utms[i]
          .substring(utms[i].indexOf("="), utms[i].length).replace("=","");
      }
    }
    return data;
  }

  return getUTMCookie;
})();