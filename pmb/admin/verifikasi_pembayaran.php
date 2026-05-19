<?php
session_start();
include '../config/koneksi.php';

// proteksi login
if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    echo "Akses ditolak!";
    exit;
}

// ==========================
// PROSES UPDATE STATUS
// ==========================
if(isset($_GET['aksi'])){

    $id = $_GET['id'];

    if($_GET['aksi'] == 'terima'){
        $status = 'lunas';
    } elseif($_GET['aksi'] == 'tolak'){
        $status = 'ditolak';
    } else {
        $status = 'pending';
    }

    mysqli_query($conn,"
        UPDATE pembayaran 
        SET status_verifikasi='$status' 
        WHERE id_pembayaran='$id'
    ");

    header("Location: verifikasi_pembayaran.php");
    exit;
}

// ==========================
// AMBIL DATA
// ==========================
$data = mysqli_query($conn,"
    SELECT pmb.*, p.nama_lengkap, p.asal_sekolah
    FROM pembayaran pmb
    JOIN pendaftaran p ON pmb.id_pendaftaran = p.id_pendaftaran
    ORDER BY pmb.id_pembayaran DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Verifikasi Pembayaran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
}

/* NAVBAR SAMA DASHBOARD */
.navbar{
    background: linear-gradient(135deg,#1e3a8a,#06b6d4);
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.nav-link{
    color:#fff !important;
    margin-right:6px;
    padding:6px 10px;
    border-radius:8px;
}

.nav-link:hover{
    background:rgba(255,255,255,0.15);
}

/* CARD STYLE */
.card{
    border:none;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

/* TABLE */
.table thead{
    background:#212529;
    color:white;
}
</style>
</head>

<body>

<!-- NAVBAR FIX FINAL -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="#">PMB Admin</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- KIRI KOSONG BIAR MENU KE KANAN -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- MENU + USER DIKANAN -->
            <ul class="navbar-nav align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="verifikasi_berkas.php">Berkas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="verifikasi_pembayaran.php">Pembayaran</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pengumuman.php">Pengumuman</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="data_ospek.php">OSPEK</a>
                </li>

                <!-- PEMISAH -->
                <li class="nav-item mx-2 text-white">|</li>

                <!-- HALO ADMIN -->
                <li class="nav-item">
                    <span class="nav-link text-white">
                        👋 Halo, <?php echo $_SESSION['nama']; ?>
                    </span>
                </li>

                <!-- LOGOUT -->
                <li class="nav-item ms-2">
                    <a href="../logout.php" class="btn btn-danger btn-sm">
                        Logout
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    <h3 class="mb-3">Verifikasi Pembayaran</h3>

    <!-- tombol kembali DI ATAS tabel -->
    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-secondary">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Asal Sekolah</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no=1; while($row = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-semibold"><?= $row['nama_lengkap'] ?></td>
                        <td><?= $row['asal_sekolah'] ?></td>
                        <td><?= $row['tanggal_bayar'] ?></td>
                        <td>Rp <?= number_format($row['jumlah']) ?></td>

                        <td>
                            <?php if($row['bukti_pembayaran']) { ?>
                                <a href="../uploads/<?= $row['bukti_pembayaran'] ?>"
                                   class="btn btn-primary btn-sm"
                                   target="_blank">
                                   Lihat
                                </a>
                            <?php } else echo "-"; ?>
                        </td>

                        <td>
                            <?php
                            if($row['status_verifikasi']=='lunas'){
                                echo "<span class='badge bg-success'>Lunas</span>";
                            }elseif($row['status_verifikasi']=='ditolak'){
                                echo "<span class='badge bg-danger'>Ditolak</span>";
                            }else{
                                echo "<span class='badge bg-warning text-dark'>Pending</span>";
                            }
                            ?>
                        </td>

                        <td class="d-flex gap-2">

                            <a href="?aksi=terima&id=<?= $row['id_pembayaran'] ?>"
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Terima pembayaran ini?')">
                               ✔ Terima
                            </a>

                            <a href="?aksi=tolak&id=<?= $row['id_pembayaran'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Tolak pembayaran ini?')">
                               ✖ Tolak
                            </a>

                        </td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>