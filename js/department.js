wm.utils.detectIframeEmbedding = function() {
  "use strict";

  if (window.top !== window.self) {
    window.top.location = window.self.location;
  }
};

wm.utils.detectIframeEmbedding();

/*
 *	jQuery OwlCarousel v1.27
 *
 *	Copyright (c) 2013 Bartosz Wojciechowski
 *	http://www.owlgraphic.com/owlcarousel/
 *
 *	Licensed under MIT
 *
 */

if ( typeof Object.create !== "function" ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}
(function( j203, window, document, undefined ) {

	var Carousel = {
		init :function(options, el){
			var base = this;
			base.options = j203.extend({}, j203.fn.owlCarousel.options, options);
			base.userOptions = options;
			var elem = el;
			var j203elem = j203(el);
			base.j203elem = j203elem;
			base.loadContent();
		},

		loadContent : function(){
			var base = this;

			if (typeof base.options.beforeInit === "function") {
				base.options.beforeInit.apply(this,[base.j203elem]);
			}

			if (typeof base.options.jsonPath === "string") {
				var url = base.options.jsonPath;

				function getData(data) {
					if (typeof base.options.jsonSuccess === "function") {
						base.options.jsonSuccess.apply(this,[data]);
					} else {
						var content = "";
						for(var i in data["owl"]){
							content += data["owl"][i]["item"];
						}
						base.j203elem.html(content);
					}
					base.logIn();
				}
				j203.getJSON(url,getData);
			} else {
				base.logIn();
			}
		},

		logIn : function(action){
			var base = this;

			base.j203elem.css({opacity: 0});
			base.orignalItems = base.options.items;
			base.checkBrowser();
			base.wrapperWidth = 0;
			base.checkVisible;
			base.setVars();
		},

		setVars : function(){
			var base = this;
			if(base.j203elem.children().length === 0){return false}
			base.baseClass();
			base.eventTypes();
			base.j203userItems = base.j203elem.children(":not('script, style')");
			base.itemsAmount = base.j203userItems.length;
			base.wrapItems();
			base.j203owlItems = base.j203elem.find(".owl-item");
			base.j203owlWrapper = base.j203elem.find(".owl-wrapper");
			base.playDirection = "next";
			base.prevItem = 0;//base.options.startPosition;
			base.currentItem = 0; //Starting Position
			base.customEvents();
			base.onStartup();
		},

		onStartup : function(){
			var base = this;
			base.updateItems();
			base.calculateAll();
			base.buildControls();
			base.updateControls();
			base.response();
			base.moveEvents();
			base.stopOnHover();
			base.owlStatus();

			if(base.options.transitionStyle !== false){
				base.transitionTypes(base.options.transitionStyle);
			}
			if(base.options.autoPlay === true){
				base.options.autoPlay = 5000;
			}
			base.play();

			base.j203elem.find(".owl-wrapper").css("display","block")

			if(!base.j203elem.is(":visible")){
				base.watchVisibility();
			} else {
				base.j203elem.css("opacity",1);
			}
			base.onstartup = false;
			base.eachMoveUpdate();
			if (typeof base.options.afterInit === "function") {
				base.options.afterInit.apply(this,[base.j203elem]);
			}
		},

		eachMoveUpdate : function(){
			var base = this;

			if(base.options.lazyLoad === true){
				base.lazyLoad();
			}
			if(base.options.autoHeight === true){
				base.autoHeight();
			}
			if(base.options.addClassActive === true){
				base.addClassActive();
			}
			if (typeof base.options.afterAction === "function") {
				base.options.afterAction.apply(this,[base.j203elem]);
			}
		},

		updateVars : function(){
			var base = this;
			if(typeof base.options.beforeUpdate === "function") {
				base.options.beforeUpdate.apply(this,[base.j203elem]);
			}
			base.watchVisibility();
			base.updateItems();
			base.calculateAll();
			base.updatePosition();
			base.updateControls();
			base.eachMoveUpdate();
			if(typeof base.options.afterUpdate === "function") {
				base.options.afterUpdate.apply(this,[base.j203elem]);
			}
		},

		reload : function(elements){
			var base = this;
			setTimeout(function(){
				base.updateVars();
			},0)
		},

		watchVisibility : function(){
			var base = this;

			if(base.j203elem.is(":visible") === false){
				base.j203elem.css({opacity: 0});
				clearInterval(base.autoPlayInterval);
				clearInterval(base.checkVisible);
			} else {
				return false;
			}
			base.checkVisible = setInterval(function(){
				if (base.j203elem.is(":visible")) {
					base.reload();
					base.j203elem.animate({opacity: 1},200);
					clearInterval(base.checkVisible);
				}
			}, 500);
		},

		wrapItems : function(){
			var base = this;
			base.j203userItems.wrapAll("<div class=\"owl-wrapper\">").wrap("<div class=\"owl-item\"></div>");
			base.j203elem.find(".owl-wrapper").wrap("<div class=\"owl-wrapper-outer\">");
			base.wrapperOuter = base.j203elem.find(".owl-wrapper-outer");
			base.j203elem.css("display","block");
		},

		baseClass : function(){
			var base = this;
			var hasBaseClass = base.j203elem.hasClass(base.options.baseClass);
			var hasThemeClass = base.j203elem.hasClass(base.options.theme);
			base.j203elem.data("owl-originalStyles", base.j203elem.attr("style"))
					  .data("owl-originalClasses", base.j203elem.attr("class"));

			if(!hasBaseClass){
				base.j203elem.addClass(base.options.baseClass);
			}

			if(!hasThemeClass){
				base.j203elem.addClass(base.options.theme);
			}
		},

		updateItems : function(){
			var base = this;

			if(base.options.responsive === false){
				return false;
			}
			if(base.options.singleItem === true){
				base.options.items = base.orignalItems = 1;
				base.options.itemsDesktop = false;
				base.options.itemsDesktopSmall = false;
				base.options.itemsTablet = false;
				base.options.itemsTabletSmall = false;
				base.options.itemsMobile = false;
				return false;
			}

			var width = j203(base.options.responsiveBaseWidth).width();

			if(width > (base.options.itemsDesktop[0] || base.orignalItems) ){
				 base.options.items = base.orignalItems
			}

			if(width <= base.options.itemsDesktop[0] && base.options.itemsDesktop !== false){
				base.options.items = base.options.itemsDesktop[1];
			}

			if(width <= base.options.itemsDesktopSmall[0] && base.options.itemsDesktopSmall !== false){
				base.options.items = base.options.itemsDesktopSmall[1];
			}

			if(width <= base.options.itemsTablet[0]  && base.options.itemsTablet !== false){
				base.options.items = base.options.itemsTablet[1];
			}

			if(width <= base.options.itemsTabletSmall[0]  && base.options.itemsTabletSmall !== false){
				base.options.items = base.options.itemsTabletSmall[1];
			}

			if(width <= base.options.itemsMobile[0] && base.options.itemsMobile !== false){
				base.options.items = base.options.itemsMobile[1];
			}

			//if number of items is less than declared
			if(base.options.items > base.itemsAmount){
				base.options.items = base.itemsAmount;
			}
		},

		response : function(){
			var base = this,
				smallDelay;
			if(base.options.responsive !== true){
				return false
			}
			var lastWindowWidth = j203(window).width();

			base.resizer = function(){
				if(j203(window).width() !== lastWindowWidth){
					if(base.options.autoPlay !== false){
						clearInterval(base.autoPlayInterval);
					}
					clearTimeout(smallDelay);
					smallDelay = setTimeout(function(){
						lastWindowWidth = j203(window).width();
						base.updateVars();
					},base.options.responsiveRefreshRate);
				}
			}
			j203(window).resize(base.resizer)
		},

		updatePosition : function(){
			var base = this;

			if(base.browser.support3d === true){
				if(base.positionsInArray[base.currentItem] > base.maximumPixels){
					base.transition3d(base.positionsInArray[base.currentItem]);
				} else {
					base.transition3d(0);
					base.currentItem = 0;
				}
			} else{
				if(base.positionsInArray[base.currentItem] > base.maximumPixels){
					base.css2slide(base.positionsInArray[base.currentItem]);
				} else {
					base.css2slide(0);
					base.currentItem = 0;
				}
			}
			if(base.options.autoPlay !== false){
				base.checkAp();
			}
		},

		appendItemsSizes : function(){
			var base = this;

			var roundPages = 0;
			var lastItem = base.itemsAmount - base.options.items;

			base.j203owlItems.each(function(index){
				var j203this = j203(this);
				j203this
					.css({"width": base.itemWidth})
					.data("owl-item",Number(index));

				if(index % base.options.items === 0 || index === lastItem){
					if(!(index > lastItem)){
						roundPages +=1;
					}
				}
				j203this.data("owl-roundPages",roundPages)
			});
		},

		appendWrapperSizes : function(){
			var base = this;
			var width = 0;

			var width = base.j203owlItems.length * base.itemWidth;

			base.j203owlWrapper.css({
				"width": width*2,
				"left": 0
			});
			base.appendItemsSizes();
		},

		calculateAll : function(){
			var base = this;
			base.calculateWidth();
			base.appendWrapperSizes();
			base.loops();
			base.max();
		},

		calculateWidth : function(){
			var base = this;
			base.itemWidth = Math.round(base.j203elem.width()/base.options.items)
		},

		max : function(){
			var base = this;
			base.maximumItem = base.itemsAmount - base.options.items;
			var maximum = (base.itemsAmount * base.itemWidth) - base.options.items * base.itemWidth;
				maximum = maximum * -1
			base.maximumPixels = maximum;
			return maximum;
		},

		min : function(){
			return 0;
		},

		loops : function(){
			var base = this;

			base.positionsInArray = [0];
			var elWidth = 0;

			for(var i = 0; i<base.itemsAmount; i++){
				elWidth += base.itemWidth;
				base.positionsInArray.push(-elWidth)
			}
		},

		buildControls : function(){
			var base = this;
			if(base.options.navigation === true || base.options.pagination === true){
				base.owlControls = j203("<div class=\"owl-controls\"/>").toggleClass("clickable", !base.browser.isTouch).appendTo(base.j203elem);
			}
			if(base.options.pagination === true){
				base.buildPagination();
			}
			if(base.options.navigation === true){
				base.buildButtons();
			}
		},

		buildButtons : function(){
			var base = this;
			var buttonsWrapper = j203("<div class=\"owl-buttons\"/>")
			base.owlControls.append(buttonsWrapper);

			base.buttonPrev = j203("<div/>",{
				"class" : "owl-prev",
				"html" : base.options.navigationText[0] || ""
				});

			base.buttonNext = j203("<div/>",{
				"class" : "owl-next",
				"html" : base.options.navigationText[1] || ""
				});

			buttonsWrapper
			.append(base.buttonPrev)
			.append(base.buttonNext);

			buttonsWrapper.on("touchend.owlControls mouseup.owlControls", "div[class^=\"owl\"]", function(event){
				event.preventDefault();
				if(j203(this).hasClass("owl-next")){
					base.next();
				} else{
					base.prev();
				}
			})
		},

		buildPagination : function(){
			var base = this;

			base.paginationWrapper = j203("<div class=\"owl-pagination\"/>");
			base.owlControls.append(base.paginationWrapper);

			base.paginationWrapper.on("touchend.owlControls mouseup.owlControls", ".owl-page", function(event){
				event.preventDefault();
				if(Number(j203(this).data("owl-page")) !== base.currentItem){
					base.goTo( Number(j203(this).data("owl-page")), true);
				}
			});
		},

		updatePagination : function(){
			var base = this;
			if(base.options.pagination === false){
				return false;
			}

			base.paginationWrapper.html("");

			var counter = 0;
			var lastPage = base.itemsAmount - base.itemsAmount % base.options.items;

			for(var i = 0; i<base.itemsAmount; i++){
				if(i % base.options.items === 0){
					counter +=1;
					if(lastPage === i){
						var lastItem = base.itemsAmount - base.options.items;
					}
					var paginationButton = j203("<div/>",{
						"class" : "owl-page"
						});
					var paginationButtonInner = j203("<span></span>",{
						"text": base.options.paginationNumbers === true ? counter : "",
						"class": base.options.paginationNumbers === true ? "owl-numbers" : ""
					});
					paginationButton.append(paginationButtonInner);

					paginationButton.data("owl-page",lastPage === i ? lastItem : i);
					paginationButton.data("owl-roundPages",counter);

					base.paginationWrapper.append(paginationButton);
				}
			}
			base.checkPagination();
		},
		checkPagination : function(){
			var base = this;
			if(base.options.pagination === false){
				return false;
			}
			base.paginationWrapper.find(".owl-page").each(function(i,v){
				if(j203(this).data("owl-roundPages") === j203(base.j203owlItems[base.currentItem]).data("owl-roundPages") ){
					base.paginationWrapper
						.find(".owl-page")
						.removeClass("active");
					j203(this).addClass("active");
				}
			});
		},

		checkNavigation : function(){
			var base = this;

			if(base.options.navigation === false){
				return false;
			}
			if(base.options.rewindNav === false){
				if(base.currentItem === 0 && base.maximumItem === 0){
					base.buttonPrev.addClass("disabled");
					base.buttonNext.addClass("disabled");
				} else if(base.currentItem === 0 && base.maximumItem !== 0){
					base.buttonPrev.addClass("disabled");
					base.buttonNext.removeClass("disabled");
				} else if (base.currentItem === base.maximumItem){
					base.buttonPrev.removeClass("disabled");
					base.buttonNext.addClass("disabled");
				} else if(base.currentItem !== 0 && base.currentItem !== base.maximumItem){
					base.buttonPrev.removeClass("disabled");
					base.buttonNext.removeClass("disabled");
				}
			}
		},

		updateControls : function(){
			var base = this;
			base.updatePagination();
			base.checkNavigation();
			if(base.owlControls){
				if(base.options.items === base.itemsAmount){
					base.owlControls.hide();
				} else {
					base.owlControls.show();
				}
			}
		},

		destroyControls : function(){
			var base = this;
			if(base.owlControls){
				base.owlControls.remove();
			}
		},

		next : function(speed){
			var base = this;

			if(base.isTransition){
				return false;
			}

			base.storePrevItem = base.currentItem;

			base.currentItem += base.options.scrollPerPage === true ? base.options.items : 1;
			if(base.currentItem > base.maximumItem + (base.options.scrollPerPage == true ? (base.options.items - 1) : 0)){
				if(base.options.rewindNav === true){
					base.currentItem = 0;
					speed = "rewind";
				} else {
					base.currentItem = base.maximumItem;
					return false;
				}
			}
			base.goTo(base.currentItem,speed);
		},

		prev : function(speed){
			var base = this;

			if(base.isTransition){
				return false;
			}

			base.storePrevItem = base.currentItem;

			if(base.options.scrollPerPage === true && base.currentItem > 0 && base.currentItem < base.options.items){
				base.currentItem = 0
			} else {
				base.currentItem -= base.options.scrollPerPage === true ? base.options.items : 1;
			}
			if(base.currentItem < 0){
				if(base.options.rewindNav === true){
					base.currentItem = base.maximumItem;
					speed = "rewind"
				} else {
					base.currentItem =0;
					return false;
				}
			}
			base.goTo(base.currentItem,speed);
		},

		goTo : function(position,speed,drag){
			var base = this;

			if(base.isTransition){
				return false;
			}
			base.getPrevItem();
			if(typeof base.options.beforeMove === "function") {
				base.options.beforeMove.apply(this,[base.j203elem]);
			}
			if(position >= base.maximumItem){
				position = base.maximumItem;
			}
			else if( position <= 0 ){
				position = 0;
			}

			base.currentItem = base.owl.currentItem = position;
			if( base.options.transitionStyle !== false && drag !== "drag" && base.options.items === 1 && base.browser.support3d === true){
				base.swapSpeed(0)
				if(base.browser.support3d === true){
					base.transition3d(base.positionsInArray[position]);
				} else {
					base.css2slide(base.positionsInArray[position],1);
				}
				base.singleItemTransition();
				base.afterGo();
				return false;
			}
			var goToPixel = base.positionsInArray[position];

			if(base.browser.support3d === true){
				base.isCss3Finish = false;

				if(speed === true){
					base.swapSpeed("paginationSpeed");
					setTimeout(function() {
						base.isCss3Finish = true;
					}, base.options.paginationSpeed);

				} else if(speed === "rewind" ){
					base.swapSpeed(base.options.rewindSpeed);
					setTimeout(function() {
						base.isCss3Finish = true;
					}, base.options.rewindSpeed);

				} else {
					base.swapSpeed("slideSpeed");
					setTimeout(function() {
						base.isCss3Finish = true;
					}, base.options.slideSpeed);
				}
				base.transition3d(goToPixel);
			} else {
				if(speed === true){
					base.css2slide(goToPixel, base.options.paginationSpeed);
				} else if(speed === "rewind" ){
					base.css2slide(goToPixel, base.options.rewindSpeed);
				} else {
					base.css2slide(goToPixel, base.options.slideSpeed);
				}
			}
			base.afterGo();
		},

		getPrevItem : function(){
			var base = this;
			base.prevItem = base.owl.prevItem = base.storePrevItem === undefined ? base.currentItem : base.storePrevItem;
			base.storePrevItem = undefined;
		},

		jumpTo : function(position){
			var base = this;
			base.getPrevItem();
			if(typeof base.options.beforeMove === "function") {
				base.options.beforeMove.apply(this,[base.j203elem]);
			}
			if(position >= base.maximumItem || position === -1){
				position = base.maximumItem;
			}
			else if( position <= 0 ){
				position = 0;
			}
			base.swapSpeed(0)
			if(base.browser.support3d === true){
				base.transition3d(base.positionsInArray[position]);
			} else {
				base.css2slide(base.positionsInArray[position],1);
			}
			base.currentItem = base.owl.currentItem = position;
			base.afterGo();
		},

		afterGo : function(){
			var base = this;
			base.checkPagination();
			base.checkNavigation();
			base.eachMoveUpdate();

			if(typeof base.options.afterMove === "function") {
				base.options.afterMove.apply(this,[base.j203elem]);
			}
			if(base.options.autoPlay !== false){
				base.checkAp();
			}
		},

		stop : function(){
			var base = this;
			base.apStatus = "stop";
			clearInterval(base.autoPlayInterval);
		},

		checkAp : function(){
			var base = this;
			if(base.apStatus !== "stop"){
				base.play();
			}
		},

		play : function(){
			var base = this;
			base.apStatus = "play";
			if(base.options.autoPlay === false){
				return false;
			}
			clearInterval(base.autoPlayInterval);
			base.autoPlayInterval = setInterval(function(){
				base.next(true);
			},base.options.autoPlay);
		},

		swapSpeed : function(action){
			var base = this;
			if(action === "slideSpeed"){
				base.j203owlWrapper.css(base.addCssSpeed(base.options.slideSpeed));
			} else if(action === "paginationSpeed" ){
				base.j203owlWrapper.css(base.addCssSpeed(base.options.paginationSpeed));
			} else if(typeof action !== "string"){
				base.j203owlWrapper.css(base.addCssSpeed(action));
			}
		},

		addCssSpeed : function(speed){
			var base = this;
			return {
				"-webkit-transition": "all "+ speed +"ms ease",
				"-moz-transition": "all "+ speed +"ms ease",
				"-o-transition": "all "+ speed +"ms ease",
				"transition": "all "+ speed +"ms ease"
			};
		},

		removeTransition : function(){
			return {
				"-webkit-transition": "",
				"-moz-transition": "",
				"-o-transition": "",
				"transition": ""
			};
		},

		doTranslate : function(pixels){
			return {
				"-webkit-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"-moz-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"-o-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"-ms-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"transform": "translate3d("+pixels+"px, 0px,0px)"
			};
		},

		transition3d : function(value){
			var base = this;
			base.j203owlWrapper.css(base.doTranslate(value));
		},

		css2move : function(value){
			var base = this;
			base.j203owlWrapper.css({"left" : value})
		},

		css2slide : function(value,speed){
			var base = this;

			base.isCssFinish = false;
			base.j203owlWrapper.stop(true,true).animate({
				"left" : value
			}, {
				duration : speed || base.options.slideSpeed ,
				complete : function(){
					base.isCssFinish = true;
				}
			});
		},

		checkBrowser : function(){
			var base = this;

			//Check 3d support
			var	translate3D = "translate3d(0px, 0px, 0px)",
				tempElem = document.createElement("div");

			tempElem.style.cssText= "  -moz-transform:"    + translate3D +
								  "; -ms-transform:"     + translate3D +
								  "; -o-transform:"      + translate3D +
								  "; -webkit-transform:" + translate3D +
								  "; transform:"         + translate3D;
			var	regex = /translate3d\(0px, 0px, 0px\)/g,
				asSupport = tempElem.style.cssText.match(regex),
				support3d = (asSupport !== null && asSupport.length === 1);

			var isTouch = "ontouchstart" in window || navigator.msMaxTouchPoints;

			base.browser = {
				"support3d" : support3d,
				"isTouch" : isTouch
			}
		},

		moveEvents : function(){
			var base = this;
			if(base.options.mouseDrag !== false || base.options.touchDrag !== false){
				base.gestures();
				base.disabledEvents();
			}
		},

		eventTypes : function(){
			var base = this;
			var types = ["s","e","x"];

			base.ev_types = {};

			if(base.options.mouseDrag === true && base.options.touchDrag === true){
				types = [
					"touchstart.owl mousedown.owl",
					"touchmove.owl mousemove.owl",
					"touchend.owl touchcancel.owl mouseup.owl"
				];
			} else if(base.options.mouseDrag === false && base.options.touchDrag === true){
				types = [
					"touchstart.owl",
					"touchmove.owl",
					"touchend.owl touchcancel.owl"
				];
			} else if(base.options.mouseDrag === true && base.options.touchDrag === false){
				types = [
					"mousedown.owl",
					"mousemove.owl",
					"mouseup.owl"
				];
			}

			base.ev_types["start"] = types[0];
			base.ev_types["move"] = types[1];
			base.ev_types["end"] = types[2];
		},

		disabledEvents :  function(){
			var base = this;
			base.j203elem.on("dragstart.owl", function(event) { event.preventDefault();});
			base.j203elem.on("mousedown.disableTextSelect", function(e) {
				return j203(e.target).is('input, textarea, select, option');
			});
		},

		gestures : function(){
			var base = this;

			var locals = {
				offsetX : 0,
				offsetY : 0,
				baseElWidth : 0,
				relativePos : 0,
				position: null,
				minSwipe : null,
				maxSwipe: null,
				sliding : null,
				dargging: null,
				targetElement : null
			}

			base.isCssFinish = true;

			function getTouches(event){
				if(event.touches){
					return {
						x : event.touches[0].pageX,
						y : event.touches[0].pageY
					}
				} else {
					if(event.pageX !== undefined){
						return {
							x : event.pageX,
							y : event.pageY
						}
					} else {
						return {
							x : event.clientX,
							y : event.clientY
						}
					}
				}
			}

			function swapEvents(type){
				if(type === "on"){
					j203(document).on(base.ev_types["move"], dragMove);
					j203(document).on(base.ev_types["end"], dragEnd);
				} else if(type === "off"){
					j203(document).off(base.ev_types["move"]);
					j203(document).off(base.ev_types["end"]);
				}
			}

			function dragStart(event) {
				var event = event.originalEvent || event || window.event;

				if(base.isCssFinish === false && !base.options.dragBeforeAnimFinish ){
					return false;
				}
				if(base.isCss3Finish === false && !base.options.dragBeforeAnimFinish ){
					return false;
				}

				if(base.options.autoPlay !== false){
					clearInterval(base.autoPlayInterval);
				}

				if(base.browser.isTouch !== true && !base.j203owlWrapper.hasClass("grabbing")){
					base.j203owlWrapper.addClass("grabbing")
				}

				base.newPosX = 0;
				base.newRelativeX = 0;

				j203(this).css(base.removeTransition());

				var position = j203(this).position();
				locals.relativePos = position.left;

				locals.offsetX = getTouches(event).x - position.left;
				locals.offsetY = getTouches(event).y - position.top;

				swapEvents("on");

				locals.sliding = false;
				locals.targetElement = event.target || event.srcElement;
			}

			function dragMove(event){
				var event = event.originalEvent || event || window.event;

				base.newPosX = getTouches(event).x- locals.offsetX;
				base.newPosY = getTouches(event).y - locals.offsetY;
				base.newRelativeX = base.newPosX - locals.relativePos;

				if (typeof base.options.startDragging === "function" && locals.dragging !== true && base.newRelativeX !== 0) {
					locals.dragging = true;
					base.options.startDragging.apply(this);
				}

				if(base.newRelativeX > 8 || base.newRelativeX < -8 && base.browser.isTouch === true){
					event.preventDefault ? event.preventDefault() : event.returnValue = false;
					locals.sliding = true;
				}

				if((base.newPosY > 10 || base.newPosY < -10) && locals.sliding === false){
					j203(document).off("touchmove.owl");
				}

				var minSwipe = function(){
					return  base.newRelativeX / 5;
				}
				var maxSwipe = function(){
					return  base.maximumPixels + base.newRelativeX / 5;
				}

				base.newPosX = Math.max(Math.min( base.newPosX, minSwipe() ), maxSwipe() );
				if(base.browser.support3d === true){
					base.transition3d(base.newPosX);
				} else {
					base.css2move(base.newPosX);
				}
			}

			function dragEnd(event){
				var event = event.originalEvent || event || window.event;
				event.target = event.target || event.srcElement;

				locals.dragging = false;

				if(base.browser.isTouch !== true){
					base.j203owlWrapper.removeClass("grabbing");
				}

				if(base.newRelativeX !== 0){
					var newPosition = base.getNewPosition();
					base.goTo(newPosition,false,"drag");
					if(locals.targetElement === event.target && base.browser.isTouch !== true){
						j203(event.target).on("click.disable", function(ev){
							ev.stopImmediatePropagation();
							ev.stopPropagation();
							ev.preventDefault();
							j203(event.target).off("click.disable");
						});
						var handlers = j203._data(event.target, "events")["click"];
						var owlStopEvent = handlers.pop();
						handlers.splice(0, 0, owlStopEvent);
					}
				}
				swapEvents("off");
			}
			base.j203elem.on(base.ev_types["start"], ".owl-wrapper", dragStart);
		},

		getNewPosition : function(){
			var base = this,
				newPosition;

			var newPosition = base.improveClosest();
			if(newPosition>base.maximumItem){
				base.currentItem = base.maximumItem;
				newPosition  = base.maximumItem;
			} else if( base.newPosX >=0 ){
				newPosition = 0;
				base.currentItem = 0;
			}
			return newPosition;
		},

		improveClosest : function(){
			var base = this;
			var array = base.positionsInArray;
			var goal = base.newPosX;
			var closest = null;
			j203.each(array, function(i,v){
				if( goal - (base.itemWidth/20) > array[i+1] && goal - (base.itemWidth/20)< v && base.moveDirection() === "left") {
					closest = v;
					base.currentItem = i;
				}
				else if (goal + (base.itemWidth/20) < v && goal + (base.itemWidth/20) > array[i+1] && base.moveDirection() === "right"){
					closest = array[i+1];
					base.currentItem = i+1;
				}
			});
			return base.currentItem;
		},

		moveDirection : function(){
			var base = this,
				direction;
			if(base.newRelativeX < 0 ){
				direction = "right"
				base.playDirection = "next"
			} else {
				direction = "left"
				base.playDirection = "prev"
			}
			return direction
		},

		customEvents : function(){
			var base = this;
			base.j203elem.on("owl.next",function(){
				base.next();
			});
			base.j203elem.on("owl.prev",function(){
				base.prev();
			});
			base.j203elem.on("owl.play",function(event,speed){
				base.options.autoPlay = speed;
				base.play();
				base.hoverStatus = "play";
			});
			base.j203elem.on("owl.stop",function(){
				base.stop();
				base.hoverStatus = "stop";
			});
			base.j203elem.on("owl.goTo",function(event,item){
				base.goTo(item)
			});
			base.j203elem.on("owl.jumpTo",function(event,item){
				base.jumpTo(item)
			});
		},

		stopOnHover : function(){
			var base = this;
			if(base.options.stopOnHover === true && base.browser.isTouch !== true && base.options.autoPlay !== false){
				base.j203elem.on("mouseover", function(){
					base.stop();
				});
				base.j203elem.on("mouseout", function(){
					if(base.hoverStatus !== "stop"){
						base.play();
					}
				});
			}
		},

		lazyLoad : function(){
			var base = this;

			if(base.options.lazyLoad === false){
				return false;
			}
			for(var i=0; i<base.itemsAmount; i++){
				var j203item = j203(base.j203owlItems[i]);

				if(j203item.data("owl-loaded") === "loaded"){
					continue;
				}

				var	itemNumber = j203item.data("owl-item"),
					j203lazyImg = j203item.find(".lazyOwl"),
					follow;

				if( typeof j203lazyImg.data("src") !== "string"){
					j203item.data("owl-loaded","loaded");
					continue;
				}
				if(j203item.data("owl-loaded") === undefined){
					j203lazyImg.hide();
					j203item.addClass("loading").data("owl-loaded","checked");
				}
				if(base.options.lazyFollow === true){
					follow = itemNumber >= base.currentItem;
				} else {
					follow = true;
				}
				if(follow && itemNumber < base.currentItem + base.options.items && j203lazyImg.length){
					base.lazyPreload(j203item,j203lazyImg);
				}
			}
		},

		lazyPreload : function(j203item,j203lazyImg){
			var base = this,
				iterations = 0;
				j203lazyImg[0].src = j203lazyImg.data("src");
				checkLazyImage();

			function checkLazyImage(){
				iterations += 1;
				if (base.completeImg( j203lazyImg.get(0) )) {
					showImage();
				} else if(iterations <= 100){//if image loads in less than 10 seconds
					setTimeout(checkLazyImage,100);
				} else {
					showImage();
				}
			}
			function showImage(){
				j203item.data("owl-loaded", "loaded").removeClass("loading");
				j203lazyImg.removeAttr("data-src");
				base.options.lazyEffect === "fade" ? j203lazyImg.fadeIn(400) : j203lazyImg.show();
			}
		},

		autoHeight : function(){
			var base = this;
			var j203currentimg = j203(base.j203owlItems[base.currentItem]).find("img");

			if(j203currentimg.get(0) !== undefined ){
				var iterations = 0;
				checkImage();
			} else {
				addHeight();
			}
			function checkImage(){
				iterations += 1;
				if ( base.completeImg(j203currentimg.get(0)) ) {
					addHeight();
				} else if(iterations <= 100){ //if image loads in less than 10 seconds
					setTimeout(checkImage,100);
				} else {
					base.wrapperOuter.css("height", ""); //Else remove height attribute
				}
			}

			function addHeight(){
				var j203currentItem = j203(base.j203owlItems[base.currentItem]).height();
				base.wrapperOuter.css("height",j203currentItem+"px");
				if(!base.wrapperOuter.hasClass("autoHeight")){
					setTimeout(function(){
						base.wrapperOuter.addClass("autoHeight");
					},0);
				}
			}
		},

		completeImg : function(img) {
		    if (!img.complete) {
		        return false;
		    }
		    if (typeof img.naturalWidth !== "undefined" && img.naturalWidth == 0) {
		        return false;
		    }
		    return true;
		},

		addClassActive : function(){
			var base = this;
			base.j203owlItems.removeClass("active");
			for(var i=base.currentItem; i<base.currentItem + base.options.items; i++){
				j203(base.j203owlItems[i]).addClass("active");
			}
		},

		transitionTypes : function(className){
			var base = this;
			//Currently available: "fade","backSlide","goDown","fadeUp"
			base.outClass = "owl-"+className+"-out";
			base.inClass = "owl-"+className+"-in";
		},

		singleItemTransition : function(){
			var base = this;
			base.isTransition = true;

			var outClass = base.outClass,
				inClass = base.inClass,
				j203currentItem = base.j203owlItems.eq(base.currentItem),
				j203prevItem = base.j203owlItems.eq(base.prevItem),
				prevPos = Math.abs(base.positionsInArray[base.currentItem]) + base.positionsInArray[base.prevItem],
				origin = Math.abs(base.positionsInArray[base.currentItem])+base.itemWidth/2;

            base.j203owlWrapper
	            .addClass('owl-origin')
	            .css({
	            	"-webkit-transform-origin" : origin+"px",
	            	"-moz-perspective-origin" : origin+"px",
	            	"perspective-origin" : origin+"px"
	            });
	        function transStyles(prevPos,zindex){
				return {
					"position" : "relative",
					"left" : prevPos+"px"
				};
			}

	        var animEnd = 'webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend';

			j203prevItem
			.css(transStyles(prevPos,10))
			.addClass(outClass)
			.on(animEnd, function() {
				base.endPrev = true;
				j203prevItem.off(animEnd);
		    	base.clearTransStyle(j203prevItem,outClass);
			});

			j203currentItem
			.addClass(inClass)
			.on(animEnd, function() {
				base.endCurrent = true;
				j203currentItem.off(animEnd);
		    	base.clearTransStyle(j203currentItem,inClass);
		    });
		},

		clearTransStyle : function(item,classToRemove){
			var base = this;
			item.css({
					"position" : "",
					"left" : ""
				})
				.removeClass(classToRemove);
			if(base.endPrev && base.endCurrent){
				base.j203owlWrapper.removeClass('owl-origin');
				base.endPrev = false;
				base.endCurrent = false;
				base.isTransition = false;
			}
		},

		owlStatus : function(){
			var base = this;
			base.owl = {
				"userOptions"	: base.userOptions,
				"baseElement" 	: base.j203elem,
				"userItems"		: base.j203userItems,
				"owlItems"		: base.j203owlItems,
				"currentItem"	: base.currentItem,
				"prevItem"		: base.prevItem,
				"isTouch" 		: base.browser.isTouch,
				"browser"		: base.browser
			}
		},

		clearEvents : function(){
			var base = this;
			base.j203elem.off(".owl owl mousedown.disableTextSelect");
			j203(document).off(".owl owl");
			j203(window).off("resize", base.resizer);
		},

		unWrap : function(){
			var base = this;
			if(base.j203elem.children().length !== 0){
				base.j203owlWrapper.unwrap();
				base.j203userItems.unwrap().unwrap();
				if(base.owlControls){
					base.owlControls.remove();
				}
			}
			base.clearEvents();
			base.j203elem
				.attr("style", base.j203elem.data("owl-originalStyles") || "")
				.attr("class", base.j203elem.data("owl-originalClasses"));
		},

		destroy : function(){
			var base = this;
			base.stop();
			clearInterval(base.checkVisible);
			base.unWrap();
			base.j203elem.removeData();
		},

		reinit : function(newOptions){
			var base = this;
			var options = j203.extend({}, base.userOptions, newOptions);
		 	base.unWrap();
		 	base.init(options,base.j203elem);
		},

		addItem : function(htmlString,targetPosition){
			var base = this,
				position;

			if(!htmlString){return false}

			if(base.j203elem.children().length === 0){
				base.j203elem.append(htmlString);
				base.setVars();
				return false;
			}
			base.unWrap();
			if(targetPosition === undefined || targetPosition === -1){
				position = -1;
			} else {
				position = targetPosition;
			}
			if(position >= base.j203userItems.length || position === -1){
				base.j203userItems.eq(-1).after(htmlString)
			} else {
				base.j203userItems.eq(position).before(htmlString)
			}

			base.setVars();
		},

		removeItem : function(targetPosition){
			var base = this,
				position;

			if(base.j203elem.children().length === 0){return false}

			if(targetPosition === undefined || targetPosition === -1){
				position = -1;
			} else {
				position = targetPosition;
			}

			base.unWrap();
			base.j203userItems.eq(position).remove();
			base.setVars();
		}

	};

	j203.fn.owlCarousel = function( options ){
		return this.each(function() {
			if(j203(this).data("owl-init") === true){
				return false;
			}
			j203(this).data("owl-init", true);
			var carousel = Object.create( Carousel );
			carousel.init( options, this );
			j203.data( this, "owlCarousel", carousel );
		});
	};

	j203.fn.owlCarousel.options = {

		items : 5,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [979,3],
		itemsTablet: [768,2],
		itemsTabletSmall: false,
		itemsMobile : [479,1],
		singleItem:false,

		slideSpeed : 200,
		paginationSpeed : 800,
		rewindSpeed : 1000,

		autoPlay : false,
		stopOnHover : false,

		navigation : false,
		navigationText : ["prev","next"],
		rewindNav : true,
		scrollPerPage : false,

		pagination : true,
		paginationNumbers: false,

		responsive: true,
		responsiveRefreshRate : 200,
		responsiveBaseWidth: window,

		baseClass : "owl-carousel",
		theme : "owl-theme",

		lazyLoad : false,
		lazyFollow : true,
		lazyEffect : "fade",

		autoHeight : false,

		jsonPath : false,
		jsonSuccess : false,

		dragBeforeAnimFinish : true,
		mouseDrag : true,
		touchDrag : true,

		addClassActive : false,
		transitionStyle : false,

		beforeUpdate : false,
		afterUpdate : false,
		beforeInit : false,
		afterInit : false,
		beforeMove: false,
		afterMove: false,
		afterAction : false,
		startDragging : false

	};
})( jQuery, window, document );
wm.menuLeft = (function() {
  "use strict";

  var component = j203(".menu-left"),
    buttonNoAction = j203(".arrow-menu"),
    buttonClass = ".open-sub-menu";

  function toggleMenu(clicked) {
    var menu = "ul." + clicked.data("menu"),
      title = "h4." + clicked.data("menu");
    clicked.toggleClass("closed");
    j203(menu).slideToggle();
    j203(title).toggleClass("no-subcategory");
  }

  function bindEvents() {
    buttonNoAction.click(function(e) {
      e.preventDefault();
    });

    // Toggle menu areas
    component.on("click", buttonClass, function(e) {
      e.preventDefault();
      var clicked = j203(this);
      toggleMenu(clicked);
    });
  }

  return {
    init: function() {
      bindEvents();
    }
  };

})();

