$(function(){
    if($('.redactor').length>0){
        editor_config.selector = ".redactor";
        tinymce.init(editor_config);
    }


    try{
        if($('textarea[name="css"]').length>0){
            var editorCss = ace.edit("css");
            var textareaCss = $('textarea[name="css"]').hide();
            editorCss.setTheme("ace/theme/dreamweaver");
            editorCss.getSession().setValue(textareaCss.val());
            editorCss.getSession().on('change', function(){
                textareaCss.val(editorCss.getSession().getValue());
            });
        }

        if($('textarea[name="header"]').length>0){
            var editorHeader = ace.edit("header");
            var textareaHeader = $('textarea[name="header"]').hide();
            editorHeader.setTheme("ace/theme/dreamweaver");
            editorHeader.getSession().setValue(textareaHeader.val());
            editorHeader.getSession().on('change', function(){
                textareaHeader.val(editorHeader.getSession().getValue());
            });
        }

        if($('textarea[name="footer"]').length>0){
            var editorFooter = ace.edit("footer");
            var textareaFooter = $('textarea[name="footer"]').hide();
            editorFooter.setTheme("ace/theme/dreamweaver");
            editorFooter.getSession().setValue(textareaFooter.val());
            editorFooter.getSession().on('change', function(){
                textareaFooter.val(editorFooter.getSession().getValue());
            });
        }
    }catch(e){
        console.log("Ace не подключен");
        console.log(e);
    }
})
