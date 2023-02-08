<?php

require_once __DIR__ . '/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('1098007898151-8thpcqfm8aem4pgfkm6o6ob0c01r75be.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/php-google-login/index.php');
$client->addScope('https://www.googleapis.com/auth/plus.login');
$client->addScope('https://www.googleapis.com/auth/userinfo.email');
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');

if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token);

  $_SESSION['access_token'] = $token;

  header('Location: http://localhost/PHP-Google-Login/index.php');
  exit;
}?>

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
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $oauth = new Google_Service_Oauth2($client);
            $user = $oauth->userinfo->get();
          
            $name = $user->getName();
            $email = $user->getEmail();
            $profileImageUrl = $user->getPicture();
          
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
        
            // Check if the user is already in the database
            try {
                $conn = new PDO("mysql:host=localhost;dbname=habasch", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT email FROM users WHERE email = :email";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();
                } catch (PDOException $e) {
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
                echo "Error: " . $e->getMessage();
            }
        }

        
            echo '<div class="user-info">';
                echo '<img src="' . $profileImageUrl . '" class="user-image" />';
                echo '<div class="user-details">';
                    echo '<h1 class="user-name">' . $name . '</h1>';
                    echo '<h3 class="user-email">' . $email . '</h3>';
                echo '</div>';
            echo '</div>';
            echo '<a href="logout.php" class="logout-button">Logout</a>';
        } else {
            $login_url = $client->createAuthUrl();
            echo '<a href="' . $login_url . '" class="login-button">Login with Google</a>';
        }        
        ?>
    </div>
</body>

</html>