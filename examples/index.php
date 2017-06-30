<!DOCTYPE html>
<html lang="en">
<head>
  <title>REST API Examples</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container text-center">
  <h2>REST API</h2>
  <button type="button" id="list" class="btn btn-info">List (GET)</button>
  <button type="button" id="create" class="btn btn-success">Create (POST)</button>
  <button type="button" id="update" class="btn btn-primary">Update (PUT)</button>
  <button type="button" id="delete" class="btn btn-danger">Delete (DELETE)</button>
  <button type="button" id="tokenrequest" class="btn btn-default">Request for Token</button>
  <div id="response" style="margin: 20px;"></div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#tokenrequest").on('click', function() {
      var params = {
        url: 'tokenrequest.php',
        method: 'GET',
      };
      callAJAX(params);
    });
    $("#list").on('click', function() {
      var params = {
        url: 'list.php',
        method: 'GET',
      };
      callAJAX(params);
    });
    $("#create").on('click', function() {
      var params = {
        url: 'create.php',
        method: 'POST',
      };
      callAJAX(params);
    });
    $("#update").on('click', function() {
      var params = {
        url: 'update.php',
        method: 'PUT',
      };
      callAJAX(params);
    });
    $("#delete").on('click', function() {
      var params = {
        url: 'delete.php',
        method: 'DELETE',
      };
      callAJAX(params);
    });
  });

  function callAJAX(params) {
    $.ajax({
      url: params.url,
      method: params.method,
      beforeSend: function() {
        $("#response").html("Loading...");
      }
    })
    .done(function(data) {
      var html = '<div class="panel panel-default"><div class="panel-heading">Response for <u>'+params.method+'</u> method</div><div class="panel-body">'+data+'</div></div>';
      $("#response").html(html);
    })
    .fail(function() {
      var html = '<div class="panel panel-default"><div class="panel-heading">Error</div><div class="panel-body">Please check your console for more details</div></div>';
      $("#response").html(html);
    });
  }
</script>
</body>
</html>
