<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
include 'navbar.php';

$username = $_SESSION['username'];

// get user id
$userQuery = "SELECT user_id FROM users WHERE username='$username'";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();
$user_id = $user['user_id'];

// base query
$where = "WHERE user_id=$user_id";

/* -------------------------
   SEARCH BY ID (FIXED)
--------------------------*/
if (!empty($_GET['search_id'])) {
    $id = $_GET['search_id'];
    $where .= " AND record_id = $id";
}

/* -------------------------
   SEARCH BY DATE
--------------------------*/
if (!empty($_GET['date'])) {
    $date = $_GET['date'];
    $where .= " AND record_date = '$date'";
}

/* -------------------------
   FINAL QUERY
--------------------------*/
$sql = "SELECT * FROM health_records $where ORDER BY record_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Records</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
            padding-top: 70px;
            text-align: center;
        }

        .box {
            margin: 20px auto;
        }

        input, button {
            padding: 8px;
            margin: 5px;
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

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #2c3e50;
            color: white;
        }
    </style>

</head>

<body>

<h2>Search Health Records 🔍</h2>

<div class="box">

    <form method="GET">

        <!-- ID SEARCH -->
        <input type="number" name="search_id" placeholder="Search by ID">

        <!-- DATE SEARCH -->
        <input type="date" name="date">

        <button type="submit">Search</button>

    </form>

</div>

<table>

    <tr>
        <th>ID</th>
        <th>Water</th>
        <th>Calories</th>
        <th>Sleep</th>
        <th>Exercise</th>
        <th>Date</th>
    </tr>

    <?php if ($result->num_rows > 0) { ?>

        <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row['record_id']; ?></td>
            <td><?php echo $row['water_intake']; ?> L</td>
            <td><?php echo $row['calories']; ?> kcal</td>
            <td><?php echo $row['sleep_hours']; ?> hrs</td>
            <td><?php echo $row['exercise_minutes']; ?> min</td>
            <td><?php echo $row['record_date']; ?></td>
        </tr>

        <?php } ?>

    <?php } else { ?>

        <tr>
            <td colspan="6">No records found</td>
        </tr>

    <?php } ?>

</table>

</body>
</html>