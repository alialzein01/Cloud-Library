<?php

include('../connection.php');

if (isset($_POST['register'])){


//first name
  if(isset($_POST["fname"]) && $_POST["fname"] != ""){
    $fname = mysqli_real_escape_string($connection, $_POST["fname"]);
  }else{
    die("First name is missing");
//    $errors[] = "Error: \"First name is missing\"";
//    $isValid = false;
  }

//last name
  if(isset($_POST["lname"]) && $_POST["lname"] != ""){
    $lname = mysqli_real_escape_string($connection, $_POST["lname"]);
  }else{
    die("Last name is missing");
//    $errors[] = "Error: \"Last name is missing\"";
//    $isValid = false;
  }

//username
  if(isset($_POST["username"]) && $_POST["username"] != ""){
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    if(strlen($username) < 8){
      die("Username must have at least 8 characters");
//      $errors[] = "Error: \"Username must have at least 8 characters\"";
//      $isValid = false;
    }
  }else{
    die("Username is missing");
//    $errors[] = "Error: \"Username is missing\"";
//    $isValid = false;
  }

//email + validation
  if(isset($_POST["email"]) && $_POST["email"] != ""){
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false){
      die("Enter a valid email address");
//      $errors[] = "Error: \"Enter a valid email address\"";
//      $isValid = false;
    }
  }else{
    die("Email is missing");
//    $errors[] = "Error: \"Email is missing\"";
//    $isValid = false;
  }


//password
  if(isset($_POST["pass_1"]) && $_POST["pass_1"] != ""){
    $pass_1 = mysqli_real_escape_string($connection, $_POST["pass_1"]);
    $pass_2 = mysqli_real_escape_string($connection, $_POST["pass_2"]);

    //similar passwords + atleast 8 characters
    if($pass_1 != $pass_2){
      die("Passwords does not match");
//      $errors[] = "Error: \"Passwords doesn't match\"";
//      $isValid = false;
    }
    if($pass_1 == $pass_2 && strlen($pass_1) < 8){
      die("Password must have atleast 8 characters");
//      $errors[] = "Error: \"Password must have atleast 8 characters\"";
//      $isValid = false;
    }
  }else{
    die("Password is missing");
//    $errors[] = "Error: \"Password is missing\"";
//    $isValid = false;
  }

  //hashing password
  $password = hash("sha256", $pass_1);

  //unique username, email and phone number for each user
  $user_check_query = "SELECT * FROM users WHERE email='$email' or username='$username'";
  $res = mysqli_query($connection, $user_check_query);

  $user = mysqli_fetch_assoc($res);

  if($user){

    if($user['username'] == $username && $user['email'] == $email){
      die("Error: \"Username and email already exist\"");
    }

    if($user['username'] == $username){
      die("Error: \"Username already exist\"");
    }

    if($user['email'] == $email){
      die("Error: \"Email already exist\"");
    }
  }

  //user image
  if(!empty($_POST['usr_image'])) {
    $iamge_url = '../resources/' . mysqli_real_escape_string($connection, $_POST["usr_image"]);
  } else {
    die('Please select an image file to upload');
  }

  $role = 0;
  $verification_num = rand(100000,999999);
  $verified = 0;

  $mysql = $connection->prepare("INSERT INTO users(role, user_image, first_name, last_name, username, email, password, verified, verification_number) VALUES (?,?,?,?,?,?,?,?,?)");
  $mysql->bind_param("issssssii", $role, $iamge_url, $fname, $lname, $username, $email, $password, $verified, $verification_num);
  $mysql->execute();



  header("Location:../../homepage/home.html");


}