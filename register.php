<?php
session_start();

include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // check if user exists
    $check = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $message = "Username already exists!";
    } else {

        $sql = "INSERT INTO users (username, name, password, age, gender)
                VALUES ('$username', '$name', '$password', '$age', '$gender')";

        if ($conn->query($sql)) {
            $message = "Registration successful! You can login now.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

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
            width: 340px;
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

        input, select, button {
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
            color: green;
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

    <h2>Create Account 📝</h2>

    <?php if ($message != "") echo "<p class='msg'>$message</p>"; ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Age</label>
        <input type="number" name="age" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <button type="submit">Register</button>

    </form>

    <a class="link" href="login.php">Already have an account? Login</a>

</div>

</body>
</html>