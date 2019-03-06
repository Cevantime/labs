$(function () {
        var timeout;

        function refreshPreview(lang) {
            console.log(lang);
            if (typeof timeout !== 'undefined') {
                clearTimeout(timeout);
            }
            timeout = setTimeout(function () {

                var editor = editors[lang];
                $('#lab_' + lang).val(editor.getSession().getValue());

                var data = $('form[name="lab"]').serialize();
                $.post(BASE_URL + 'lab/live-preview', data)
                    .done(function (html) {
                        $('#lab-preview')[0].srcdoc = html;
                    });
            }, 500);

        }

        var editors = {};
        var supportAssoc = {
            'html': 'ace/mode/html',
            'js': 'ace/mode/javascript',
            'css': 'ace/mode/css',
            'php': 'ace/mode/php'
        };

        $("#lab-preview").sticky({topSpacing: 60});

        for (var lang in supportAssoc) {
            editors[lang] = ace.edit('editor-' + lang, {
                theme : "ace/theme/tomorrow_night_eighties",
                mode: supportAssoc[lang],
                maxLines: 30,
                minLines: 7,
                wrap: true,
                autoScrollEditorIntoView: true
            });
            editors[lang].getSession().setValue($('#lab_' + lang).hide().val());
            const l = lang;
            editors[lang].getSession().on('change', function() {refreshPreview(l)});

        }
    }
);