<?php
include_once 'db.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

// Pagination setup
$limit = 10; // Max 10 rows per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search query
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch gudang data
$stmt = $gudang->search($search, $limit, $offset);
$total_rows = $gudang->countSearchResults($search);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse MSIB</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="my-4">
            <h1 class="text-center">Warehouse MSIB</h1>
        </header>

        <!-- Search & Add Data -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form class="form-inline" method="GET">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau lokasi gudang..." value="<?= htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                </form>
            </div>
            <div class="col-md-4 text-right">
                <a href="create.php" class="btn btn-success">Tambah Data Gudang</a>
            </div>
        </div>

        <!-- Table Gudang -->
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Gudang</th>
                    <th>Lokasi</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Waktu Buka</th>
                    <th>Waktu Tutup</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['location']); ?></td>
                        <td><?= htmlspecialchars($row['capacity']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['opening_hour']); ?></td>
                        <td><?= htmlspecialchars($row['closing_hour']); ?></td>
                        <td>
                            <a href="update.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            <a href="toggle_status.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">
                                <?= ($row['status'] == 'aktif') ? 'Non-Aktifkan' : 'Aktifkan'; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php
                $total_pages = ceil($total_rows / $limit);
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item " . ($i == $page ? "active" : "") . "'><a class='page-link' href='?page=$i&search=$search'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>

        <footer class="mt-4 text-center">
            <p>PT. CGS Fatifah Farida</p>
        </footer>
    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>