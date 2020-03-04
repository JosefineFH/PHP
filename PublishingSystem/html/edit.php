<?php

session_start();
//return to login if not logged in
if (!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
    header('location:index.php');
}

include_once('../classes/function.class.php');

$getArticlesId = new functions();
$articleId = $_GET['id'];
$data = $getArticlesId->getArticlesId($articleId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Article </title>
    <link rel="stylesheet" href="../includes/css/style.css" type="text/css">
</head>

<body>
    <div class="editForm">
        <h1>Edit you articel</h1>

        <section class="editContainer">
            <form name="insertrecord" method="post">

                <div>
                    <label>Title</label>
                    <div>
                        <input type="text" name="title" value="<?php echo $data[0]['title']; ?>" class="form-control">
                    </div>

                    <div>
                        <label>Content</label> <br>
                        <textarea name="content"><?php echo $data[0]['content']; ?></textarea>
                    </div>
                </div>

                <div>
                    <div class="update">
                        <input type="submit" name="update" value="Update">

                        <input type="submit" name="Cancel" value="Cancel">
                    </div>
                </div>

            </form>

        </section>
    </div>
</body>

</html>

<?php
$updateArticle = new functions();

if (isset($_POST['update'])) {
    $articleId = intval($_GET['id']);
    $title = $_POST['title'];
    $content = $_POST['content'];

    header("Location: loggedin.php");
    $sql = $updateArticle->updateArticle($articleId, $title, $content);
}


if (isset($_POST['Cancel'])) {

    header("Location: loggedin.php");
}
?>