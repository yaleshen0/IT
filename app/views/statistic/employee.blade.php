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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{HTML::style('css/statistic/index.css')}}
    {{HTML::style('css/font.css')}}
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
  
          <ul class="nav nav-tabs">
            <li><a href="{{URL::to('statistic/index')}}">Category</a></li>
            <li class="active"><a href="{{URL::to('statistic/employee')}}">Employee</a></li>
            <select class="dropdown btn btn-lg" id="chartSelect" style="float: right;">
              <option selected>Chart</option>
              <option value="YY">YY</option>
              <option value="TuTu">TuTu</option>
              <option value="Ben">Ben</option>
            </select>
          </ul>
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Opened</th>
              <th>Closed</th>
              <th>AssignTo</th>
              <th>Assigned</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Y.Y.Chan</td>
              <?php
              $openbyYY = 0; $closebyYY = 0;
              foreach($alltickets as $allticket){
                if($allticket['openedby'] == 'YY'){
                  $openbyYY++;
                }
                if($allticket['closed_by'] == 'YY'){
                  $closebyYY++;
                } 
              }
              ?>

              <td>{{$openbyYY}}</td>
              <td>{{$closebyYY}}</td>
              <td>{{sizeof($yy['referId'])}}</td>
              <td>{{sizeof($yy['referredId'])}}</td>
            </tr>
            <tr>
              <td>Tutu</td>
              <?php
              $openbyTT = 0; $closebyTT = 0;
              foreach($alltickets as $allticket){
                if($allticket['openedby'] == 'TT'){
                  $openbyTT++;
                }
                if($allticket['close_by'] == 'TT'){
                  $closebyTT++;
                }
              }
              ?>
              <td>{{$openbyTT}}</td>
              <td>{{$closebyTT}}</td>
              <td>{{sizeof($tt['referId'])}}</td>
              <td>{{sizeof($tt['referredId'])}}</td>
            </tr>
            <tr>
              <td>Ben</td>
              <?php
              $openbyBB = 0; $closebyBB = 0;
              foreach($alltickets as $allticket){
                if($allticket['openedby'] == 'BB'){
                  $openbyBB++;
                }
                if($allticket['close_by'] == 'BB'){
                  $closebyBB++;
                }
              }
              ?>
              <td>{{$openbyBB}}</td>
              <td>{{$closebyBB}}</td>
              <td>{{sizeof($bb['referId'])}}</td>
              <td>{{sizeof($bb['referredId'])}}</td>
            </tr>
          </tbody>
        </table>
        <div style="">
          <canvas id="yyChart"></canvas>
          <canvas id="ttChart"></canvas>
          <canvas id="bbChart"></canvas>
        </div>
      </div>
    </div>
  </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.bundle.min.js"></script>
    <script type="text/javascript">
      //YY的数据
      var assignedYY = <?php echo sizeof(($yy['referredId']))?>;
      var openbyYY = <?php echo $openbyYY;?>;
      var closebyYY = <?php echo $closebyYY;?>;
      var assignToYY = <?php echo sizeof(($yy['referId']))?>
      //TT的数据
      var assignedTT = <?php echo sizeof(($tt['referredId']))?>;
      var openbyTT = <?php echo $openbyTT;?>;
      var closebyTT = <?php echo $closebyTT;?>;
      var assignToTT = <?php echo sizeof(($tt['referId']))?>
      //BB的数据
      var assignedBB = <?php echo sizeof(($bb['referredId']))?>;
      var openbyBB = <?php echo $openbyBB;?>;
      var closebyBB = <?php echo $closebyBB;?>;
      var assignToBB = <?php echo sizeof(($bb['referId']))?>
    </script>
    {{HTML::script('js/statistic/employee.js')}}
  </body>
</html>