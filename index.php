<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Health Tracker</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;

            display: flex;
            justify-content: center;
            align-items: center;

            height: 100vh;
        }

        .box {
            background: white;

            width: 90%;
            max-width: 520px;

            padding: 60px;

            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.15);

            text-align: center;
        }

        h1 {
            font-size: 34px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            font-size: 18px;
            margin-bottom: 35px;
            color: #555;
        }

        a {
            display: block;
            margin: 15px 0;
            padding: 15px;

            background: #2c3e50;
            color: white;

            text-decoration: none;
            border-radius: 8px;

            font-size: 18px;
            transition: 0.3s;
        }

        a:hover {
            background: #1a252f;
            transform: scale(1.03);
        }

        @media (max-width: 600px) {
            .box {
                padding: 35px;
            }

            h1 {
                font-size: 26px;
            }

            a {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>

</head>

<body>

<div class="box">

    <h1>Health Tracker 🩺</h1>
    <p>Track your daily health easily and stay fit</p>

    <a href="login.php">Login</a>
    <a href="register.php">Register</a>

</div>

</body>
</html>