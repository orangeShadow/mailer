$(function(){
    if($('.redactor').length>0){
        editor_config.selector = ".redactor";
        tinymce.init(editor_config);
    }

    $('#removeFile').click(function(){
        var id  = $(this).data('id');
        $.ajax({
            url:'/mailing/'+id+'/removeFile',
            method:"GET",
            success:function (data) {
                location.reload();
            }
        })
    });


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

    $(document).on('submit','#form-api',function(e){
        e.preventDefault();
        var o = {};
        $("#form-api :input").each(function(){
            if($(this).attr('name')=='groups[]' && $(this).is(":checked")){
                if(o["groups"]===undefined){
                    o["groups"] = [];
                }
                o["groups"].push($(this).val());
            }
            if($(this).attr('name')!='groups[]'){
                o[$(this).attr('name')] = $(this).val();
            }

        });

        $.post($(this).attr('action'),o,function(data){
            try{
                var res = JSON.parse(data);
                if(res.type=='group'){
                    $('#form-content').html(res.html);
                }else if(res.type=='complite'){
                    $('#form-api').html(res.html);
                }
                if(res.error==1){
                    alert(res.html);
                }
            }catch(e){

            }
        });
    });


    $('.remove-u-g').click(function(){
        var that = $(this);
        var el = {};
        el.id = that.attr('data-id');
        el.group_id = that.attr('data-group');
        $.post('/group/user_remove',el,function(data){
            if(data=="Y"){
                that.parents('tr').remove();
            }else{
                alert('Произошла ошибка');
            }
        });
    });
})
