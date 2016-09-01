
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<title>登录</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body style="padding: 100px 0 0 100px;">

	
    <div class="container ">
      
    <header style="margin-bottom: 5%; margin-bottom: 10%;">
      <h1 style="padding-left:35%;">IT维护部后台管理系统</h1>
    </header>
  {{Form::open( array('url' => '/tickets/index'))}} 
    <form class="form-signin" >
         <!-- @if (Session::has('message'))
        <div style="margin-left: 35%; width:250px; font-size: 20px;" class="alert alert-danger" >
          <p>{{ Session::get('message') }}</p>
        </div>
        @endif -->
		<p style="font-size:18px; margin-bottom: 1%; margin-left: 35%;">
		{{Form::label('username', '用户名')}} {{Form::text('username')}}
		</p>
		<p style="font-size:18px; margin-left: 35%;">
		{{Form::label('password', '密码')}} <span style="padding-left: 18px;">{{Form::password('password')}}</span>
		</p>
		<!-- <input type="submit" class="btn btn-default btn-lg center-block" value="登陆"/> -->
		<input type="submit" class="btn btn-default btn-lg center-block" value="登陆" style="text-align: center;"></input>
		<br>
    </form>
   {{ Form::close() }}  
		<!-- <p style="font-size:18px; margin-left: 35%;">
		<span>若没有账号请注册</span>
		<br>
		<button class="btn btn-danger center-lock" type="button">注册</button> 
		</p> -->
      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>