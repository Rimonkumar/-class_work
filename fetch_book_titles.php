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

$sql = "SELECT book_title FROM bookss";
$result = $conn->query($sql);

$bookTitles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookTitles[] = $row["book_title"];
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($bookTitles);
?>
