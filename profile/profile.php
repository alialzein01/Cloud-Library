<?php
include('../connection.php');
include('../scripts/editProfile.php');
include('../scripts/sessionInfo.php');
include('../scripts/login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>

<body>
<?php
if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == 'true') {
// Print a message to the user
    echo 'Welcome back, you are logged in!';
} else {
// Print a message to the user
    echo 'Please log in to access this page.';
}
?>
<div class="dvPadding">
    <div class="flex">
        <div class="left">
            <img src="<?php echo $user_image; ?>" alt="Error in Loading pic">
        </div>
        <div class="right">
            <div class="info" id="info">
                <div>
                    -Name: <?php echo $username; ?>
                </div>
                <div>
                    -Email: <a href="<?php echo $email; ?>"><?php echo $email; ?></a>
                </div>
                <div>
                    -Role: <?php echo $usr_role; ?>
                </div>
            </div>

            <!-- Edit username / first name / last name-->
            <div class="editt">
                <div class="edit" id="edit" style="display: none;">
                    <form id="edit-form" method="post">
                        <label for="">First Name:</label>
                        <input type="text" id="email" name="fname" placeholder="<?php echo $first_name; ?>">
                        <br>
                        <label for="">Last Name:</label>
                        <input type="text" id="email" name="lname" placeholder="<?php echo $last_name; ?>">
                        <br>
                        <label for="name">Image:</label>
                        <input type="file" id="file" accept="image/png, image/jpg, image/gif, image/jpeg"
                               name="usr_image">
                        <br>
                        <div class="buttons-cont">
                            <button name="updateSubmit">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="editt">
                <div class="changePass" id="changePass" style="display: none;">
                    <form id="pass-form" method="POST">
                        <label for="name">Old Password:</label>
                        <input type="password" id="oldPass" name="oldPass" placeholder="Old value"> <br>
                        <label for="">New Password:</label>
                        <input type="password" id="newPass" name="newPass" placeholder="New value"> <br>

                        <div class="buttons-cont">
                            <button name="updatePassSubmit">Update</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <div class="buttons-cont">
        <button id="edit-btn" onclick="edit()">Edit</button>
        <button id="update-btn" onclick="update()" style="display: none;">Cancel</button>
        <button id="changePass-btn" onclick="editPass()">Change Password</button>
        <button id="updatePass-btn" onclick="updatePass()" style="display: none;">Cancel</button>
    </div>
</div>
<script>
    function edit() {
        document.getElementById("info").style.display = "none";
        document.getElementById("edit").style.display = "block";
        document.getElementById("edit-btn").style.display = "none";
        document.getElementById("update-btn").style.display = "block";

        document.getElementById("changePass").style.display = "none";
        document.getElementById("changePass-btn").style.display = "none";
    }

    function update() {
        document.getElementById("info").style.display = "block";
        document.getElementById("edit").style.display = "none";
        document.getElementById("edit-btn").style.display = "block";
        document.getElementById("update-btn").style.display = "none";

        document.getElementById("changePass-btn").style.display = "block";
    }

    function editPass() {
        document.getElementById("info").style.display = "none";
        document.getElementById("edit").style.display = "none";
        document.getElementById("changePass").style.display = "block";
        document.getElementById("changePass-btn").style.display = "none";
        document.getElementById("updatePass-btn").style.display = "block";

        document.getElementById("edit").style.display = "none";
        document.getElementById("edit-btn").style.display = "none";
    }

    function updatePass() {
        document.getElementById("info").style.display = "block";
        document.getElementById("changePass").style.display = "none";
        document.getElementById("changePass-btn").style.display = "block";
        document.getElementById("updatePass-btn").style.display = "none";

        document.getElementById("edit-btn").style.display = "block";
    }

</script>


<footer>
    <script src="../common/footer.js"></script>
</footer>

</body>

</html>