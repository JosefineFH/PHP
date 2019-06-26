<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php
 include_once 'db/db_connection.php';
?>
</head>

<body>
    <?php
// $sql = "SELECT email FROM booking where email='josefine.magnussen@hotmail.com'";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while ($row = $result->fetch_assoc()) {
//         echo $row["email"];
//     }
// } else {
//     echo "0 results";
// }


?>
    <div class="grid-container">

        <div class="col1">
            <?php include("includes/navbar.html"); ?>
        </div>

        <div class="col2">
            <form method="post" action="login.php">
                Userpage

                <button>Logut</button>
            </form>


        </div>



        <div class="col4">
            Footer
        </div>
    </div>

</body>

</html>