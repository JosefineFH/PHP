<!doctype html>
<html>

<head>
    <title> PHP </title>
</head>

<body>

    <?php
    $name = '';
    $password = '';

    if (isset($_POST['submit'])) {
        $ok = true;
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            $ok = false;
        } else {
            $name = $_POST['name'];
        }

        if (!isset($_POST['password']) || $_POST['password'] === '') {
            $ok = false;
        } else {
            $password = $_POST['password'];
        }

        if ($ok) {
            printf(
                'User name: %s 
    <br>Password: %s',
                htmlspecialchars($name),
                htmlspecialchars($password)

            );
        }
    }
    ?>

    <form method="post" actions="">
        <a>User Name: </a>
        <input type="text" name="name" value="
        <?php echo htmlspecialchars($name);?>"><br>

        <a> Password: </a>
        <input type="password" name="password" value="
        <?php echo htmlspecialchars($password); ?>">
        <br>

        <button type="submit" name="submit" value="submit"> Submit </button>
    </form>
</body>

<style>
a{
    
    font-size: 20px;
    margin-left: 2px;
}
input{

    border:none;
    border-bottom: black solid 1px;
}
</style>

</html>