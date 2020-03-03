<?php
session_start();
//return to login if not logged in
if (!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
    header('location:index.php');
}

include_once('../classes/function.class.php');

$getArticles = new functions();
$userId = explode(" ", $_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/css/style.css" type="text/css">

    <h1>Logedin</h1>
</head>

<body>
    <a href="logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>

    <table width="100%" border="0">
        <tr>
            <th>Title</th>
            <th>content</th>
        </tr>
        <?php
        $sql = $getArticles->getArticles($userId);
        $cnt = 1;
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
            $cnt++;
        } ?>
        </tbody>
    </table>

    </table>
</body>

</html>