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
    $stmt->bind_param("sssis", $bookTitle, $authorName, $isbn, $quantity, $category);

    try {
        $stmt->execute();
        echo "New book added successfully";
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            echo "Error: Duplicate entry for ISBN.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }

    $stmt->close();
}

$conn->close();
?>
