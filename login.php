<?php
session_start();

include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
            height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: white;
            padding: 30px;
            width: 320px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 15px;
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #1a252f;
        }

        .msg {
            color: red;
            margin-bottom: 10px;
        }

        .link {
            margin-top: 10px;
            display: block;
        }
    </style>

</head>

<body>

<div class="box">

    <h2>Login 🔐</h2>

    <?php if ($message != "") echo "<p class='msg'>$message</p>"; ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>

    </form>

    <a class="link" href="register.php">Don't have an account? Register</a>

</div>

</body>
</html>