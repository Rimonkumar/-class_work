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
    $bookTitle = $_POST["book_title"];
    $authorName = $_POST["author_name"];
    $isbn = $_POST["isbn"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category"];

    $sql = "INSERT INTO bookss (book_title, author_name, isbn, quantity, category) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssds", $bookTitle, $authorName, $isbn, $quantity, $category);

    if ($stmt->execute()) {
        echo "New book added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
