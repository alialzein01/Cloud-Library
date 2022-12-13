<?php
include ('../connection.php');
$errors = array();

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    //check if user id is empty
    if (empty($user_id)) {
        $errors[] = "Error, User id is empty";
    }
    //check if books id is empty
    if (empty($book_id)) {
        $errors[] = "Error, Book id is empty";
    }
    //check if user id is valid
    if (!empty($user_id)) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            $errors[] = "Error, User id is invalid";
        }
    }
    //check if book id is valid
    if (!empty($book_id)) {
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$book_id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$book) {
            $errors[] = "Error, Book id is invalid";
        }
    }
    //check is user has already reserved the book
    if (!empty($user_id) && !empty($book_id)) {
        $sql = "SELECT * FROM books_reserved WHERE user_id = ? AND book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $book_id]);
        $reserved_book = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($reserved_book) {
            $errors[] = "Error, User has already reserved the book";
        }
    }
    //check if book is available
    if (!empty($book_id)) {
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$book_id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($book['copies_left'] == 0) {
            $errors[] = "Error, Book is not available";
        }
    }
    //reserve book
    if (count($errors) == 0) {
        try {
            $sql = "INSERT INTO books_reserved (user_id, book_id) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $book_id]);
            //decrease book quantity
            $sql = "UPDATE books SET copies_left = copies_left - 1 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$book_id]);
            header('Location: reserved-books.php?message=success');
        } catch (Exception $exception) {
            $errors[] = $exception->getMessage();
        }
    }
}