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
  {{HTML::style('minified/themes/default.min.css')}} 
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  
  
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css"/>  
 
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
      <input type="button" value="BACK" onclick="location.href='../../../forum/index'" style="position:absolute; left:0px; top:0px; height:100%"/>
    </nav> 

<article class="am-article" style="margin-top: 30px;">  
  <div class="am-g am-g-fixed">  
      <div class="am-u-sm-12">  
        <br/>  
        <div class="am-article-hd">  
          <h1 class="am-article-title">{{$article['title']}}</h1>  
          <label>Tags</label>
          @if(isset($article['tags']))
          @foreach($article['tags'] as $key=>$value)
            <input type="button" value="{{$value}}" disabled/>
          @endforeach 
          @endif
          <p class="am-article-meta">Author: <a href="#" style="cursor: pointer;">{{ $article['auth']}}</a> Datetime: {{ $article['create_time'] }}</p>  
        </div>  
        <div class="am-article-bd"><b>Contents:</b>:
          <p>{{ $article['content']}}</p>  
        </div>  
        <br/>  
        <div class="images"> <b>Attached Images</b>:<br/>
          @if(isset($article['images']))
          @foreach($article['images'] as $key=>$value)
          <?php $v = trim($value,'public');?>
            <!-- <a href="{{URL::to($v)}}">{{$value}}</a><br/> -->
            <img src="{{URL::to($v)}}"/>
          @endforeach
          @endif
        </div>
      </div>  
  </div>  
</article>  
  
@include('_layouts.footer')  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>