 
/* noUiSlider 3.2.1 */
(function (j203) {

	j203.fn.noUiSlider = function (options, flag) {

		// test for mouse, pointer or touch
		var EVENT = window.navigator.msPointerEnabled ? 2 : 'ontouchend' in document ? 3 : 1;
		if (window.debug && console) {
			console.log(EVENT);
		}

		// shorthand for test=function, calling
		function call(f, scope, args) {
			if (typeof f === "function") {
				f.call(scope, args);
			}
		}

		// function wrapper for calculating to and from range values
		var percentage = {
			to : function (range, value) {
				value = range[0] < 0 ? value + Math.abs(range[0]) : value - range[0];
				return (value * 100) / this._length(range);
			},
			from : function (range, value) {
				return (value * 100) / this._length(range);
			},
			is : function (range, value) {
				return ((value * this._length(range)) / 100) + range[0];
			},
			_length : function (range) {
				return (range[0] > range[1] ? range[0] - range[1] : range[1] - range[0]);
			}
		}

		// bounce handles of eachother, the edges of the slider
		function correct(proposal, slider, handle) {

			var
			setup = slider.data('setup'),
			handles = setup.handles,
			settings = setup.settings,
			pos = setup.pos;

			proposal = proposal < 0 ? 0 : proposal > 100 ? 100 : proposal;

			if (settings.handles == 2) {
				if (handle.is(':first-child')) {
					var other = parseFloat(handles[1][0].style[pos]) - settings.margin;
					proposal = proposal > other ? other : proposal;
				} else {
					var other = parseFloat(handles[0][0].style[pos]) + settings.margin;
					proposal = proposal < other ? other : proposal;
				}
			}

			if (settings.step) {
				var per = percentage.from(settings.range, settings.step);
				proposal = Math.round(proposal / per) * per;
			}

			return proposal;

		}

		// get standarised clientX and clientY
		function client(f) {
			try {
				return [(f.clientX || f.originalEvent.clientX || f.originalEvent.touches[0].clientX), (f.clientY || f.originalEvent.clientY || f.originalEvent.touches[0].clientY)];
			} catch (e) {
				return ['x', 'y'];
			}
		}

		// get native inline style value in %
		function place(handle, pos) {
			return parseFloat(handle[0].style[pos]);
		}

		// simplified defaults
		var defaults = {
			handles : 2,
			serialization : {
				to : ['', ''],
				resolution : 0.01
			}
		};

		// contains all methods
		methods = {
			create : function () {

				return this.each(function () {

					// set handle to position
					function setHandle(handle, to, slider) {
						handle.css(pos, to + '%').data('input').val(percentage.is(settings.range, to).toFixed(res));
					}

					var
					settings = j203.extend(defaults, options),
					// handles
					handlehtml = '<a><div></div></a>',
					// save this to variable, // allows identification
					slider = j203(this).data('_isnS_', true),
					// array of handles
					handles = [],
					// the way the handles are positioned for this slider, top/left
					pos,
					// for quick orientation testing and array matching
					orientation,
					// append classes
					classes = "",
					// tests numerical
					num = function (e) {
						return !isNaN(parseFloat(e)) && isFinite(e);
					},
					// counts decimals in serialization, sets default
					split = (settings.serialization.resolution = settings.serialization.resolution || 0.01).toString().split('.'),
					res = split[0] == 1 ? 0 : split[1].length;

					settings.start = num(settings.start) ? [settings.start, 0] : settings.start;

					// logs bad input values, if possible
					j203.each(settings, function (a, b) {

						if (num(b)) {
							settings[a] = parseFloat(b);
						} else if (typeof b == "object" && num(b[0])) {
							b[0] = parseFloat(b[0]);
							if (num(b[1])) {
								b[1] = parseFloat(b[1]);
							}
						}

						var e = false;
						b = typeof b == "undefined" ? "x" : b;

						switch (a) {
						case 'range':
						case 'start':
							e = b.length != 2 || !num(b[0]) || !num(b[1]);
							break;
						case 'handles':
							e = (b < 1 || b > 2 || !num(b));
							break;
						case 'connect':
							e = b != "lower" && b != "upper" && typeof b != "boolean";
							break;
						case 'orientation':
							e = (b != "vertical" && b != "horizontal");
							break;
						case 'margin':
						case 'step':
							e = typeof b != "undefined" && !num(b);
							break;
						case 'serialization':
							e = typeof b != "object" || !num(b.resolution) || (typeof b.to == 'object' && b.to.length < settings.handles);
							break;
						case 'slide':
							e = typeof b != "function";
							break;
						}

						if (e && console) {
							console.error('Bad input for ' + a + ' on slider:', slider);
						}

					});

					settings.margin = settings.margin ? percentage.from(settings.range, settings.margin) : 0;

					// tests serialization to be strings or jQuery objects
					if (settings.serialization.to instanceof jQuery || typeof settings.serialization.to == 'string' || settings.serialization.to === false) {
						settings.serialization.to = [settings.serialization.to];
					}

					if (settings.orientation == "vertical") {
						classes += "vertical";
						pos = 'top';
						orientation = 1;
					} else {
						classes += "horizontal";
						pos = 'left';
						orientation = 0;
					}

					classes += settings.connect ? settings.connect == "lower" ? " connect lower" : " connect" : "";

					slider.addClass(classes);

					for (var i = 0; i < settings.handles; i++) {

						handles[i] = slider.append(handlehtml).children(':last');
						var setTo = percentage.to(settings.range, settings.start[i]);
						handles[i].css(pos, setTo + '%');
						if (setTo == 100 && handles[i].is(':first-child')) {
							handles[i].css('z-index', 2);
						}

						var bind = '.noUiSlider',
						onEvent = (EVENT === 1 ? 'mousedown' : EVENT === 2 ? 'MSPointerDown' : 'touchstart') + bind + 'X',
						moveEvent = (EVENT === 1 ? 'mousemove' : EVENT === 2 ? 'MSPointerMove' : 'touchmove') + bind,
						offEvent = (EVENT === 1 ? 'mouseup' : EVENT === 2 ? 'MSPointerUp' : 'touchend') + bind

						handles[i].find('div').on(onEvent, function (e) {

							j203('body').bind('selectstart' + bind, function () {
								return false;
							});

							if (!slider.hasClass('disabled')) {

								j203('body').addClass('TOUCH');

								var handle = j203(this).addClass('active').parent(),
								unbind = handle.add(j203(document)).add('body'),
								originalPosition = parseFloat(handle[0].style[pos]),
								originalClick = client(e),
								previousClick = originalClick,
								previousProposal = false;

								j203(document).on(moveEvent, function (f) {

									f.preventDefault();

									var currentClick = client(f);

									if (currentClick[0] == "x") {
										return;
									}

									currentClick[0] -= originalClick[0];
									currentClick[1] -= originalClick[1];

									var movement = [
										previousClick[0] != currentClick[0], previousClick[1] != currentClick[1]
									],
									proposal = originalPosition + ((currentClick[orientation] * 100) / (orientation ? slider.height() : slider.width()));
									proposal = correct(proposal, slider, handle);

									if (movement[orientation] && proposal != previousProposal) {
										handle.css(pos, proposal + '%').data('input').val(percentage.is(settings.range, proposal).toFixed(res));
										call(settings.slide, slider.data('_n', true));
										previousProposal = proposal;
										handle.css('z-index', handles.length == 2 && proposal == 100 && handle.is(':first-child') ? 2 : 1);
									}

									previousClick = currentClick;

								}).on(offEvent, function () {

									unbind.off(bind);
									j203('body').removeClass('TOUCH');
									if (slider.find('.active').removeClass('active').end().data('_n')) {
										slider.data('_n', false).change();
									}

								});

							}
						}).on('click', function (e) {
							e.stopPropagation();
						});

					}

					if (EVENT == 1) {
						slider.on('click', function (f) {
							if (!slider.hasClass('disabled')) {
								var currentClick = client(f),
								proposal = ((currentClick[orientation] - slider.offset()[pos]) * 100) / (orientation ? slider.height() : slider.width()),
								handle = handles.length > 1 ? (currentClick[orientation] < (handles[0].offset()[pos] + handles[1].offset()[pos]) / 2 ? handles[0] : handles[1]) : handles[0];
								setHandle(handle, correct(proposal, slider, handle), slider);
								call(settings.slide, slider);
								slider.change();
							}
						});
					}

					for (var i = 0; i < handles.length; i++) {
						var val = percentage.is(settings.range, place(handles[i], pos)).toFixed(res);
						
						if (typeof settings.serialization.to[i] == 'string') {
							handles[i].data('input',
								slider.append('<input type="hidden" name="' + settings.serialization.to[i] + '">').find('input:last')
								.val(val)
								.change(function (a) {
									a.stopPropagation();
								}));
						} else if (settings.serialization.to[i] == false) {
							handles[i].data('input', {
								val : function (a) {
									if (typeof a != 'undefined') {
										this.handle.data('noUiVal', a);
									} else {
										return this.handle.data('noUiVal');
									}
								},
								handle : handles[i]
							});
						} else {
							handles[i].data('input', settings.serialization.to[i].data('handleNR', i).val(val).change(function () {
									var arr = [null, null];
									arr[j203(this).data('handleNR')] = j203(this).val();
									slider.val(arr);
								}));
						}
					}

					j203(this).data('setup', {
						settings : settings,
						handles : handles,
						pos : pos,
						res : res
					});

				});
			},
			val : function () {

				if (typeof arguments[0] !== 'undefined') {

					var val = typeof arguments[0] == 'number' ? [arguments[0]] : arguments[0];

					return this.each(function () {

						var setup = j203(this).data('setup');

						for (var i = 0; i < setup.handles.length; i++) {
							if (val[i] != null) {
								var proposal = correct(percentage.to(setup.settings.range, val[i]), j203(this), setup.handles[i]);
								setup.handles[i].css(setup.pos, proposal + '%').data('input').val(percentage.is(setup.settings.range, proposal).toFixed(setup.res));
							}
						}
					});

				} else {

					var handles = j203(this).data('setup').handles,
					re = [];
					for (var i = 0; i < handles.length; i++) {
						re.push(parseFloat(handles[i].data('input').val()));
					}
					return re.length == 1 ? re[0] : re;

				}
			},
			disabled : function () {
				return flag ? j203(this).addClass('disabled') : j203(this).removeClass('disabled');
			}
		}

		// remap the native/current val function to noUiSlider
		var j203_val = jQuery.fn.val;

		jQuery.fn.val = function () {
			return this.data('_isnS_') ? methods.val.apply(this, arguments) : j203_val.apply(this, arguments);
		}

		return options == "disabled" ? methods.disabled.apply(this) : methods.create.apply(this);

	}

})(jQuery);

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
 
 
wm.rating = (function() {
  "use strict";

  var rating = j203(".rating"),
    ratingSku = j203("#rating"),
    range = j203(".slider-range"),
    tooltipRating = j203(".tooltip-rating"),
    mouseDelay = null;

  function initGraphich() {
    j203(function() {
      rating.each(function() {
        var that = j203(this);

        that.removeClass("average").addClass("average-" +
          that.attr("data-rating"));
      });
    });
  }
//var notaavaliacao
  function initSlider() {
    j203(function() {
      range.noUiSlider({
        range: [0, 5],
        start: 0,
        step: 1,
        handles: 1,
        connect: true
      }).change(function(){
        j203(".small-chart .rating").attr("class","rating small")
        .addClass("average-" + j203(this).val() * 10)
        .find(".arc-content-value").html(j203(this).val());
		 
		 j203("#notaavaliacao").val(j203(this).val());

        range.parent().find(".label-item").removeClass("active")
        .eq(j203(this).val()).addClass("active");

        // Sending...
        if (j203(this).parents(".rating-review").length === 0) {
          sendRate(rating.attr("data-productId"), j203(this).val());
        }
      });
    });
  }

  function sendRate (productId, ratingValue) {
    var response = false;

    if(ratingValue > 0){

      wm.utils.post(wm.constants.API_ENDPOINT + "/webstore/v1/rating/" + productId + "/" + ratingValue,
			function (data) {
				response = data === "OK" ? true : false;
			});

/*      j203.post("/produto/review_rating/" + productId + "/?ratingValue=" + value,
        function(data) {
        response = data === "OK" ? true : false;
      });*/
    }
    return response;
  }

  function bindEvents() {
    ratingSku.mouseover(function() {
      mouseDelay = setTimeout(function() {
        tooltipRating.stop(true,true).fadeIn();
      }, 500);
    }).mouseout(function() {
      clearTimeout(mouseDelay);
    });

    tooltipRating.mouseleave(function() {
      tooltipRating.stop(true,true).delay(1000).fadeOut();
    });
  }

  return {
    init: function() {
      bindEvents();
      initGraphich();
      initSlider();
    },
    initGraphich: function() {
      initGraphich();
    },
    send: function(productId, value) {
      sendRate (productId, value);
    }
  };

})();

