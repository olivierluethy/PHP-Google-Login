# PHP-Google-Login
This project is an implementation of a simple Google Login system in PHP.

## Requirements
1. PHP >= 5.6
2. Composer
2. Google API Console Project with enabled Google+ API and Google OAuth 2.0 API

## Setup Guide
1. Clone this repository:
```
git clone https://github.com/[username]/PHP-Google-Login.git
```

2. Navigate to the project directory:
cd PHP-Google-Login

3. Install the dependencies using Composer:
composer install

4. Create a new project in Google API Console.

5. Enable Google+ API and Google OAuth 2.0 API for the project.

6. Create a new OAuth client ID.

7. Update the client ID, client secret and redirect URI in index.php:

```php
$client->setClientId('YOUR_CLIENT_ID');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setRedirectUri('YOUR_REDIRECT_URI');
```

8. Start the PHP built-in server:

```cmd
php -S localhost:8000
```

9. Access the application in your browser at ```http://localhost:8000```.

## Common Errors and Solutions
<strong>Missing dependencies:</strong><br>If you get an error related to missing classes, make sure you have installed the dependencies using Composer.<br><br>
<strong>Undefined index:</strong><br>If you get an error related to undefined index in $_GET['code'], make sure that you have granted access to your Google account and the authorization code is being passed in the URL.<br><br>
<strong>Redirect URI mismatch:</strong><br>If you get an error related to redirect URI mismatch, make sure that the redirect URI in your OAuth client ID configuration in Google API Console matches the one in index.php.

## Troubleshooting
If you face any issues, feel free to create an issue in this repository or ask for help in the comments section.
