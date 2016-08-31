<?php

require 'assets/init.php';

$auth = new GoogleAuth();

if ($auth->checkRedirectCode()) {
  header('location: add.php');
}

if (isset($_REQUEST['logout'])) {
   session_unset();
}

if (!$auth->isLoggedIn()) {
  header('location: index.php');
}


$auth->deleteAllTasks();

?>


<!DOCTYPE html>
<html>
<head>
  <title>Google Tasks API</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <style type="text/css">
    body{
      background-color: #f0f0f0;
    }
  </style>
</head>
<body> 

    <?php require 'assets/header.inc.php'; ?>

   <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h1>Processing</h1>
      </div>
    </div>
</body>
</html>


