<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// ambil data pendaftaran
$pendaftaran = mysqli_query($conn,"SELECT * FROM pendaftaran WHERE id_user='$id_user'");
$data = mysqli_fetch_assoc($pendaftaran);

if(!$data){
    die("Kamu belum melakukan pendaftaran!");
}

$id_pendaftaran = $data['id_pendaftaran'];

// cek sudah upload
$cek = mysqli_query($conn,"SELECT * FROM dokumen WHERE id_pendaftaran='$id_pendaftaran'");
$sudah = mysqli_fetch_assoc($cek);

// untuk navbar
$daftar = $data;

if(isset($_POST['upload'])){

    $ktp    = $_FILES['ktp']['name'];
    $ijazah = $_FILES['ijazah']['name'];
    $foto   = $_FILES['foto']['name'];

    $tmp1 = $_FILES['ktp']['tmp_name'];
    $tmp2 = $_FILES['ijazah']['tmp_name'];
    $tmp3 = $_FILES['foto']['tmp_name'];

    $folder = "../uploads/";

    $ktp_name    = time().'_ktp_'.$ktp;
    $ijazah_name = time().'_ijazah_'.$ijazah;
    $foto_name   = time().'_foto_'.$foto;

    move_uploaded_file($tmp1, $folder.$ktp_name);
    move_uploaded_file($tmp2, $folder.$ijazah_name);
    move_uploaded_file($tmp3, $folder.$foto_name);

    mysqli_query($conn,"
        INSERT INTO dokumen 
        (id_pendaftaran, file_ktp, file_ijazah, file_foto)
        VALUES 
        ('$id_pendaftaran','$ktp_name','$ijazah_name','$foto_name')
    ");

    mysqli_query($conn,"
        UPDATE pendaftaran 
        SET status_berkas='pending'
        WHERE id_pendaftaran='$id_pendaftaran'
    ");

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Upload Dokumen</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
    font-family:system-ui;
}

/* NAVBAR SAMA */
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

    <!-- BACK BUTTON -->
    <a href="dashboard.php" class="btn btn-secondary mb-3">
        ← Kembali ke Dashboard
    </a>

    <div class="card">
        <div class="card-body">

            <h3>Upload Dokumen PMB</h3>
            <hr>

            <?php if($sudah){ ?>

                <div class="alert alert-success">
                    Kamu sudah upload dokumen.
                </div>

            <?php } else { ?>

                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-2">
                        <label>Upload KTP</label>
                        <input type="file" name="ktp" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Upload Ijazah</label>
                        <input type="file" name="ijazah" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Upload Foto</label>
                        <input type="file" name="foto" class="form-control" required>
                    </div>

                    <button type="submit" name="upload" class="btn btn-success">
                        Upload Sekarang
                    </button>

                </form>

            <?php } ?>

        </div>
    </div>

</div>

</body>
</html>