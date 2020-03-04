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
    <link rel="stylesheet" href="../includes/css/style.css" type="text/css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <section>
            <h1> Login </h1>
        </section>
        <section>
            <form class="login-form" action="" method="POST">
                <input placeholder="Username" type="text" name="username" autofocus><br><br>
                <input placeholder="Password" type="password" name="password"><br><br>
                <button class="login-button" type="submit" name="login">Login</button>

            </form>
        </section>
    </div>
</body>
<style>

</style>

</html>