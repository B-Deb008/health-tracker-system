<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
include 'navbar.php';

$username = $_SESSION['username'];
$message = "";

// fetch user info
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    if (!empty($password)) {
        $update = "UPDATE users SET 
                    username='$new_username',
                    name='$name',
                    password='$password',
                    age='$age',
                    gender='$gender'
                  WHERE username='$username'";
    } else {
        $update = "UPDATE users SET 
                    username='$new_username',
                    name='$name',
                    age='$age',
                    gender='$gender'
                  WHERE username='$username'";
    }

    if ($conn->query($update)) {
        $_SESSION['username'] = $new_username;
        $message = "Profile updated successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Management</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
            padding-top: 90px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
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
            text-align: center;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="box">

        <h2>Profile Management 👤</h2>

        <?php if ($message != "") echo "<p class='msg'>$message</p>"; ?>

        <form method="POST">

            <label>Username</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>

            <label>Full Name</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter new password (optional)">

            <label>Age</label>
            <input type="number" name="age" value="<?php echo $user['age']; ?>" required>

            <label>Gender</label>
            <select name="gender" required>
                <option value="Male" <?php if($user['gender']=="Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if($user['gender']=="Female") echo "selected"; ?>>Female</option>
                <option value="Other" <?php if($user['gender']=="Other") echo "selected"; ?>>Other</option>
            </select>

            <button type="submit">Update Profile</button>

        </form>

    </div>

</div>

</body>
</html>