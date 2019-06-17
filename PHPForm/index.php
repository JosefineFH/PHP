<!DOCTYPE HTML>
<html>
<head>
<style>
<?php include 'css/Form.css'; ?>
</style> 
</head>

<body>

<nav id="navbar"> 
<h1 id="logo">Web contact:</h1>
</nav>
    <?php
    // define variables and set to empty values
    $name = $email = $gender = $comment = $website = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
        $email = test_input($_POST["email"]);
        $website = test_input($_POST["website"]);
        $comment = test_input($_POST["comment"]);
        // $gender = test_input($_POST["gender"]);
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <?php
    $nameErr = $emailErr = $genderErr = $websiteErr = "";
    $name = $email = $gender = $comment = $website = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace

            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);

            //Check if e-mail address is well-formed

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["website"])) {
            $websiteErr = " Website is required";
        } else {
            $website = test_input($_POST["website"]);
            // check if URL address syntax is valid (this regular expression also allows dashes in the URL)

            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
                $websiteErr = "Invalid URL";
            }
        }

        if (empty($_POST["comment"])) {
            $comment = "";
        } else {
            $comment = test_input($_POST["comment"]);
        }

        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }
    }
    ?>

    <h2>Contact:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>Name: 
        <input class="input" type="text" name="name" value="<?php echo $name; ?>"></p>
        <span class="error"> * <?php echo $nameErr; ?></span>

        <p>E-mail: <input class="input" type="text" name="email" value="<?php echo
                                                            $email; ?>"></p>
        <span class="error"> * <?php echo $emailErr; ?></span>

        <p>Website: <input class="input" type="text" name="website" value="<?php echo
                                                                $website; ?>"></p>
        <span class="error"> * <?php echo $websiteErr; ?></span>

        <p>Comment:</p> 
        <textarea name="comment" rows="5" cols="40">
            <?php echo $comment; ?></textarea>

        <p>Gender:</p>
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">
        <a>Female</a>
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male">
        <a>Male</a>
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "other") echo "checked"; ?> value="other">
        <a>Other</a>

        <span class="error"> * <?php echo $genderErr; ?></span>
<br>
        <button type="submit" name="submit" value="Submit"> Submit</button>
    </form>
<hr>
    <h2>Your submitions:</h2>
    <table>
<tr>
    <th>Name:</th>
    <td><?php echo $name;?></td>
</tr>
<tr>
    <th>Email:</th>
    <td><?php echo $email;?></td>
</tr>
<tr>
    <th>Website:</th>
    <td><?php echo $website;?></td>
</tr>
<tr>
    <th>Comment:</th>
    <td><?php echo $comment;?></td>
</tr>
<tr>
    <th>Gender:</th>
    <td><?php echo $gender;?></td>
</tr>
    </table>
    <footer></footer>
</body>

</html>