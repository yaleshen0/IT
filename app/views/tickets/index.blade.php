<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">
    {{HTML::style('css/tickets/chatbox.css')}}
    <!-- <link rel="stylesheet" type="text/css" href="css/tickets/chatbox.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
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
        <div class="col-sm-12  col-md-12 col-lg-12 col-xs-12">
          <span style="font-size: 34px; color:black;" class="page-header">
            <input class="btn btn-primary btn-lg center-lock" type="button" value="ALL" onclick="$(window).attr('location','/tickets/index')"/>
            <input class="btn btn-default btn-lg center-lock" type="button" value="Closed" onclick="$(window).attr('location','/tickets/closed')"/>
            <!-- <div class="dropdown" style="display: inline;">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                筛选
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#" class="category" id="categ">Category</a></li>
                <li><a href="#" class="priority" id="prior">Priority</a></li>
                <li><a href="#">其他2</a></li>
              </ul>
            </div> -->
          </span>
          <span style= "float:right; ">  
          <span style="font-size: 24px;">HI, {{Auth::user()->username}}</span>
          
          </span>
          
          
          <div class="table-responsive">
          
            <table class="table table-striped" id="myTable" style="">
              <thead>
                <tr style="font-size: 12px;">
                  <th>auto_id</th>
                  <th>Category</th>
                  <th colspan="2" style="width:30%;">Content</th>
                  <th>Priority</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @foreach($order_tickets as $order_ticket)
                  @if($order_ticket['bstatus']!='Finished')
                    @if($order_ticket['referTo'] == '' && (Auth::user()->permission =='Admin' || Auth::user()->permission =='TT' || Auth::user()->permission =='BB'))
                      <tr>
                        <td>
                          {{$order_ticket['auto_id']}}
                          @if($order_ticket['bstatus'] == 'Processing')
                            <!-- <span style="color: red;">{{$order_ticket['openedby']}}</span> -->
                            <input type="text" value="{{$order_ticket['openedby']}}" style="color: red; width: 30px;  "disabled/>
                          @endif
                        </td>
                        <td>{{$order_ticket['category']}}</td>
                        <td colspan="2"><a href={{URL::to('/tickets/'.$order_ticket['_id'].'/details')}}>
                          @if($order_ticket['content'])
                            @foreach($order_ticket['content'] as $key=>$value)
                              @if(gettype($value) == 'string')
                              {{$value}} 
                              @endif
                            @endforeach
                          @endif
                        </a></td>
                        
                        <td>
                        {{$order_ticket['priority']}}
                        </td>
                        
                        <td class="status" id="status[{{$order_ticket['_id']}}]">{{$order_ticket['bstatus']}} </td>

                       
                        @if($order_ticket['bstatus'] == 'New')
                        <td>
                          <input type="button" class="btn btn-danger Open" id="openAction[{{$order_ticket['_id']}}]" value="Open"/>
                          <input type="button" class="btn btn-default Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                          <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer" href=""/>
                        </td>
                        @elseif($order_ticket['bstatus'] == 'Processing')
                        <td>
                            <input type="button" class="btn btn-default Hold" id="holdAction[{{$order_ticket['_id']}}]" value="Hold"/>
                            <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                        </td>
                        @elseif($order_ticket['bstatus'] == 'Holding')
                        <td>
                            <input type="button" class="btn btn-default Unhold" id="unholdAction[{{$order_ticket['_id']}}]" value="Unhold"/>
                            <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                            <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer"/>
                        </td>
                        @endif
                        <!-- refer dialog -->
                        <div id="dialog" title="Basic dialog" hidden>
                            <select id="{{$order_ticket['_id']}}">
                              <option value="YY">YY</option>
                              <option value="TT">TT</option>
                              <option value="BB">BB</option>
                            </select>
                        </div> 
                      </tr>
                    @elseif(Auth::user()->permission =='Admin')
                      @if($order_ticket['referTo'] == 'YY' || $order_ticket['referTo'] == '')
                        <tr>
                          <td>
                            {{$order_ticket['auto_id']}}
                            @if($order_ticket['bstatus'] == 'Processing')
                              <input type="text" value="{{$order_ticket['openedby']}}" style="color: red; width: 30px;  "disabled/>
                            @endif
                          </td>
                          <td>{{$order_ticket['category']}} </td>
                            <td colspan="2"><a href={{URL::to('/tickets/'.$order_ticket['_id'].'/details')}}>
                              @if($order_ticket['content'])
                                @foreach($order_ticket['content'] as $key=>$value)
                                  @if(gettype($value) == 'string')
                                  {{$value}} 
                                  @endif
                                @endforeach
                              @endif
                            </a></td>
                            
                            <td>
                            {{$order_ticket['priority']}}
                            </td>
                            
                            <td class="status" id="status[{{$order_ticket['_id']}}]">{{$order_ticket['bstatus']}} </td>

                           
                            @if($order_ticket['bstatus'] == 'New')
                            <td>
                              <input type="button" class="btn btn-danger Open" id="openAction[{{$order_ticket['_id']}}]" value="Open"/>
                              <input type="button" class="btn btn-default Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                              <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer" href=""/>
                            </td>
                            @elseif($order_ticket['bstatus'] == 'Processing')
                            <td>
                                <input type="button" class="btn btn-default Hold" id="holdAction[{{$order_ticket['_id']}}]" value="Hold"/>
                                <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                            </td>
                            @elseif($order_ticket['bstatus'] == 'Holding')
                            <td>
                                <input type="button" class="btn btn-default Unhold" id="unholdAction[{{$order_ticket['_id']}}]" value="Unhold"/>
                                <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                                <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer"/>
                            </td>
                            @endif
                            <!-- refer dialog -->
                           <div id="dialog" title="Basic dialog" hidden>
                              <select id="{{$order_ticket['_id']}}">
                                <option value="YY">YY</option>
                                <option value="TT">TT</option>
                                <option value="BB">BB</option>
                              </select>
                            </div> 
                        </tr>
                      @endif
                    @elseif(Auth::user()->permission =='TT')
                      @if($order_ticket['referTo'] == 'TT' || $order_ticket['referTo'] == '')
                        <tr>
                          <td>
                            {{$order_ticket['auto_id']}}
                            @if($order_ticket['bstatus'] == 'Processing')
                              <input type="text" value="{{$order_ticket['openedby']}}" style="color: red; width: 30px;  "disabled/>
                            @endif
                          </td>
                          <td>{{$order_ticket['category']}} </td>
                            <td colspan="2"><a href={{URL::to('/tickets/'.$order_ticket['_id'].'/details')}}>
                              @if($order_ticket['content'])
                                @foreach($order_ticket['content'] as $key=>$value)
                                  @if(gettype($value) == 'string')
                                  {{$value}} 
                                  @endif
                                @endforeach
                              @endif
                            </a></td>
                            
                            <td>
                            {{$order_ticket['priority']}}
                            </td>
                            
                            <td class="status" id="status[{{$order_ticket['_id']}}]">{{$order_ticket['bstatus']}} </td>

                           
                            @if($order_ticket['bstatus'] == 'New')
                            <td>
                              <input type="button" class="btn btn-danger Open" id="openAction[{{$order_ticket['_id']}}]" value="Open"/>
                              <input type="button" class="btn btn-default Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                              <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer" href=""/>
                            </td>
                            @elseif($order_ticket['bstatus'] == 'Processing')
                            <td>
                                <input type="button" class="btn btn-default Hold" id="holdAction[{{$order_ticket['_id']}}]" value="Hold"/>
                                <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                            </td>
                            @elseif($order_ticket['bstatus'] == 'Holding')
                            <td>
                                <input type="button" class="btn btn-default Unhold" id="unholdAction[{{$order_ticket['_id']}}]" value="Unhold"/>
                                <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                                <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer"/>
                            </td>
                            @endif
                            <!-- refer dialog -->
                            <div id="dialog" title="Basic dialog" hidden>
                                <select id="{{$order_ticket['_id']}}">
                                  <option value="YY">YY</option>
                                  <option value="TT">TT</option>
                                  <option value="BB">BB</option>
                                </select>
                            </div> 
                        </tr>
                      @endif
                    @elseif(Auth::user()->permission =='BB')
                      @if($order_ticket['referTo'] == 'BB' || $order_ticket['referTo'] == '')
                        <tr>
                          <td>
                            {{$order_ticket['auto_id']}}
                            @if($order_ticket['bstatus'] == 'Processing')
                              <input type="text" value="{{$order_ticket['openedby']}}" style="color: red; width: 30px;  "disabled/>
                            @endif
                          </td>
                          <td>{{$order_ticket['category']}} </td>
                            <td colspan="2"><a href={{URL::to('/tickets/'.$order_ticket['_id'].'/details')}}>
                              @if($order_ticket['content'])
                                @foreach($order_ticket['content'] as $key=>$value)
                                  @if(gettype($value) == 'string')
                                  {{$value}} 
                                  @endif
                                @endforeach
                              @endif
                            </a></td>
                            
                            <td>
                            {{$order_ticket['priority']}}
                            </td>
                            
                            <td class="status" id="status[{{$order_ticket['_id']}}]">{{$order_ticket['bstatus']}} </td>

                           
                            @if($order_ticket['bstatus'] == 'New')
                            <td>
                              <input type="button" class="btn btn-danger Open" id="openAction[{{$order_ticket['_id']}}]" value="Open"/>
                              <input type="button" class="btn btn-default Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                              <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer" href=""/>
                            </td>
                            @elseif($order_ticket['bstatus'] == 'Processing')
                            <td>
                                <input type="button" class="btn btn-default Hold" id="holdAction[{{$order_ticket['_id']}}]" value="Hold"/>
                                <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                            </td>
                            @elseif($order_ticket['bstatus'] == 'Holding')
                            <td>
                                <input type="button" class="btn btn-default Unhold" id="unholdAction[{{$order_ticket['_id']}}]" value="Unhold"/>
                                <input type="button" class="btn btn-danger Close" id="closeAction[{{$order_ticket['_id']}}]" value="Close" href=""/>
                                <input type="button" class="btn btn-default Refer" id="referAction[{{$order_ticket['_id']}}]" value="Refer"/>
                            </td>
                            @endif
                            <!-- refer dialog -->
                            <div id="dialog" title="Basic dialog" hidden>
                                <select id="{{$order_ticket['_id']}}">
                                  <option value="YY">YY</option>
                                  <option value="TT">TT</option>
                                  <option value="BB">BB</option>
                                </select>
                            </div> 
                        </tr>
                      @endif
                    @endif
                  @endif
                @endforeach
              
              </tbody>

            </table>
            
          </div>
        </div>
      </div>
    </div>
    <div class="addTag" title="" hidden>
          <input type="text" class="addText" id="addText" placeholder="type here.." />
        </div>

    <div id='employee' value="{{Auth::user()->username}}" hidden>
    <?php
      $employee = Auth::user()->username;
      $employee = json_encode($employee);
      echo $employee;
    ?>
    </div>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.27.4/js/jquery.tablesorter.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{HTML::script('js/tickets/index.js')}}
  </body>
</html>