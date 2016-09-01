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

    <title></title>
    {{HTML::style('css/statistic/index.css')}}
    {{HTML::style('css/font.css')}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-static-top" style="position: fixed; width: 100%;">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="{{URL::to('tickets/index')}}">Tickets&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('forum/index')}}">Forum&nbsp;</a>
          <a class="navbar-brand" href="{{URL::to('statistic/index')}}">Statistic</a>
        </div>
        </div>
      </div><!-- /.container -->
    </nav><!-- /.navbar -->


<div class="container-fluid" style="padding-top: 80px;">
      <div class="row">

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 main">
          <span style="font-size: 34px; color:black;" class="page-header"></span>
          <span style= "float:right; ">  
          </span>
  
          <!-- <div class="table-responsive">
            <table>
            <thead><h3 strong>员工统计</h3>
              <tr>
                <th></th>
                <th>Closed</th>
                <th>Referring</th>
                <th>Referred</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
              <tr>
                <td>{{$user['username']}}</td>
                <td>@if($user['username'] == 'YY')
                    {{$num_of_YY}}
                    @elseif($user['username'] == 'TT')
                    {{$num_of_TT}}
                    @elseif($user['username'] == 'BB')
                    {{$num_of_BB}}
                    @endif
                </td>
                <td>@if($user['username'] == 'YY')
                    {{$YY_refer}}
                    @elseif($user['username'] == 'TT')
                    {{$TT_refer}}
                    @elseif($user['username'] == 'BB')
                    {{$BB_refer}}
                    @endif
                </td>
                <td>@if($user['username'] == 'YY')
                    {{$YY_referred}}
                    @elseif($user['username'] == 'TT')
                    {{$TT_referred}}
                    @elseif($user['username'] == 'BB')
                    {{$BB_referred}}
                    @endif
                </td>
                <td></td>
              </tr>
            @endforeach
            </tbody>
           </table>
        </div> -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="{{URL::to('statistic/index')}}">Category</a></li>
            <li><a href="{{URL::to('statistic/employee')}}">Employee</a></li>
            <!-- <li><a href="#">Menu 2</a></li> -->
          </ul>
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Categories</th>
                <th>Opened</th>
                <th>Unopened</th>
                <th>Closed</th>
                <th>All</th>
                <th>APT(Average Processing Time)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>不能上网</td>
                <?php
                $openWifi = 0; $closeWifi = 0; $unopenWifi = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($wifi as $w){
                  //# of opened
                  if($w['bstatus']!='New' && $w['bstatus']!='Finished'){
                    $openWifi++;
                  }
                  if($w['bstatus']=='Finished'){
                    $closeWifi++;
                  }
                  if($w['bstatus']=='New'){
                    $unopenWifi++;
                  }
                  if($w['used_time']!=''){
                    $used_time = $w['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closeWifi != 0){
                    $avg = $all/$closeWifi;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>

                <td>{{$openWifi}}</td>
                <td>{{$unopenWifi}}</td>
                <td>{{$closeWifi}}</td>
                <td>{{$openWifi + $unopenWifi + $closeWifi}}</td>
                <td>{{$gmdate}}</td>
              </tr>
              <tr>
                <td>QuickBook</td>
                <?php
                $openQB = 0; $closeQB = 0; $unopenQB = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($qb as $q){
                  //# of opened
                  if($q['bstatus']!='New' && $q['bstatus']!='Finished'){
                    $openQB++;
                  }
                  if($q['bstatus']=='Finished'){
                    $closeQB++;
                  }
                  if($q['bstatus']=='New'){
                    $unopenQB++;
                  }
                  if($q['used_time']!=''){
                    $used_time = $q['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closeQB != 0){
                    $avg = $all/$closeQB;
                    $gmdate = gmdate("H:i:s", $avg);
                  } 
                }
                ?>
                <td>{{$openQB}}</td>
                <td>{{$unopenQB}}</td>
                <td>{{$closeQB}}</td>
                <td>{{$openQB + $unopenQB + $closeQB}}</td>
                <td>{{$gmdate}}</td>
              </tr>
              <tr>
                <td>电话</td>
                <?php
                $openPhone = 0; $closePhone = 0; $unopenPhone = 0; $avg = 0; $all = 0;  $gmdate = gmdate("H:i:s", 0);
                foreach($phone as $p){
                  //# of opened
                  if($p['bstatus']!='New' && $p['bstatus']!='Finished'){
                    $openPhone++;
                  }
                  if($p['bstatus']=='Finished'){
                    $closePhone++;
                  }
                  if($p['bstatus']=='New'){
                    $unopenPhone++;
                  }
                  if($p['used_time']!=''){
                    $used_time = $p['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all =0;
                  }
                  if($closePhone != 0){
                    $avg = $all/$closePhone;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>
                <td>{{$openPhone}}</td>
                <td>{{$unopenPhone}}</td>
                <td>{{$closePhone}}</td>
                <td>{{$openPhone + $unopenPhone + $closePhone}}</td>
                <td>{{$gmdate}}</td>
              </tr>
              <tr>
                <td>Remote/PC</td>
                <?php
                $openRemp = 0; $closeRemp = 0; $unopenRemp = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($rempc as $rem){
                  //# of opened
                  if($rem['bstatus']!='New' && $rem['bstatus']!='Finished'){
                    $openRemp++;
                  }
                  if($rem['bstatus']=='Finished'){
                    $closeRemp++;
                  }
                  if($rem['bstatus']=='New'){
                    $unopenRemp++;
                  }
                  if($rem['used_time']!=''){
                    $used_time = $rem['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closeRemp != 0){
                    $avg = $all/$closeRemp;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?> 
                <td>{{$openRemp}}</td>
                <td>{{$unopenRemp}}</td>
                <td>{{$closeRemp}}</td>
                <td>{{$openRemp + $unopenRemp + $closeRemp}}</td>
                <td>{{$gmdate}}</td>
              </tr> 
                <tr>
                <td>EXCEL</td>
                <?php
                $openExcel = 0; $closeExcel = 0; $unopenExcel = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($excel as $e){
                  //# of opened
                  if($e['bstatus']!='New' && $e['bstatus']!='Finished'){
                    $openExcel++;
                  }
                  if($e['bstatus']=='Finished'){
                    $closeExcel++;
                  }
                  if($e['bstatus']=='New'){
                    $unopenExcel++;
                  }
                  if($e['used_time']!=''){
                    $used_time = $e['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all =0;
                  }
                  if($closeExcel != 0){
                    $avg = $all/$closeExcel;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>
                <td>{{$openExcel}}</td>
                <td>{{$unopenExcel}}</td>
                <td>{{$closeExcel}}</td>
                <td>{{$openExcel + $unopenExcel + $closeExcel}}</td>
                <td>{{$gmdate}}</td>
              </tr>
              <tr>
                <td>无法登陆网站</td>
                <?php
                $openWebsite = 0; $closeWebsite = 0; $unopenWebsite = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($website as $web){
                  //# of opened
                  if($web['bstatus']!='New' && $web['bstatus']!='Finished'){
                    $openWebsite++;
                  }
                  if($web['bstatus']=='Finished'){
                    $closeWebsite++;
                  }
                  if($web['bstatus']=='New'){
                    $unopenWebsite++;
                  }
                  if($web['used_time']!=''){
                    $used_time = $web['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closeWebsite != 0){
                    $avg = $all/$closeWebsite;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>
                <td>{{$openWebsite}}</td>
                <td>{{$unopenWebsite}}</td>
                <td>{{$closeWebsite}}</td>
                <td>{{$openWebsite + $unopenWebsite + $closeWebsite}}</td>
                <td>{{$gmdate}}</td>
              </tr>
              <tr>
                <td>Email</td>
                <?php
                $openEmail = 0; $closeEmail = 0; $unopenEmail = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($email as $em){
                  //# of opened
                  if($em['bstatus']!='New' && $em['bstatus']!='Finished'){
                    $openEmail++;
                  }
                  if($em['bstatus']=='Finished'){
                    $closeEmail++;
                  }
                  if($em['bstatus']=='New'){
                    $unopenEmail++;
                  }
                  if(($em['used_time'])!=''){
                    $used_time = $em['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closeEmail != 0){
                    $avg = $all/$closeEmail;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>
                <td>{{$openEmail}}</td>
                <td>{{$unopenEmail}}</td>
                <td>{{$closeEmail}}</td>
                <td>{{$openEmail + $unopenEmail + $closeEmail}}</td>
                <td>{{$gmdate}}</td>
              </tr>
               <tr>
                <td>显示器问题</td>
                <?php
                $openMonitor = 0; $closeMonitor = 0; $unopenMonitor = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($monitor as $moni){
                  //# of opened
                  if($moni['bstatus']!='New' && $moni['bstatus']!='Finished'){
                    $openMonitor++;
                  }
                  if($moni['bstatus']=='Finished'){
                    $closeMonitor++;
                  }
                  if($moni['bstatus']=='New'){
                    $unopenMonitor++;
                  }
                  if($moni['used_time']!=''){
                    $used_time = $moni['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closeMonitor != 0){
                    $avg = $all/$closeMonitor;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>
                <td>{{$openMonitor}}</td>
                <td>{{$unopenMonitor}}</td>
                <td>{{$closeMonitor}}</td>
                <td>{{$openMonitor + $unopenMonitor + $closeMonitor}}</td>
                <td>{{$gmdate}}</td>
              </tr>
              <tr>
                <td>打印机问题</td>
                <?php
                $openPrinter = 0; $closePrinter = 0; $unopenPrinter = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($printer as $pri){
                  //# of opened
                  if($pri['bstatus']!='New' && $pri['bstatus']!='Finished'){
                    $openPrinter++;
                  }
                  if($pri['bstatus']=='Finished'){
                    $closePrinter++;
                  }
                  if($pri['bstatus']=='New'){
                    $unopenPrinter++;
                  }
                  if($pri['used_time']!=''){
                    $used_time = $pri['used_time'];
                    $seconds = 0;
                    $parts   = explode(':', $used_time);
                    

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closePrinter != 0){
                    $avg = $all/$closePrinter;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>
                <td>{{$openPrinter}}</td>
                <td>{{$unopenPrinter}}</td>
                <td>{{$closePrinter}}</td>
                <td>{{$openPrinter + $unopenPrinter + $closePrinter}}</td>
                <td>{{$gmdate}}</td>
              </tr>
              <tr>
                <td>其他</td>
                <?php
                $openOthers = 0; $closeOthers = 0; $unopenOthers = 0; $avg = 0; $all = 0; $gmdate = gmdate("H:i:s", 0);
                foreach($others as $other){
                  //# of opened
                  if($other['bstatus']!='New' && $other['bstatus']!='Finished'){
                    $openOthers++;
                  }
                  if($other['bstatus']=='Finished'){
                    $closeOthers++;
                  }
                  if($other['bstatus']=='New'){
                    $unopenOthers++;
                  }
                 if($other['used_time']!=''){
                  $used_time = $other['used_time'];
                  $seconds = 0;
                  $parts   = explode(':', $used_time);
                  

                    if (count($parts) > 2) {
                        $seconds += $parts[0] * 3600;
                    }
                    $seconds += $parts[1] * 60;
                    $seconds += $parts[2];
                    $all += $seconds;
                  } else{
                    $all = 0;
                  }
                  if($closeOthers != 0){
                    $avg = $all/$closeOthers;
                    $gmdate = gmdate("H:i:s", $avg);
                  }
                }
                ?>
                <td>{{$openOthers}}</td>
                <td>{{$unopenOthers}}</td>
                <td>{{$closeOthers}}</td>
                <td>{{$openOthers + $unopenOthers + $closeOthers}}</td>
                <td>{{$gmdate}}</td>
              </tr>
            </tbody>
          </table>
      </div>
      </div>
      <div class="row">
      <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 main">
         <canvas id="myChart" width="" height=""></canvas>
      </div>
</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.bundle.min.js"></script>
    <script type="text/javascript">
  //   $(window).on('beforeunload', function() {
  //     $(window).scrollTop(100); 
  // });
    //wifi
      var openWifi = <?php echo $openWifi?>;
      var unopenWifi = <?php echo $unopenWifi?>;
      var closeWifi = <?php echo $closeWifi?>;
      var allWifi = <?php echo $closeWifi + $unopenWifi + $openWifi?>;
    //quickbook
      var openQB = <?php echo $openQB ?>;
      var unopenQB = <?php echo $unopenQB ?>;
      var closeQB = <?php echo $closeQB ?>;
      var allQB = <?php echo $openQB + $unopenQB + $closeQB?>;
    //电话
      var openPhone = <?php echo $openPhone ?>;
      var unopenPhone = <?php echo $unopenPhone ?>;
      var closePhone = <?php echo $closePhone ?>;
      var allPhone = <?php echo $openPhone + $unopenPhone + $closePhone?>;
    //remote
      var openRemp = <?php echo $openRemp ?>;
      var unopenRemp = <?php echo $unopenRemp ?>;
      var closeRemp = <?php echo $closeRemp ?>;
      var allRemp = <?php echo $openRemp + $unopenRemp + $closeRemp?>;
    //EXCEL
      var openExcel = <?php echo $openExcel ?>;
      var unopenExcel = <?php echo $unopenExcel ?>;
      var closeExcel = <?php echo $closeExcel ?>;
      var allExcel = <?php echo $openExcel + $unopenExcel + $closeExcel?>;
    //website
      var openWebsite = <?php echo $openWebsite ?>;
      var unopenWebsite = <?php echo $unopenWebsite ?>;
      var closeWebsite = <?php echo $unopenWebsite ?>;
      var allWebsite = <?php echo $openWebsite + $unopenWebsite + $unopenWebsite?>;
    //Email
      var openEmail = <?php echo $openEmail ?>;
      var unopenEmail = <?php echo $unopenEmail ?>;
      var closeEmail = <?php echo $closeEmail ?>;
      var allEmail = <?php echo $openEmail + $unopenEmail + $closeEmail?>;
    //monitor
      var openMonitor = <?php echo $openMonitor ?>;
      var unopenMonitor = <?php echo $unopenMonitor ?>;
      var closeMonitor = <?php echo $closeMonitor ?>;
      var allMonitor = <?php echo $openMonitor + $unopenMonitor + $closeMonitor?>;
    //printer
      var openPrinter = <?php echo $openPrinter ?>;
      var unopenPrinter = <?php echo $unopenPrinter ?>;
      var closePrinter = <?php echo $closePrinter ?>;
      var allPrinter = <?php echo $openPrinter + $unopenPrinter + $closePrinter?>;
    //others
      var openOthers = <?php echo $openOthers ?>;
      var unopenOthers = <?php echo $unopenOthers ?>;
      var closeOthers = <?php echo $closeOthers ?>;
      var allOthers = <?php echo $openOthers + $unopenOthers + $closeOthers?>;
    </script>
    {{HTML::script('js/statistic/category.js')}}
  </body>
</html>