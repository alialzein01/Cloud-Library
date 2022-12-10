<?php
include('../connection.php');
include("../scripts/signup.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>SignUp</title>
</head>

<body>
    <div>
        <form method="post">
            <h1><span style="color: red;">Sign</span><span style="color: black;"> Up</span></h1>
            
            <input type="text" name="fname" placeholder="First Name">
            <input type="text" name="lname" placeholder="Last Name">
            <input type="text" name="username" placeholder="Username">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pass_1" placeholder="Password">
            <input type="password" name="pass_2" placeholder="Confirm Password">

            <input type="file" id="file" accept="image/png, image/jpg, image/gif, image/jpeg" name="usr_image">
            
            <button type="submit" name="register">Submit</button>

        </form>
    </div>
</body>

</html>