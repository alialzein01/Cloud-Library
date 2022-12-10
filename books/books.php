<?php
include("../connection.php");
$query = mysqli_query($connection, "SELECT * FROM books");
$books = mysqli_fetch_all($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="books.css">
    <title>Books List</title>
</head>

<body>
<div id="mainContainer" class="mainContainer">
    <?php foreach ($books as $book) { ?>
        <div id="container0" class="container">
            <a href=book.php?id=<?php echo $book[0] ?> id="bookLink0">
                <div class="product-image">
                    <img id="bookImage0" src="<?php echo $book[3] ?>" alt="" class="bookImage"/>
                    <div class="info">
                        <h2 id="bookName0"><?php echo $book[1] ?></h2>
                        <p style="border: 0;" id="testt">Copies left: <?php echo $book[4] ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>
</body>

</html>