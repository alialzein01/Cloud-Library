<?php
//connection
include('../connection.php');

//query
if (isset($_POST['add'])) {

    //Document name
    if (isset($_POST["dname"]) && $_POST["dname"] != "") {
        $dname = mysqli_real_escape_string($connection, $_POST["dname"]);
    } else {
        die("Document name is missing");
    }


    //Document description
    if (isset($_POST["ddes"]) && $_POST["ddes"] != "") {
        $ddes = mysqli_real_escape_string($connection, $_POST["ddes"]);
    } else {
        die("Document description is missing");
    }

    //image
    if (!empty($_POST['doc_image'])) {
        $doc_image = '../resources/' . mysqli_real_escape_string($connection, $_POST["doc_image"]);
    } else {
        die('Please select an image file to upload');
    }

    //doc copies
    if (isset($_POST["copiesR"]) && $_POST["copiesR"] != "") {
        $dCop = mysqli_real_escape_string($connection, $_POST["copiesR"]);
    } else {
        die("Number of remaining copies is missing");
//    $errors[] = "Error: \"Number of remaining copies is missing\"";
//    $isValid = false;
    }


    //doc category
    if (isset($_POST["dCategory"]) && $_POST["dCategory"] != "") {
        $dCat = mysqli_real_escape_string($connection, $_POST["dCategory"]);
    } else {
        die("Document category is missing");
    }


    $mysql = $connection->prepare("INSERT INTO documents(document_name, document_description, document_image, copies_left, document_category_id) VALUES (?,?,?,?,?)");
    $mysql->bind_param("ssssi", $dname, $ddes, $doc_image, $dCop, $dCat);
    $mysql->execute();
    $mysql->close();

}