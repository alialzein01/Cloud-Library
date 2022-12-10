<?php
//connection
include('../connection.php');

//query
if (isset($_POST['add'])) {

    //book name
    if (isset($_POST["bname"]) && $_POST["bname"] != "") {
        $bname = mysqli_real_escape_string($connection, $_POST["bname"]);
    } else {
        die("Book name is missing");
    }


    //book description
    if (isset($_POST["bdes"]) && $_POST["bdes"] != "") {
        $bdes = mysqli_real_escape_string($connection, $_POST["bdes"]);
    } else {
        die("Book description is missing");
    }

    //image
    if (!empty($_POST['book_image'])) {
        $book_image = '../resources/' . mysqli_real_escape_string($connection, $_POST["book_image"]);
    } else {
        die('Please select an image file to upload');
    }

    //book copies
    if (isset($_POST["copiesR"]) && $_POST["copiesR"] != "") {
        $bCop = mysqli_real_escape_string($connection, $_POST["copiesR"]);
    } else {
        die("Number of remaining copies is missing");
//    $errors[] = "Error: \"Number of remaining copies is missing\"";
//    $isValid = false;
    }


    //book category
    if (isset($_POST["bCategory"]) && $_POST["bCategory"] != "") {
        $bCat = mysqli_real_escape_string($connection, $_POST["bCategory"]);
    } else {
        die("Book Category is missing");
//    $errors[] = "Error: \"Number of remaining copies is missing\"";
//    $isValid = false;
    }


    $mysql = $connection->prepare("INSERT INTO books(book_name, book_description, book_image, copies_left, book_category_id) VALUES (?,?,?,?,?)");
    $mysql->bind_param("ssssi", $bname, $bdes, $book_image, $bCop, $bCat);
    $mysql->execute();

    $mysql->close();

}