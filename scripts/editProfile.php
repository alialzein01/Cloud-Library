<?php

include('../connection.php');

if(!isset($_SESSION))
{
  session_start();
}

if (isset($_POST['updateSubmit'])) {
  if (!empty($_POST['usr_image']) && !empty($_POST['fname']) && !empty($_POST['lname'])) {

    $new_usr_image = '../resources/' . mysqli_real_escape_string($connection, $_POST['usr_image']);
    $new_fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $new_lname = mysqli_real_escape_string($connection, $_POST['lname']);

    $update_query = "UPDATE users SET first_name=?, last_name=?, user_image=? WHERE user_id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("sssi", $new_fname, $new_lname, $new_usr_image, $_SESSION['user_id']);
    $update_stmt->execute();

    $_SESSION['usr_image'] = $new_usr_image;
    $_SESSION['fname'] = $new_fname;
    $_SESSION['lname'] = $new_lname;

  } else if (!empty($_POST['usr_image']) && !empty($_POST['fname'])) {
    $new_usr_image = '../resources/' . mysqli_real_escape_string($connection, $_POST['usr_image']);
    $new_fname = mysqli_real_escape_string($connection, $_POST['fname']);

    $update_query = "UPDATE users SET first_name=?, user_image=? WHERE user_id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("ssi", $new_fname, $new_usr_image, $_SESSION['user_id']);
    $update_stmt->execute();

    $_SESSION['usr_image'] = $new_usr_image;
    $_SESSION['fname'] = $new_fname;

  } else if (!empty($_POST['usr_image']) && !empty($_POST['lname'])) {
    $new_usr_image = '../resources/' . mysqli_real_escape_string($connection, $_POST['usr_image']);
    $new_lname = mysqli_real_escape_string($connection, $_POST['lname']);

    $update_query = "UPDATE users SET last_name=?, user_image=? WHERE user_id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("ssi", $new_lname, $new_usr_image, $_SESSION['user_id']);
    $update_stmt->execute();

    $_SESSION['usr_image'] = $new_usr_image;
    $_SESSION['lname'] = $new_lname;

  } else if (!empty($_POST['fname']) && !empty($_POST['lname'])) {
    $new_fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $new_lname = mysqli_real_escape_string($connection, $_POST['lname']);

    $update_query = "UPDATE users SET first_name=?, last_name=? WHERE user_id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("ssi", $new_fname, $new_lname, $_SESSION['user_id']);
    $update_stmt->execute();

    $_SESSION['fname'] = $new_fname;
    $_SESSION['lname'] = $new_lname;

  } else if (!empty($_POST['usr_image'])) {
    $new_usr_image = '../resources/' . mysqli_real_escape_string($connection, $_POST['usr_image']);


    $update_query = "UPDATE users SET user_image=? WHERE user_id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("si", $new_usr_image, $_SESSION['user_id']);
    $update_stmt->execute();

    $_SESSION['usr_image'] = $new_usr_image;

  } else if (!empty($_POST['fname'])) {
    $new_fname = mysqli_real_escape_string($connection, $_POST['fname']);

    $update_query = "UPDATE users SET first_name=? WHERE user_id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("si", $new_fname, $_SESSION['user_id']);
    $update_stmt->execute();

    $_SESSION['fname'] = $new_fname;

  } else if (!empty($_POST['lname'])) {
    $new_lname = mysqli_real_escape_string($connection, $_POST['lname']);

    $update_query = "UPDATE users SET last_name=? WHERE user_id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("si", $new_lname, $_SESSION['user_id']);
    $update_stmt->execute();

    $_SESSION['lname'] = $new_lname;


  }

}

if(isset($_POST['updatePassSubmit'])) {
  if(!empty($_POST['oldPass']) && !empty($_POST['newPass'])) {
    $input_pass = mysqli_real_escape_string($connection, $_POST['oldPass']);
    $new_pass = mysqli_real_escape_string($connection, $_POST['newPass']);

    if(strlen($new_pass) > 8) {

      if (hash('sha256', $input_pass) == $_SESSION['password']) {

        if($input_pass != $new_pass) {

          $new_pass = hash('sha256', $new_pass);

          $updatePass_query = "UPDATE users SET password=? WHERE user_id=?";
          $updatePass_stmt = $connection->prepare($updatePass_query);
          $updatePass_stmt->bind_param("si", $new_pass, $_SESSION['user_id']);
          $updatePass_stmt->execute();
        }

      }else {
        die('Error Occurred');
      }

    }else {
      die('Error: \"Password must have least 8 characters\"');
    }

  }
}
