<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id_user']) || $_SESSION['role']!='mahasiswa'){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* =========================
   DATA PENDAFTARAN
========================= */
$daftar = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pendaftaran WHERE id_user='$id_user'
"));

$id_pendaftaran = $daftar['id_pendaftaran'] ?? null;

/* =========================
   PEMBAYARAN
========================= */
$bayar = null;
if($id_pendaftaran){
    $bayar = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM pembayaran WHERE id_pendaftaran='$id_pendaftaran'
    "));
}

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
        SELECT * FROM pembayaran WHERE id_daftar_ulang='{$du['id_daftar_ulang']}'
        "));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Mahasiswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
    font-family:system-ui, -apple-system, Segoe UI, Roboto;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#1e3a8a,#06b6d4);
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

/* MENU */
.nav-link{
    color:#fff !important;
    margin-right:6px;
    border-radius:8px;
    padding:6px 10px;
    transition:0.2s;
}

.nav-link:hover{
    background:rgba(255,255,255,0.15);
}

/* HALO USER */
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

h4{
    font-weight:700;
    color:#1e3a8a;
}

/* STATUS TEXT */
.badge{
    font-size:12px;
    padding:6px 10px;
}
</style>
</head>

<body>

<!-- NAVBAR FIX FINAL (MAHASISWA STYLE ADMIN) -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="dashboard.php">PMB Mahasiswa</a>

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

                <?php if(($daftar['hasil_seleksi'] ?? '')=='lulus'){ ?>
                <li class="nav-item">
                    <a class="nav-link text-warning fw-bold" href="daftar_ulang.php">
                        Daftar Ulang
                    </a>
                </li>
                <?php } ?>

                <!-- PEMISAH -->
                <li class="nav-item mx-2 text-white">|</li>

                <!-- HALO USER -->
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

<div class="card">
<div class="card-body">

<h4>Status PMB Anda</h4>
<hr>

<p>Pendaftaran:
<?php if(!$daftar){ ?>
<span class="badge bg-secondary">Belum Daftar</span>
<?php } else { ?>
<span class="badge bg-success">Sudah Daftar</span>
<?php } ?>
</p>

<p>Berkas:
<?php
if(($daftar['status_berkas'] ?? '')=='valid'){
echo "<span class='badge bg-success'>Valid</span>";
}elseif(($daftar['status_berkas'] ?? '')=='ditolak'){
echo "<span class='badge bg-danger'>Ditolak</span>";
}else{
echo "<span class='badge bg-warning text-dark'>Menunggu</span>";
}
?>
</p>

<p>Pembayaran PMB:
<?php
if(($bayar['status_verifikasi'] ?? '')=='lunas'){
echo "<span class='badge bg-success'>Lunas</span>";
}elseif($bayar){
echo "<span class='badge bg-warning text-dark'>Proses</span>";
}else{
echo "<span class='badge bg-secondary'>Belum Bayar</span>";
}
?>
</p>

<p>Hasil Seleksi:
<?php
if(($daftar['hasil_seleksi'] ?? '')=='lulus'){
echo "<span class='badge bg-success'>Lulus</span>";
}elseif(($daftar['hasil_seleksi'] ?? '')=='tidak lulus'){
echo "<span class='badge bg-danger'>Tidak Lulus</span>";
}else{
echo "<span class='badge bg-secondary'>Belum Diproses</span>";
}
?>
</p>

<p>Daftar Ulang:
<?php
if($du && $bayar_du && $bayar_du['status_verifikasi']=='lunas'){
echo "<span class='badge bg-success'>Selesai</span>";
}elseif($du){
echo "<span class='badge bg-warning text-dark'>Proses</span>";
}else{
echo "<span class='badge bg-secondary'>Belum</span>";
}
?>
</p>

</div>
</div>

<!-- STATUS BESAR -->
<?php if(($daftar['hasil_seleksi'] ?? '')=='lulus'){ ?>

<?php if(!$du){ ?>

<div class="card mt-3 border-success">
<div class="card-body d-flex justify-content-between align-items-center">
<div>
<h5>🎉 Kamu LULUS!</h5>
<small>Lanjutkan ke proses daftar ulang</small>
</div>
<a href="daftar_ulang.php" class="btn btn-success">Daftar Ulang</a>
</div>
</div>

<?php } elseif($bayar_du && $bayar_du['status_verifikasi']=='lunas'){ ?>

<div class="card mt-3 border-primary">
<div class="card-body">
<h5>🎉 Selamat!</h5>
<p>Kamu sudah menyelesaikan semua proses PMB.</p>
<p>Kami tunggu di OSPEK ya ✨</p>
</div>
</div>

<?php } else { ?>

<div class="card mt-3 border-warning">
<div class="card-body">
<h5>⏳ Proses Daftar Ulang</h5>
<p>Menunggu verifikasi pembayaran admin.</p>
</div>
</div>

<?php } ?>

<?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>