<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
include 'navbar.php';

$username = $_SESSION['username'];

// Get user id
$userQuery = "SELECT user_id FROM users WHERE username='$username'";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();
$user_id = $user['user_id'];

// Get latest health record
$sql = "SELECT * FROM health_records WHERE user_id=$user_id ORDER BY record_id DESC LIMIT 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
            padding-top: 70px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            text-align: center;
        }

        .welcome {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .logout {
            margin-top: 20px;
        }

        button {
            padding: 10px;
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: #1a252f;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="welcome">
        <h2>Welcome, <?php echo $_SESSION['username']; ?> 🎉</h2>
        <p>You are successfully logged in.</p>
    </div>

    <?php if ($data): ?>

    <div class="cards">

        <div class="card">
            <h3>Water Intake 💧</h3>
            <p><?php echo $data['water_intake']; ?> L</p>
        </div>

        <div class="card">
            <h3>Calories 🔥</h3>
            <p><?php echo $data['calories']; ?> kcal</p>
        </div>

        <div class="card">
            <h3>Sleep 😴</h3>
            <p><?php echo $data['sleep_hours']; ?> hrs</p>
        </div>

        <div class="card">
            <h3>Exercise 🏃</h3>
            <p><?php echo $data['exercise_minutes']; ?> min</p>
        </div>

    </div>

    <?php else: ?>

        <p>No health data found. Please add your record.</p>

    <?php endif; ?>

    <div class="logout">
        <a href="logout.php">
            <button>Logout</button>
        </a>
    </div>

</div>

</body>
</html>