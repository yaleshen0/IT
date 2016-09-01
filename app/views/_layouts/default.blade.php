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
  <link rel="stylesheet" href="../minified/themes/default.min.css" type="text/css" media="all" />
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  
  
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css"/>  
 
</head>  
<body>  
<header class="am-topbar am-topbar-fixed-top">  
  <div class="am-container">  
    <h1 class="am-topbar-brand">  
      <a href="#"></a>  
    </h1>  
    @include('_layouts.nav')  
  </div>  
</header>  
  
<div class="am-g am-g-fixed">  
  <div class="am-u-sm-12">  
      <h1>Publish Article</h1>  
      <hr/>    
    {{ Form::open(array('url' => '/forum/save', 'class' => 'am-form')) }}  
        <div class="am-form-group">  
          <label for="title">Title</label>  
          <input id="title" name="title" type="text" value="{{ Input::old('title') }}"/>  
        </div>  
        <div class="am-form-group">  
          <label for="content"></label>  
          <textarea id="content" name="content" rows="20">{{ Input::old('content') }}</textarea>   
        </div>  

        <p><button type="submit" class="am-btn am-btn-success"><span class="am-icon-send"></span> Publish</button></p>  
    {{ Form::close() }}  
  </div>  
</div>  
  
@include('_layouts.footer')  
<!-- Include the editors JS -->
<script type="text/javascript" src="../minified/jquery.sceditor.bbcode.min.js"></script>
<script src="http://labfile.oss.aliyuncs.com/amazeui/2.2.1/js/amazeui.min.js"></script>  
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script>  
  $(function() {  
      $('#preview').on('click', function() {  
          $('.am-popup-title').text($('#title').val());  
          $.post('preview', {'content': $('#content').val()}, function(data, status) {  
            $('.am-popup-bd').html(data);  
          });  
          $('#preview-popup').modal();  
      });  
  }); 
  $(function() {
    $("textarea").sceditor({
      plugins: "bbcode",
      style: "minified/jquery.sceditor.default.min.css"
    });
    window.sceditorInstance = $("textarea").sceditor("instance");
  }); 
</script>
</body>  
</html>  