/*
 * jQuery DP Lite Event Calendar
 *
 * Copyright 2014, Diego Pereyra
 *
 * @Web: http://www.wpsleek.com
 * @Email: info@wpsleek.com
 *
 * Depends:
 * jquery.js
 */
  
(function ($) {
	function DPProEventCalendar(element, options) {
		this.calendar = $(element);
		this.eventDates = $('.dp_pec_date', this.calendar);
		
		/* Setting vars*/
		this.settings = $.extend({}, $.fn.dpProEventCalendar.defaults, options); 
		this.no_draggable = false,
		this.hasTouch = false,
		this.downEvent = "mousedown.rs",
		this.moveEvent = "mousemove.rs",
		this.upEvent = "mouseup.rs",
		this.cancelEvent = 'mouseup.rs',
		this.isDragging = false,
		this.successfullyDragged = false,
		this.view = "monthly",
		this.monthlyView = "calendar",
		this.type = 'calendar',
		this.defaultDate = 0,
		this.startTime = 0,
		this.startMouseX = 0,
		this.startMouseY = 0,
		this.currentDragPosition = 0,
		this.lastDragPosition = 0,
		this.accelerationX = 0,
		this.tx = 0;
		
		// Touch support
		if("ontouchstart" in window) {
					
			this.hasTouch = true;
			this.downEvent = "touchstart.rs";
			this.moveEvent = "touchmove.rs";
			this.upEvent = "touchend.rs";
			this.cancelEvent = 'touchcancel.rs';
		} 
		
		this.init();
	}
	
	DPProEventCalendar.prototype = {
		init : function(){
			var instance = this;
			
			instance.view = instance.settings.view;
			instance.defaultDate = instance.settings.defaultDate;
			
			$(instance.calendar).addClass(instance.settings.skin);
			instance._makeResponsive();
						
			$(instance.calendar).on('click', '.prev_month', function(e) { instance._prevMonth(instance); });
			if(instance.settings.dateRangeStart && instance.settings.dateRangeStart.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.prev_month', instance.calendar).hide();
			}
			
			$(instance.calendar).on('click', '.next_month', function(e) { instance._nextMonth(instance); });
			if(instance.settings.dateRangeEnd && instance.settings.dateRangeEnd.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.next_month', instance.calendar).hide();
			}
			
			$('.prev_day', instance.calendar).click(function(e) { instance._prevDay(instance); });
			$('.next_day', instance.calendar).click(function(e) { instance._nextDay(instance); });
						
			if(instance.settings.type == "add-event") {
				$('.dp_pec_new_event_wrapper select').selectric();
				$('.dp_pec_new_event_wrapper input.checkbox').iCheck({
					checkboxClass: 'icheckbox_flat',
					radioClass: 'iradio_flat',
					increaseArea: '20%' // optional
				});
			}
			
			if(instance.settings.type == "grid-upcoming") {
				$(instance.calendar).on('click', '.dp_pec_grid_text_wrap', function() {
					
					location.href = $('.dp_pec_grid_link_image', $(this).closest('.dp_pec_grid_event')).attr('href');
					
				})	
			}
						
			if(!instance.settings.isAdmin) {
				if(!$.proCalendar_isVersion('1.7')) {
					$(instance.calendar).on({
						mouseenter:
						   function()
						   {
							   if(!$('.eventsPreviewDiv').length) {
									$('body').append($('<div />').addClass('eventsPreviewDiv'));
							   }
							  
							   $('.eventsPreviewDiv').removeClass('light dark').addClass(instance.settings.skin);
							   
								$('.eventsPreviewDiv').html($('.eventsPreview', $(this)).html());
								
								if($('.eventsPreviewDiv').html() != "") {
									$('.eventsPreviewDiv').show();
								}
						   },
						mouseleave:
						   function()
						   {
								$('.eventsPreviewDiv').html('').hide();
						   }
					   }, '.dp_pec_date:not(.disabled)'
					).bind('mousemove', function(e){
							
						if($('.eventsPreviewDiv').html() != "") {
							var body_pos = $("body").css('position');
							if(body_pos == "relative") {
								$("body").css('position', 'static');
							}
							$('.eventsPreviewDiv').removeClass('previewRight');
							
							var position = $(e.target).closest('.dp_pec_date').offset();
							var target_height = $(e.target).closest('.dp_pec_date').height();
							if(typeof position != "undefined") {
								$('.eventsPreviewDiv').css({
									left: position.left,
									top: position.top,
									marginTop: (target_height + 12) + "px",
									marginLeft: (position.left + $('.eventsPreviewDiv').outerWidth() >= $( window ).width() ? -($('.eventsPreviewDiv').outerWidth() - 30) + "px" : 0)
								});
							}
							
							if(position && position.left + $('.eventsPreviewDiv').outerWidth() >= $( window ).width()) {
								$('.eventsPreviewDiv').addClass('previewRight');
							}
						}
					});
					
				} else {
					$('.dp_pec_date:not(.disabled)', instance.calendar).live({
						mouseenter:
						   function(e)
						   {
							   if(!$('.eventsPreviewDiv').length) {
									$('body').append($('<div />').addClass('eventsPreviewDiv'));
							   }
							  
							   $('.eventsPreviewDiv').removeClass('light dark').addClass(instance.settings.skin);
							   
								$('.eventsPreviewDiv').html($('.eventsPreview', $(this)).html());
								
								if($('.eventsPreviewDiv').html() != "") {
									$('.eventsPreviewDiv').show();
								}
								
								if($('.eventsPreviewDiv').html() != "") {
									var body_pos = $("body").css('position');
									if(body_pos == "relative") {
										$("body").css('position', 'static');
									}
									$('.eventsPreviewDiv').removeClass('previewRight');
									
									var position = $(e.target).closest('.dp_pec_date').offset();
									var target_height = $(e.target).closest('.dp_pec_date').height();
									if(typeof position != "undefined") {
										$('.eventsPreviewDiv').css({
											left: position.left,
											top: position.top,
											marginTop: (target_height + 12) + "px",
											marginLeft: (position.left + $('.eventsPreviewDiv').outerWidth() >= $( window ).width() ? -($('.eventsPreviewDiv').outerWidth() - 30) + "px" : 0)
										});
									}
									
									if(position.left + $('.eventsPreviewDiv').outerWidth() >= $( window ).width()) {
										$('.eventsPreviewDiv').addClass('previewRight');
									}
								}
						   },
						mouseleave:
						   function()
						   {
								$('.eventsPreviewDiv').html('').hide();
						   }
					   }
					);
				}

				if(!$.proCalendar_isVersion('1.7')) {
					$(instance.calendar).on('mouseup', '.dp_pec_date:not(.disabled)', function(event) {
						if(instance.calendar.hasClass('dp_pec_daily')) { return; }
						
						
						if(!$('.dp_pec_content', instance.calendar).hasClass('isDragging') && (event.which === 1 || event.which === 0)) {
							
							instance._removeElements();
							
							$.post(ProEventCalendarAjax.ajaxurl, { date: $(this).data('dppec-date'), calendar: instance.settings.calendar, category: $('select.pec_categories_list', instance.calendar).val(), event_id: instance.settings.event_id, author: instance.settings.author, action: 'getEvents', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
								function(data) {
	
									$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
									
									instance.eventDates = $('.dp_pec_date', instance.calendar);
									
									$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
								}
							);	
						}
		
					});
					
					$(instance.calendar).on('mouseup', '.dp_daily_event', function(event) {
						if(!$('.dp_pec_content', instance.calendar).hasClass('isDragging') && (event.which === 1 || event.which === 0)) {
							
							instance._removeElements();
							
							$.post(ProEventCalendarAjax.ajaxurl, { event: $(this).data('dppec-event'), calendar: instance.settings.calendar, action: 'getEvent', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
								function(data) {
	
									$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
									
									instance.eventDates = $('.dp_pec_date', instance.calendar);
									
									$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
								}
							);	
						}
					});
					
				} else {
					$('.dp_pec_date:not(.disabled)', instance.calendar).live('mouseup', function(event) {
						
						if(instance.calendar.hasClass('dp_pec_daily')) { return; }
						
						if(!$('.dp_pec_content', instance.calendar).hasClass('isDragging') && (event.which === 1 || event.which === 0)) {
							
							instance._removeElements();
							
							$.post(ProEventCalendarAjax.ajaxurl, { date: $(this).data('dppec-date'), calendar: instance.settings.calendar, category: $('select.pec_categories_list', instance.calendar).val(), event_id: instance.settings.event_id, author: instance.settings.author, action: 'getEvents', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
								function(data) {
	
									$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
									
									instance.eventDates = $('.dp_pec_date', instance.calendar);
									
									$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
								}
							);	
						}
		
					});
					
					$('.dp_daily_event', instance.calendar).live('mouseup', function(event) {
						if(!$('.dp_pec_content', instance.calendar).hasClass('isDragging') && (event.which === 1 || event.which === 0)) {
							
							instance._removeElements();
							
							$.post(ProEventCalendarAjax.ajaxurl, { event: $(this).data('dppec-event'), calendar: instance.settings.calendar, action: 'getEvent', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
								function(data) {
	
									$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
									
									instance.eventDates = $('.dp_pec_date', instance.calendar);
									
									$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
								}
							);	
						}
					});
				}
			}
			
			if(!$.proCalendar_isVersion('1.7')) {
				$(instance.calendar).on('click', '.dp_pec_date_event_back', function(event) {
					event.preventDefault();
					instance._removeElements();
					
					instance._changeLayout();
				});
			} else {
				$('.dp_pec_date_event_back', instance.calendar).live('click', function(event) {
					event.preventDefault();
					instance._removeElements();
					
					instance._changeLayout();
				});
			}
			
			$(instance.calendar).on({
				'mouseenter': function(i) {

					$('.dp_pec_user_rate li a').addClass('is-off');
	
					for(var x = $(this).data('rate-val'); x > 0; x--) {
						$('.dp_pec_user_rate li a[data-rate-val="'+x+'"]', instance.calendar).removeClass('is-off').addClass('is-on');
					}

				},
				'mouseleave': function() {
					$('.dp_pec_user_rate li a', instance.calendar).removeClass('is-on');
					$('.dp_pec_user_rate li a', instance.calendar).removeClass('is-off');
				},
				'click': function() {
					
					$('.dp_pec_user_rate', instance.calendar).replaceWith($('<div>').addClass('dp_pec_loading').attr({ id: 'dp_pec_loading_rating' }));
					
					jQuery.post(ProEventCalendarAjax.ajaxurl, { 
							event_id: $(this).data('event-id'), 
							rate: $(this).data('rate-val'), 
							calendar: instance.settings.calendar,
							action: 'ProEventCalendar_RateEvent', 
							postEventsNonce : ProEventCalendarAjax.postEventsNonce 
						},
						function(data) {
							$('#dp_pec_loading_rating', instance.calendar).replaceWith(data);
						}
					);	
				}
			}, '.dp_pec_user_rate li a');
									
			$('.dp_pec_references', instance.calendar).click(function(e) {
				e.preventDefault();
				if(!$(this).hasClass('active')) {
					$(this).addClass('active');
					$('.dp_pec_references_div', instance.calendar).slideDown('fast');
				} else {
					$(this).removeClass('active');
					$('.dp_pec_references_div', instance.calendar).slideUp('fast');
				}
				
			});
			
			if(instance.monthlyView == "calendar") {
				$('.dp_pec_content', instance.calendar).find("[data-dppec-date='" + instance.settings.defaultDateFormat + "']").css('background-color', instance.settings.current_date_color);
			}
			
			$('.dp_pec_view_all', instance.calendar).click(function(event) {
				event.preventDefault();

				if(!$('.dp_pec_content', instance.calendar).hasClass('isDragging') && (event.which === 1 || event.which === 0)) {
					if(instance.monthlyView == "calendar") {
						$(this).addClass('active');
						instance.monthlyView = "list";
					} else {
						$(this).removeClass('active');
						instance.monthlyView = "calendar";
					}
					
					instance._changeMonth();
					
				}
			});
			
			//if(!instance.settings.isAdmin) {
				$('.dp_pec_layout select, .dp_pec_add_form select, .dp_pec_nav select', instance.calendar).selectric();
			//}
						
			if(instance.view == "monthly-all-events" && instance.settings.type != "accordion" && instance.settings.type != "accordion-upcoming" && instance.settings.type != "add-event" && instance.settings.type != "list-author" && instance.settings.type != "grid" && instance.settings.type != "grid-upcoming" && instance.settings.type != "today-events" && instance.settings.type != "bookings-user" && instance.settings.type != "past") {
				$('.dp_pec_view_all', instance.calendar).addClass('active');
				instance.monthlyView = "list";
				
				instance._changeMonth();
			}

			$('.dp_pec_references_close', instance.calendar).click(function(e) {
				e.preventDefault();
				$('.dp_pec_references', instance.calendar).removeClass('active');
				$('.dp_pec_references_div', instance.calendar).slideUp('fast');
			});
			
			$('.dp_pec_search', instance.calendar).one('click', function(event) {
				$(this).val("");
			});
			
			if($('.dp_pec_accordion_event', instance.calendar).length) {
				$(instance.calendar).on('click', '.dp_pec_accordion_event', function(e) {

					if(!$(this).hasClass('visible')) {
						if(e.target.className != "dp_pec_date_event_close") {
							$('.dp_pec_accordion_event').removeClass('visible');
							$(this).addClass('visible');
						}
					} else {
						//$(this).removeClass('visible');
					}
				});
				
				$(instance.calendar).on('click', '.dp_pec_date_event_close', function(e) {
					
					$('.dp_pec_accordion_event', instance.calendar).removeClass('visible');
				});
			}
			
			if($('.dp_pec_view_action', instance.calendar).length) {
				$('.dp_pec_view_action', instance.calendar).click(function(e) {
					e.preventDefault();
					$('.dp_pec_view_action', instance.calendar).removeClass('active');
					$(this).addClass('active');
					
					if(instance.view != $(this).data('pec-view')) {
						instance.view = $(this).data('pec-view');
						
						instance._changeLayout();
					}
				});
			}
			
			if($('.dp_pec_clear_end_date', instance.calendar).length) {
				$('.dp_pec_clear_end_date', instance.calendar).click(function(e) {
					e.preventDefault();
					$('.dp_pec_end_date_input', instance.calendar).val('');
				});
				
			}
			
			if($('.dp_pec_add_event', instance.calendar).length) {
				$('.dp_pec_add_event', instance.calendar).click(function(e) {
					e.preventDefault();
					$(this).hide();
					$('.dp_pec_cancel_event', instance.calendar).show();
					
					$('.dp_pec_add_form', instance.calendar).slideDown('fast');
					
				});
			}
			
			if($('.dp_pec_cancel_event', instance.calendar).length) {
				$('.dp_pec_cancel_event', instance.calendar).click(function(e) {
					e.preventDefault();
					$(this).hide();
					$('.dp_pec_add_event', instance.calendar).show();
					
					$('.dp_pec_add_form', instance.calendar).slideUp('fast');
					$('.dp_pec_notification_event_succesfull', instance.calendar).hide();
					
				});
			}
			
			if($('.event_image', instance.calendar).length) {

				$(instance.calendar).on('change', '.event_image', function() 
				{
					$('#event_image_lbl', $(this).parent()).val($(this).val().replace(/^.*[\\\/]/, ''));
				});

			}
						
			function pec_createWindowNotification(text) {
				if(!$('.dpProEventCalendar_windowNotification').length) {
					$('body').append(
						$('<div>').addClass('dpProEventCalendar_windowNotification').text(text).show()
					);
				} else {
					$('.dpProEventCalendar_windowNotification').removeClass('fadeOutDown').text(text).show();
				}
				
				setTimeout(function() { $('.dpProEventCalendar_windowNotification').addClass('fadeOutDown'); }, 3000)
			}
			
			$('.dp_pec_search_form', instance.calendar).submit(function() {
				if($(this).find('.dp_pec_search').val() != "" && !$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
					instance._removeElements();
					
					$.post(ProEventCalendarAjax.ajaxurl, { key: $(this).find('.dp_pec_search').val(), calendar: instance.settings.calendar, author: instance.settings.author, action: 'getSearchResults', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
						function(data) {
							
							$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
							
							instance.eventDates = $('.dp_pec_date', instance.calendar);
							
							$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
						}
					);	
				}
				return false;
			});
			
			$('.dp_pec_icon_search', instance.calendar).click(function() {
				if($(this).parent().find('.dp_pec_content_search_input').val() != "" && !$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
					instance._removeElements();
					var results_lang = $(this).data('results_lang');
					$('.events_loading', instance.calendar).show();
					
					$.post(ProEventCalendarAjax.ajaxurl, { key: $(this).parent().find('.dp_pec_content_search_input').val(), type: 'accordion', calendar: instance.settings.calendar, author: instance.settings.author, action: 'getSearchResults', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
						function(data) {
							
							$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).html(data);
							$('.actual_month', instance.calendar).text(results_lang);
							$('.return_layout', instance.calendar).show();
							$('.month_arrows', instance.calendar).hide();
							$('.events_loading', instance.calendar).hide();
							//.empty();
							
						}
					);	
				}
				return false;
			});
			
			$('.return_layout', instance.calendar).click(function() {
				$(this).hide();
				$('.month_arrows', instance.calendar).show();
				$('.dp_pec_content_search_input', instance.calendar).val('');
				
				instance._changeMonth();
			});
			
			$('.dp_pec_content_search_input', instance.calendar).keyup(function (e) {
				if (e.keyCode == 13) {
					// Do something
					$('.dp_pec_icon_search', instance.calendar).trigger('click');
				}
			});
			
			$('.pec_categories_list', instance.calendar).on('change', function() {

					$('.dp_pec_search_form', instance.calendar).find('.dp_pec_search').val('');
					instance._changeMonth();

				return false;
			});
			
			$('.dp_pec_nav select.pec_switch_year', instance.calendar).on('change', function() {
				$('.dp_pec_search_form', instance.calendar).find('.dp_pec_search').val('');
				instance.settings.actualYear = $(this).val();
				instance._changeMonth();
				return false;
			});
			
			$('.dp_pec_nav select.pec_switch_month', instance.calendar).on('change', function() {
				$('.dp_pec_search_form', instance.calendar).find('.dp_pec_search').val('');
				for(i = 0; i < instance.settings.monthNames.length; i++) {
					if(instance.settings.monthNames[i] == $(this).val()) {
						instance.settings.actualMonth = i + 1;
					}
				}
				instance._changeMonth();
				return false;
			});
			
			if(!$.proCalendar_isVersion('1.7')) {
				$(instance.calendar).on('click', '.dp_pec_date_event_map', function(event) {
					event.preventDefault();
					$(this).closest('.dp_pec_date_event').find('.dp_pec_date_event_map_iframe').slideDown('fast');
				});
			} else {
				$('.dp_pec_date_event_map', instance.calendar).live('click', function(event) {
					event.preventDefault();
					$(this).closest('.dp_pec_date_event').find('.dp_pec_date_event_map_iframe').slideDown('fast');
				});
			}
		},
		
		_makeResponsive : function() {
			var instance = this;
			
			if(instance.calendar.width() < 500) {
				$(instance.calendar).addClass('dp_pec_400');

				$('.dp_pec_dayname span', instance.calendar).each(function(i) {
					$(this).html($(this).html().substr(0,3));
				});
				
				$('.prev_month strong', instance.calendar).hide();
				$('.next_month strong', instance.calendar).hide();
				$('.prev_day strong', instance.calendar).hide();
				$('.next_day strong', instance.calendar).hide();
				
			} else {
				$(instance.calendar).removeClass('dp_pec_400');

				$('.prev_month strong', instance.calendar).show();
				$('.next_month strong', instance.calendar).show();
				$('.prev_day strong', instance.calendar).show();
				$('.next_day strong', instance.calendar).show();
				
			}
		},
		_removeElements : function () {
			var instance = this;
			
			$('.dp_pec_date,.dp_pec_dayname,.dp_pec_isotope', instance.calendar).fadeOut(500);
			$('.dp_pec_content', instance.calendar).addClass( 'dp_pec_content_loading' );
			$('.eventsPreviewDiv').html('').hide();
		},
		
		_prevMonth : function (instance) {
			if(!$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
				instance.settings.actualMonth--;
				instance.settings.actualMonth = instance.settings.actualMonth == 0 ? 12 : (instance.settings.actualMonth);
				instance.settings.actualYear = instance.settings.actualMonth == 12 ? instance.settings.actualYear - 1 : instance.settings.actualYear;
				
				instance._changeMonth();
			}
		},
		
		_nextMonth : function (instance) {
			if(!$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
				instance.settings.actualMonth++;
				instance.settings.actualMonth = instance.settings.actualMonth == 13 ? 1 : (instance.settings.actualMonth);
				instance.settings.actualYear = instance.settings.actualMonth == 1 ? instance.settings.actualYear + 1 : instance.settings.actualYear;
	
				instance._changeMonth();
			}
		},
		
		_prevDay : function (instance) {
			if(!$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
				instance.settings.actualDay--;
				//instance.settings.actualDay = instance.settings.actualDay == 0 ? 12 : (instance.settings.actualDay);
				
				instance._changeDay();
			}
		},
		
		_nextDay : function (instance) {
			if(!$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
				instance.settings.actualDay++;
				//instance.settings.actualDay = instance.settings.actualDay == 13 ? 1 : (instance.settings.actualDay);
	
				instance._changeDay();
			}
		},
		
		_changeMonth : function () {
			var instance = this;
			
			//$('.dp_pec_content', instance.calendar).css({'overflow': 'hidden'});
			$('.dp_pec_nav_monthly', instance.calendar).show();
			$('.actual_month', instance.calendar).html( instance.settings.monthNames[(instance.settings.actualMonth - 1)] + ' ' + instance.settings.actualYear );
			$('.dp_pec_nav select.pec_switch_month', instance.calendar).val(instance.settings.monthNames[(instance.settings.actualMonth - 1)]);
			$('.dp_pec_nav select.pec_switch_year', instance.calendar).val(instance.settings.actualYear);
			$('.dp_pec_nav select', instance.calendar).selectric('refresh');
			
			instance._removeElements();
			
			if(instance.settings.dateRangeStart && instance.settings.dateRangeStart.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.prev_month', instance.calendar).hide();
			} else {
				$('.prev_month', instance.calendar).show();
			}

			if(instance.settings.dateRangeEnd && instance.settings.dateRangeEnd.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.next_month', instance.calendar).hide();
			} else {
				$('.next_month', instance.calendar).show();
			}
			
			var date_timestamp = Date.UTC(instance.settings.actualYear, (instance.settings.actualMonth - 1), 15) / 1000;
			
			if(instance.settings.type == "accordion") {
				$('.events_loading', instance.calendar).show();
				$.post(ProEventCalendarAjax.ajaxurl, { month: instance.settings.actualMonth, year: instance.settings.actualYear, calendar: instance.settings.calendar, category: instance.settings.category, event_id: instance.settings.event_id, author: instance.settings.author, action: 'getEventsMonthList', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
					function(data) {
						
						$('.events_loading', instance.calendar).hide();
						$('.dp_pec_content', instance.calendar).html(data);
						
						$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);

					}
				);	
			} else {
				if(instance.monthlyView == "calendar") {
					var start = new Date().getTime(); // note getTime()

					$.post(ProEventCalendarAjax.ajaxurl, { date: date_timestamp, calendar: instance.settings.calendar, category: (instance.settings.category != "" ? instance.settings.category : $('select.pec_categories_list', instance.calendar).val()), is_admin: instance.settings.isAdmin, event_id: instance.settings.event_id, author: instance.settings.author, action: 'getDate', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
						function(data) {
							
							$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
							$('.dp_pec_content', instance.calendar).find("[data-dppec-date='" + instance.settings.defaultDateFormat + "']").css('background-color', instance.settings.current_date_color);

							$(instance.calendar).removeClass('dp_pec_daily');
							$(instance.calendar).addClass('dp_pec_'+instance.view);
		
							instance.eventDates = $('.dp_pec_date', instance.calendar);
							
							
							// Load time debug
					        //console.log( end - start );
							
							$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
							instance._makeResponsive();
						}
					);	
					
				} else {
				
					$.post(ProEventCalendarAjax.ajaxurl, { month: instance.settings.actualMonth, year: instance.settings.actualYear, calendar: instance.settings.calendar, category: (instance.settings.category != "" ? instance.settings.category : $('select.pec_categories_list', instance.calendar).val()), event_id: instance.settings.event_id, author: instance.settings.author, action: 'getEventsMonth', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
						function(data) {
		
							$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
							$(instance.calendar).removeClass('dp_pec_daily');
							$(instance.calendar).addClass('dp_pec_'+instance.view);
							
							instance.eventDates = $('.dp_pec_date', instance.calendar);
							
							$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
							instance._makeResponsive();
						}
					);	
				
				}
			}
			
			
		},
		
		_changeDay : function () {
			var instance = this;
			
			$('.dp_pec_nav_daily', instance.calendar).show();
						
			//$('span.actual_month', instance.calendar).html( instance.settings.monthNames[(instance.settings.actualMonth - 1)] + ' ' + instance.settings.actualYear );

			instance._removeElements();
						
			var date_timestamp = Date.UTC(instance.settings.actualYear, (instance.settings.actualMonth - 1), (instance.settings.actualDay)) / 1000;

			$.post(ProEventCalendarAjax.ajaxurl, { date: date_timestamp, calendar: instance.settings.calendar, category: (instance.settings.category != "" ? instance.settings.category : $('select.pec_categories_list', instance.calendar).val()), is_admin: instance.settings.isAdmin, event_id: instance.settings.event_id, author: instance.settings.author, is_admin: instance.settings.isAdmin, action: 'getDaily', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
				function(data) {
					var newDate = data.substr(0, data.indexOf(">!]-->")).replace("<!--", "");
					$('span.actual_day', instance.calendar).html( newDate );
					
					$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' ).empty().html(data);
					$(instance.calendar).removeClass('dp_pec_monthly');
					$(instance.calendar).addClass('dp_pec_'+instance.view);

					instance.eventDates = $('.dp_pec_date', instance.calendar);
					
					$('.dp_pec_date', instance.calendar).hide().fadeIn(500);
					instance._makeResponsive();
				}
			);
			
			
		},
		
		_changeLayout : function () {
			var instance = this;
			
			instance._removeElements();
			
			$('.dp_pec_nav', instance.calendar).hide();
			
			if(instance.view == "monthly" || instance.view == "monthly-all-events") {
				instance._changeMonth();
			}
			
			if(instance.view == "daily") {
				instance._changeDay();
			}
			
		},
		
		_str_pad: function (input, pad_length, pad_string, pad_type) {
			
			var half = '',
				pad_to_go;
		 
			var str_pad_repeater = function (s, len) {
				var collect = '',
					i;
		 
				while (collect.length < len) {
					collect += s;
				}
				collect = collect.substr(0, len);
		 
				return collect;
			};
		 
			input += '';
			pad_string = pad_string !== undefined ? pad_string : ' ';
		 
			if (pad_type != 'STR_PAD_LEFT' && pad_type != 'STR_PAD_RIGHT' && pad_type != 'STR_PAD_BOTH') {
				pad_type = 'STR_PAD_RIGHT';
			}
			if ((pad_to_go = pad_length - input.length) > 0) {
				if (pad_type == 'STR_PAD_LEFT') {
					input = str_pad_repeater(pad_string, pad_to_go) + input;
				} else if (pad_type == 'STR_PAD_RIGHT') {
					input = input + str_pad_repeater(pad_string, pad_to_go);
				} else if (pad_type == 'STR_PAD_BOTH') {
					half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
					input = half + input + half;
					input = input.substr(0, pad_length);
				}
			}
		 
			return input;
		},
		
		/**
		* Returns a MS time stamp of the current time
		*/
		getTimeStamp : function() {
			var now = new Date();
			return now.getTime();
		}
	}
	
	$.fn.dpProEventCalendar = function(options){  

		var dpProEventCalendar;
		this.each(function(){
			
			dpProEventCalendar = new DPProEventCalendar($(this), options);
			
			$(this).data("dpProEventCalendar", dpProEventCalendar);
			
		});
		
		return this;

	}
	
  	/* Default Parameters and Events */
	$.fn.dpProEventCalendar.defaults = {  
		monthNames : new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
		actualMonth : '',
		actualYear : '',
		actualDay : '',
		defaultDate : '',
		lang_sending: 'Sending...',
		skin : 'light',
		view: 'monthly',
		type: 'calendar',
		lockVertical: true,
		calendar: null,
		dateRangeStart: null,
		dateRangeEnd: null,
		draggable: true,
		isAdmin: false,
		dragOffset: 50,
		allowPageScroll: "vertical",
		fingers: 1
	};  
	
	$.fn.dpProEventCalendar.settings = {}
	
})(jQuery);

/* onShowProCalendar custom event */
 (function($){
  $.fn.extend({ 
    onShowProCalendar: function(callback, unbind){
      return this.each(function(){
        var obj = this;
        var bindopt = (unbind==undefined)?true:unbind; 
        if($.isFunction(callback)){
          if($(this).is(':hidden')){
            var checkVis = function(){
              if($(obj).is(':visible')){
                callback.call();
                if(bindopt){
                  $('body').unbind('click keyup keydown', checkVis);
                }
              }                         
            }
            $('body').bind('click keyup keydown', checkVis);
          }
          else{
            callback.call();
          }
        }
      });
    }
  });
})(jQuery);

(function($) {
/**
 * Used for version test cases.
 *
 * @param {string} left A string containing the version that will become
 *        the left hand operand.
 * @param {string} oper The comparison operator to test against. By
 *        default, the "==" operator will be used.
 * @param {string} right A string containing the version that will
 *        become the right hand operand. By default, the current jQuery
 *        version will be used.
 *
 * @return {boolean} Returns the evaluation of the expression, either
 *         true or false.
 */
	$.proCalendar_isVersion = function(version1, version2){
		if ('undefined' === typeof version1) {
		  throw new Error("$.versioncompare needs at least one parameter.");
		}
		version2 = version2 || $.fn.jquery;
		if (version1 == version2) {
		  return 0;
		}
		var v1 = normalize(version1);
		var v2 = normalize(version2);
		var len = Math.max(v1.length, v2.length);
		for (var i = 0; i < len; i++) {
		  v1[i] = v1[i] || 0;
		  v2[i] = v2[i] || 0;
		  if (v1[i] == v2[i]) {
			continue;
		  }
		  return v1[i] > v2[i] ? 1 : 0;
		}
		return 0;
	};
	function normalize(version){
	return $.map(version.split('.'), function(value){
	  return parseInt(value, 10);
	});

}
})(jQuery);