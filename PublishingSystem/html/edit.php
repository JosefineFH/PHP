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
    <link rel="stylesheet" type="css" href="../includes/css/style.php">
</head>

<body>
    <h1>Edit you articel</h1>
    <section id="body">
        <form name="insertrecord" method="post">
            <div class="row">
                <div class="col-md-4"><b>title</b>
                    <input type="text" name="title" value="<?php echo $data[0]['title']; ?>" class="form-control">
                </div>

                <div class="col-md-8"><b>content</b>
                    <textarea class="form-control" name="content"><?php echo $data[0]['content']; ?></textarea>
                </div>
            </div>
            <div class="row" style="margin-top:1%">
                <div class="col-md-8">
                    <input type="submit" name="update" value="Update">
                </div>
                <div class="col-md-8">
                    <input type="submit" name="Cancel" value="Cancel">
                </div>
            </div>
        </form>

    </section>
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