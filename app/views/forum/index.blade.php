<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Forum</title>

    <!-- Bootstrap core CSS -->
    <link href="..\..\..\css\bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../../css/assets/js/ie10-viewport-bug-workaround.js" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../../css/assets/js/ie-emulation-modes-warning.js"></script>
    {{HTML::style('css/font.css')}}
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link  rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="{{URL::to('tickets/index')}}">Tickets&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('forum/index')}}">Forum&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('statistic/index')}}">Statistic</a>
        </div>
      </div><!-- /.container -->
    </nav><!-- /.navbar -->


<div class="container-fluid">
      <div class="row">

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 main">
          <span style="font-size: 34px; color:black;" class="page-header">Forum</span>
          <span style= "float:right; ">  
          <a href="{{ URL::to('/forum/create') }}"><button style="background-color: black; color: white;" class="btn btn-default center-lock" type="button">Create New</button></a>   
          </span>

          <!-- <div class="dropup">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Category
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
              <li><a href="#">Software</a></li>
              <li><a href="#">Hardware</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </div> -->
  
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Tag</th>
                  <th>Written By</th>
                  <th>Create Time</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($articles as $article)
                <tr>
                  <td><a href={{URL::to('/forum/article/'.$article['_id'].'/show')}}>{{$article['title']}}</a></td>
                  <td>
                  @if(isset($article['tags']))
                  @foreach($article['tags'] as $key=>$value)
                    {{$value}}
                  @endforeach
                  @endif
                  </td>
                  <td>{{$article['auth']}}</td>
                  <td>{{$article['create_time']}}</td>
                  <td>  
                      <a href={{URL::to('/forum/article/'.$article['_id'].'/edit')}} class="btn btn-info"><span class="am-icon-pencil"></span> Edit</a>

                      <a href={{URL::to('/forum/article/'.$article['_id'].'/delete')}} class="btn btn-danger"><span class="am-icon-pencil"></span> Delete</a>

                      <!-- { Form::open(array('url' => 'article/' . $article->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }}  
                        <button type="button" class="am-btn am-btn-xs am-btn-danger" id="delete{{ $article->id }}"><span class="am-icon-remove"></span> Delete</button>  
                      {{ Form::close() }}   -->
                 </td>
                </tr>
                @endforeach

              </tbody>
            </table>
        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ==================================================
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><script>')</script>
    <script src="..\..\..\css\bootstrap\css\bootstrap.min.css"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../../css/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>