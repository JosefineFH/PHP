<?php
session_start();
//return to login if not logged in
if (!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
    header('location:index.php');
}

include_once('../classes/function.class.php');

$getArticles = new functions();
$userId = explode(" ", $_SESSION['user']);

$getUserFullname = new functions();
$fullUserName = $getUserFullname->getUserFullbane($userId);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/css/style.css" type="text/css">
</head>

<body>

    <div class="article">
        <section>
            <!-- Prints full name of the user who is logged in -->
            <h1>Welcomes <?php echo $fullUserName[0]['fullname']; ?></h1>
        </section>

        <section>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                </tr>

                <?php
                $sql = $getArticles->getArticles($userId);
                $count = 1;

                foreach ($sql as $data) {
                ?>

                    <tr>
                        <td>
                            <a href="edit.php?id=<?php echo htmlentities($data['id']); ?>">
                                <?php echo $data['title']; ?>
                            </a>

                        </td>
                        <td>
                            <?php echo $data['fullname']; ?>
                        </td>

                    </tr>
                <?php
                    // for serial number increment
                    $count++;
                } ?>
            </table>
        </section>

        <section>
            <a href="logout.php" class="button"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
        </section>
    </div>
</body>

</html>