<?php
  require_once 'includes/class-autoloader.php';
  $users = new Users();

  
  if(isset($_POST['createUser'])){
    $user = $users->createUser();
    echo $user;
  }