wm.menuLeft.init();
wm.carouselTvDepartment = (function(){
  "use strict";

  var carouselElem = j203(".tv-department .owl-carousel");

  function activateCarousel() {
    carouselElem.owlCarousel({
      items: 1,
      autoPlay: true,
      stopOnHover: true,
      responsive: true,
      itemsDesktop: [1334, 1],
      itemsDesktopSmall: [1004, 1],
      itemsTablet: [1004, 1],
      itemsMobile: [1004, 1],
      responsiveRefreshRate: 0
    });
  }

  function fixBannerDuploIE() {
    j203(".tvDestaqueModaDireito, .tvDestaqueModaEsquerdo").each(function(){
      var that = j203(this);
      j203("." + that.attr("data-target")).append(that);
    });
  }

  function bindEvents() {
    if(navigator.userAgent.indexOf("MSIE") > 0) {
      fixBannerDuploIE();
    }
    activateCarousel();
  }

  return {
    init: function() {
      bindEvents();
    }
  };

})();

wm.carouselTvDepartment.init();
wm.carouselBanner = (function() {
  "use strict";

  var carouselElem = j203(".carousel-banners .owl-carousel");

  function activateCarousel() {
    var googleAdxItem = j203(".owl-carousel > ins");

    if(googleAdxItem.size() > 0) {
      googleAdxItem.each(function(i) {
        googleAdxItem.eq(i).appendTo(".adx-item").eq(i);
      });
    }

    carouselElem.owlCarousel({
      items: 1,
      slideSpeed: 700,
      pagination: false,
      navigation: true,
      navigationText : ["",""],
      responsive: true,
      itemsDesktop: [1334, 1],
      itemsDesktopSmall: [1004, 1],
      itemsTablet: [1004, 1],
      itemsMobile: [1004, 1]
    });
  }

  function checkHiddenBanner() {
    var component = j203("#hidden-banner"),
      items = component.find("img[src*='empty.gif']");

    if(items.length === 0) {
      component.show();
    }
  }

  function bindEvents() {
    activateCarousel();

    if(j203("body").hasClass("category")) {
      checkHiddenBanner();
    }
  }

  return {
    init: function() {
      bindEvents();
    }
  };

})();

