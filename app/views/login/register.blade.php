<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	  <title>注册</title>
	<!-- Bootstrap core CSS -->
    <link href="css/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css\assets\css\ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css\css\signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="css/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="padding: 100px 0 0 100px;">

	
    <div class="container ">
      
    <header style="margin-bottom: 5%; margin-bottom: 10%;">
      <h1 style="padding-left:35%;">IT维护部后台管理系统</h1>
    </header>
       {{Form::open( array('url' => '/tickets')) }} 
    <form class="form-signin" >
         <!-- @if (Session::has('message'))
        <div style="margin-left: 35%; width:250px; font-size: 20px;" class="alert alert-danger" >
          <p>{{ Session::get('message') }}</p>
        </div>
        @endif -->
		<p style="font-size:18px; margin-bottom: 1%; margin-left: 35%;">
		{{Form::label('username', '用户名')}}  <span style="padding-left: 72px;">{{Form::text('username')}}</span>@if($errors->has('username'))<span style="color:red;">required</span> @endif
		</p>
		<p style="font-size:18px; margin-bottom: 1%; margin-left: 35%;">
		{{Form::label('password', '密码')}} <span style="padding-left: 90px;">{{Form::password('password')}}</span>@if($errors->has('password'))<span style="color:red;">required</span> @endif
		</p>

    <p style="font-size:18px; margin-left: 35%;">
    {{Form::label('checkpassword', '重复确认密码')}} <span style="padding-left: 18px;">{{Form::password('checkpassword')}}</span>@if($errors->has('checkpassword'))<span style="color:red;">required</span> @endif
    </p>

		<!-- <input type="submit" class="btn btn-default btn-lg center-block" value="登陆"/> -->
		<p style="font-size:18px; margin-bottom: 1%; margin-left: 35%;">
		<button class="btn btn-primary btn-lg center-lock" type="button">注册</button> 
    <button class="btn btn-danger btn-lg center-lock" type="button">取消</button> 
		
		</p>
<!-- 		<p style="font-size:18px; margin-left: 35%;">
		<span>若没有账号请注册</span>
		<br>
		<button class="btn btn-primary  center-lock" type="button">注册</button> 
		</p> -->
      </form>
      
	  {{ Form::close() }}	
</body>
</html>