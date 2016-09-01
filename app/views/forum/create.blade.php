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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.3/themes/base/jquery-ui.min.css">
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css"/>  
  {{HTML::style('css/font.css')}}
</head>  
<body>  


<nav class="navbar navbar-inverse navbar-static-top">

      <div class="container" style="display: absolute; padding-left: 30px;">
        <div class="navbar-header" >
          <a class="navbar-brand" href="{{URL::to('tickets/index')}}">Tickets&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('forum/index')}}">Forum&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('statistic/index')}}">Statistic</a>
        </div>
      </div><!-- /.container -->
      <input type="button" value="BACK" onclick="location.href='../forum/index'" style="position:absolute; left:0px; top:0px; height:100%"/>
    </nav><!-- /.navbar -->

<div class="am-g am-g-fixed">  
  <div class="am-u-sm-12">  
      <h1>Publish Article</h1>
      <hr/>    
    {{ Form::open(array('url' => '/forum/save', 'files' =>true, 'class' => 'am-form')) }}  
        <div class="am-form-group">  
          <label for="title">Title</label>
          <input type="button" value="New Tag" class="newTag" id="newTag"/>
          <div class="adding" name="adding" for="adding" id="adding"></div>
          <input id="title" name="title" type="text" value="{{ Input::old('title') }}"/>  
        </div>  
        <div class="am-form-group">  
          <label for="content"></label>  
          <textarea id="content" name="content" rows="20">{{ Input::old('content') }}</textarea>   
        </div>  

        <p><button type="submit" class="am-btn am-btn-success"><span class="am-icon-send"></span> Publish</button></p>  
        <!-- upload image -->
         <!-- <form action="" id="imgForm" value="" method="post" enctype="multipart/form-data"> -->
         <!-- <input type="file" id="file" name="img"/>
         <input type="submit" id="upload" value="Upload"/> -->
        <!-- </form> -->
        <!-- {{ Form::file('img') }} -->
        <!-- <input type="file" multiple="multiple" class="multi with-preview"/> -->
        {{Form::file('files[]', array('multiple'=>true, 'class'=>'multi with-preview'))}}
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
<script src="http://labfile.oss.aliyuncs.com/amazeui/2.2.1/js/amazeui.min.js"></script>  
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!-- jquery multi files plugin -->
{{HTML::script('packages/multifile/jQuery.MultiFile.min.js')}}
<script type="text/javascript">
$(document).ready(function(){
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
              var text = $('.addText').val();
              // console.log(text);
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
      $(this).closest('div').remove();
      var fields = $('.tags');
      // console.log($fields);
      var count = 1;
      $.each(fields, function(){
        $(this).attr({name: 'div['+count+']',
                      id: 'div['+count+']'});
        $(this).find('input').attr({id: 'tag['+count+']',
                                    name: 'tag['+count+']'});
        count++;
      });
      tagId--;
    });
});
</script>
</body>  
</html>  