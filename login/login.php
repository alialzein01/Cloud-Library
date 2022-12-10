<?php
include('../scripts/login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <div>
        <h1><span style="color: red;">Log</span><span style="color: black;">in</span></h1>
        <form method="POST">
            <input type="text" name="inputt" placeholder="Username or Email">
            <input type="password" name="pass" placeholder="Password">
            
            <button type="submit" name="login">Submit</button>
            <p>New User? <a href="../signUp/signup.php">Signup here.</a></p>
        </form>
    </div>
</body>
</html>