<?php
include_once 'db.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

// Pastikan ID gudang tersedia
if (isset($_GET['id'])) {
    $gudang->id = $_GET['id'];

    if ($gudang->toggleStatus()) {
        header("Location: index.php?success=Status updated successfully");
    } else {
        header("Location: index.php?error=Failed to update status");
    }
} else {
    header("Location: index.php?error=No ID provided");
}
