<?php

include('../connection.php');

$input = '';
$pass_1 = '';
$password = '';

session_start();

if(isset($_POST["login"])) {

//Username or email input
  if (isset($_POST["inputt"]) || $_POST["inputt"] != "") {
    $input = mysqli_real_escape_string($connection, $_POST["inputt"]);
  } else {
    die("Error:Input your email or username");
  }

  $_SESSION['input'] = $input;


//Password
  if (isset($_POST["pass"]) && $_POST["pass"] != "") {
    $pass_1 = mysqli_real_escape_string($connection, $_POST["pass"]);
  } else {
    die("Error:Input your password");
  }


//hashing password
  $password = hash("sha256", $pass_1);


//query to login using email or username with the correct password
  $query = "SELECT password FROM users WHERE username = ? or email = ?";
  $stmt = $connection->prepare($query);
  $stmt->bind_param("ss", $input, $input);
  $stmt->execute();
  $results = $stmt->get_result();


  $row = $results->fetch_assoc();


//comparing the input password with the one in the database
  $json = json_encode($row);

  $password_check = "{\"password\":\"$password\"}";

  if ($json == $password_check) {

    $ver_query = "SELECT verified FROM users WHERE username=? or email=?";
    $ver_stmt = $connection->prepare($ver_query);
    $ver_stmt->bind_param("ss", $input, $input);
    $ver_stmt->execute();

    $ver_result = $ver_stmt->get_result();
    $ver_row = $ver_result->fetch_assoc();
    $ver_json = json_encode($ver_row);

    if($ver_json ==  "{\"verified\":1}"){
      header('Location: ../profile/profile.php');
    }else {
      die("Error: Email not verified");
    }

  } else {
    die("Error: Failed to log in");
  }
}
