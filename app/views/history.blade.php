
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<title>历史查询</title>
	<!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.3/themes/base/jquery-ui.min.css">
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css"/>  
</head>
<body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <header>
            <h1>Tickets历史查询</h1>
          </header>
        </div>
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th>#ID</th>
                <th>Content</th>
                <th>状态</th>
              </tr>
            </thead>
            <tbody>
            @foreach($tickets as $ticket)
              <tr>
                <th scope="row" id="{{$ticket['_id']}}">{{$ticket['auto_id']}}</th>
                <td><a href={{URL::to('/'.$ticket['_id'].'/historyDetails')}}>
                  @if($ticket['content'])
                    @if(gettype($ticket['content'][0]) == 'string')
                    {{$ticket['content'][0]}} 
                    @endif
                  @endif
                  </a>
                </td>
                <td>
                  @if($ticket['bstatus'] == 'New')
                    Waiting
                  @elseif($ticket['bstatus'] == 'Processing')
                    Processing
                  @elseif($ticket['bstatus'] == 'Holding')
                    Holding
                  @else
                    Finished
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>

              <div class="comment" title="Comment Board" id="" hidden>
                <input type="text" class="addComment" id="" placeholder="What you want to say" />
              </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script src="http://labfile.oss.aliyuncs.com/amazeui/2.2.1/js/amazeui.min.js"></script>  
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.btn-default').on('click', function(e){
          $('.comment').dialog({
              autoOpen: true,
              modal: true,
              buttons:{
                  "Say it": addComment,
                  Cancel: function(){
                      $(this).dialog("close");
                  }
              }
          });
          function addComment(){
              // ticket_id
              var id = e.target.id;
              var operator = e.target.value;
              var comment = $(this).find('.addComment').val();
              // console.log(id);
              // console.log(operator);
              // console.log(comment);
              $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
              });
              $.ajax({
                url:'/commentToIt/'+id+'/'+operator+'/'+comment+'',
                    type: 'POST',
                    data: {
                        id: id,
                        operator: operator,
                        comment: comment
                    },
                    success: function( data ){
                        alert('发送成功');
                        $('.comment').dialog("close");
                        $(this).find('.addComment').val('');
                        window.location = window.location.href;
                        
                    },
                    error: function (xhr, b, c) {
                        console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                    }
              });
          }
        });
      });
    </script>
</body>
</html>