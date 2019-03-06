$(function () {
    var timeout;
    function refreshPreview() {
        if(typeof timeout !== 'undefined') {
            clearTimeout(timeout);
        }
        timeout = setTimeout(function(){
            var data = $('form[name="lab"]').serialize();
            $.post(BASE_URL + 'lab/live-preview', data)
                .done(function (html) {
                    $('#lab-preview').contents().find('html').html(html)
                });
        }, 500);

    }

    console.log('test');

    $('#lab_js,#lab_html,#lab_css,#lab_php').change(refreshPreview).on('input', refreshPreview);
});