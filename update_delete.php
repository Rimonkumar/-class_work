<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "class_work";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $category = $_POST["category"];

    if (isset($_POST["update"])) {
        $newTitle = $_POST["new_title"];
        $newAuthor = $_POST["new_author"];
        $newCategory = $_POST["new_category"];

        $sql = "UPDATE bookss SET book_title=?, author_name=?, category=? WHERE book_title=? AND author_name=? AND category=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $newTitle, $newAuthor, $newCategory, $title, $author, $category);

        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST["delete"])) {
        $sql = "DELETE FROM bookss WHERE book_title=? AND author_name=? AND category=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $author, $category);

        if ($stmt->execute()) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
