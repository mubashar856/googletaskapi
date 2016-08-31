<?php

require 'assets/init.php';

$auth = new GoogleAuth();

if ($auth->checkRedirectCode()) {
  header('location: index.php');
}

if (isset($_REQUEST['logout'])) {
   session_unset();
}


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
        <?php
          if (!$auth->isLoggedIn()) {
              $authUrl = $auth->getAuthUrl();
              echo '<h1>login</h1>';
              echo "<a class='login' href='" . $authUrl . "'><img src='assets/img/signin_button.png' height='50px'/></a>";
          } else {
            echo '<h1>All Tasks</h1>';
            if (count($auth->getTasks()['tasks']['modelData']) != 0) {
              echo '<ul class="list-group">';
              foreach ($auth->getTasks()['tasks']['modelData']['items'] as $task) {
                $taskTitle = $task['title'];
                $taskId = $task['id'];
                echo '<li class="list-group-item">';
                echo $taskTitle;
                echo '<div style="float: right">';
                echo '<a href="delete.php?task='.$taskId.'" alt="delete this task"><span class="glyphicon glyphicon-remove"></span></a>';
                echo '</div>';
                echo '</li>';
              }
              echo '</ul>';
            }else{
              echo '<div class="alert alert-danger">Warning! No task found. <a href="add.php">Click here</a> to add task.</div>';
            }
          }
        ?>
      </div>
    </div>
</body>
</html>

 