wm.rating.init();

wm.moreCharacteristics = (function() {
  "use strict";

  var component = j203("#product-characteristics"),
      specification = component.find(".characteristics"),
      items = component.find("tbody tr"),
      moreItems = component.find("tbody .limit"),
      tfoot = component.find("tfoot"),
      moreButton = component.find(".more-characteristics"),
      isOpen = false,
      url = wm.constants.WEBSTORE_ENDPOINT + "/xhr/sku/specification/[[skuId]]";


  function checkTableStyle(hasMoreButton) {
    if(hasMoreButton) {
      var buttonRow = tfoot.find("tr");

      if(isOpen) {
        if(moreItems.last().hasClass("odd")) {
          buttonRow.removeClass("odd");
          specification.css({"border-bottom-width" : "9px"});
        } else {
          buttonRow.addClass("odd");
          specification.css({"border-bottom-width" : "0px"});
        }
      } else {
        buttonRow.addClass("odd");
        specification.css({"border-bottom-width" : "0px"});
      }

    } else {
      if(items.last().hasClass("odd")) {
        specification.css({"border-bottom-width" : "0px"});
      } else {
        specification.css({"border-bottom-width" : "9px"});
      }
    }
  }

  function setSpecificationOpen() {
    moreButton.html("Ocultar características<span class='arrow open'></span>");
    moreItems.fadeIn();
    isOpen = true;
    checkTableStyle(true);
  }

  function setSpecificationClose() {
    setTimeout(function(){
      moreButton.html("Ver todas as características<span class='arrow'></span>");
      moreItems.fadeOut();
      isOpen = false;
      checkTableStyle(true);
    }, 300);
  }

  function checkContent() {
    if(moreItems.length === 0) {
      tfoot.hide();
      checkTableStyle(false);

    } else {
      setSpecificationClose();
      tfoot.show();
      checkTableStyle(true);
    }
  }

  function bindEvents() {
    j203(document).on("skuMatch", update);

    j203("#product-characteristics").on("click", function() {
      if(isOpen) {
        setSpecificationClose();
        wm.productToolbar.navigateTo("#product-characteristics");

      } else {
        setSpecificationOpen();
      }
    });
  }

  function unbindUpdateEvents() {
    j203(document).off("skuMatch");
  }

  function update(event, skuId) {
    var tempUrl = url.replace("[[skuId]]", skuId);
    unbindUpdateEvents();
    j203.ajax({
      url: tempUrl,
      dataType: "html",
      success: updateContent
    });
  }


  function updateContent(data) {
    var content = j203("#product-characteristics-container");
    content.html(data);
    component = j203("#product-characteristics");
    items = component.find("tbody tr");
    moreItems = component.find("tbody .limit");
    tfoot = component.find("tfoot");
    moreButton = component.find(".more-characteristics");
    checkContent();
    bindEvents();
  }

  return {
    init: function() {
      bindEvents();
      checkContent();
    },
    update: update
  };
})();

