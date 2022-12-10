<?php
include("../connection.php");
$query = mysqli_query($connection, "SELECT * FROM cds");
$cds = mysqli_fetch_all($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cds.css">
    <title>CDs List</title>
</head>

<body>
<div id="mainContainer" class="mainContainer">
    <?php foreach ($cds as $cd) { ?>
        <div id="container0" class="container">
            <a href=cd.php?id=<?php echo $cd[0] ?> id="cdLink0">
                <div class="product-image">
                    <img id="cdImage0" src="<?php echo $cd[3] ?>" alt="" class="cdImage"/>
                    <div class="info">
                        <h2 id="cdName0"><?php echo $cd[1] ?></h2>
                        <p style="border: 0;" id="testt">Copies left: <?php echo $cd[4] ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>
</body>

</html>