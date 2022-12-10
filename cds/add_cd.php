<?php
//connection
include('../connection.php');

//query
if (isset($_POST['add'])) {

    //cd name
    if (isset($_POST["cname"]) && $_POST["cname"] != "") {
        $cname = mysqli_real_escape_string($connection, $_POST["cname"]);
    } else {
        die("CD name is missing");
    }


    //cd description
    if (isset($_POST["cdes"]) && $_POST["cdes"] != "") {
        $cdes = mysqli_real_escape_string($connection, $_POST["cdes"]);
    } else {
        die("CD description is missing");
    }

    //image
    if (!empty($_POST['cd_image'])) {
        $cd_image = '../resources/' . mysqli_real_escape_string($connection, $_POST["cd_image"]);
    } else {
        die('Please select an image file to upload');
    }

    //cd copies
    if (isset($_POST["copiesR"]) && $_POST["copiesR"] != "") {
        $cCop = mysqli_real_escape_string($connection, $_POST["copiesR"]);
    } else {
        die("Number of remaining copies is missing");
    }


    //cd category
    if (isset($_POST["cCategory"]) && $_POST["cCategory"] != "") {
        $cCat = mysqli_real_escape_string($connection, $_POST["cCategory"]);
    } else {
        die("CD Category is missing");
    }


    $mysql = $connection->prepare("INSERT INTO cds(cd_name, cd_description, cd_image, copies_left, cd_category_id) VALUES (?,?,?,?,?)");
    $mysql->bind_param("ssssi", $cname, $cdes, $cd_image,$cCop, $cCat);
    $mysql->execute();
    $mysql->close();
}