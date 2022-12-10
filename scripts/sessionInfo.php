<?php

include('../connection.php');

if(!isset($_SESSION))
{
  session_start();
}

if(isset($_SESSION['input'])) {

  //  get user info
  $info_query = $connection->prepare("SELECT user_id, first_name, last_name, username, email, user_image, role, password FROM users WHERE username=? or email=?");
  $info_query->bind_param('ss', $_SESSION['input'], $_SESSION['input']);
  $info_query->execute();

  $info_result = $info_query->get_result();

  $info_row = $info_result->fetch_assoc();

  $info_json = json_encode($info_row);

  $info = explode("\"", $info_json);


  $user_id = $info[2][1];

  $first_name = $info[5];

  $last_name = $info[9];

  $username = $info[13];

  $email = $info[17];

  $user_image = $info[21];

  $role = $info[24][1];

  $password = $info[27];


  if($role == 0) {
    $usr_role = 'Student';
  }else {
    $usr_role = 'Instructor';
  }

  $_SESSION['user_id'] = $user_id;
  $_SESSION['fname'] = $first_name;
  $_SESSION['lname'] = $last_name;
  $_SESSION['username'] = $username;
  $_SESSION['password'] = $password;
  $_SESSION['usr_image'] = $user_image;


//  echo $_SESSION['username'];
//  echo $_SESSION['fname'];
//  echo $_SESSION['lname'];

}else {
  die('no active session');
}