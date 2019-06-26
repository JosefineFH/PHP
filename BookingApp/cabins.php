<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
.img {
    height: 400px;
    margin-left: 10%;
}

<?php include 'includes/css/cabins.css';
?>
</style>

<body>

    <div class="grid-container">

        <div class="col1">
            <?php include("includes/navbar.html"); ?>
        </div>

        <div class="col2">

            <p> Cabin 1</p>
            <img class="img" src="includes/imag/cabin2_1.jpg" alt="">

        </div>

        <div class="col3">
            <p>Hytte 1 </p>
            <button> Order </button>
        </div>

        <div class="col4">
        </div>
    </div>

</body>

</html>