<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrowing Management</title>
    <link rel="stylesheet" href="style/style.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
    <script>
        function showInfo(title, author, category) {
            document.getElementById('formTitle').value = title;
            document.getElementById('formAuthor').value = author;
            document.getElementById('formCategory').value = category;
            document.getElementById('newTitle').value = title;
            document.getElementById('newAuthor').value = author;
            document.getElementById('newCategory').value = category;
            document.getElementById('box2').classList.remove('hidden');
        }

        function refreshDatabaseInfo() {
            fetch('fetch_books.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('databaseInfo').innerHTML = data;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            refreshDatabaseInfo();
        });
    </script>
</head>

<body>
<h1 style="text-align: center;">Book Borrowing Management <br> <img class="id-img " src="id.png" alt="ID"></h1>

<div class="main">

    <div class="left used-tokens-container">
        <h3>Used Tokens</h3>
        <?php
        // Read the used tokens JSON file
        $usedTokensData = file_get_contents('used.json');
        $usedTokens = json_decode($usedTokensData, true) ?: [];

        if (!empty($usedTokens)) {
            echo "<ul>";
            foreach ($usedTokens as $usedToken) {
                echo "<li>" . htmlspecialchars($usedToken) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='no-used-tokens-message'>No used tokens found.</p>";
        }
        ?>
    </div>

    <div class="middle">
        <div class="first-box">
            <div class="">
                <h2>Database Information</h2>
                <div id="databaseInfo">
                    <!-- Database information will be loaded here -->
                </div>
            </div>
        </div>

        <div class="second-box">
        <h2>Manage Information</h2>
            <div id="box2" class="hidden">
                <form action="update_delete.php" method="post" onsubmit="refreshDatabaseInfo()">
                    <input type="hidden" name="title" id="formTitle">
                    <input type="hidden" name="author" id="formAuthor">
                    <input type="hidden" name="category" id="formCategory">
                    <label for="new_title">New Title</label>
                    <input type="text" name="new_title" id="newTitle" required>
                    <label for="new_author">New Author</label>
                    <input type="text" name="new_author" id="newAuthor" required>
                    <label for="new_category">New Category</label>
                    <input type="text" name="new_category" id="newCategory" required>
                    <button type="submit" name="update">Update</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            </div>
        </div>

        <div class="third-box">
            <div class="image-container">
                <div class="box2">
                    <img src="111.png">
                </div>
                <div class="box2">
                    <img src="112.jpg">
                </div>
                <div class="box2">
                    <img src="121.jpg">
                </div>
            </div>
        </div>

        <div class="box6">
            <div class="add-book-container">
                <form action="add_book.php" method="post">
                    <table>
                        <tr>
                            <td><label for="book_title">Book Title</label></td>
                            <td><input type="text" id="book_title" name="book_title" required></td>
                        </tr>
                        <tr>
                            <td><label for="author_name">Author Name</label></td>
                            <td><input type="text" id="author_name" name="author_name" required></td>
                        </tr>
                        <tr>
                            <td><label for="isbn">ISBN</label></td>
                            <td><input type="text" id="isbn" name="isbn" required></td>
                        </tr>
                        <tr>
                            <td><label for="quantity">Quantity</label></td>
                            <td><input type="number" id="quantity" name="quantity" min="1" required></td>
                        </tr>
                        <tr>
                            <td><label for="category">Category</label></td>
                            <td><input type="text" id="category" name="category" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Add Book">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div class="third">
            <div class="box3_1 ">
                <form action="process.php" method="post">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="id">Student AIUB ID</label>
                    <input type="text" id="id" name="student_id" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="books">Book Title</label>
                    <select id="books" name="books" required>
                        <option value="B1">BOOK1</option>
                        <option value="B2">BOOK2</option>
                        <option value="B3">BOOK3</option>
                        <option value="B4">BOOK4</option>
                        <option value="B5">BOOK5</option>
                        <option value="B6">BOOK6</option>
                        <option value="B7">BOOK7</option>
                        <option value="B8">BOOK8</option>
                        <option value="B9">BOOK9</option>
                        <option value="B10">BOOK10</option>
                    </select>

                    <label for="date">Borrow Date</label>
                    <input type="date" id="date" name="date" required>

                    <label for="token">Token</label>
                    <input type="number" id="token" name="token" min="0">

                    <label for="Return_date">Return Date</label>
                    <input type="date" id="Return_date" name="Return_date" required>

                    <label for="fees">Fees</label>
                    <input type="number" id="fees" name="fees" min="0" step="0.01">

                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>

            <div class="box3_">
                <?php
                // Read the JSON file
                $jsonData = file_get_contents('token.json');

                // Decode the JSON data into a PHP array
                $data = json_decode($jsonData, true);

                // Check if data is loaded successfully
                if (isset($data[0]['token'])) {
                    $tokens = $data[0]['token'];

                    // Display the tokens in a styled format
                    echo "<div style='border: 2px solid #4CAF50; border-radius: 10px; padding: 20px; max-width: 300px; font-family: Arial, sans-serif;'>";
                    echo "<h2 style='color: #4CAF50; text-align: center;'>Available Tokens</h2>";
                    echo "<ul style='list-style: none; padding: 0;'>";

                    foreach ($tokens as $token) {
                        echo "<li style='background: #f9f9f9; margin: 5px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px; text-align: center; font-size: 18px;'>";
                        echo htmlspecialchars($token);
                        echo "</li>";
                    }

                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "<p style='color: red; font-family: Arial, sans-serif;'>No tokens found in the JSON file.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="right">
        Right Box
    </div>
</div>

</body>
</html>