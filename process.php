<?php
$errors = [];
$receiptDisplayed = false;

// Load tokens and used tokens
$jsonData = file_get_contents('token.json');
$data = json_decode($jsonData, true);
$tokens = isset($data[0]['token']) ? $data[0]['token'] : [];

$usedTokensData = file_get_contents('used.json');
$usedTokens = json_decode($usedTokensData, true) ?: [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect inputs
    $bookTitle = $_POST["books"] ?? '';
    $name = $_POST['name'] ?? '';
    $studentID = $_POST["student_id"] ?? '';
    $studentMail = $_POST["email"] ?? '';
    $borrowDate = $_POST["date"] ?? '';
    $returnDate = $_POST["Return_date"] ?? '';
    $fees = $_POST["fees"] ?? 0;
    $token = $_POST['token'] ?? '';

    // Validate inputs (name, ID, email, dates)
    if (!preg_match("/^([A-Z][a-z]+\.?\s)?[A-Z][a-z]+(\s[A-Z][a-z]+)+$/", $name)) {
        $errors[] = "The name format is invalid.";
    }
    if (!preg_match("/^\d{2}-\d{5}-\d$/", $studentID)) {
        $errors[] = "Invalid ID format. Use '11-11111-1'.";
    }
    if (!preg_match("/^\d{2}-\d{5}-\d@student\.aiub\.edu$/", $studentMail)) {
        $errors[] = "Invalid email format.";
    }

    // Validate token if needed
    $isValidToken = false;
    if ($borrowDate && $returnDate) {
        $borrowDateObj = new DateTime($borrowDate);
        $returnDateObj = new DateTime($returnDate);
        $interval = $borrowDateObj->diff($returnDateObj);

        if ($borrowDateObj >= $returnDateObj) {
            $errors[] = "Return date must be after the borrow date.";
        } elseif ($interval->days > 10) {
            if (in_array($token, $tokens)) {
                if (in_array($token, $usedTokens)) {
                    $errors[] = "This token has already been used.";
                } else {
                    $isValidToken = true;
                }
            } else {
                $errors[] = "Invalid token for return date exceeding 10 days.";
            }
        }
    } else {
        $errors[] = "Both borrowing and return dates must be provided.";
    }

    // Check if the book is already borrowed
    if (empty($errors) && isset($_COOKIE[$bookTitle])) {
        $currentBorrower = $_COOKIE[$bookTitle];
        $errors[] = "This book is already borrowed by $currentBorrower. Wait 10 days before borrowing it again.";
    }

    // Set the cookie and display the receipt if no errors
    if (empty($errors) && !isset($_COOKIE[$bookTitle])) {
        setcookie($bookTitle, $name, time() + 30); // 10 days
        $receiptDisplayed = true;

        // Add token to used.json if valid
        if ($isValidToken) {
            $usedTokens[] = $token;
            file_put_contents('used.json', json_encode($usedTokens));
        }

        echo "<div class='receipt-container'>";
        echo "<div class='receipt'>";
        echo "<h2>Borrow Book Receipt</h2>";
        echo '<div class="item"><span><strong>Student Name:</strong></span><span>' . htmlspecialchars($name) . '</span></div>';
        echo '<div class="item"><span><strong>Student ID:</strong></span><span>' . htmlspecialchars($studentID) . '</span></div>';
        echo '<div class="item"><span><strong>Email:</strong></span><span>' . htmlspecialchars($studentMail) . '</span></div>';
        echo '<div class="item"><span><strong>Book Title:</strong></span><span>' . htmlspecialchars($bookTitle) . '</span></div>';
        echo '<div class="item"><span><strong>Borrow Date:</strong></span><span>' . htmlspecialchars($borrowDate) . '</span></div>';
        echo '<div class="item"><span><strong>Return Date:</strong></span><span>' . htmlspecialchars($returnDate) . '</span></div>';
        if ($interval->days > 10) {
            echo '<div class="item"><span><strong>Token:</strong></span><span>' . htmlspecialchars($token) . '</span></div>';
        } else {
            echo '<div class="item"><span><strong>Token:</strong></span><span>Not required</span></div>';
        }

        echo '<div class="item"><span><strong>Fees:</strong></span><span>TK' . number_format((float)$fees, 2) . '</span></div>';
        echo '<div class="total"><strong>Total:</strong> TK' . number_format((float)$fees, 2) . '</div>';
        echo "</div>"; // Close .receipt
        echo "</div>"; // Close .receipt-container
    }

    // Display errors
    if (!empty($errors)) {
        echo "<div class='error-message'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    }
}
?>

<style>
    .receipt-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .receipt {
        border: 1px solid #ddd;
        padding: 20px;
        width: 400px;
        background-color: #fff;
        box-shadow: 0 0 10px hsla(0, 59.40%, 50.80%, 0.10);
        font-family: Arial, sans-serif;
    }

    .receipt h2 {
        text-align: center;
        color:rgb(62, 45, 106);
    }

    .receipt hr {
        border: 0;
        border-top: 2px solid #ddd;
        margin: 20px ;
    }

    .item {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
    }

    .item span:first-child {
        font-weight: bold;
        color:rgb(77, 106, 45);
        width: 45%;
    }

    .item span:last-child {
        color: #333;
        width: 45%;
        text-align: right;
    }

    .total {
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        color:rgb(190, 57, 230);
    }

    .error-message {
        color: red;
        font-family: Arial, sans-serif;
        text-align: center;
        margin-top: 20px;
    }

    .error-message p {
        margin: 5px;
    }
</style>
