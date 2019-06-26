<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- <?php
    // include_once 'db/db_connection.php';
    ?> -->
</head>

<body>

    <div class="grid-container">
        <div class="col1">
            <?php include("includes/navbar.html"); ?>
        </div>

        <div class="col2">
            <form method="post">
                <table>
                    <tr>
                        <td>Email:</td>
                        <td> <input type="email" name="email"></td>
                    </tr>
                    <tr>
                        <td>Passord:</td>
                        <td> <input type="password" name="password"></td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Login">
            </form>

        </div>



        <div class="col4">
            Footer
        </div>
    </div>

</body>

</html>