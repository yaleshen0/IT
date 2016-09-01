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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    {{HTML::style('css/font.css')}}
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


<div class="container">
      <div class="row">

        <div class="col-sm-12  col-md-12 col-lg-12 col-xs-12main">
          <span style="font-size: 34px; color:black;" class="page-header">
            <input class="btn btn-default btn-lg center-lock" type="button" value="ALL" onclick="$(window).attr('location','/tickets/index')"/>
            <input class="btn btn-primary btn-lg center-lock" type="button" value="Closed" onclick="$(window).attr('location','/tickets/closed')"/>
            <!-- <div class="dropdown" style="display:inline;">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                分类
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#">硬件</a></li>
                <li><a href="#">软件</a></li>
                <li><a href="#">其他</a></li>
              </ul>
            </div> -->
          </span>
          <span style= "float:right; ">  
          
          </span>

          

          <div class="table-responsive">
            <table class="table table-striped" id="myTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Category</th>
                  <th>Content</th>
                  <th>Received Time</th>
                  <th>Pickup Time</th>
                  <th>Finished Time</th>
                  <th>Used Time</th>
                  <th>Used Holding Time</th>
                  <th>Submitted by</th>
                  <th>ClosedBy</th>
                </tr>
              </thead>
              <tbody>
              
              @foreach($tickets as $ticket)
              @if($ticket['bstatus']=='Finished')
              <!-- <?php 
               // $diff = $ticket['used_time'];
               // $years   = floor($diff / (365*60*60*24)); 
               // $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
               // $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
               // $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
               // $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
               // $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));
               ?> -->
                <tr>
                  <td>{{$ticket['auto_id']}}
                  @if($ticket['notice'] == 'ON')
                  <span class="glyphicon glyphicon-tag" style="color: #ff6666;"></span>
                  @endif
                  </td>
                  
                  <td>
                    <div class="category" id="catgory[{{$ticket['_id']}}]" value="{{$ticket['category']}}"/>{{$ticket['category']}}</div>
                  </td>
                  <td>
                  <a href={{URL::to('/tickets/'.$ticket['_id'].'/details')}}>
                    @if($ticket['content'])
                      @foreach($ticket['content'] as $key=>$value)
                        @if(gettype($value) == 'string')
                        {{$value}} 
                        @endif
                      @endforeach
                    @endif
                  </a>
                  </td>
                  <td>{{$ticket['created_at']}}</td>
                  <td>{{$ticket['pickup_time']}}</td>
                  <td>{{$ticket['finished_time']}}</td>
                  
                  <td>{{$ticket['used_time']}}</td>
                  <td>{{$ticket['used_holdingtime']}}</td>
                   <!-- 查询openid找到是谁发的ticket -->
                  @foreach($Usermodels as $Usermodel)
                    @if($ticket['from_user_name'] == $Usermodel['openid'])
                    <td>{{$Usermodel['nickname']}}</td>
                    @endif
                  @endforeach

                  <td>{{$ticket['closed_by']}}</td>
                </tr>
                <!-- change category dialog -->
                 <div id="dialog" title="Basic dialog" hidden>
                    <select id="{{$ticket['_id']}}">
                      <option value="">wifi</option>
                      <option value="">qb</option>
                      <option value="">phone</option>
                      <option value="">rem/pc</option>
                      <option value="">excel</option>
                      <option value="">website</option>
                      <option value="">email</option>
                      <option value="">monitor</option>
                      <option value="">printer</option>
                      <option value="">others</option>
                    </select>
                 </div> 
              @endif
              @endforeach
              </tbody>
            </table>
            <div id='employee' value="{{Auth::user()->username}}" hidden>
              <?php
                $employee = Auth::user()->username;
                $employee = json_encode($employee);
                echo $employee;
              ?>
              </div>
        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script   src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"   integrity="sha256-xI/qyl9vpwWFOXz7+x/9WkG5j/SVnSw21viy8fWwbeE="   crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.27.4/js/jquery.tablesorter.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{HTML::script('js/tickets/closed.js')}}
  </body>
</html>