wm.carouselBanner.init();
wm.carouselBrands = (function() {
  "use strict";

  var carouselElem = j203(".carousel-brands .owl-carousel");

  function activateCarousel() {
    carouselElem.owlCarousel({
      items: 4,
      slideSpeed: 700,
      pagination: false,
      navigation: true,
      navigationText : ["",""],
      responsive: true,
      scrollPerPage: true,
      itemsDesktop: [1334, 4],
      itemsDesktopSmall: [1004, 4],
      itemsTablet: [1004, 4],
      itemsMobile: [1004, 4]
    });
  }

  function bindEvents() {
    activateCarousel();
  }

  return {
    init: function() {
      bindEvents();
    }
  };

})();

wm.carouselBrands.init();
wm.disclaimer = (function() {
  "use strict";

  var el = j203(".wm-lightbox");

  function bindEvents() {
    el.magnificPopup({
      type: "inline",
      // Allow opening popup on middle mouse click. Always set it to
      // true if you don't provide alternative source in href.
      midClick: true
    });
  }

  return {
    init: function() {
      bindEvents();
    }
  };

})();

wm.disclaimer.init();

wm.bannerSlide = (function() {
  "use strict";

  var component = j203(".banner-slide"),
      button = component.find(".see-more-brands"),
      wrapper = component.find(".slide-wrapper"),
      buttonContent = button.find("span");

  function bindEvents() {
    button.click(function(e) {
      e.preventDefault();
      wrapper.toggleClass("big");
      buttonContent.toggleClass("hidden");
    });
  }

  return {
    init: function() {
      bindEvents();
    }
  };
})();

wm.bannerSlide.init();