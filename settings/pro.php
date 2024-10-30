<?php
// This function displays the admin page content
function dpProEventCalendar_pro_page() {
	global $wpdb, $table_prefix, $dpProEventCalendar;

	?>

    <div class="wrap" style="clear:both;" id="dp_options">
    
    <h2></h2>
    <div style="clear:both;"></div>
     <!--end of poststuff --> 
        <div id="dp_ui_content">
            
            <div id="leftSide">
                <a id="dp_logo" href="http://codecanyon.net/item/wordpress-pro-event-calendar/2485867" target="_blank"></a>
                <p>
                    Version: <?php echo DP_LITE_EVENT_CALENDAR_VER?><br />
                </p>
                <ul id="menu" class="nav">
                	<li><a href="admin.php?page=dpProEventCalendar-settings" title=""><span><?php _e('General Settings','dpProEventCalendar'); ?></span></a></li>
                    <li><a href="admin.php?page=dpProEventCalendar-admin" title=""><span><?php _e('Calendars','dpProEventCalendar'); ?></span></a></li>
                    <li><a href="edit.php?post_type=pec-events" title=""><span><?php _e('Events','dpProEventCalendar'); ?></span></a></li>
                    <li><a href="admin.php?page=dpProEventCalendar-special" title=""><span><?php _e('Special Dates','dpProEventCalendar'); ?></span></a></li>
	                <li><a href="admin.php?page=dpProEventCalendar-custom-shortcodes" title=""><span><?php _e('Custom Shortcodes','dpProEventCalendar'); ?></span></a></li>
					<li><a href="javascript:void(0);" title="" class="active"><span><?php _e('Get More Features!','dpProEventCalendar'); ?></span></a></li>
                </ul>
                
                <div class="clear"></div>
            </div>     
            
            <div id="rightSide">
                <div id="menu_general_settings">
                    <div class="titleArea">
                        <div class="wrapper">
                            <div class="pageTitle">
                                <h2><?php _e('Get More Features!','dpProEventCalendar'); ?></h2>
                                <span></span>
                            </div>
                            
                            <div class="clear"></div>
                        </div>
                    </div>
                    
                    <div class="wrapper">
                    	
                        <p><?php _e('Get the <a href="http://codecanyon.net/item/wordpress-pro-event-calendar/2485867?ref=DPereyra" target="_blank">Pro version</a> of this plugin to get free support and the extended features including:','dpProEventCalendar'); ?></p>
                        
                        <h2><?php _e('Bookings','dpProEventCalendar'); ?></h2>
                        
                        <p><?php _e('Allow logged in and non-logged in users to book an event from the frontend easily and get a notification for each new booking.','dpProEventCalendar'); ?></p>
                        
                        <img src="<?php echo dpProEventCalendar_plugin_url().'/images/pro/booking.png'?>" alt="<?php _e('Bookings','dpProEventCalendar'); ?>" class="dp_pec_image_shadow" />
                        
                        <hr />
                                                
                        <h2><?php _e('Allow users to submit / edit and remove their own events','dpProEventCalendar'); ?></h2>
                        
                        <p><?php _e('Add a form in the frontend to allow users submit their own events, publish them automatically or approve them first. Also you can customize the form adding / removing fields:','dpProEventCalendar'); ?></p>
                        
                        <img src="<?php echo dpProEventCalendar_plugin_url().'/images/pro/new_event.jpg'?>" alt="<?php _e('Allow users to submit / edit and remove their own events','dpProEventCalendar'); ?>" class="dp_pec_image_shadow" />
                        
                        <hr />
                        
                        <h2><?php _e('Calendar Subscription','dpProEventCalendar'); ?></h2>
                        
                        <p><?php _e('Allow users to subscribe to a calendar and receive newsletters with new events. This feature supports MailChimp','dpProEventCalendar'); ?></p>
                        
                        <img src="<?php echo dpProEventCalendar_plugin_url().'/images/pro/subscribe.jpg'?>" alt="<?php _e('Calendar Subscription','dpProEventCalendar'); ?>" class="dp_pec_image_shadow" />
                        
                        <hr />
                        
                        <h2><?php _e('iCal / RSS support','dpProEventCalendar'); ?></h2>
                        
                        <p><?php _e('Allow users to get your calendar events in their RSS feed reader or iCal platform (iCalendar, Outlook, Google Calendar)','dpProEventCalendar'); ?></p>
                                                
                        <hr />
                        
                        <h2><?php _e('More Layouts / Widgets / Shortcodes','dpProEventCalendar'); ?></h2>
                        
                        <p><?php _e('Extends the Layouts, Widgets and Shortcodes included:','dpProEventCalendar'); ?></p>
                        
                        <h3><?php _e('Accordion Layout','dpProEventCalendar'); ?></h3>
                        
                        <img src="<?php echo dpProEventCalendar_plugin_url().'/images/pro/accordion.jpg'?>" alt="<?php _e('Accordion Layout','dpProEventCalendar'); ?>" class="dp_pec_image_shadow" />
                        
                        <h3><?php _e('Grid Layout','dpProEventCalendar'); ?></h3>
                        
                        <img src="<?php echo dpProEventCalendar_plugin_url().'/images/pro/grid.jpg'?>" alt="<?php _e('Grid Layout','dpProEventCalendar'); ?>" class="dp_pec_image_shadow" />
                        
                        <h3><?php _e('Gmaps Layout','dpProEventCalendar'); ?></h3>
                        
                        <img src="<?php echo dpProEventCalendar_plugin_url().'/images/pro/gmaps.jpg'?>" alt="<?php _e('Gmaps Layout','dpProEventCalendar'); ?>" class="dp_pec_image_shadow" />
                        
                        <p><?php _e('To see more live examples visit <a href="http://demo.wpsleek.com/?item=wp_proeventcalendar" target="_blank">the PRO version demo site.</a>','dpProEventCalendar'); ?></p>
                        
                        <hr />
                        
                        <h2><?php _e('Free Support and future updates','dpProEventCalendar'); ?></h2>
                        
                        <p><?php _e('Get Free support and the exclusive features that will be implemented in the Pro version.','dpProEventCalendar'); ?></p>
                    </div>
                </div>           
            </div>
        </div>

                    
</div> <!--end of float wrap -->


<?php	
}
?>