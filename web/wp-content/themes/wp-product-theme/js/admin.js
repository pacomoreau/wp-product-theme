jQuery(document).ready(function($) {

  // Upload files
  var file_frame;

  jQuery('.wdg_img_del').live('click', function(event) {
    $id = '';
    var classList = jQuery(this).attr('class').split(/\s+/);
    jQuery.each(classList, function(index, item) {
      if (item !== 'wdg_img_del' && item !== 'button')
        $id = '.' + item;
    });
    jQuery('.wdg_img_file' + $id).val('');
    jQuery('.wdg_img_src' + $id).attr('src','').hide();
    jQuery('.wdg_img_del' + $id).hide();
  });

  jQuery('.wdg_img_add').live('click', function(event) {
    event.preventDefault();
    $id = '';
    var classList = jQuery(this).attr('class').split(/\s+/);
    jQuery.each(classList, function(index, item) {
      if (item !== 'wdg_img_add' && item !== 'button')
        $id = '.' + item;
    });

    // If the media frame already exists, reopen it
    if (file_frame) {
      file_frame.open();
      return;
    }

    // Create the media frame
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery(this).data('uploader_title'),
      library: { // remove these to show all
        type: 'image'
      },
      button: {
        text: jQuery(this).data('uploader_button_text')
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an file is selected, run a callback
    file_frame.on('select', function() {
      // We set multiple to false so only get one file from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();

      // Get media
      jQuery('.wdg_img_file' + $id).val(attachment.id);
      jQuery('.wdg_img_src' + $id).attr('src', attachment.url).show();
      jQuery('.wdg_img_del' + $id).show();
    });

    // Finally, open the modal
    file_frame.open();
  });

});
