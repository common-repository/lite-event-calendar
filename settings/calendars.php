<?php 
// This function displays the admin page content
function dpProEventCalendar_calendars_page() {
	global $dpProEventCalendar, $dpProEventCalendar_cache, $wpdb, $table_prefix;
	$table_name = $table_prefix.DP_LITE_EVENT_CALENDAR_TABLE_CALENDARS;
	$table_name_events = $table_prefix.DP_LITE_EVENT_CALENDAR_TABLE_EVENTS;
	$table_name_special_dates_calendar = $table_prefix.DP_LITE_EVENT_CALENDAR_TABLE_SPECIAL_DATES_CALENDAR;
	$table_name_subscribers_calendar = $table_prefix.DP_LITE_EVENT_CALENDAR_TABLE_SUBSCRIBERS_CALENDAR;
	
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);

	if ($_POST['submit']) {
	   
	   foreach($_POST as $key=>$value) { $$key = $value; }
	   
	   if($active != 1) { $active = 0; }
	   if($format_ampm != 1) { $format_ampm = 0; }
	   if($show_time != 1) { $show_time = 0; }
	   if($show_search != 1) { $show_search = 0; }
	   if($show_category_filter != 1) { $show_category_filter = 0; }
	   if($show_x != 1) { $show_x = 0; }
	   if($allow_user_add_event != 1) { $allow_user_add_event = 0; }
	   if($allow_user_edit_event != 1) { $allow_user_edit_event = 0; }
	   if($allow_user_remove_event != 1) { $allow_user_remove_event = 0; }
	   if($publish_new_event != 1) { $publish_new_event = 0; }
	   if($show_view_buttons != 1) { $show_view_buttons = 0; }
	   if($show_preview != 1) { $show_preview = 0; }
	   if($show_references != 1) { $show_references = 0; }
	   if($show_author != 1) { $show_author = 0; }
	   if($cache_active != 1) { $cache_active = 0; }
	   if($ical_active != 1) { $ical_active = 0; }
	   if($rss_active != 1) { $rss_active = 0; }
	   if($subscribe_active != 1) { $subscribe_active = 0; }
       if($link_post != 1) { $link_post = 0; }
	   if($email_admin_new_event != 1) { $email_admin_new_event = 0; }
	   if($article_share != 1) { $article_share = 0; }
	   if($hide_old_dates != 1) { $hide_old_dates = 0; }
	   if(!is_numeric($limit_time_start)) { $limit_time_start = 0; }
	   if(!is_numeric($limit_time_end)) { $limit_time_end = 23; }
	   if($assign_events_admin == "") { $assign_events_admin = 0; }
	   if($form_show_description != 1) { $form_show_description = 0; }
	   if($form_show_category != 1) { $form_show_category = 0; }
	   if($form_show_hide_time != 1) { $form_show_hide_time = 0; }
	   if($form_show_frequency != 1) { $form_show_frequency = 0; }
	   if($form_show_all_day != 1) { $form_show_all_day = 0; }
	   if($form_show_image != 1) { $form_show_image = 0; }
	   if($form_show_link != 1) { $form_show_link = 0; }
	   if($form_show_share != 1) { $form_show_share = 0; }
	   if($form_show_location != 1) { $form_show_location = 0; }
	   if($form_show_phone != 1) { $form_show_phone = 0; }
	   if($form_show_map != 1) { $form_show_map = 0; }
	   if($booking_enable != 1) { $booking_enable = 0; }
	   if($booking_comment != 1) { $booking_comment = 0; }
	   if($booking_non_logged != 1) { $booking_non_logged = 0; }
	   $enable_wpml = 1;
	   
	   if(is_array($category_filter_include)) {
	   	$category_filter_include = implode(",", $category_filter_include);
	   } else {
		$category_filter_include =  "";
	   }
	   	   
	   if (is_numeric($_POST['calendar_id']) && $_POST['calendar_id'] > 0) {
	   	   $wpdb->query("SET NAMES utf8");
		   
	   	   $sql = "UPDATE $table_name SET ";
		   $sql .= "title = '$title', ";
		   $sql .= "description = '$description', ";
		   $sql .= "width = '$width', ";
		   $sql .= "width_unity = '$width_unity', ";
		   if($default_date != '') {
		     	$sql .= "default_date = '$default_date', ";
		   } else {
		     	$sql .= "default_date = null, ";
		   }
		   if($date_range_start != '') {
		   		$sql .= "date_range_start = '$date_range_start', ";
		   } else {
		   		$sql .= "date_range_start = null, ";
		   }
		   if($date_range_end != '') {
		   		$sql .= "date_range_end = '$date_range_end', ";
		   } else {
		   		$sql .= "date_range_end = null, ";
		   }
		   $sql .= "current_date_color = '$current_date_color', ";
		   $sql .= "active = $active, ";
		   $sql .= "hide_old_dates = $hide_old_dates, ";
		   $sql .= "limit_time_start = $limit_time_start, ";
		   $sql .= "limit_time_end = $limit_time_end, ";
		   $sql .= "assign_events_admin = $assign_events_admin, ";
		   $sql .= "cache_active = $cache_active, ";
		   $sql .= "ical_active = $ical_active, ";
		   $sql .= "ical_limit = '$ical_limit', ";
		   $sql .= "rss_active = $rss_active, ";
		   $sql .= "booking_enable = $booking_enable, ";
		   $sql .= "booking_non_logged = $booking_non_logged, ";
		   $sql .= "booking_email_template_user = '$booking_email_template_user', ";
		   $sql .= "booking_email_template_admin = '$booking_email_template_admin', ";
		   $sql .= "booking_comment = $booking_comment, ";
		   $sql .= "booking_event_color = '$booking_event_color', ";
		   $sql .= "lang_txt_book_event_comment = '$lang_txt_book_event_comment', ";
		   $sql .= "lang_txt_book_event_select_date = '$lang_txt_book_event_select_date', ";
		   $sql .= "lang_txt_book_event_pick_date = '$lang_txt_book_event_pick_date', ";
		   $sql .= "lang_txt_book_event_already_booked = '$lang_txt_book_event_already_booked', ";
		   $sql .= "subscribe_active = $subscribe_active, ";
		   $sql .= "lang_txt_book_event = '$lang_txt_book_event', ";
		   $sql .= "lang_txt_book_event_remove = '$lang_txt_book_event_remove', ";
		   $sql .= "lang_txt_book_event_saved = '$lang_txt_book_event_saved', ";
		   $sql .= "lang_txt_book_event_removed = '$lang_txt_book_event_removed', ";
		   $sql .= "mailchimp_api = '$mailchimp_api', ";
		   $sql .= "mailchimp_list = '$mailchimp_list', ";
		   $sql .= "rss_limit = '$rss_limit', ";
		   $sql .= "link_post = $link_post, ";
		   $sql .= "article_share = $article_share, ";
		   $sql .= "email_admin_new_event = $email_admin_new_event, ";
		   $sql .= "view = 'monthly', ";
		   $sql .= "format_ampm = $format_ampm, ";
		   $sql .= "show_time = $show_time, ";
		   $sql .= "enable_wpml = $enable_wpml, ";
		   $sql .= "show_category_filter = $show_category_filter, ";
		   $sql .= "category_filter_include = '$category_filter_include', ";
		   $sql .= "show_search = $show_search, ";
		   $sql .= "show_x = $show_x, ";
		   $sql .= "allow_user_add_event = $allow_user_add_event, ";
		   $sql .= "allow_user_edit_event = $allow_user_edit_event, ";
		   $sql .= "allow_user_remove_event = $allow_user_remove_event, ";
		   $sql .= "publish_new_event = $publish_new_event, ";
		   $sql .= "show_view_buttons = $show_view_buttons, ";
		   $sql .= "show_preview = $show_preview, ";
		   $sql .= "show_references = $show_references, ";
		   $sql .= "show_author = $show_author, ";
		   $sql .= "form_show_description = $form_show_description, ";
		   $sql .= "form_show_category = $form_show_category, ";
		   $sql .= "form_show_hide_time = $form_show_hide_time, ";
		   $sql .= "form_show_frequency = $form_show_frequency, ";
		   $sql .= "form_show_all_day = $form_show_all_day, ";
		   $sql .= "form_show_image = $form_show_image, ";
		   $sql .= "form_show_link = $form_show_link, ";
		   $sql .= "form_show_share = $form_show_share, ";
		   $sql .= "form_show_location = $form_show_location, ";
		   $sql .= "form_show_phone = $form_show_phone, ";
		   $sql .= "form_show_map = $form_show_map, ";
		   $sql .= "first_day = $first_day, ";
		   $sql .= "lang_txt_no_events_found = '$lang_txt_no_events_found', ";
		   $sql .= "lang_txt_all_day = '$lang_txt_all_day', ";
		   $sql .= "lang_txt_references = '$lang_txt_references', ";
		   $sql .= "lang_txt_view_all_events = '$lang_txt_view_all_events', ";
		   $sql .= "lang_txt_all_categories = '$lang_txt_all_categories', ";
		   $sql .= "lang_txt_monthly = '$lang_txt_monthly', ";
		   $sql .= "lang_txt_daily = '$lang_txt_daily', ";
		   $sql .= "lang_txt_all_working_days = '$lang_txt_all_working_days', ";
		   $sql .= "lang_txt_search = '$lang_txt_search', ";
		   $sql .= "lang_txt_results_for = '$lang_txt_results_for', ";
		   $sql .= "lang_txt_by = '$lang_txt_by', ";
		   $sql .= "lang_txt_current_date = '$lang_txt_current_date', ";
		   $sql .= "lang_prev_month = '$lang_prev_month', ";
		   $sql .= "lang_next_month = '$lang_next_month', ";
		   $sql .= "lang_prev_day = '$lang_prev_day', ";
		   $sql .= "lang_next_day = '$lang_next_day', ";
		   $sql .= "lang_day_sunday = '$lang_day_sunday', ";
		   $sql .= "lang_day_monday = '$lang_day_monday', ";
		   $sql .= "lang_day_tuesday = '$lang_day_tuesday', ";
		   $sql .= "lang_day_wednesday = '$lang_day_wednesday', ";
		   $sql .= "lang_day_thursday = '$lang_day_thursday', ";
		   $sql .= "lang_day_friday = '$lang_day_friday', ";
		   $sql .= "lang_day_saturday = '$lang_day_saturday', ";
		   $sql .= "lang_month_january = '$lang_month_january', ";
		   $sql .= "lang_month_february = '$lang_month_february', ";
		   $sql .= "lang_month_march = '$lang_month_march', ";
		   $sql .= "lang_month_april = '$lang_month_april', ";
		   $sql .= "lang_month_may = '$lang_month_may', ";
		   $sql .= "lang_month_june = '$lang_month_june', ";
		   $sql .= "lang_month_july = '$lang_month_july', ";
		   $sql .= "lang_month_august = '$lang_month_august', ";
		   $sql .= "lang_month_september = '$lang_month_september', ";
		   $sql .= "lang_month_october = '$lang_month_october', ";
		   $sql .= "lang_month_november = '$lang_month_november', ";
		   $sql .= "lang_month_december = '$lang_month_december', ";
		   $sql .= "lang_txt_category = '$lang_txt_category', ";
		   $sql .= "lang_txt_subscribe = '$lang_txt_subscribe', ";
		   $sql .= "lang_txt_subscribe_subtitle = '$lang_txt_subscribe_subtitle', ";
		   $sql .= "lang_txt_your_name = '$lang_txt_your_name', ";
		   $sql .= "lang_txt_your_email = '$lang_txt_your_email', ";
		   $sql .= "lang_txt_fields_required = '$lang_txt_fields_required', ";
		   $sql .= "lang_txt_invalid_email = '$lang_txt_invalid_email', ";
		   $sql .= "lang_txt_subscribe_thanks = '$lang_txt_subscribe_thanks', ";
		   $sql .= "lang_txt_sending = '$lang_txt_sending', ";
		   $sql .= "lang_txt_send = '$lang_txt_send', ";
		   $sql .= "lang_txt_add_event = '$lang_txt_add_event', ";
		   $sql .= "lang_txt_edit_event = '$lang_txt_edit_event', ";
		   $sql .= "lang_txt_remove_event = '$lang_txt_remove_event', ";
		   $sql .= "lang_txt_remove_event_confirm = '$lang_txt_remove_event_confirm', ";
		   $sql .= "lang_txt_cancel = '$lang_txt_cancel', ";
		   $sql .= "lang_txt_logged_to_submit = '$lang_txt_logged_to_submit', ";
		   $sql .= "lang_txt_thanks_for_submit = '$lang_txt_thanks_for_submit', ";
		   $sql .= "lang_txt_event_title = '$lang_txt_event_title', ";
		   $sql .= "lang_txt_event_description = '$lang_txt_event_description', ";
		   $sql .= "lang_txt_event_link = '$lang_txt_event_link', ";
		   $sql .= "lang_txt_event_share = '$lang_txt_event_share', ";
		   $sql .= "lang_txt_event_image = '$lang_txt_event_image', ";
		   $sql .= "lang_txt_event_location = '$lang_txt_event_location', ";
		   $sql .= "lang_txt_event_phone = '$lang_txt_event_phone', ";
		   $sql .= "lang_txt_event_googlemap = '$lang_txt_event_googlemap', ";
		   $sql .= "lang_txt_event_start_date = '$lang_txt_event_start_date', ";
		   $sql .= "lang_txt_event_all_day = '$lang_txt_event_all_day', ";
		   $sql .= "lang_txt_event_start_time = '$lang_txt_event_start_time', ";
		   $sql .= "lang_txt_event_hide_time = '$lang_txt_event_hide_time', ";
		   $sql .= "lang_txt_event_end_time = '$lang_txt_event_end_time', ";
		   $sql .= "lang_txt_event_frequency = '$lang_txt_event_frequency', ";
		   $sql .= "lang_txt_event_none = '$lang_txt_event_none', ";
		   $sql .= "lang_txt_event_daily = '$lang_txt_event_daily', ";
		   $sql .= "lang_txt_event_weekly = '$lang_txt_event_weekly', ";
		   $sql .= "lang_txt_event_monthly = '$lang_txt_event_monthly', ";
		   $sql .= "lang_txt_event_yearly = '$lang_txt_event_yearly', ";
		   $sql .= "lang_txt_event_end_date = '$lang_txt_event_end_date', ";
		   $sql .= "lang_txt_event_submit = '$lang_txt_event_submit', ";
		   $sql .= "lang_txt_yes = '$lang_txt_yes', ";
		   $sql .= "lang_txt_no = '$lang_txt_no', ";
		   $sql .= "skin = '$skin' ";
		   $sql .= "WHERE id = $calendar_id ";
		   $result = $wpdb->query($sql);

	   } else {
		   
		   $sql = "INSERT INTO $table_name (";
		   $sql .= "title, ";
		   $sql .= "description, ";
		   $sql .= "width, ";
		   $sql .= "width_unity, ";
		   if($default_date != '') {
		   	$sql .= "default_date, ";
		   }
		   if($date_range_start != '') {
		   	$sql .= "date_range_start, ";
		   }
		   if($date_range_end != '') {
		   	$sql .= "date_range_end, ";
		   }
		   $sql .= "current_date_color, ";
		   $sql .= "active, ";
		   $sql .= "hide_old_dates, ";
		   $sql .= "limit_time_start, ";
		   $sql .= "limit_time_end, ";
		   $sql .= "assign_events_admin, ";
		   $sql .= "cache_active, ";
		   $sql .= "ical_active, ";
		   $sql .= "ical_limit, ";
		   $sql .= "rss_active, ";
		   $sql .= "booking_enable, ";
		   $sql .= "booking_non_logged, ";
		   $sql .= "booking_email_template_user, ";
		   $sql .= "booking_email_template_admin, ";
		   $sql .= "booking_comment, ";
		   $sql .= "booking_event_color, ";
		   $sql .= "lang_txt_book_event_comment, ";
		   $sql .= "lang_txt_book_event_select_date, ";
		   $sql .= "lang_txt_book_event_pick_date, ";
		   $sql .= "lang_txt_book_event_already_booked, ";
		   $sql .= "subscribe_active, ";
		   $sql .= "lang_txt_book_event, ";
		   $sql .= "lang_txt_book_event_remove, ";
		   $sql .= "lang_txt_book_event_saved, ";
		   $sql .= "lang_txt_book_event_removed, ";
		   $sql .= "mailchimp_api, ";
		   $sql .= "mailchimp_list, ";
		   $sql .= "rss_limit, ";
		   $sql .= "link_post, ";
		   $sql .= "article_share, ";
		   $sql .= "email_admin_new_event, ";
		   $sql .= "view, ";
		   $sql .= "format_ampm, ";
		   $sql .= "show_time, ";
		   $sql .= "enable_wpml, ";
		   $sql .= "show_category_filter, ";
		   $sql .= "category_filter_include, ";
		   $sql .= "show_search, ";
		   $sql .= "show_x, ";
		   $sql .= "allow_user_add_event, ";
		   $sql .= "allow_user_edit_event, ";
		   $sql .= "allow_user_remove_event, ";
		   $sql .= "publish_new_event, ";
		   $sql .= "show_view_buttons, ";
		   $sql .= "show_preview, ";
		   $sql .= "show_references, ";
		   $sql .= "show_author, ";
		   $sql .= "form_show_description, ";
		   $sql .= "form_show_category, ";
		   $sql .= "form_show_hide_time, ";
		   $sql .= "form_show_frequency, ";
		   $sql .= "form_show_all_day, ";
		   $sql .= "form_show_image, ";
		   $sql .= "form_show_link, ";
		   $sql .= "form_show_share, ";
		   $sql .= "form_show_location, ";
		   $sql .= "form_show_phone, ";
		   $sql .= "form_show_map, ";
		   $sql .= "first_day, ";
		   $sql .= "lang_txt_no_events_found, ";
		   $sql .= "lang_txt_all_day, ";
		   $sql .= "lang_txt_references, ";
		   $sql .= "lang_txt_view_all_events, ";
		   $sql .= "lang_txt_all_categories, ";
		   $sql .= "lang_txt_monthly, ";
		   $sql .= "lang_txt_daily, ";
		   $sql .= "lang_txt_all_working_days, ";
		   $sql .= "lang_txt_search, ";
		   $sql .= "lang_txt_results_for, ";
		   $sql .= "lang_txt_by, ";
		   $sql .= "lang_txt_current_date, ";
		   $sql .= "lang_prev_month, ";
		   $sql .= "lang_next_month, ";
		   $sql .= "lang_prev_day, ";
		   $sql .= "lang_next_day, ";
		   $sql .= "lang_day_sunday, ";
		   $sql .= "lang_day_monday, ";
		   $sql .= "lang_day_tuesday, ";
		   $sql .= "lang_day_wednesday, ";
		   $sql .= "lang_day_thursday, ";
		   $sql .= "lang_day_friday, ";
		   $sql .= "lang_day_saturday, ";
		   $sql .= "lang_month_january, ";
		   $sql .= "lang_month_february, ";
		   $sql .= "lang_month_march, ";
		   $sql .= "lang_month_april, ";
		   $sql .= "lang_month_may, ";
		   $sql .= "lang_month_june, ";
		   $sql .= "lang_month_july, ";
		   $sql .= "lang_month_august, ";
		   $sql .= "lang_month_september, ";
		   $sql .= "lang_month_october, ";
		   $sql .= "lang_month_november, ";
		   $sql .= "lang_month_december, ";
		   $sql .= "lang_txt_category, ";
		   $sql .= "lang_txt_subscribe, ";
		   $sql .= "lang_txt_subscribe_subtitle, ";
		   $sql .= "lang_txt_your_name, ";
		   $sql .= "lang_txt_your_email, ";
		   $sql .= "lang_txt_fields_required, ";
		   $sql .= "lang_txt_invalid_email, ";
		   $sql .= "lang_txt_subscribe_thanks, ";
		   $sql .= "lang_txt_sending, ";
		   $sql .= "lang_txt_add_event, ";
		   $sql .= "lang_txt_edit_event, ";
		   $sql .= "lang_txt_remove_event, ";
		   $sql .= "lang_txt_remove_event_confirm, ";
		   $sql .= "lang_txt_cancel, ";
		   $sql .= "lang_txt_yes, ";
		   $sql .= "lang_txt_no, ";
		   $sql .= "lang_txt_logged_to_submit, ";
		   $sql .= "lang_txt_thanks_for_submit, ";
		   $sql .= "lang_txt_event_title, ";
		   $sql .= "lang_txt_event_description, ";
		   $sql .= "lang_txt_event_link, ";
		   $sql .= "lang_txt_event_share, ";
		   $sql .= "lang_txt_event_image, ";
		   $sql .= "lang_txt_event_location, ";
		   $sql .= "lang_txt_event_phone, ";
		   $sql .= "lang_txt_event_googlemap, ";
		   $sql .= "lang_txt_event_start_date, ";
		   $sql .= "lang_txt_event_all_day, ";
		   $sql .= "lang_txt_event_start_time, ";
		   $sql .= "lang_txt_event_hide_time, ";
		   $sql .= "lang_txt_event_end_time, ";
		   $sql .= "lang_txt_event_frequency, ";
		   $sql .= "lang_txt_event_none, ";
		   $sql .= "lang_txt_event_daily, ";
		   $sql .= "lang_txt_event_weekly, ";
		   $sql .= "lang_txt_event_monthly, ";
		   $sql .= "lang_txt_event_yearly, ";
		   $sql .= "lang_txt_event_end_date, ";
		   $sql .= "lang_txt_event_submit, ";
		   $sql .= "skin ";
		   $sql .= ") VALUES ( ";
		   $sql .= "'$title', ";
		   $sql .= "'$description', ";
		   $sql .= "'$width', ";
		   $sql .= "'$width_unity', ";
		   if($default_date != '') {
		   	$sql .= "'$default_date', ";
		   }
		   if($date_range_start != '') {
		   	$sql .= "'$date_range_start', ";
		   }
		   if($date_range_end != '') {
		   	$sql .= "'$date_range_end', ";
		   }
		   $sql .= "'$current_date_color', ";
		   $sql .= "$active, ";
		   $sql .= "$hide_old_dates, ";
		   $sql .= "$limit_time_start, ";
		   $sql .= "$limit_time_end, ";
		   $sql .= "$assign_events_admin, ";
		   $sql .= "$cache_active, ";
		   $sql .= "$ical_active, ";
		   $sql .= "'$ical_limit', ";
		   $sql .= "$rss_active, ";
		   $sql .= "$booking_enable, ";
		   $sql .= "$booking_non_logged, ";
		   $sql .= "'$booking_email_template_user', ";
		   $sql .= "'$booking_email_template_admin', ";
		   $sql .= "$booking_comment, ";
		   $sql .= "'$booking_event_color', ";
		   $sql .= "'$lang_txt_book_event_comment', ";
		   $sql .= "'$lang_txt_book_event_select_date', ";
		   $sql .= "'$lang_txt_book_event_pick_date', ";
		   $sql .= "'$lang_txt_book_event_already_booked', ";
		   $sql .= "$subscribe_active, ";
		   $sql .= "'$lang_txt_book_event', ";
		   $sql .= "'$lang_txt_book_event_remove', ";
		   $sql .= "'$lang_txt_book_event_saved', ";
		   $sql .= "'$lang_txt_book_event_removed', ";
		   $sql .= "'$mailchimp_api', ";
		   $sql .= "'$mailchimp_list', ";
		   $sql .= "'$rss_limit', ";
		   $sql .= "$link_post, ";
		   $sql .= "$article_share, ";
		   $sql .= "$email_admin_new_event, ";
		   $sql .= "'monthly', ";
		   $sql .= "$format_ampm, ";
		   $sql .= "$show_time, ";
		   $sql .= "$enable_wpml, ";
		   $sql .= "$show_category_filter, ";
		   $sql .= "'$category_filter_include', ";
		   $sql .= "$show_search, ";
		   $sql .= "$show_x, ";
		   $sql .= "$allow_user_add_event, ";
		   $sql .= "$allow_user_edit_event, ";
		   $sql .= "$allow_user_remove_event, ";
		   $sql .= "$publish_new_event, ";
		   $sql .= "$show_view_buttons, ";
		   $sql .= "$show_preview, ";
		   $sql .= "$show_references, ";
		   $sql .= "$show_author, ";
		   $sql .= "$form_show_description, ";
		   $sql .= "$form_show_category, ";
		   $sql .= "$form_show_hide_time, ";
		   $sql .= "$form_show_frequency, ";
		   $sql .= "$form_show_all_day, ";
		   $sql .= "$form_show_image, ";
		   $sql .= "$form_show_link, ";
		   $sql .= "$form_show_share, ";
		   $sql .= "$form_show_location, ";
		   $sql .= "$form_show_phone, ";
		   $sql .= "$form_show_map, ";
		   $sql .= "$first_day, ";
		   $sql .= "'$lang_txt_no_events_found', ";
		   $sql .= "'$lang_txt_all_day', ";
		   $sql .= "'$lang_txt_references', ";
		   $sql .= "'$lang_txt_view_all_events', ";
		   $sql .= "'$lang_txt_all_categories', ";
		   $sql .= "'$lang_txt_monthly', ";
		   $sql .= "'$lang_txt_daily', ";
		   $sql .= "'$lang_txt_all_working_days', ";
		   $sql .= "'$lang_txt_search', ";
		   $sql .= "'$lang_txt_results_for', ";
		   $sql .= "'$lang_txt_by', ";
		   $sql .= "'$lang_txt_current_date', ";
		   $sql .= "'$lang_prev_month', ";
		   $sql .= "'$lang_next_month', ";
		   $sql .= "'$lang_prev_day', ";
		   $sql .= "'$lang_next_day', ";
		   $sql .= "'$lang_day_sunday', ";
		   $sql .= "'$lang_day_monday', ";
		   $sql .= "'$lang_day_tuesday', ";
		   $sql .= "'$lang_day_wednesday', ";
		   $sql .= "'$lang_day_thursday', ";
		   $sql .= "'$lang_day_friday', ";
		   $sql .= "'$lang_day_saturday', ";
		   $sql .= "'$lang_month_january', ";
		   $sql .= "'$lang_month_february', ";
		   $sql .= "'$lang_month_march', ";
		   $sql .= "'$lang_month_april', ";
		   $sql .= "'$lang_month_may', ";
		   $sql .= "'$lang_month_june', ";
		   $sql .= "'$lang_month_july', ";
		   $sql .= "'$lang_month_august', ";
		   $sql .= "'$lang_month_september', ";
		   $sql .= "'$lang_month_october', ";
		   $sql .= "'$lang_month_november', ";
		   $sql .= "'$lang_month_december', ";
		   $sql .= "'$lang_txt_category', ";
		   $sql .= "'$lang_txt_subscribe', ";
		   $sql .= "'$lang_txt_subscribe_subtitle', ";
		   $sql .= "'$lang_txt_your_name', ";
		   $sql .= "'$lang_txt_your_email', ";
		   $sql .= "'$lang_txt_fields_required', ";
		   $sql .= "'$lang_txt_invalid_email', ";
		   $sql .= "'$lang_txt_subscribe_thanks', ";
		   $sql .= "'$lang_txt_sending', ";
		   $sql .= "'$lang_txt_add_event', ";
		   $sql .= "'$lang_txt_edit_event', ";
		   $sql .= "'$lang_txt_remove_event', ";
		   $sql .= "'$lang_txt_remove_event_confirm', ";
		   $sql .= "'$lang_txt_cancel', ";
		   $sql .= "'$lang_txt_yes', ";
		   $sql .= "'$lang_txt_no', ";
		   $sql .= "'$lang_txt_logged_to_submit', ";
		   $sql .= "'$lang_txt_thanks_for_submit', ";
		   $sql .= "'$lang_txt_event_title', ";
		   $sql .= "'$lang_txt_event_description', ";
		   $sql .= "'$lang_txt_event_link', ";
		   $sql .= "'$lang_txt_event_share', ";
		   $sql .= "'$lang_txt_event_image', ";
		   $sql .= "'$lang_txt_event_location', ";
		   $sql .= "'$lang_txt_event_phone', ";
		   $sql .= "'$lang_txt_event_googlemap', ";
		   $sql .= "'$lang_txt_event_start_date', ";
		   $sql .= "'$lang_txt_event_all_day', ";
		   $sql .= "'$lang_txt_event_start_time', ";
		   $sql .= "'$lang_txt_event_hide_time', ";
		   $sql .= "'$lang_txt_event_end_time', ";
		   $sql .= "'$lang_txt_event_frequency', ";
		   $sql .= "'$lang_txt_event_none', ";
		   $sql .= "'$lang_txt_event_daily', ";
		   $sql .= "'$lang_txt_event_weekly', ";
		   $sql .= "'$lang_txt_event_monthly', ";
		   $sql .= "'$lang_txt_event_yearly', ";
		   $sql .= "'$lang_txt_event_end_date', ";
		   $sql .= "'$lang_txt_event_submit', ";
		   $sql .= "'$skin' ";
		   $sql .= ");";
		   $result = $wpdb->query($sql);
//die($sql."<br>".mysql_error());
		   $calendar_id = $wpdb->insert_id;
	   }
	   
   	   if(isset($dpProEventCalendar_cache['calendar_id_'.$calendar_id])) {
		   $dpProEventCalendar_cache['calendar_id_'.$calendar_id] = array();
		   update_option( 'dpProEventCalendar_cache', $dpProEventCalendar_cache );
	   }
	   
	   wp_redirect( admin_url('admin.php?page=dpProEventCalendar-admin&settings-updated=1') );
	   exit;
	}
	
	if(!empty($_FILES['pec_ical_file']['name'])) {
		$calendar_id = $_POST['pec_id_calendar_ics'];
		$category_ics = $_POST['pec_category_ics'];
		
		$extensions = array('.ics');
		$extension = strrchr($_FILES['pec_ical_file']['name'], '.'); 
		if(in_array($extension, $extensions)) {
			include(dirname(__FILE__) . '/../includes/ical_parser.php');
			$ical = new ICal($_FILES['pec_ical_file']['tmp_name']);
			$feed = $ical->cal;
			if(!empty($feed)) {
				foreach($feed['VEVENT'] as $key) {
					
					foreach($key as $k => $v) {
						$key[substr($k, 0, strpos($k, ';'))] = $v;	
					}
					
					$args = array( 
						'posts_per_page' => 1, 
						'post_type'=> 'pec-events', 
						"meta_query" => array(
							'relation' => 'AND',
							array(
							   'key' => 'pec_id_calendar',
							   'value' => $calendar_id,
							),
							array(
							   'key' => 'pec_ics_uid',
							   'value' => $key['UID'],
							)
						)
					);
					
					$imported_posts = get_posts( $args );
					
					// Create post object
					$ics_event = array(
					  'post_title'    => $key['SUMMARY'],
					  'post_content'  => $key['DESCRIPTION'],
					  'post_status'   => 'publish',
					  'tax_input' 	  => array( 'pec_events_category' => $category_ics ),
					  'post_type'	  => 'pec-events'
					);
					
					if(!empty($imported_posts)) {
						$ics_event['ID'] = $imported_posts[0]->ID;
					}
					
					$rrule = explode(';', $key['RRULE']);
					$rrule_arr = array();
					if(is_array($rrule)) {
						foreach($rrule as $rule) {
							$rrule_arr[substr($rule, 0, strpos($rule, '='))] = substr($rule, strrpos($rule, '=') + 1);
						}
					}
					// Insert the post into the database
					$post_id = wp_insert_post( $ics_event );
					
					update_post_meta($post_id, 'pec_id_calendar', $calendar_id);
					update_post_meta($post_id, 'pec_date', date("Y-m-d H:i:s", strtotime($key['DTSTART'])));
					update_post_meta($post_id, 'pec_all_day', '');
					
					if(is_array($rrule_arr)) {
						
						foreach($rrule_arr as $key2 => $value) {
							
							if($key2 == 'FREQ') {
								$recurring_frecuency = '';
								switch($value) {
									case 'DAILY':
										$recurring_frecuency = '1';
										break;
									case 'WEEKLY':
										$recurring_frecuency = '2';
										break;
									case 'MONTHLY':
										$recurring_frecuency = '3';
										break;
									case 'YEARLY':
										$recurring_frecuency = '4';
										break;
								}
								update_post_meta($post_id, 'pec_recurring_frecuency', $recurring_frecuency);
							}
							
							if($key2 == 'FREQ' && $value == 'DAILY') {
								update_post_meta($post_id, 'pec_daily_every', $rrule_arr['INTERVAL']);

								update_post_meta($post_id, 'pec_daily_working_days', '');
							}
							
							if($key2 == 'FREQ' && $value == 'WEEKLY') {
								$day_arr = array();
								foreach(explode(',', $rrule_arr['BYDAY']) as $day) {
									switch($day) {
										case 'MO':
											$day_arr[] = 1;
											break;
										case 'TU':
											$day_arr[] = 2;
											break;
										case 'WE':
											$day_arr[] = 3;
											break;
										case 'TH':
											$day_arr[] = 4;
											break;
										case 'FR':
											$day_arr[] = 5;
											break;
										case 'SA':
											$day_arr[] = 6;
											break;
										case 'SU':
											$day_arr[] = 7;
											break;
									}
									
									update_post_meta($post_id, 'pec_weekly_day', $day_arr);
								}

								update_post_meta($post_id, 'pec_weekly_every', $rrule_arr['INTERVAL']);

							}
							
							if($key2 == 'FREQ' && $value == 'MONTHLY') {
								
								update_post_meta($post_id, 'pec_monthly_every', $rrule_arr['INTERVAL']);
								
								$setpos = "";
								switch($rrule_arr['BYSETPOS']) {
									case '1':
										$setpos = 'first';
										break;
									case '2':
										$setpos = 'second';
										break;
									case '3':
										$setpos = 'third';
										break;
									case '4':
										$setpos = 'fourth';
										break;
									case '-1':
										$setpos = 'last';
										break;
								}
								update_post_meta($post_id, 'pec_monthly_position', $setpos);
								
								$day_arr = '';
								foreach(explode(',', $rrule_arr['BYDAY']) as $day) {
									switch($day) {
										case 'MO':
											$day_arr = 'monday';
											break;
										case 'TU':
											$day_arr = 'tuesday';
											break;
										case 'WE':
											$day_arr = 'wednesday';
											break;
										case 'TH':
											$day_arr = 'thursday';
											break;
										case 'FR':
											$day_arr = 'friday';
											break;
										case 'SA':
											$day_arr = 'saturday';
											break;
										case 'SU':
											$day_arr = 'sunday';
											break;
									}
								}
								update_post_meta($post_id, 'pec_monthly_day', $day_arr);
							}
						}
					}
					update_post_meta($post_id, 'pec_end_date', ($recurring_frecuency != '' ? '' : date("Y-m-d", strtotime($key['DTEND']))));
					update_post_meta($post_id, 'pec_link', $key['URL']);
					update_post_meta($post_id, 'pec_share', '');
					update_post_meta($post_id, 'pec_map', '');
					update_post_meta($post_id, 'pec_end_time_hh', date("H", strtotime($key['DTEND'])));
					update_post_meta($post_id, 'pec_end_time_mm', date("i", strtotime($key['DTEND'])));
					update_post_meta($post_id, 'pec_hide_time', '');
					update_post_meta($post_id, 'pec_location', $key['LOCATION']);	
					update_post_meta($post_id, 'pec_ics_uid', $key['UID']);						
				}

			}
		}
	   	wp_redirect( admin_url('admin.php?page=dpProEventCalendar-admin&settings-updated=1') );
	   exit;
   }
	
	if ($_GET['delete_calendar']) {
	   $calendar_id = $_GET['delete_calendar'];
	   
	   $args = array( 
			'posts_per_page' => -1, 
			'post_type' => 'pec-events', 
			'meta_key' => 'pec_id_calendar',
			'meta_value' => $calendar_id
		);
					
	   $delete_posts = get_posts( $args );
	   if(!empty($delete_posts)) {
		   foreach($delete_posts as $key) {
	   			wp_delete_post($key->ID);
		   }
	   }
	   	
	   $sql = "DELETE FROM $table_name WHERE id = $calendar_id;";
	   $result = $wpdb->query($sql);
	   
	   $sql = "DELETE FROM $table_name_special_dates_calendar WHERE calendar = $calendar_id;";
	   $result = $wpdb->query($sql);
	   	   
	   wp_redirect( admin_url('admin.php?page=dpProEventCalendar-admin&settings-updated=1') );
	   exit;
	}
	
	
	
	require_once (dirname (__FILE__) . '/../classes/base.class.php');
	
	
	?>
    <script type="text/javascript">
	function MailChimp_getList() {
		jQuery('#div_mailchimp_list').hide();
		
		if(jQuery('#mailchimp_api_key').val() != "") {
			jQuery.post("<?php echo dpProEventCalendar_plugin_url('ajax/MailChimp_getLists.php')?>", { mailchimp_api: jQuery('#mailchimp_api_key').val() },
			   function(data) {
				 jQuery('#mailchimp_list').html(data);
				 jQuery('#div_mailchimp_list').show();
			   }
			);
			
		}
	}
	</script>

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
                <li><a href="javascript:void(0);" class="active" title=""><span><?php _e('Calendars','dpProEventCalendar'); ?></span></a></li>
                <li><a href="edit.php?post_type=pec-events" title=""><span><?php _e('Events','dpProEventCalendar'); ?></span></a></li>
                <li><a href="admin.php?page=dpProEventCalendar-special" title=""><span><?php _e('Special Dates','dpProEventCalendar'); ?></span></a></li>
                <li><a href="admin.php?page=dpProEventCalendar-custom-shortcodes" title=""><span><?php _e('Custom Shortcodes','dpProEventCalendar'); ?></span></a></li>
                <li><a href="admin.php?page=dpProEventCalendar-pro" title=""><span><?php _e('Get More Features!','dpProEventCalendar'); ?></span></a></li>
            </ul>
            
            <div class="clear"></div>
		</div>     
		<?php if(!is_numeric($_GET['add']) && !is_numeric($_GET['edit'])) {	?>
 
        
        <div id="rightSide">
        	<div id="menu_general_settings">
                <div class="titleArea">
                    <div class="wrapper">
                        <div class="pageTitle">
                            <h2><?php _e('Calendars List','dpProEventCalendar'); ?></h2>
                            <span><?php _e('Use the shortcode in your posts or pages.','dpProEventCalendar'); ?></span>
                        </div>
                        
                        <div class="clear"></div>
                    </div>
                </div>
                
                <div class="wrapper">

                <form action="" method="post" enctype="multipart/form-data">
					<?php settings_fields('dpProEventCalendar-group'); ?>
                    
                    <input type="hidden" name="remove_posts_calendar" value="1" />
                    
                    	<div class="submit">
                        
                        <input type="button" value="<?php echo __( 'Add new calendar', 'dpProEventCalendar' )?>" name="add_calendar" onclick="location.href='<?php echo dpProEventCalendar_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        <table class="widefat" cellpadding="0" cellspacing="0" id="sort-table">
                        	<thead>
                        		<tr style="cursor:default !important;">
                                	<th><?php _e('ID','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Default Shortcode','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Title','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Description','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Events','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Actions','dpProEventCalendar'); ?></th>
                                 </tr>
                            </thead>
                            <tbody>
                        <?php 
						$counter = 0;
						$cal_output = "";
                        $querystr = "
                        SELECT calendars.*
                        FROM $table_name calendars
                        ORDER BY calendars.title ASC
                        ";
                        $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                        foreach($calendars_obj as $calendar) {
							$dpProEventCalendar_class = new DpProEventCalendar( true, (is_numeric($calendar->id) ? $calendar->id : null) );
							
							$dpProEventCalendar_class->addScripts(true);
							
							$calendar_nonce = $dpProEventCalendar_class->getNonce();
							$args = array( 'numberposts' => -1, 'meta_key'=> 'pec_id_calendar', 'meta_value' => $calendar->id, 'post_status' => 'publish', 'post_type' => 'pec-events' );

							$events_cal = get_posts( $args );
							$events_count = count($events_cal);
							
                            echo '<tr id="'.$calendar->id.'">
									<td width="5%">'.$calendar->id.'</td>
									<td width="20%">[dpProEventCalendar id='.$calendar->id.']</td>
									<td width="20%">'.$calendar->title.'</td>
									<td width="20%">'.$calendar->description.'</td>
									<td width="5%"><a href="'.admin_url('edit.php?s&post_status=all&post_type=pec-events&action=-1&m=0&pec_id_calendar='.$calendar->id.'&paged=1').'">'.$events_count.'</a></td>
									<td width="30%">
										<input type="button" value="'.__( 'Edit', 'dpProEventCalendar' ).'" name="edit_calendar" class="button-secondary" onclick="location.href=\''.admin_url('admin.php?page=dpProEventCalendar-admin&edit='.$calendar->id).'\';" />
										<input type="button" value="'.__( 'Special Dates', 'dpProEventCalendar' ).'" name="sp_calendar" data-calendar-id="'.$calendar->id.'" data-calendar-nonce="'.$calendar_nonce.'" class="btn_manage_special_dates button-secondary" />
										<input type="button" value="'.__( 'Delete', 'dpProEventCalendar' ).'" name="delete_calendar" class="button-secondary" onclick="if(confirmCalendarDelete()) { location.href=\''.admin_url('admin.php?page=dpProEventCalendar-admin&delete_calendar='.$calendar->id.'&noheader=true').'\'; }" />
									</td>
								</tr>'; 
							$counter++;
							$cal_output .= $dpProEventCalendar_class->output();
                        }
                        ?>
                        
                    		</tbody>
                            <tfoot>
                            	<tr style="cursor:default !important;">
                                	<th><?php _e('ID','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Default Shortcode','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Title','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Description','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Events','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Actions','dpProEventCalendar'); ?></th>
                                 </tr>
                            </tfoot>
                        </table>
                        
                        <div class="submit">
                        
                        <input type="button" value="<?php echo __( 'Add new calendar', 'dpProEventCalendar' )?>" name="add_calendar" onclick="location.href='<?php echo dpProEventCalendar_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        <div class="clear"></div>
                        
                        <h2><?php _e('Import iCal Feed','dpProEventCalendar'); ?></h2>
                        
                        
                        <select name="pec_id_calendar_ics" id="pec_id_calendar_ics">
                            <option value=""><?php _e('Select a Calendar','dpProEventCalendar'); ?></option>
                            <?php
                            $querystr = "
                            SELECT *
                            FROM $table_name
                            ORDER BY title ASC
                            ";
                            $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                            if(is_array($calendars_obj)) {
                                foreach($calendars_obj as $calendar) {
                            ?>
                                <option value="<?php echo $calendar->id?>"><?php echo $calendar->title?></option>
                            <?php }
                            }?>
                        </select>
                        &nbsp;&nbsp;
                        <select name="pec_category_ics" id="pec_category_ics">
                            <option value=""><?php _e('Select a Category (optional)','dpProEventCalendar'); ?></option>
                            <?php
                           $categories = get_categories('taxonomy=pec_events_category'); 
						   if(is_array($categories)) {
							  foreach ($categories as $category) {
								$option = '<option value="'.$category->term_id.'">';
								$option .= $category->cat_name;
								$option .= ' ('.$category->category_count.')';
								$option .= '</option>';
								echo $option;
							  }
						   }?>
                        </select>
                        &nbsp;&nbsp;
                        <?php _e('Select the .ics file. ','dpProEventCalendar'); ?>(<?php _e('Max', 'theme')?> <?php echo $upload_mb?>mb)
                        <input type="file" name="pec_ical_file" id="pec_ical_file" />

                        <div class="submit">
                        
                        <input type="submit" value="<?php echo __( 'Import Events', 'dpProEventCalendar' )?>" name="import_events"  />
                        
                        </div>
                        <div class="clear"></div>
                 </form>
                 <?php echo $cal_output?>
             	</div>
            </div> 
        </div>
        <?php } elseif(is_numeric($_GET['add']) || is_numeric($_GET['edit'])) {
		
		if(is_numeric($_GET['edit'])){
			$calendar_id = $_GET['edit'];
			$querystr = "
			SELECT *
			FROM $table_name 
			WHERE id = $calendar_id
			";
			$calendar_obj = $wpdb->get_results($querystr, OBJECT);
			$calendar_obj = $calendar_obj[0];	
			foreach($calendar_obj as $key=>$value) { $$key = $value; }
			
			$category_filter_include = explode(',', $category_filter_include);
		} else {
			$width_unity = '%';
			$width = 100;	
			$booking_event_color = '#e14d43';
		}
		
		if($booking_email_template_user == '') {
			$booking_email_template_user = "Hi #USERNAME#,\n\nThanks for booking the event:\n\n#EVENT_DETAILS#\n\nPlease contact us if you have questions.\n\nKind Regards.\n#SITE_NAME#";
		}
		
		if($booking_email_template_admin == '') {
			$booking_email_template_admin = "The user #USERNAME# booked the event:\n\n#EVENT_DETAILS#\n\n#SITE_NAME#";
		}
		
		$dpProEventCalendar_class = new DpProEventCalendar( true, (is_numeric($calendar_id) ? $calendar_id : null) );
		
		$dpProEventCalendar_class->addScripts(true);
		?>
        <div id="rightSide">
        	<div id="menu_general_settings">
                <div class="titleArea">
                    <div class="wrapper">
                        <div class="pageTitle">
                            <h2><?php _e('Calendar','dpProEventCalendar'); ?></h2>
                            <span><?php _e('Customize the Calendar.','dpProEventCalendar'); ?></span>
                        </div>
                        
                        <div class="clear"></div>
                    </div>
                </div>
                
                <div class="wrapper">
        
       		<form method="post" action="<?php echo admin_url('admin.php?page=dpProEventCalendar-admin&noheader=true'); ?>" onsubmit="return calendar_checkform();" enctype="multipart/form-data">
            <input type="hidden" name="submit" value="1" />
            <?php if(is_numeric($id) && $id > 0) {?>
            	<input type="hidden" name="calendar_id" value="<?php echo $id?>" />
            <?php }?>
            <?php settings_fields('dpProEventCalendar-group'); ?>
            <div style="clear:both;"></div>
             <!--end of poststuff --> 
             	
                <h2 class="subtitle accordion_title" onclick="showAccordion('div_general_settings');">General Settings</h2>
                <div id="div_general_settings">
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Active','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="active" id="dpProEventCalendar_active" class="checkbox" <?php if($active) {?>checked="checked" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('On/Off the calendar','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
        
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Title','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="title" maxlength="80" id="dpProEventCalendar_title" class="large-text" value="<?php echo $title?>" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Introduce the title (80 chars max.)','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Description','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="description" id="dpProEventCalendar_description" class="large-text" value="<?php echo $description?>" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Introduce the description','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Preselected Date','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" readonly="readonly" maxlength="10" class="large-text"  name="default_date" id="dpProEventCalendar_default_date" value="<?php echo $default_date != '0000-00-00' ? $default_date : '' ?>" style="width:100px;" />
                                    <button type="button" class="dpProEventCalendar_btn_getDate">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                    </button>
                                    <button type="button" onclick="jQuery('#dpProEventCalendar_default_date').val('');">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/clear.png' ); ?>" alt="Clear" title="Clear">
                                    </button>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select the preselected date.(optional)<br />Leave blank to NOT preselect any date.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                                        
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Link Events to Single Post','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="link_post" id="dpProEventCalendar_link_post" class="checkbox" <?php if($link_post) {?>checked="checked" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Adds a link in the event title to the post type single page.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Include share buttons','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="article_share" id="dpProEventCalendar_article_share" class="checkbox" <?php if($article_share) {?> checked="checked" <?php } if ( !is_plugin_active( 'dpArticleShare/dpArticleShare.php' ) ) {?> disabled="disabled" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Adds a share bar in the events content using the Wordpress Article Social Share plugin','dpProEventCalendar'); ?></div>
                                <?php if ( !is_plugin_active( 'dpArticleShare/dpArticleShare.php' ) ) {?>
                                	<div class="errorCustom"><p><?php _e('Notice: This feature requires the <a href="http://codecanyon.net/item/wordpress-article-social-share/6247263" target="_blank">
Wordpress Article Social Share plugin</a>.','dpProEventCalendar'); ?></p></div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                   
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Date Range','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" readonly="readonly" maxlength="10" class="large-text"  name="date_range_start" id="dpProEventCalendar_date_range_start" value="<?php echo $date_range_start != '0000-00-00' ? $date_range_start : '' ?>" style="width:100px;" />
                                    <button type="button" class="dpProEventCalendar_btn_getDateRangeStart">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                    </button>
                                    <button type="button" onclick="jQuery('#dpProEventCalendar_date_range_start').val('');">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/clear.png' ); ?>" alt="Clear" title="Clear">
                                    </button>
                                    
                                    &nbsp;&nbsp;to&nbsp;&nbsp;
                                    
                                    <input type="text" readonly="readonly" maxlength="10" class="large-text"  name="date_range_end" id="dpProEventCalendar_date_range_end" value="<?php echo $date_range_end != '0000-00-00' ? $date_range_end : '' ?>" style="width:100px;" />
                                    <button type="button" class="dpProEventCalendar_btn_getDateRangeEnd">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                    </button>
                                    <button type="button" onclick="jQuery('#dpProEventCalendar_date_range_end').val('');">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/clear.png' ); ?>" alt="Clear" title="Clear">
                                    </button>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select the date range.(optional)','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Hide Old Dates','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="hide_old_dates" id="dpProEventCalendar_hide_old_dates" class="checkbox" <?php if($hide_old_dates) {?>checked="checked" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Hide old dates in calendar view.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Limit Time in daily View','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="number" name="limit_time_start" id="dpProEventCalendar_limit_time_start" style="width: 60px;" maxlength="2" min="0" max="23" value="<?php echo $limit_time_start?>" />:00 hs /
                                    &nbsp;
                                    <input type="number" name="limit_time_end" id="dpProEventCalendar_limit_time_end" style="width: 60px;" maxlength="2" min="0" max="23" value="<?php echo $limit_time_end?>" />:00 hs
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set a range of time to display in the daily view.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('First Day','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <select name="first_day" id="dpProEventCalendar_first_day" class="large-text">
                                    	<option value="0" <?php if($first_day == "0") { echo 'selected="selected"'; }?>><?php _e('Sunday','dpProEventCalendar'); ?></option>
                                        <option value="1" <?php if($first_day == "1") { echo 'selected="selected"'; }?>><?php _e('Monday','dpProEventCalendar'); ?></option>
                                    </select>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select the first day to display in the calendar','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox no_border">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show Monthly/Daily Buttons','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_view_buttons" class="checkbox" id="dpProEventCalendar_show_view_buttons" value="1" <?php if($show_view_buttons) {?>checked="checked" <?php }?> />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set if Show/Hide the Monthly/Daily Buttons.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    
                </div>
                
                <h2 class="subtitle accordion_title" onclick="showAccordion('div_display_settings');"><?php _e('Display Settings','dpProEventCalendar'); ?></h2>
                
                <div id="div_display_settings" style="display: none;">
                	<div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Skin','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <select name="skin" id="dpProEventCalendar_skin" class="large-text">
                                    	<option value="light" <?php if($skin == 'light') { echo 'selected="selected"'; }?>><?php _e('Light','dpProEventCalendar'); ?></option>
                                        <option value="dark" <?php if($skin == 'dark') { echo 'selected="selected"'; }?>><?php _e('Dark','dpProEventCalendar'); ?></option>
                                    </select>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select the skin theme','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show Time','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_time" class="checkbox" id="dpProEventCalendar_show_time" value="1" <?php if($show_time) {?>checked="checked" <?php }?> onclick="toggleFormat();" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set if Show/Hide the events time.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox" id="div_format_ampm" style="display:none;">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Hour Format AM/PM','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="format_ampm" id="dpProEventCalendar_format_ampm" class="checkbox" <?php if($format_ampm) {?> checked="checked" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set the hour format to AM/PM, if disabled the format will be 24 hours','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show Search','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_search" class="checkbox" id="dpProEventCalendar_show_search" value="1" <?php if($show_search) {?>checked="checked" <?php }?> />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set if Show/Hide the search input.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show Category Filter','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_category_filter" class="checkbox" id="dpProEventCalendar_show_category_filter" value="1" <?php if($show_category_filter) {?>checked="checked" <?php }?>  onclick="toggleFormatCategories();" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Show/Hide the categories dropdown.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox" id="div_category_filter" style="display:none;">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Categories to display','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <select name="category_filter_include[]" id="dpProEventCalendar_category_filter_include" multiple="multiple">
                                    	<option value="" <?php if(empty($category_filter_include)) {?>selected="selected"<?php }?>><?php _e('All','dpContentGallery'); ?></option>
										<?php 
                                          $categories = get_categories('taxonomy=pec_events_category&hide_empty=0'); 
                                          foreach ($categories as $category) {
                                            $option = '<option value="'.$category->term_id.'" ';
											if(in_array($category->term_id, $category_filter_include)) {
												$option .= 'selected="selected"';
											}
											$option .= '>';
                                            $option .= $category->cat_name;
                                            $option .= '</option>';
                                            echo $option;
                                          }
                                         ?>
                                    </select>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select specific categories to display. To select multiple categories, keep pressing ctrl.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show X in dates with events?','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_x" class="checkbox" id="dpProEventCalendar_show_x" value="1" <?php if($show_x) {?>checked="checked" <?php }?> />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set if Show a X instead of the number of events in a date.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show Events Preview?','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_preview" class="checkbox" id="dpProEventCalendar_show_preview" value="1" <?php if($show_preview) {?>checked="checked" <?php }?> />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Display a list of event in a day on mouse over','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show References Button?','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_references" class="checkbox" id="dpProEventCalendar_show_references" value="1" <?php if($show_references) {?>checked="checked" <?php }?> />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Display the references button','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Display the Event Author','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_author" class="checkbox" id="dpProEventCalendar_show_author" value="1" <?php if($show_author) {?>checked="checked" <?php }?> />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Display the event author','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Current Date Color','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <div id="currentDate_colorSelector" class="colorSelector"><div style="background-color: <?php echo $current_date_color?>"></div></div>
                                    <input type="hidden" name="current_date_color" id="dpProEventCalendar_current_date_color" value="<?php echo $current_date_color?>" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set the Current date color.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select no_border">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Width','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="width" id="dpProEventCalendar_width" maxlength="4" style="width:50px;" class="large-text" value="<?php echo $width?>" /> 
                                    <select name="width_unity" id="dpProEventCalendar_width_unity" style="width:60px;" class="large-text">
                                        <option value="px" <?php if($width_unity == 'px') {?> selected="selected" <?php }?>>px</option>
                                        <option value="%" <?php if($width_unity == '%') {?> selected="selected" <?php }?>>%</option>
                                    </select>
                                    <br>
                                </div>
                                <div class="desc" style="width: 400px;"><?php _e('Set the width of the calendar','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                
                <h2 class="subtitle accordion_title" onclick="showAccordion('div_booking');"><?php _e('Booking','dpProEventCalendar'); ?></h2>

                <div id="div_booking" style="display: none;">
                
                    <div class="errorCustom"><p><?php _e('Notice: This feature requires the <a href="http://codecanyon.net/item/wordpress-pro-event-calendar/2485867" target="_blank">
Wordpress Pro Event Calendar plugin</a>.','dpProEventCalendar'); ?></p></div>

                </div>
                
                <h2 class="subtitle accordion_title" onclick="showAccordion('div_translations');"><?php _e('Translations / Multi Language','dpProEventCalendar'); ?></h2>
                
                <div id="div_translations" style="display: none;">
                	
                    <div id="div_translations_ml">
                    	<div class="option option-select">
                            <div class="option-inner">
                            	<div class="desc"><?php _e('Create PO files in the /languages/ folder to translate the plugin texts. You can use the free software <a href="http://poedit.net/" target="_blank">Po Edit</a>','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
               </div>
               
               <h2 class="subtitle accordion_title" onclick="showAccordion('div_cache');"><?php _e('Cache','dpProEventCalendar'); ?></h2>
                
                <div id="div_cache" style="display: none;">
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Active Cache','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="cache_active" id="dpProEventCalendar_cache_active" class="checkbox" <?php if($cache_active) {?>checked="checked" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('On/Off the cache feature for this calendar. The cache will be cleared every time you edit the calendar settings and when you add / edit an event.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
               
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
                        <input type="button" class="button" value="<?php _e('Back') ?>" onclick="history.back();" />
                    </p>
                </form>
                <script type="text/javascript">
					toggleFormat();
					toggleTranslations();
					toggleFormatCategories();
				</script>
            </div>
        </div>
    </div>
        <?php $dpProEventCalendar_class->output(true);?>
        <?php }?>
	 <!--end of poststuff --> 
	
	
	</div> <!--end of float wrap -->
    <div class="clear"></div>
	

	<?php	
}
?>