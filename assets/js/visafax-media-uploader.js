jQuery(document).ready(function ($) {
    var mediaUploader;

    $('.visafax_upload_image_button').click(function (e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#visafax_image').val(attachment.id);
            $('#visafax_image_preview').html('<img src="' + attachment.url + '" style="max-width: 150px;" />');
        });
        mediaUploader.open();
    });
});
