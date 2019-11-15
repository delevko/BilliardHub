function readURL(input, class_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(class_id).css('background-image', 'url('+e.target.result +')');
            $(class_id).hide();
            $(class_id).fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#playerImg_upload").change(function() {
    readURL(this, '#playerImg_preview');
});
$("#clubImg_upload").change(function() {
    readURL(this, '#clubImg_preview');
});
$("#settingsImg_upload").change(function() {
    readURL(this, '#settingsImg_preview');
});

