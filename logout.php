<?php
  // Start the session
  session_start();
  // Include the 'index.php' file
  include 'index.php';

  // Unset the 'access_token' session
  unset($_SESSION['access_token']);
  // Revoke the access token from Google API
  $client->revokeToken();
  // Redirect the user back to the index page
  header('Location: index.php');
?>