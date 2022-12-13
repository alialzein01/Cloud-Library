<?php
session_start();
include '../connection.php';

if (!isset($_GET['type'])) {
    die('error');
} else if ($_GET['type'] == 'Books') {
    $item = showBook($pdo);
} else if ($_GET['type'] == 'Cds') {
    $item = showCd($pdo);
} else if ($_GET['type'] == 'Documents') {
    $item = showDocument($pdo);
} else {
    $item = [];
}


?>
<!DOCTYPE html>

<html lang="eng">
<head>
    <meta charset="utf-8">
    <title>Assignmnet 2</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>

</head>
<body>
<?php include "../components/navbar.php"; ?>
<div class="innerBody">
    <div class="left">
        <div class="horizantal-container">
            <div class="book-name">
                <?php echo $item['name'] ?>
            </div>
            <?php if ($_GET['type'] != 'Cds' or $_GET['type'] != 'Books') { ?>
                <?php if ($item['quantity'] > 0) { ?>
                    <div class="available">
                        Available
                    </div>
                <?php } else { ?>
                    <div class="not-available">
                        Not Available
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="horizantal-container">
            <div class="genre">
                Musical
            </div>
            <?php if ($_GET['type'] != 'Cds' or $_GET['type'] != 'Books') { ?>
                <div class="price">
                    <?php echo $item['quantity'] ?>pcs
                </div>
            <?php } ?>
        </div>
        <div class="desc">
            <?php echo $item['description'] ?>
        </div>
        <div class="horizantal-container">

        </div>
        <?php if ($_GET['type'] == 'Cds' or $_GET['type'] == 'Books') { ?>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>
                <input type="date" name="start_date">
                <input type="date" name="end_date">
                <button name="borrow" type="submit" class="order-button">
                    Borrow Now
                </button>
            </form>
            <?php
            if (isset($_POST['borrow'])) {
                //check if user is authenticated
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /authentication/login.php');
                }

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $item_id = $_POST['id'];
                $user_id = $_SESSION['user_id'];
                $errors = array();
                //check if the start date is not null
                if (!empty($start_date) or !empty($end_date)) {
                    //check if the start date is not greater than the end date
                    if (strtotime($start_date) > strtotime($end_date)) {
                        $errors[] = 'start date must be less than end date';
                    }
                } else {
                    $errors[] = 'start date and end date must not be empty';
                }

                foreach ($errors as $error) {
                    echo $error;
                }
                if (count($errors) == 0) {
                    if ($_GET['type'] == 'Books') {

                        //check if book quantity is greater than 0
                        $sql = "SELECT * FROM books WHERE id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$item_id]);
                        $result = $stmt->fetch();

                        if ($result['quantity'] == 0) {
                            echo "Not Available";
                        } else {
                            //check if book is borrowed by this user
                            $sql = "SELECT * FROM borrowed_books WHERE user_id = ? AND book_id = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$user_id, $item_id]);
                            $result = $stmt->fetch();
                            if ($result) {
                                echo "You have already borrowed this book";
                            } else {
                                $sql = "INSERT INTO `borrowed_books` (`user_id`, `book_id`, `start_date`, `end_date`) VALUES (?, ?, ?, ?)";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$user_id, $item_id, $start_date, $end_date]);
                                if ($stmt->rowCount() > 0) {
                                    //decrease number of books by 1
                                    $sql = "UPDATE books SET quantity = quantity - 1 WHERE id = ?";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([$item_id]);
                                    echo "Borrowed";
                                } else {
                                    echo "Error";
                                }
                            }
                        }
                    } else if ($_GET['type'] == 'Cds') {
                        //check if the cd quantity is greater than 0
                        $sql = "SELECT * FROM cds WHERE id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$item_id]);
                        $result = $stmt->fetch();
                        if ($result['quantity'] == 0) {
                            echo "Not Available";
                        } else {
                            //check if cd is borrowed by this user
                            $sql = "SELECT * FROM borrowed_cds WHERE user_id = ? AND cd_id = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$user_id, $item_id]);
                            $result = $stmt->fetch();
                            if ($result) {
                                echo "You have already borrowed this cd";
                            } else {
                                $sql = "INSERT INTO `borrowed_cds` (`user_id`, `cd_id`, `start_date`, `end_date`) VALUES (?, ?, ?, ?)";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$user_id, $item_id, $start_date, $end_date]);
                                if ($stmt->rowCount() > 0) {
                                    //decrease number of cds by 1
                                    $sql = "UPDATE cds SET quantity = quantity - 1 WHERE id = ?";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([$item_id]);
                                    echo "Borrowed";
                                } else {
                                    echo "Error";
                                }
                            }
                        }
                    }
                }

            }
            ?>
        <?php } ?>
    </div>
    <div class="right">
        <img class="book-image" src="<?php echo $item['image'] ?>"/>
    </div>
</div>


</body>

</html>