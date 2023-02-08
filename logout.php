<?php
  session_start();
  include 'index.php';

  unset($_SESSION['access_token']);
  $client->revokeToken();
  header('Location: index.php');
?>
