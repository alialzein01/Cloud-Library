<?php
include("../connection.php");
$cdID = $_GET['id'];
$sql = "SELECT cd_name, cd_description,copies_left, cd_author FROM cds WHERE cd_id=" . $cdID;
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="cdDetails.css" rel="stylesheet" type="text/css">
    <title>CD details</title>
</head>

<body>
<div class="detailsContainer">
    <img class="cdcover" src="https://learning.oreilly.com/library/cover/9781771373470/360h/">
    <div class="cddetails">
        <h2 class="cdtitle"><?php echo $row['cd_name'] ?></h2>
        <h4 class="author">by <?php echo $row['cd_author'] ?>
        </h4>
        <p class="cdDesc"><?php echo $row['cd_description'] ?></p>
        <p class="copiesLeft">Copies left: <?php echo $row['copies_left'] ?>
        </p>
        <button class="reserveButton">
            Reserve A Copy
        </button>

    </div>
</div>

</body>

</html>
