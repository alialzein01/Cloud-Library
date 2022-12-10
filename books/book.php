<?php
include("../connection.php");
$bookID = $_GET['id'];
$sql = "SELECT book_name, book_description,copies_left, book_author FROM books WHERE book_id=" . $bookID;
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bookdetails.css" rel="stylesheet" type="text/css">
    <title>Bookk details</title>
</head>

<body>
<div class="detailsContainer">
    <img class="bookcover" src="http://universe.byu.edu/wp-content/uploads/2015/01/HP4cover.jpg">
    <div class="bookdetails">
        <h2 class="booktitle"><?php echo $row['book_name'] ?></h2>
        <h4 class="author">by <?php echo $row['book_author'] ?>
        </h4>
        <p class="bookDesc"><?php echo $row['book_description'] ?></p>
        <p class="copiesLeft">Copies left: <?php echo $row['copies_left'] ?>
        </p>
        <button class="reserveButton">
            Reserve A Copy
        </button>

    </div>
</div>

</body>

</html>
