<?php
include('login.php');

//start session
session_start();

$usercredentials = new User();

if (isset($_POST['login'])) {
    //posted valus
    $username = $_POST['username'];
    $password = $_POST['password'];

    //function calling
    $userLogin = $usercredentials->check_login($username, $password);

    if ($userLogin > 0) {
        $_SESSION['user'] = $userLogin[0]['userid'];
        
        // For success
        var_dump($_SESSION['user']);
        header('location:loggedin.php');
    } else {
        // Message for unsuccessfull login
        $_SESSION['message'] = 'You need to login first';

        header('location:index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/css/style.css" type="text/css">
    <title>Login</title>
</head>

<body>
    <section>
        <form class="login-form" action="" method="POST">
            <input placeholder="Username" type="text" name="username" autofocus><br><br>
            <input placeholder="Password" type="password" name="password"><br><br>
            <button class="login-button" type="submit" name="login">Login</button>

        </form>
    </section>
    <!-- <?php
    if (isset($_SESSION['message'])) {
    ?>
        <div class="alert alert-info text-center">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php

        unset($_SESSION['message']);
    }
    ?> -->
</body>
<style>

</style>

</html>