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

// fetch records
$sql = "SELECT * FROM health_records WHERE user_id=$user_id ORDER BY record_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Records</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
            padding-top: 70px;
            text-align: center;
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
        }

        th {
            background: #2c3e50;
            color: white;
        }

        a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .edit {
            background: #3498db;
            color: white;
        }

        .delete {
            background: #e74c3c;
            color: white;
        }
    </style>

</head>

<body>

<h2>Your Health Records 📊</h2>

<table>

    <tr>
        <th>ID</th>
        <th>Water</th>
        <th>Calories</th>
        <th>Sleep</th>
        <th>Exercise</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

    <tr>
        <td><?php echo $row['record_id']; ?></td>
        <td><?php echo $row['water_intake']; ?> L</td>
        <td><?php echo $row['calories']; ?> kcal</td>
        <td><?php echo $row['sleep_hours']; ?> hrs</td>
        <td><?php echo $row['exercise_minutes']; ?> min</td>
        <td><?php echo $row['record_date']; ?></td>

        <td>
            <!-- EDIT -->
            <a class="edit" href="edit_record.php?id=<?php echo $row['record_id']; ?>">Edit</a>

            <!-- DELETE (FIXED) -->
            <a class="delete"
               href="delete.php?id=<?php echo $row['record_id']; ?>"
               onclick="return confirm('Are you sure you want to delete this record?');">
               Delete
            </a>
        </td>
    </tr>

    <?php } ?>

</table>

</body>
</html>