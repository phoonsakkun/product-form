<?php
// Database connection settings
$db_host = 'localhost:8889';
$db_user = 'root';
$db_password = 'root';
$db_name = 'productdb';

// Connect to the database
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Prepare the SQL statement
    $sql = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $name, $description, $price);

    // Execute the query
    if ($stmt->execute()) {
        $status = "Product submitted successfully!";
    } else {
        $status = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Submission</title>
</head>
<body>
    <h1>Product Submission Form</h1>
    <form method="post" >
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required><br>

        <input type="submit" value="Submit">
    </form>

    <?php if (isset($status)): ?>
        <p>Status: <?php echo $status; ?></p>
    <?php endif; ?>
</body>
</html>
