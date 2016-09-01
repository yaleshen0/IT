(function () {

    var tagId = 1;
    $('.newTag').on('click', function(){
        $('.addTag').dialog({
            autoOpen: true,
            modal: true,
            buttons:{
                "Add": addTag,
                Cancel: function(){
                    $(this).dialog("close");
                }
            }
        });

        function addTag(){
            var text = $('#addText').val();
            $('#addText').val('');
            var added = '<input type="text" id="tag['+tagId+']" name="tag['+tagId+']" style="width:100px; display:inline;" value='+text+' /><span class="am-icon-remove"></span>';
            
            $('#adding').append(added);
            $.post({
                // data: {tag: $}
            })
            tagId++;
        }
        $(document).on('click', '.am-icon-remove', function(){
            $(this).prev('input').remove();
            $(this).remove();
        });
    }); 

    $('#imgForm').submit(function(){
        // alert();
    }); 
}());