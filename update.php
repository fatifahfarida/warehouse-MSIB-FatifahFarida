<?php
include_once 'db.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

// Pastikan ID tersedia
if (isset($_GET['id'])) {
    $gudang->id = $_GET['id'];
    $gudang_data = $gudang->getById($gudang->id);

    // Jika form disubmit
    if ($_POST) {
        $gudang->name = $_POST['name'];
        $gudang->location = $_POST['location'];
        $gudang->capacity = $_POST['capacity'];
        $gudang->status = $_POST['status'];
        $gudang->opening_hour = $_POST['opening_hour'];
        $gudang->closing_hour = $_POST['closing_hour'];

        if ($gudang->update()) {
            header("Location: index.php?success=Data updated successfully");
        } else {
            echo "<div class='alert alert-danger'>Unable to update data.</div>";
        }
    }
} else {
    header("Location: index.php?error=No ID provided");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Gudang</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Edit Data Gudang</h1>
        <form action="update.php?id=<?= $gudang->id ?>" method="POST">
            <div class="form-group">
                <label for="name">Nama Gudang</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($gudang_data['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Lokasi</label>
                <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($gudang_data['location']) ?>" required>
            </div>
            <div class="form-group">
                <label for="capacity">Kapasitas</label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?= htmlspecialchars($gudang_data['capacity']) ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="aktif" <?= $gudang_data['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="tidak_aktif" <?= $gudang_data['status'] == 'tidak_aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <label for="opening_hour">Waktu Buka</label>
                <input type="time" class="form-control" id="opening_hour" name="opening_hour" value="<?= htmlspecialchars($gudang_data['opening_hour']) ?>" required>
            </div>
            <div class="form-group">
                <label for="closing_hour">Waktu Tutup</label>
                <input type="time" class="form-control" id="closing_hour" name="closing_hour" value="<?= htmlspecialchars($gudang_data['closing_hour']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
    </div>
</body>
</html>
