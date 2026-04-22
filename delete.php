<?php
include 'db.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM health_records WHERE record_id=$id";

    if ($conn->query($sql)) {
        header("Location: view_records.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

} else {
    echo "Invalid request!";
}
?>