<?php
include_once 'db.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

// Pastikan ID tersedia di URL
if (isset($_GET['id'])) {
    $gudang->id = $_GET['id'];

    // Jika penghapusan berhasil
    if ($gudang->delete()) {
        header("Location: index.php?success=Data deleted successfully");
    } else {
        header("Location: index.php?error=Failed to delete data");
    }
} else {
    header("Location: index.php?error=No ID provided");
}
