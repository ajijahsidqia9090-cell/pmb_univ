<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pendaftaran WHERE id_user='$id_user'
"));

if(!$data){
    die("Data pendaftaran tidak ditemukan");
}

/* =========================
   FIX PENTING: supaya navbar tidak error
========================= */
$daftar = $data;

/* =========================
   VALIDASI LULUS
========================= */
if($data['hasil_seleksi'] != 'lulus'){
    die("Tidak bisa daftar ulang");
}

/* =========================
   PROSES SIMPAN
========================= */
if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn,"
        INSERT INTO daftar_ulang
        (id_pendaftaran,nama_lengkap,jurusan,alamat,tanggal,status)
        VALUES
        ('{$data['id_pendaftaran']}','$nama','$jurusan','$alamat',CURDATE(),'proses')
    ");

    header("Location: pembayaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Ulang</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
    font-family:system-ui, -apple-system, Segoe UI, Roboto;
}

/* NAVBAR STYLE SAMA ADMIN */
.navbar{
    background: linear-gradient(135deg,#1e3a8a,#06b6d4);
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.nav-link{
    color:#fff !important;
    margin-right:6px;
    padding:6px 10px;
    border-radius:8px;
    transition:0.2s;
}

.nav-link:hover{
    background:rgba(255,255,255,0.15);
}

/* USER */
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

/* FORM */
.form-control, select, textarea{
    border-radius:10px;
}
</style>
</head>

<body>

<!-- NAVBAR (SUDAH FIX) -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="dashboard.php">PMB Mahasiswa</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto"></ul>

            <ul class="navbar-nav align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pendaftaran.php">Pendaftaran</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="upload_dokumen.php">Dokumen</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pembayaran.php">Pembayaran</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="hasil.php">Hasil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ospek.php">OSPEK</a>
                </li>

                <?php if(strtolower(trim($daftar['hasil_seleksi'])) == 'lulus'){ ?>
                <li class="nav-item">
                    <a class="nav-link text-warning fw-bold" href="daftar_ulang.php">
                        Daftar Ulang
                    </a>
                </li>
                <?php } ?>

                <li class="nav-item mx-2 text-white">|</li>

                <li class="nav-item">
                    <span class="nav-link text-white">
                        👋 Halo, <?= $_SESSION['nama']; ?>
                    </span>
                </li>

                <li class="nav-item ms-2">
                    <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

<div class="card">
<div class="card-body">

<h3 class="mb-3">Daftar Ulang Mahasiswa</h3>

<hr>

<a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">
← Kembali ke Dashboard
</a>

<form method="POST">

<div class="mb-3">
<label>Nama Lengkap</label>
<input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
<label>Jurusan</label>
<select name="jurusan" class="form-control" required>
<option>Informatika</option>
<option>Sistem Informasi</option>
<option>Bisnis Digital</option>
</select>
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control" required></textarea>
</div>

<button name="simpan" class="btn btn-success">
Lanjut ke Pembayaran
</button>

</form>

</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>