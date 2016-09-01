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

    <title>stats</title>
    {{HTML::style('css/statistic/basic.css')}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">STATS</a>
        </div>
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
          <!-- foreach tickets & closed_tickets 计算各category数量 -->
          <?php 
            $wifi = $qb = $phone = $rempc = $excel = $website = $email = $monitor = $printer = $others =0;
            $cwifi = $cqb = $cphone = $crempc = $cexcel = $cwebsite = $cemail = $cmonitor = $cprinter = $cothers =0;
            $cho_wifi = $cho_qb = $cho_phone = $cho_rempc = $cho_excel = $cho_website = $cho_email = $cho_monitor = $cho_printer = $cho_others =0;
            $ccho_wifi = $ccho_qb = $ccho_phone = $ccho_rempc = $ccho_excel = $ccho_website = $ccho_email = $ccho_monitor = $ccho_printer = $ccho_others =0;
            foreach($tickets as $ticket){
              if($ticket['category'] == 'wifi'){
                $wifi += 1;
              } elseif($ticket['category'] == 'qb'){
                $qb += 1;
              } elseif($ticket['category'] == 'phone'){
                $phone += 1;
              } elseif($ticket['category'] == 'rem/pc'){
                $rempc += 1;
              } elseif($ticket['category'] == 'excel'){
                $excel += 1;
              } elseif($ticket['category'] == 'website'){
                $website += 1;
              } elseif($ticket['category'] == 'email'){
                $email += 1;
              } elseif($ticket['category'] == 'monitor'){
                $monitor += 1;
              } elseif($ticket['category'] == 'printer'){
                $printer += 1;
              } elseif($ticket['category'] == 'others'){
                $others += 1;
              }
            }
            foreach($closed_tickets as $ticket){
              if($ticket['category'] == 'wifi'){
                $cwifi += 1;
              } elseif($ticket['category'] == 'qb'){
                $cqb += 1;
              } elseif($ticket['category'] == 'phone'){
                $cphone += 1;
              } elseif($ticket['category'] == 'rem/pc'){
                $crempc += 1;
              } elseif($ticket['category'] == 'excel'){
                $cexcel += 1;
              } elseif($ticket['category'] == 'website'){
                $cwebsite += 1;
              } elseif($ticket['category'] == 'email'){
                $cemail += 1;
              } elseif($ticket['category'] == 'monitor'){
                $cmonitor += 1;
              } elseif($ticket['category'] == 'printer'){
                $cprinter += 1;
              } elseif($ticket['category'] == 'others'){
                $cothers += 1;
              }
            }

            if($chosen_tickets){

            foreach($chosen_tickets as $ticket){
              if($ticket['category'] == 'wifi'){
                $cho_wifi += 1;
              } elseif($ticket['category'] == 'qb'){
                $cho_qb += 1;
              } elseif($ticket['category'] == 'phone'){
                $cho_phone += 1;
              } elseif($ticket['category'] == 'rem/pc'){
                $cho_rempc += 1;
              } elseif($ticket['category'] == 'excel'){
                $cho_excel += 1;
              } elseif($ticket['category'] == 'website'){
                $cho_website += 1;
              } elseif($ticket['category'] == 'email'){
                $cho_email += 1;
              } elseif($ticket['category'] == 'monitor'){
                $cho_monitor += 1;
              } elseif($ticket['category'] == 'printer'){
                $cho_printer += 1;
              } elseif($ticket['category'] == 'others'){
                $cho_others += 1;
              }
            }
          } 
            if($closed_chosen_tickets){
            foreach($closed_chosen_tickets as $ticket){
              if($ticket['category'] == 'wifi'){
                $ccho_wifi += 1;
              } elseif($ticket['category'] == 'qb'){
                $ccho_qb += 1;
              } elseif($ticket['category'] == 'phone'){
                $ccho_phone += 1;
              } elseif($ticket['category'] == 'rem/pc'){
                $ccho_rempc += 1;
              } elseif($ticket['category'] == 'excel'){
                $ccho_excel += 1;
              } elseif($ticket['category'] == 'website'){
                $ccho_website += 1;
              } elseif($ticket['category'] == 'email'){
                $ccho_email += 1;
              } elseif($ticket['category'] == 'monitor'){
                $ccho_monitor += 1;
              } elseif($ticket['category'] == 'printer'){
                $ccho_printer += 1;
              } elseif($ticket['category'] == 'others'){
                $ccho_others += 1;
              }
            }
          }
            ?>

<div class="container-fluid">
      <div class="row">

          <div class="col-sm-12  col-md-12 main">
          <span style="font-size: 34px; color:black;" class="page-header"></span>
          <span style= "float:right; ">  
          </span>

          <div class="table-responsive">
          <table>
            <thead><h3 strong>历史总计</h3>
              <tr>
                <th colspan="2">不能上网</th>
                <th colspan="2">QuickBook</th>
                <th colspan="2">电话</th>
                <th colspan="2">remote死机/电脑死机</th>
                <th colspan="2">EXCEL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$wifi}}</td>
                <td>{{$cwifi}}</td>
                <td>{{$qb}}</td>
                <td>{{$cqb}}</td>
                <td>{{$phone}}</td>
                <td>{{$cphone}}</td>
                <td>{{$rempc}}</td>
                <td>{{$rempc}}</td>
                <td>{{$excel}}</td>
                <td>{{$cexcel}}</td>
              </tr>
            </tbody>
            <thead>
              <tr>
                <th colspan="2">无法登陆网站</th>
                <th colspan="2">Email</th>
                <th colspan="2">显示器问题</th>
                <th colspan="2">打印机问题</th>
                <th colspan="2">其他</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$website}}</td>
                <td>{{$cwebsite}}</td>
                <td>{{$email}}</td>
                <td>{{$cemail}}</td>
                <td>{{$monitor}}</td>
                <td>{{$cmonitor}}</td>
                <td>{{$printer}}</td>
                <td>{{$cprinter}}</td>
                <td>{{$others}}</td>
                <td>{{$cothers}}</td>
              </tr>
            </tbody>
            <thead>
              <tr>
                <th colspan="2" id="total">TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{sizeof($tickets)}}</td>
                <td>{{sizeof($closed_tickets)}}</td>
              </tr>
            </tbody>
          </table>

          <table>
            <thead>
            <span style="font-size: 26px;">最新统计</span>
            {{Form::open(array('url' => '/statistic/basic', 'method' => 'get'))}}
            <div>
              <label>
                初始日期
                <input class="date-input" type="text" name="start_date" value="{{ Utility::getArrayStringValue($search_array,'start_date')}}">
              </label>
              <label>
                结束日期
                <input class="date-input" type="text" name="end_date" value="{{ Utility::getArrayStringValue($search_array,'end_date')}}">
              </label>
              
              <input class="operating btn btn-info btn-lg" type="submit" value="搜索">
             </div>
            {{ Form::close() }}
            @if(!$chosen_tickets) 
              <tr>
                <th colspan="2">不能上网</th>
                <th colspan="2">QuickBook</th>
                <th colspan="2">电话</th>
                <th colspan="2">remote死机/电脑死机</th>
                <th colspan="2">EXCEL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$wifi}}</td>
                <td>{{$cwifi}}</td>
                <td>{{$qb}}</td>
                <td>{{$cqb}}</td>
                <td>{{$phone}}</td>
                <td>{{$cphone}}</td>
                <td>{{$rempc}}</td>
                <td>{{$rempc}}</td>
                <td>{{$excel}}</td>
                <td>{{$cexcel}}</td>
              </tr>
            </tbody>
            <thead>
              <tr>
                <th colspan="2">无法登陆网站</th>
                <th colspan="2">Email</th>
                <th colspan="2">显示器问题</th>
                <th colspan="2">打印机问题</th>
                <th colspan="2">其他</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$website}}</td>
                <td>{{$cwebsite}}</td>
                <td>{{$email}}</td>
                <td>{{$cemail}}</td>
                <td>{{$monitor}}</td>
                <td>{{$cmonitor}}</td>
                <td>{{$printer}}</td>
                <td>{{$cprinter}}</td>
                <td>{{$others}}</td>
                <td>{{$cothers}}</td>
              </tr>
            </tbody>
            <thead>
              <tr>
                <th colspan="2" id="total">TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{sizeof($tickets)}}</td>
                <td>{{sizeof($closed_tickets)}}</td>
              </tr>
            </tbody>
            @else
              <tr>
                <th colspan="2">不能上网</th>
                <th colspan="2">QuickBook</th>
                <th colspan="2">电话</th>
                <th colspan="2">remote死机/电脑死机</th>
                <th colspan="2">EXCEL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$cho_wifi}}</td>
                <td>{{$ccho_wifi}}</td>
                <td>{{$cho_qb}}</td>
                <td>{{$ccho_qb}}</td>
                <td>{{$cho_phone}}</td>
                <td>{{$ccho_phone}}</td>
                <td>{{$cho_rempc}}</td>
                <td>{{$ccho_rempc}}</td>
                <td>{{$cho_excel}}</td>
                <td>{{$ccho_excel}}</td>
              </tr>
            </tbody>
            <thead>
              <tr>
                <th colspan="2">无法登陆网站</th>
                <th colspan="2">Email</th>
                <th colspan="2">显示器问题</th>
                <th colspan="2">打印机问题</th>
                <th colspan="2">其他</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$cho_website}}</td>
                <td>{{$ccho_website}}</td>
                <td>{{$cho_email}}</td>
                <td>{{$ccho_email}}</td>
                <td>{{$cho_monitor}}</td>
                <td>{{$ccho_monitor}}</td>
                <td>{{$cho_printer}}</td>
                <td>{{$ccho_printer}}</td>
                <td>{{$cho_others}}</td>
                <td>{{$ccho_others}}</td>
              </tr>
            </tbody>
            <thead>
              <tr>
                <th colspan="2" id="total">TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{sizeof($chosen_tickets)}}</td>
                <td>{{sizeof($closed_chosen_tickets)}}</td>
              </tr>
            </tbody>
            @endif
          </table>
            

            <!-- #Closed Tickets:  {{sizeof($closed_tickets)}}<br/> -->
        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>