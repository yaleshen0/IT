(function () {
    $(document).on('submit', '#chatForm', function(){
        //text content
        var comment = $.trim($('#text').val());
        //time 
        var d = new Date();
        var YMDHMS = d.getFullYear() + "-" +(d.getMonth()+1) + "-" + d.getDate() + " " + 
        d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
        //define li
        var li = '<li class="cm">--- '+comment+'<span style="float:right;">'+YMDHMS+'</span></li>';
        // 当前ticket['_id']
        var id = $('.hidden').attr('id');
        if(comment != ''){
            $('#text').val('');
            $.post('/tickets/'+id+'/'+comment+'', {comment:comment, id:id}, function(data){
                $('.chatMessages').append(li);
            });
        }else{
            alert('不能为空');
        }
    });
    $(document).on('submit', '#noticeForm', function(){
        //text content
        var notice = $.trim($('#noticeText').val());
        //time 
        var d = new Date();
        var YMDHMS = d.getFullYear() + "-" +(d.getMonth()+1) + "-" + d.getDate() + " " + 
        d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
        //define li
        var li = '<li class="cm">--- '+notice+'<span style="float:right;">'+YMDHMS+'</span></li>';
        // 当前ticket['_id']
        var id = $('.hidden').attr('id');
        if(notice != ''){
            $('#noticeText').val('');
            $.post('/tickets/'+id+'+'+notice+'', {id:id, notice:notice}, function(data){
                $('.noticeMessages').append(li);
            });
        }else{
            alert('data missing');
        }
    });
    //轮询
    function fresh()
    {
        var id = $('.chatHeader').attr('value');
        $.ajaxSetup({
          headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        $.ajax({
            url:'/tickets/'+id+'/details',
            type: 'GET',
            success: function( data ){
                // window.location = window.location.href;
                $('.chatMessages').load('/tickets/'+id+'/details .chatMessages');
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
        setTimeout(function(){ 
            fresh(); 
        }, 5000);
    };
    // fresh();
}());