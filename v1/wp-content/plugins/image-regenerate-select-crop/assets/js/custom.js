function sirsc_send_ajax_post_element(url, callback_action, elem, target) {
  var data = jQuery('#' + elem + ' :input').serializeArray();
  data.push({'name': 'callback', 'value': callback_action});
  var $t = jQuery('#' + target);
  if ($t.size()) {
    $t.prepend('<div class="spinner inline"></div>');
  }

  var post_data = {
    action: url, // This is required so WordPress knows which func to use
    'sirsc_data': data // Post any variables you want here
  };
  jQuery.post(
    ajaxurl,
    post_data,
    function (response) {
      if (response && $t.size()) {
        $t.html(response);
      }
    }
  );
}

function sirsc_show_ajax_action(callback_action, elem, target) {
  sirsc_send_ajax_post_element('sirsc_show_actions_result', callback_action, elem, target);
}

jQuery.fn.sirsc_center = function (ch) {
  var max_diff = 100;
  var max_padd = 50;
  this.css('position', 'fixed');
  var windowH = jQuery(window).height();
  var currentH = this.outerHeight();
  if (currentH >= parseInt(windowH - max_diff)) {
    this.css('max-height', parseInt(windowH - max_diff) + 'px');
    this.css('height', parseInt(windowH - max_diff) + 'px');

    ch.css('max-height', parseInt(windowH - max_diff - max_padd) + 'px');
    ch.css('height', parseInt(windowH - max_diff - max_padd) + 'px');
    ch.css('overflow', 'scroll');
    ch.css('overflow-x', 'hidden');

    this.css('top', Math.ceil(max_diff / 2));
  } else {
    this.css('top', Math.ceil(( jQuery(window).height() - this.outerHeight() - max_padd ) / 2));
  }
  this.css('left', Math.ceil(jQuery(window).width() / 2) - (this.outerWidth() / 2));
  jQuery('body').css('position', '');
  return this;
}

function sirsc_arrange_center_element(el) {
  var ch = jQuery(el + ' .inside');
  jQuery(el).sirsc_center(ch);
  jQuery(window).resize(function () {
    jQuery(el).sirsc_center(ch);
  });
}

function sirsc_toggle_info(el) {
  jQuery(el).slideToggle();
}

function sirsc_load_post_type(el, url) {
  jQuery('#main_settings_block').hide();
  window.location = url + '&_sirsc_post_types=' + el.value;
}

function sirsc_finish_regenerate(image_size_name) {
  jQuery('#_sisrsc_regenerate_image_size_name_page' + image_size_name).val('0');
  jQuery('#_sirsc_regenerate_initiated_for_' + image_size_name + '_result').html('');
	jQuery('#_sirsc_regenerate_initiated_for_' + image_size_name + '_result').hide();
}

function sirsc_continue_regenerate(image_size_name, next) {
  sirsc_arrange_center_element('.sirsc_image-size-selection-box');
  jQuery('#_sisrsc_regenerate_image_size_name_page' + image_size_name).val(next);
  setTimeout( function() {
    sirsc_show_ajax_action('ajax_regenerate_image_sizes_on_request', '_sirsc_regenerate_initiated_for_' + image_size_name, '_sirsc_regenerate_initiated_for_' + image_size_name + '_result');
  }, 250);
}

function sirsc_finish_cleanup(image_size_name) {
  jQuery('#_sisrsc_image_size_name_page' + image_size_name).val('0');
  jQuery('#_sirsc_cleanup_initiated_for_' + image_size_name + '_result').html('');
}

function sirsc_continue_cleanup(image_size_name, next) {
  sirsc_arrange_center_element('.sirsc_image-size-selection-box');
  jQuery('#_sisrsc_image_size_name_page' + image_size_name).val(next);
  setTimeout( function() {
    sirsc_show_ajax_action('ajax_cleanup_image_sizes_on_request', '_sirsc_cleanup_initiated_for_' + image_size_name, '_sirsc_cleanup_initiated_for_' + image_size_name + '_result');
  }, 250);
}

function sirsc_initiate_cleanup(image_size_name) {
  if (confirm(SIRSC_settings.confirm_cleanup + '\n\n' + SIRSC_settings.time_warning + '\n' + SIRSC_settings.irreversible_operation)) {
    sirsc_show_ajax_action('ajax_cleanup_image_sizes_on_request', '_sirsc_cleanup_initiated_for_' + image_size_name, '_sirsc_cleanup_initiated_for_' + image_size_name + '_result');
  }
}

function sirsc_initiate_regenerate(image_size_name) {
  if (confirm(SIRSC_settings.confirm_regenerate + '\n\n' + SIRSC_settings.time_warning + '\n' + SIRSC_settings.irreversible_operation)) {
    jQuery('#_sirsc_regenerate_initiated_for_' + image_size_name + '_result').html('');
    sirsc_show_ajax_action('ajax_regenerate_image_sizes_on_request', '_sirsc_regenerate_initiated_for_' + image_size_name, '_sirsc_regenerate_initiated_for_' + image_size_name + '_result');
    jQuery('#_sirsc_regenerate_initiated_for_' + image_size_name + '_result').show();
  }
}

function sirsc_spinner_off(id) {
  jQuery('#sirsc_recordsArray_' + id + '_result spinner').removeClass('off');
}

function sirsc_open_details(id) {
  sirsc_spinner_off(id);
  sirsc_show_ajax_action('ajax_show_available_sizes', 'sirsc_recordsArray_' + id, 'sirsc_recordsArray_' + id + '_result');
}

function sirsc_start_regenerate(id) {
  sirsc_spinner_off(id);
  sirsc_show_ajax_action('ajax_process_image_sizes_on_request', 'sirsc_recordsArray_' + id, 'sirsc_recordsArray_' + id + '_result');
}

function sirsc_crop_position(id) {
  sirsc_spinner_off(id);
  sirsc_show_ajax_action('ajax_process_image_sizes_on_request', 'sirsc_recordsArray_' + id, 'sirsc_recordsArray_' + id + '_result');
}

function sirsc_clear_result(id) {
  jQuery('#sirsc_recordsArray_' + id + '_result').html('');
}

function sirsc_thumbnail_details(id, size, src, w, h, crop) {
  jQuery('#idsrc' + id + size + '').html('<img src="' + src + '" /><div class="sirsc_clearAll"></div>' + SIRSC_settings.resolution + ': <b>' + w + '</b>x<b>' + h + '</b>px');
  jQuery('#idsrc' + id + size + '-url').html('<a href="' + src + '" target="_blank"><div class="dashicons dashicons-admin-links"></div></a>');
  if (crop != '') {
    jQuery('#sirsc_recordsArray_' + id + size + ' .sirsc_image-action-column').html(crop);
  }
}

function sirsc_autosubmit() {
  jQuery('#sirsc_settings_frm #sirsc-settings-submit').trigger('click');
}

jQuery(document).ready(function () {
  function sirsc_hide_updated_response() {
    jQuery('.sirsc_successfullysaved').hide();
  }
  setInterval(sirsc_hide_updated_response, 3000);
});
