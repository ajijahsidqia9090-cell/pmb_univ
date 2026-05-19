<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../config/koneksi.php';

/* =========================
   CEK LOGIN
========================= */
if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* =========================
   AMBIL PENDAFTARAN
========================= */
$daftar = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pendaftaran WHERE id_user='$id_user'
"));

$id_pendaftaran = $daftar['id_pendaftaran'] ?? null;

/* =========================
   DAFTAR ULANG
========================= */
$du = null;
$bayar_du = null;

if($id_pendaftaran){
    $du = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM daftar_ulang WHERE id_pendaftaran='$id_pendaftaran'
    "));

    if($du){
        $bayar_du = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT * FROM pembayaran 
        WHERE id_daftar_ulang='{$du['id_daftar_ulang']}'
        "));
    }
}

/* =========================
   FIX: AMBIL SEMUA DATA OSPEK
========================= */
$ospek = mysqli_query($conn,"
SELECT * FROM ospek ORDER BY tanggal ASC
");

/* =========================
   CEK BISA OSPEK ATAU TIDAK
========================= */
$boleh_ospek =
    ($daftar['hasil_seleksi'] ?? '') == 'lulus'
    && $du
    && ($bayar_du['status_verifikasi'] ?? '') == 'lunas';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>OSPEK Mahasiswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
    font-family:system-ui;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#1e3a8a,#06b6d4);
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.nav-link{
    color:#fff !important;
    margin-right:6px;
    border-radius:8px;
    padding:6px 10px;
}

.nav-link:hover{
    background:rgba(255,255,255,0.15);
}

.user-badge{
    background:rgba(255,255,255,0.2);
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-size:13px;
    margin-right:10px;
}

/* CARD */
.card{
    border:none;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}
</style>
</head>

<body>

<!-- NAVBAR (TIDAK DIUBAH) -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="dashboard.php">PMB Mahasiswa</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto"></ul>

            <ul class="navbar-nav align-items-center">

                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="pendaftaran.php">Pendaftaran</a></li>
                <li class="nav-item"><a class="nav-link" href="upload_dokumen.php">Dokumen</a></li>
                <li class="nav-item"><a class="nav-link" href="pembayaran.php">Pembayaran</a></li>
                <li class="nav-item"><a class="nav-link" href="hasil.php">Hasil</a></li>
                <li class="nav-item"><a class="nav-link" href="ospek.php">OSPEK</a></li>

                <?php if(($daftar['hasil_seleksi'] ?? '')=='lulus'){ ?>
                <li class="nav-item">
                    <a class="nav-link text-warning fw-bold" href="daftar_ulang.php">
                        Daftar Ulang
                    </a>
                </li>
                <?php } ?>

                <li class="nav-item mx-2 text-white">|</li>

                <li class="nav-item">
                    <span class="nav-link text-white">
                        👋 Halo, <?php echo $_SESSION['nama']; ?>
                    </span>
                </li>

                <li class="nav-item ms-2">
                    <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<!-- CONTENT (TIDAK DIUBAH TAMPILAN) -->
<div class="container mt-4">

    <div class="card">
        <div class="card-body">

            <h3>OSPEK Mahasiswa</h3>
            <hr>

            <?php if(mysqli_num_rows($ospek) == 0){ ?>

                <div class="alert alert-secondary">
                    Belum ada OSPEK dari admin
                </div>

            <?php } elseif(!$boleh_ospek){ ?>

                <div class="alert alert-warning">
                    <h5>⛔ Kamu belum bisa OSPEK</h5>
                    <p>Selesaikan daftar ulang & pembayaran dulu</p>
                </div>

            <?php } else { ?>

                <div class="alert alert-success">
                    <h5>🎉 Daftar OSPEK</h5>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no=1; while($row = mysqli_fetch_assoc($ospek)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['judul_kegiatan'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['lokasi'] ?></td>
                            <td><?= $row['deskripsi'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>

            <?php } ?>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>