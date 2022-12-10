<?php

include('../connection.php');

$users = array();

$sql = "SELECT * FROM users";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {

//    echo "id: " . $row["user_id"] . "<br>" . "Name: " . $row["first_name"] . " " . $row["last_name"] . "<br>" . "Username: " . $row["username"] . "<hr>";

    $temp = array();

    $temp = [$row["user_id"], $row["username"], $row["first_name"], $row["last_name"], $row["email"], $row["role"], $row["user_image"], $row["verified"], $row["verification_number"], $row["password"]];

    array_push($users, $temp);

  }
} else {
  echo "0 results";
}

if (isset($_POST['updateSubmit'])) {

  $i = $_POST['array_index'];

  $usr_id = $_POST['user_id'];

  if(!empty($_POST['username'])) {
    $new_username = mysqli_real_escape_string($connection, $_POST['username']);
  }else {
    $new_username = $users[$i][1];
  }

  if(!empty($_POST['firstName'])) {
    $new_fname = mysqli_real_escape_string($connection, $_POST['firstName']);
  }else {
    $new_fname = $users[$i][2];
  }

  if(!empty($_POST['lastName'])) {
    $new_lname = mysqli_real_escape_string($connection, $_POST['lastName']);
  }else {
    $new_lname = $users[$i][3];
  }

  if(!empty($_POST['pass']) && $users[$i][9] != $_POST['pass']) {
    $new_password = mysqli_real_escape_string($connection, $_POST['pass']);
    $new_password = hash("sha256", $new_password);
  }else{
    $new_password = $users[$i][9];
  }

  if(!empty($_POST['usrImage'])) {
    $new_usr_image = '../resources/' . mysqli_real_escape_string($connection, $_POST['usrImage']);
  }else {
    $new_usr_image = $users[$i][6];
  }

  if( $users[$i][5] != $_POST['editRole']) {
    $new_role = mysqli_real_escape_string($connection, $_POST['editRole']);
  }else {
    $new_role = $users[$i][5];
  }

  if( $users[$i][7] != $_POST['verified']) {
    $isVerified = mysqli_real_escape_string($connection, $_POST['verified']);
  }else {
    $isVerified = $users[$i][7];
  }

  $update_query = "UPDATE users SET username=?, first_name=?, last_name=?, user_image=?, password=?, role=?, verified=? WHERE user_id=?";
  $update_stmt = $connection->prepare($update_query);
  $update_stmt->bind_param("sssssiii", $new_username, $new_fname, $new_lname, $new_usr_image, $new_password, $new_role, $isVerified, $usr_id);
  $update_stmt->execute();

  header("Location:../users/users.php");

//  echo $i . "<br>" . $new_username . "<br>" . $new_fname . "<br>" . $new_lname . "<br>" . $new_role . "<br>" . $new_usr_image . "<br>" . $new_password;

}


if(isset($_POST['deleteSubmit'])) {

  $usr_id = $_POST['user_id'];

  $delete_query = "DELETE FROM users WHERE user_id=?";
  $delete_stmt = $connection->prepare($delete_query);
  $delete_stmt->bind_param("i", $usr_id);
  $delete_stmt->execute();

  header("Location:../users/users.php");

}


if(isset($_POST['addUser'])) {

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

