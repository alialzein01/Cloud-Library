<?php
//include('../scripts/login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <title>Login</title>
</head>
<body>
<div>
    <h1><span style="color: red;">Log</span><span style="color: black;">in</span></h1>
    <form method="POST" id=login-form>
        <input type="text" name="inputt" placeholder="Username or Email" id="user-id">
        <input type="password" name="pass" placeholder="Password" id="pass">
        <button type="submit" name="login">Submit</button>
        <p>New User? <a href="../signUp/signup.php">Signup here.</a></p>
    </form>
    <p id="login-error"></p>
</div>
<script>
    // Listen for the form submission
    $('#login-form').on('submit', function (e) {
        // Prevent the form from being submitted
        e.preventDefault();

        // Get the username and password from the form
        var user_id = $('#user-id').val()
        var password = $('#pass').val();

        // Send the username and password to the PHP script using Ajax
        $.ajax({
            type: 'POST',
            url: '../scripts/login.php',
            data: {
                inputt: user_id,
                password: password
            },
            success: function (response) {
                console.log(response);
                // If the login was successful, redirect the user to the homepage
                if (response == 'success') {
                    window.location.href = '../homepage/home.html';
                } else {
                    // Otherwise, display an error message
                    $('#login-error').text('Invalid username or password');
                }
            },
            fail: function (response) {
                console.log(response);
            }
        });
    });
</script>
</body>
</html>