wm.moreCharacteristics.init();

wm.review = (function() {
  "use strict";

  var component = j203("#product-review"),
  items = component.find(".item-review"),
  buttons = items.find(".btn");
  // idReview = ...

  function toggleButtons(container, clicked) {
    var buttonYes = container.find(".helped-yes"),
    buttonNo = container.find(".helped-no");

    resetButtons(buttonYes, buttonNo);
    clicked.parent().find(".helped-yes").addClass("btn-success on");
    clicked.parent().find(".helped-no").addClass("btn-danger on");
  }

  function resetButtons(btnYes, btnNo) {
    btnYes.attr("class", "btn helped-yes");
    btnNo.attr("class", "btn helped-no");
  }

  function sendRelevance(container, clicked) {

    var id = parseInt(container.data("id"), 10),
    relevant = true;

    if (clicked.hasClass("helped-no")) {
      relevant = false;
    }

    wm.utils.post(
      wm.constants.API_ENDPOINT + "/webstore/v1/relevance/" + id + "/" + relevant,
      function(data) {
        toggleButtons(container, clicked);
        refreshAmount(data, container);
      }
    );
  }

  function refreshAmount(data, container){
    var totalYes = parseInt(data.voteRelevant, 10),
        totalNo = parseInt(data.voteCount, 10) - totalYes;

    container.find(".helped-yes").parent().find(".amount").html(
      "(" + totalYes + ")"
    );

    container.find(".helped-no").parent().find(".amount").html(
      "(" + totalNo + ")"
    );
  }

  function bindEvents() {
    buttons.click(function() {
      var clicked = j203(this),
      container = clicked.parent().parent();

      sendRelevance(container, clicked);
    });
  }

  return {
    init: function() {
      bindEvents();
    }
  };
})();

wm.review.init();
wm.reviewPost = (function() {
  "use strict";

  var component = j203("#review-post-modal"),
    title = component.find(".title-review"),
    comment = component.find(".comment-review"),
    tooltipOptions = {
      target: component,
      class: "bottom",
      style: {
        top: "386px"
      },
      timeToClose: 3000
    },
    //productId = dataLayer && dataLayer[0].product &&
     // dataLayer[0].product[0].productId,
    form = j203("#form-review"),
    range = component.find(".slider-range");

  function closeLightbox() {
    component.find(".mfp-close").click();
  } 
  
  
 
   function customizeSelector() {
    var settingsSelector = {
      cutOff: 10,
      wrapperClass: "wm-select sku-selector-custom"
    };

    if(j203(".sku-selector-custom").size() > 0) {
      j203(".product-sku-selector").find("select").easyDropDown("destroy");
    }
    j203(".product-sku-selector").find("select").easyDropDown(settingsSelector);
    
  }
  customizeSelector() ;

  return {
    init: function() {
      bindEvents();
    }
  };

})();
 