<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
include 'navbar.php';

$message = "";
$username = $_SESSION['username'];

// get user id
$userQuery = "SELECT user_id FROM users WHERE username='$username'";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();
$user_id = $user['user_id'];

// handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $water = $_POST['water_intake'];
    $calories = $_POST['calories'];
    $sleep = $_POST['sleep_hours'];
    $exercise = $_POST['exercise_minutes'];

    $sql = "INSERT INTO health_records 
            (user_id, water_intake, calories, sleep_hours, exercise_minutes, record_date)
            VALUES 
            ('$user_id', '$water', '$calories', '$sleep', '$exercise', CURDATE())";

    if ($conn->query($sql)) {
        $message = "Data added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Health Data</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
            padding-top: 90px;
        }

        .box {
            background: white;
            padding: 30px;
            width: 320px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
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
    </style>

</head>

<body>

<div class="box">

    <h2>Add Health Data</h2>

    <?php if ($message != "") echo "<p class='msg'>$message</p>"; ?>

    <form method="POST">

        <input type="number" step="0.1" name="water_intake" placeholder="Water Intake (L)" required>

        <input type="number" name="calories" placeholder="Calories" required>

        <input type="number" step="0.1" name="sleep_hours" placeholder="Sleep Hours" required>

        <input type="number" name="exercise_minutes" placeholder="Exercise (min)" required>

        <button type="submit">Save Data</button>

    </form>

</div>

</body>
</html>