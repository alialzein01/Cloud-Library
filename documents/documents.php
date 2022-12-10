<?php
include("../connection.php");
$query = mysqli_query($connection, "SELECT * FROM documents");
$documents = mysqli_fetch_all($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="documents.css">
    <title>Documents List</title>
</head>

<body>
<div id="mainContainer" class="mainContainer">
    <?php foreach ($documents as $document) { ?>
        <div id="container0" class="container">
            <a href=<?php echo $document[2] ?>>
                <div class="product-image">
                    <img id="bookImage0" src="<?php echo $document[3] ?>" alt="" class="documentImage"/>
                    <div class="info">
                        <h2 id="bookName0"><?php echo $document[1] ?></h2>
                        <p style="border: 0;" id="testt">Copies left: <?php echo $document[4] ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>
</body>

</html>