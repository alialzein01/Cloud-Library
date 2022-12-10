<?php

include('../connection.php');


if(isset($_POST['submit'])) {
//get the inputted info on verify.html
  $ver_email = $_POST["email"];
  $ver_number = $_POST["verification"];

//query to get the verification number for a user from the database
  $ver_query = "SELECT verification_number FROM users WHERE email=?";
  $ver_stmt = $connection->prepare($ver_query);
  $ver_stmt->bind_param("s", $ver_email);
  $ver_stmt->execute();
  $ver_res = $ver_stmt->get_result();

  $ver_row = $ver_res->fetch_assoc();
  $ver_json = json_encode($ver_row);

//modified the inputted verification number
  $ver2_number = "{\"verification_number\":$ver_number}";

//comparing the verification number set by the one in the database
  if ($ver_json == $ver2_number) {

    //query to change the verified section in the database to "True" if the if statement is correct
    $change_verified = "UPDATE users SET verified='1' WHERE email=?";
    $change_stmt = $connection->prepare($change_verified);
    $change_stmt->bind_param("s", $ver_email);
    $change_stmt->execute();
    echo "Your email is successfully verified"; //to be deleted when homepage is done

    $change_stmt->close();

    header("Location:../homepage/home.html"); //homepage

  } else {
    echo "Error: verification number is incorrect";
  }

  $ver_stmt->close();
  $connection->close();

}


?>
