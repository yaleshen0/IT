<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title></title>
    {{HTML::style('css/tickets/chatbox.css')}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  </head>

  <body>
      <nav class="navbar navbar-inverse navbar-static-top" style="position: fixed; width: 100%;">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="" onclick="window.history.back();">返回</a>
          </div>
        </div>
      </nav>

            <div class="container" style="padding-top: 100px;">
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                <?php
                  if (empty($ticket['content']) == 'true') {
                      echo ' <h1>内容为空</h1>';
                  } else {
                      foreach ($ticket['content'] as $key => $value) {
                        if(isset($value[0])){
                          if (!filter_var($value[0], FILTER_VALIDATE_URL) === false) {
                              //echo(" is a valid URL");
                        echo "<div class='col-md-3'><img style='width: 260px; height: 140px; border:3px solid #ddd;' src=$value[0] /></div>";
                          } else {
                              echo "<div style='border:3px solid #ddd;'>$value</div>";
                          }
                        }
                      }
                  }
                ?>
                </div>
              </div>
            <!-- HTML Codes by Code-Generator.net -->
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
              <div class='chatContainer'>
                  
              </div>
            </div>
          </div>

            </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript">
      tinymce.init({selector: 'input.form-control'});
    </script>
    <!-- {{HTML::script('js/tickets/details.js')}} -->
  </body>
</html>