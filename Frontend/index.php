<?php
// Database connection details
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission (Add User)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $conn->real_escape_string($_POST['name']);
    if (!empty($name)) {
        $sql = "INSERT INTO users (name) VALUES ('$name')";
        if (!$conn->query($sql)) {
            echo "Error: " . $conn->error;
        } else {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = $id";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all users
$users = [];
$result = $conn->query("SELECT * FROM users");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users Page</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px 0;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 0 auto;
        }

        h1 {
            color: #333333;
            margin-bottom: 20px;
            text-align: center;
        }

        form input[type="text"] {
            padding: 10px;
            width: 80%;
            border: 1px solid #cccccc;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        form button {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        form button:hover {
            background-color: #45a049;
        }

        h2 {
            color: #555555;
            margin-top: 25px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            max-height: 300px;
            overflow-y: auto;
        }

        ul li {
            background-color: #e0e0e0;
            margin: 5px 0;
            padding: 8px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
         <h1>Manara SSA Course Project </h1>

         <h1>(simple web server)</h1>

         <h1>This Data is Loaded from the RDS</h1>

        <form method="POST">
            <input type="text" name="name" placeholder="Enter your name" required>
            <br>
            <button type="submit">Save</button>
        </form>

        <h2>Stored Users:</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <?php echo htmlspecialchars($user['name']); ?>
                    <form method="GET" style="display:inline;">
                        <input type="hidden" name="delete" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
