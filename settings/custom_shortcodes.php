<?php
// This function displays the admin page content
function dpProEventCalendar_custom_shortcodes_page() {
	global $wpdb, $table_prefix;
	$table_name_calendars = $table_prefix.DP_LITE_EVENT_CALENDAR_TABLE_CALENDARS;
	
	require_once (dirname (__FILE__) . '/../classes/base.class.php');
	
	$dpProEventCalendar_class = new DpProEventCalendar( true, (is_numeric($calendar_id) ? $calendar_id : null) );
		
	$dpProEventCalendar_class->addScripts(true);
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
	                <li><a href="javascript:void(0);" title="" class="active"><span><?php _e('Custom Shortcodes','dpProEventCalendar'); ?></span></a></li>
                    <li><a href="admin.php?page=dpProEventCalendar-pro" title=""><span><?php _e('Get More Features!','dpProEventCalendar'); ?></span></a></li>
	            </ul>
                
                <div class="clear"></div>
            </div>     
            
            <div id="rightSide">
                <div id="menu_general_settings">
                    <div class="titleArea">
                        <div class="wrapper">
                            <div class="pageTitle">
                                <h2><?php _e('Custom Shortcodes','dpProEventCalendar'); ?></h2>
                                <span><?php _e('Get a calendar custom shortcode.','dpProEventCalendar'); ?></span>
                            </div>
                            
                            <div class="clear"></div>
                        </div>
                    </div>
                    
                    <div class="wrapper">
                    	<div class="option option-select">
                            <div class="option-inner">
                                <label class="titledesc"><?php _e('Calendar','dpProEventCalendar'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <select name="pec_custom_shortcode_calendar" id="pec_custom_shortcode_calendar" onchange="pec_updateShortcode();">
											<?php
                                            $querystr = "
                                            SELECT *
                                            FROM $table_name_calendars
                                            ORDER BY title ASC
                                            ";
                                            $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                                            foreach($calendars_obj as $calendar_key) {
                                            ?>
                                                <option value="<?php echo $calendar_key->id?>"><?php echo $calendar_key->title?></option>
                                            <?php }?>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="desc"><?php _e('Select a calendar','dpProEventCalendar'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-select">
                            <div class="option-inner">
                                <label class="titledesc"><?php _e('Layout','dpProEventCalendar'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <select name="pec_custom_shortcode_layout" id="pec_custom_shortcode_layout" onchange="pec_updateShortcode();">
											<option value=""><?php _e('Default','dpProEventCalendar'); ?></option>
                                            <option value="upcoming"><?php _e('Upcoming Events','dpProEventCalendar'); ?></option>
                                            <option value="calendar-author"><?php _e('Calendar by Author','dpProEventCalendar'); ?></option>
                                            <option value="today-events"><?php _e('Today Events','dpProEventCalendar'); ?></option>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="desc"><?php _e('Select a layout type.','dpProEventCalendar'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-select" id="list-category">
                            <div class="option-inner">
                                <label class="titledesc"><?php _e('Category','dpProEventCalendar'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <select name="pec_custom_shortcode_category" id="pec_custom_shortcode_category" onchange="pec_updateShortcode();">
                                        	<option value=""><?php _e('All Categories...','dpProEventCalendar'); ?></option>
                                            <?php 
											 $categories = get_categories(array('taxonomy' => 'pec_events_category', 'hide_empty' => 0)); 
											  foreach ($categories as $category) {

												$option = '<option value="'.$category->term_id.'">';
												$option .= $category->cat_name;
												$option .= '</option>';
												echo $option;
											  }
?>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="desc"><?php _e('Select a category.','dpProEventCalendar'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-select" id="list-authors" style="display:none;">
                            <div class="option-inner">
                                <label class="titledesc"><?php _e('Authors','dpProEventCalendar'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <select name="pec_custom_shortcode_authors" id="pec_custom_shortcode_authors" onchange="pec_updateShortcode();">
                                            <option value="current"><?php _e('Current logged in user','dpProEventCalendar'); ?></option>
											<?php 
											$blogusers = get_users('who=authors');
											foreach ($blogusers as $user) {
												echo '<option value="'.$user->ID.'">' . $user->display_name . ' ('.$user->user_nicename.')</option>';
											}?>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="desc"><?php _e('Select an author.','dpProEventCalendar'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-select" id="list-columns" style="display:none;">
                            <div class="option-inner">
                                <label class="titledesc"><?php _e('Columns','dpProEventCalendar'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <select name="pec_custom_shortcode_columns" id="pec_custom_shortcode_columns" onchange="pec_updateShortcode();">
                                            <option value="1"><?php _e('1 Column','dpProEventCalendar'); ?></option>
                                            <option value="2"><?php _e('2 Columns','dpProEventCalendar'); ?></option>
                                            <option value="3"><?php _e('3 Columns','dpProEventCalendar'); ?></option>
                                            <option value="4"><?php _e('4 Columns','dpProEventCalendar'); ?></option>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="desc"><?php _e('Select the number of columns.','dpProEventCalendar'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-select" id="from-param" style="display:none;">
                            <div class="option-inner">
                                <label class="titledesc"><?php _e('From','dpProEventCalendar'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
                                        <input type="text" readonly="readonly" maxlength="10" class="large-text"  name="default_date" id="pec_custom_shortcode_from" value="" style="width:100px;" />
                                    	<button type="button" class="dpProEventCalendar_btn_getFromDate">
                                            <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                        </button>
                                        <br>
                                    </div>
                                    <div class="desc"><?php _e('Select a date to start displaying the past events.','dpProEventCalendar'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="option option-select" id="limit-param" style="display:none;">
                            <div class="option-inner">
                                <label class="titledesc"><?php _e('Limit','dpProEventCalendar'); ?></label>
                                <div class="formcontainer">
                                    <div class="forminp">
	                                    
                                        <input type="number" min="1" max="99" name="pec_custom_shortcode_limit" id="pec_custom_shortcode_limit" value="5" onchange="pec_updateShortcode();" />
                                        <br>
                                    </div>
                                    <div class="desc"><?php _e('Select a limit of posts to display.','dpProEventCalendar'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="submit">
                        
                            <span class="pec_custom_shortcode"></span> 

                            <div class="clear"></div>
                            
                            <p class="pec_custom_shortcode_help"></p>
                            
                            
                            <!--<input type="button" class="button button-large" id="pec_custom_shortcode_preview_btn" value="<?php echo __( 'Get Preview', 'dpProEventCalendar' )?>" />-->
                            
                            <div id="pec_custom_shortcode_preview"></div>
                        </div>
                    </div>
                </div>           
            </div>
        </div>
                    
</div> <!--end of float wrap -->

<script type="text/javascript">
	function pec_updateShortcode() {
		var shortcode = '[dpProEventCalendar';
		
		jQuery('#list-authors').hide();
		jQuery('#list-category').hide();
		jQuery('#list-events').hide();
		jQuery('#list-columns').hide();
		jQuery('#limit-param').hide();
		
		if(jQuery('#pec_custom_shortcode_calendar').val() != "") {
			shortcode += ' id="'+jQuery('#pec_custom_shortcode_calendar').val()+'"';
		}
		
		if(jQuery('#pec_custom_shortcode_layout').val() != "" && jQuery('#pec_custom_shortcode_layout').val() != "calendar-author") {
			shortcode += ' type="'+jQuery('#pec_custom_shortcode_layout').val()+'"';
		}
		
		if(jQuery('#pec_custom_shortcode_layout').val() == "" || jQuery('#pec_custom_shortcode_layout').val() == "calendar-author") {
			jQuery('#list-category').show();
			jQuery('#list-events').show();
			
			if(jQuery('#pec_custom_shortcode_category').val() != "") {
				shortcode += ' category="'+jQuery('#pec_custom_shortcode_category').val()+'"';
			}
		}
		
		if(jQuery('#pec_custom_shortcode_layout').val() == "list-author" || jQuery('#pec_custom_shortcode_layout').val() == "calendar-author") {
			jQuery('#list-authors').show();
			shortcode += ' author="'+jQuery('#pec_custom_shortcode_authors').val()+'"';
			//jQuery('.pec_custom_shortcode_help').text('<?php echo __( 'This shortcode should be implemented inside the author template of your theme.', 'dpProEventCalendar' )?>');
		} else {
			jQuery('.pec_custom_shortcode_help').text('');
		}
		
		if(jQuery('#pec_custom_shortcode_layout').val() == "upcoming" 
			|| jQuery('#pec_custom_shortcode_layout').val() == "accordion-upcoming" 
			|| jQuery('#pec_custom_shortcode_layout').val() == "grid-upcoming" 
			|| jQuery('#pec_custom_shortcode_layout').val() == "bookings-user"
			|| jQuery('#pec_custom_shortcode_layout').val() == "past") {
			jQuery('#limit-param').show();
			shortcode += ' limit="'+jQuery('#pec_custom_shortcode_limit').val()+'"';
		}
		
		if(jQuery('#pec_custom_shortcode_layout').val() == "past") {
			jQuery('#from-param').show();
			shortcode += ' from="'+jQuery('#pec_custom_shortcode_from').val()+'"';
		}
		
		if(jQuery('#pec_custom_shortcode_layout').val() == "grid-upcoming") {
			jQuery('#list-columns').show();
			shortcode += ' columns="'+jQuery('#pec_custom_shortcode_columns').val()+'"';
		}

		shortcode += ']';
		
		jQuery('.pec_custom_shortcode').text(shortcode);
	};
	
	pec_updateShortcode();
</script>

<?php $dpProEventCalendar_class->output(true);?>
<?php	
}
?>