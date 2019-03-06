$(function () {
    var timeout;
    function refreshPreview() {
        if(typeof timeout !== 'undefined') {
            clearTimeout(timeout);
        }
        timeout = setTimeout(function(){
            for(var lang in editors) {
                if(editors.hasOwnProperty(lang)) {
                    var editor = editors[lang];
                    $('#lab_'+lang).val(editor.getSession().getValue());
                }
            }
            var data = $('form[name="lab"]').serialize();
            $.post(BASE_URL + 'lab/live-preview', data)
                .done(function (html) {
                    document.getElementById('lab-preview').src = "data:text/html;charset=utf-8," + escape(html);
                });
        }, 500);

    }

    var editors = {};

    ['html', 'js', 'css', 'php'].forEach(function(el){
       editors[el] = ace.edit('editor-' + el);

       editors[el].getSession().setValue($('#lab_'+el).hide().val());
       editors[el].getSession().on('change', refreshPreview);
    });

});