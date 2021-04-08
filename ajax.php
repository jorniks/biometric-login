<?php
  require_once 'includes/class-autoloader.php';
  include 'includes/env-autoload.php';
  $users = new Users();

  
  if(isset($_POST['createUser'])){
    $user = $users->createUser();
    echo $user;
  }