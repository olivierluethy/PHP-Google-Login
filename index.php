<?php

// Require the autoload file from the composer package
require_once __DIR__ . '/vendor/autoload.php';

// Start a session to store the access token
session_start();

// Create a new Google Client object
$client = new Google_Client();

// Set the client ID and client secret for the Google API
$client->setClientId('1098007898151-8thpcqfm8aem4pgfkm6o6ob0c01r75be.apps.googleusercontent.com');
$client->setClientSecret('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');

// Set the redirect URI to redirect the user after logging in
$client->setRedirectUri('http://localhost/php-google-login/index.php');

// Add the required scopes for the Google API
$client->addScope('https://www.googleapis.com/auth/plus.login');
$client->addScope('https://www.googleapis.com/auth/userinfo.email');
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');

// Check if the code parameter is set in the URL
if (isset($_GET['code'])) {
  // Fetch the access token with the auth code
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

  // Set the access token in the client object
  $client->setAccessToken($token);

  // Store the access token in the session
  $_SESSION['access_token'] = $token;

  // Redirect the user back to the index page
  header('Location: http://localhost/PHP-Google-Login/index.php');
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Google Login</title>
</head>

<body>
    <div class="container">
        <?php
        // Check if the user has an access token in the session and it is valid
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            // If the access token is present, set it in the client object
            $client->setAccessToken($_SESSION['access_token']);
        
            // Create a new Google_Service_Oauth2 object
            $oauth = new Google_Service_Oauth2($client);
        
            // Get the user information from the OAuth service
            $user = $oauth->userinfo->get();
        
            // Get the user's name, email and profile image URL
            $name = $user->getName();
            $email = $user->getEmail();
            $profileImageUrl = $user->getPicture();
        
            // Store the user's name and email in the session
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
        
            // Connect to the database
            try {
                $conn = new PDO("mysql:host=localhost;dbname=habasch", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT email FROM users WHERE email = :email";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();
            } catch (PDOException $e) {
                // If there is an error, display the error message
                echo "Error: " . $e->getMessage();
            }
            
            // If the user is not in the database, add them
            if (!$user) {
                try {
                    $query = "INSERT INTO users (name, email) VALUES (:name, :email)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                } catch (PDOException $e) {
                    // If there is an error, display the error message
                    echo "Error: " . $e->getMessage();
                }
            }
        
            // Display the user's information
            echo '<div class="user-info">';
            echo '<img src="' . $profileImageUrl . '" class="user-image" />';
            echo '<div class="user-details">';
            echo '<h1 class="user-name">' . $name . '</h1>';
            echo '<h3 class="user-email">' . $email . '</h3>';
            echo '</div>';
            echo '</div>';
        
            // Display the logout button
            echo '<a href="logout.php" class="logout-button">Logout</a>';
        } else {
            // If the user does not have an access token, create the login URL and display the login button
            $login_url = $client->createAuthUrl();
            echo '<a href="' . $login_url . '" class="login-button">Login with Google</a>';
        }
        ?>
    </div>
</body>

</html>