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

$sql = "SELECT book_title, author_name, category FROM bookss";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='max-height: 300px; overflow-y: auto;'>";
    echo "<table border='1' style='width:100%; text-align:left;'>";
    echo "<tr><th>Title</th><th>Author</th><th>Category</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><button onclick=\"showInfo('" . htmlspecialchars($row["book_title"]) . "', '" . htmlspecialchars($row["author_name"]) . "', '" . htmlspecialchars($row["category"]) . "')\">" . htmlspecialchars($row["book_title"]) . "</button></td>";
        echo "<td>" . htmlspecialchars($row["author_name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "No books found.";
}

$conn->close();
?>
