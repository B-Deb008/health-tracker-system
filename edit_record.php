<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
include 'navbar.php';

$id = $_GET['id'];

// get record
$sql = "SELECT * FROM health_records WHERE record_id=$id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

$message = "";

// update record
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $water = $_POST['water_intake'];
    $calories = $_POST['calories'];
    $sleep = $_POST['sleep_hours'];
    $exercise = $_POST['exercise_minutes'];

    $update = "UPDATE health_records SET 
        water_intake='$water',
        calories='$calories',
        sleep_hours='$sleep',
        exercise_minutes='$exercise'
        WHERE record_id=$id";

    if ($conn->query($update)) {
        header("Location: view_records.php");
        exit();
    } else {
        $message = "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #1a252f;
        }

        a {
            display: block;
            margin-top: 10px;
        }
    </style>

</head>

<body>

<div class="box">

    <h2>Edit Record</h2>

    <?php if ($message != "") echo "<p>$message</p>"; ?>

    <form method="POST">

        <input type="number" name="water_intake" value="<?php echo $data['water_intake']; ?>" required>

        <input type="number" name="calories" value="<?php echo $data['calories']; ?>" required>

        <input type="number" step="0.1" name="sleep_hours" value="<?php echo $data['sleep_hours']; ?>" required>

        <input type="number" name="exercise_minutes" value="<?php echo $data['exercise_minutes']; ?>" required>

        <button type="submit">Update</button>

    </form>

    <a href="view_records.php">Back</a>

</div>

</body>
</html>