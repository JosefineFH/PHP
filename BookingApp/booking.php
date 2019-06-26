<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <?php
 include_once 'db/db_connection.php';
?>
</head>
<style>
<?php include 'includes/css/booking.css';
?>
</style>

<body>

    <?php

     if (isset($_POST['submit'])) {
         $firstName = $_POST['firstName'];
         $lastName = $_POST['lastName'];
         $cabin = $_POST['cabin'];
         $startDate = $_POST['startDate'];
         $endDate = $_POST['endDate'];
         $phoneNumber = $_POST['phoneNumber'];
         $email = $_POST['email'];
         $hasToStoreInDn = password_hash($_POST['password'], PASSWORD_DEFAULT);
         $num_guests = $_POST['num_guests'];
         $message = $_POST['message'];


         $sql = "INSERT INTO
  booking (
    cabin,
    firstName,
    lastName,
    startDate,
    endDate,
    phoneNumber,
    email,
    password,
    num_guests,
    message
  )
VALUES
  (
    '$cabin',
    '$firstName',
    '$lastName',
    '$startDate',
    '$endDate',
    '$phoneNumber',
    '$email',
    '$hasToStoreInDn',
    '$num_guests',
    '$message'
  )";
         if ($conn->query($sql) === true) {
             echo "New record created successfully";
         } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }
         header('Location: booking.php'); //clears POST
     }

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
/* $todaysDay = date(); */

?>

    <div class="grid-container">

        <div class="col1">
            <?php include("includes/navbar.html"); ?>
        </div>

        <div class="col2">
            <form method="post" action="">
                <table>
                    <tr>
                        <td>
                            <p>First Name:</p>
                            <input type="text" name="firstName">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Last Name:</p>
                            <input type="text" name="lastName">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Email:</p>
                            <input type="email " name="email">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Password</p>

                            <input type="password " name="password">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Mobil: </p> <input type="number " name="phoneNumber">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Velg din hytte:</p>
                            <select name="cabin">
                                <option value="By the Water">Hytte ved Sjøen</option>
                                <option value="By opp i terne">Hytte Opp i trerne</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Antall Mennesker:</p>
                            <select name="num_guests">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Innsjekk:</p>
                            <input min="" type="date" name="startDate" value="<?php echo $today; ?>"
                                class="form-control" id="date" name="date">
                            <p>Utsjekk:</p>
                            <input type="date" name="endDate">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <textarea rows="4" cols="50" name="message"></textarea>
                        </td>
                    </tr>
                </table>
                <button name="submit"> Submit</button>
            </form>


        </div>

        <div class="col4">
        </div>
    </div>

</body>

</html>