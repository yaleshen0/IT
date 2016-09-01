<!DOCTYPE html>  
<html>  
<head lang="zh">  
  <meta charset="UTF-8"/>  
  <title></title>  
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>  
  <meta name="viewport"  
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">  
  <meta name="format-detection" content="telephone=no"/>  
  <meta name="renderer" content="webkit"/>  
  <meta http-equiv="Cache-Control" content="no-siteapp"/>  
  <!-- Latest compiled and minified CSS -->
  {{HTML::style('minified/themes/default.min.css')}} 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.3/themes/base/jquery-ui.min.css">
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css"/>  
  {{HTML::style('css/font.css')}}
</head>  
<body>  
<nav class="navbar navbar-inverse navbar-static-top" style="position: fixed; width: 100%;">

      <div class="container" style="display: absolute; padding-left: 30px;">
        <div class="navbar-header" >
          <a class="navbar-brand" href="{{URL::to('tickets/index')}}">Tickets&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('forum/index')}}">Forum&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('statistic/index')}}">Statistic</a>
        </div>
      </div><!-- /.container -->
      <input type="button" value="BACK" onclick="location.href='../../../forum/index'" style="position:absolute; left:0px; top:0px; height:100%"/>
    </nav> 
<div class="am-g am-g-fixed">  
  <div class="am-u-sm-12">  
      <h1>Edit Article</h1>  
      <hr/> 
    {{ Form::open(array('url' => '/forum/article/'.$article['_id'].'/editsave', 'files' =>true, 'class' => 'am-form')) }}  
        <div class="am-form-group">  
        {{ Form::label('title', 'Title') }} 
        <input type="button" value="New Tag" class="newTag" id="newTag"/>
        <div class="adding" name="adding" for="adding" id="adding">
          @if($article['tags'])
          <?php $i=1 ?>
            @foreach($article['tags'] as $key=>$value)
            <div class="tags" name="div[{{$i}}]" id="div[{{$i}}]" style="display:inline;">
              <input type="text" id="tag[{{$i}}]" name="tag[{{$i}}]" style="width:100px; display:inline;" value="{{$value}}" /><span class="am-icon-remove"></span>
            </div>
          <?php $i++ ?>
            @endforeach
          @endif
        </div>
        {{ Form::text('title', $article['title'], array('class'=>'am-form'))  }}  
        </div>  
        <div class="am-form-group">  
          {{ Form::label('content', 'Content') }}  
          {{ Form::textarea('content',  $article['content'], array('class'=>'am-form', 'rows' => '20')) }}    
        </div>   
        <p>
          <button type="submit" class="am-btn am-btn-success">  
          <span class="am-icon-pencil"></span> Modify</button>  
        </p>  
       <!-- upload more images -->
        {{Form::file('files[]', array('multiple'=>true, 'class'=>'multi with-preview'))}}

        @if(isset($article['images']))

        <div class="upDown" name="divImg" id="divImg">
        <?php $i = 0;?>
        @foreach($article['images'] as $key=>$value)
        <?php $v = trim($value,'public');?>
        <?php $pic = trim($v, '/Images')?>
        <div id="i[{{$i}}]" class="images">
            <input type="hidden" style="background-image: url('{{URL::to($v)}}');" id="Img[{{$i}}]" name="Img_[{{$i}}][name]" value="{{$value}}"/>
            <input type="image" src="{{URL::to($v)}}" width="270" height="210" id="Img[{{$i}}]" name="Img_[{{$i}}][name]" value="{{$value}}"/>
            <span class="am-icon-remove am-icon-lg"></span>
         </div>   
        <?php $i++?>
        @endforeach
        </div>
        @endif
      <?php $i=0?>
      <div class="addTag" title="NEW TAG" hidden>
        <input type="text" class="addText" id="addText[{{$i}}]" placeholder="Type tag to add" />
      </div>
      <?php $i++?>
    {{ Form::close() }}  
  </div>  
</div>  
  
@include('_layouts.footer')  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<!-- <script type="text/javascript" src="../minified/jquery.sceditor.bbcode.min.js"></script> -->
<!-- Include the editors JS -->
<script src="http://labfile.oss.aliyuncs.com/amazeui/2.2.1/js/amazeui.min.js"></script>  
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{HTML::script('js/forum/edit.js')}}
{{HTML::script('packages/multifile/jQuery.MultiFile.min.js')}}
<script type="text/javascript">
  $(function() {  
      var tagId = {{$i}};

      $('#preview').on('click', function() {  
          $('.am-popup-title').text($('#title').val());  
          $.post('preview', {'content': $('#content').val()}, function(data, status) {  
            $('.am-popup-bd').html(data);  
          });  
          $('#preview-popup').modal();  
      });  
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
            var text = $('.addText').val();
            if(text != '' && text != undefined){
              var added = '<div class="tags" name="div['+tagId+']" id="div['+tagId+']" style="display:inline;"><input type="text" id="tag['+tagId+']" name="tag['+tagId+']" style="width:100px; display:inline;" value='+text+' /><span class="am-icon-remove"></span></div>';
              
              $('#adding').append(added);
              $('.addText').val('');
              tagId++;
            } else{
              alert('不能为空');
            }
          }
      });

      $(document).on('click', '.am-icon-remove', function(){
        $(this).parent().remove();
        var fields = $('.images');
        // console.log($fields);
        var count = 0;
        $.each(fields, function(){
          $(this).attr({id: 'i['+count+']'});
          $(this).find('input[type=image]').attr({id: 'Img['+count+']',
                                                  name: 'Img_['+count+'][name]'});
          $(this).find('input[type=hidden]').attr({id: 'Img['+count+']',
                                                   name: 'Img_['+count+'][name]'});
          count++;
        });
        tagId--;
      });
  });  
</script>  
</body>
</html>