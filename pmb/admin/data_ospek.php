<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id_user']) || $_SESSION['role']!='admin'){
    header("Location: ../login.php");
    exit;
}

/* =========================
   TAMBAH OSPEK
========================= */
if(isset($_POST['tambah'])){
    $judul     = mysqli_real_escape_string($conn,$_POST['judul']);
    $tanggal   = $_POST['tanggal'];
    $lokasi    = mysqli_real_escape_string($conn,$_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn,$_POST['deskripsi']);

    mysqli_query($conn,"
        INSERT INTO ospek (judul_kegiatan,tanggal,lokasi,deskripsi)
        VALUES ('$judul','$tanggal','$lokasi','$deskripsi')
    ");
}

/* =========================
   HAPUS OSPEK
========================= */
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn,"DELETE FROM ospek WHERE id_ospek='$id'");
}

/* =========================
   AMBIL DATA
========================= */
$data = mysqli_query($conn,"SELECT * FROM ospek ORDER BY tanggal ASC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Data OSPEK</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f4f6fb;}

/* NAVBAR SAMA DASHBOARD */
.navbar{
    background:linear-gradient(135deg,#1e3a8a,#06b6d4);
}

.nav-link{
    color:#fff !important;
    margin-right:6px;
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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
<div class="container-fluid">

<ul class="navbar-nav me-auto"></ul>

<ul class="navbar-nav align-items-center">

<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
<li class="nav-item"><a class="nav-link" href="verifikasi_berkas.php">Berkas</a></li>
<li class="nav-item"><a class="nav-link" href="verifikasi_pembayaran.php">Pembayaran</a></li>
<li class="nav-item"><a class="nav-link" href="pengumuman.php">Pengumuman</a></li>
<li class="nav-item"><a class="nav-link" href="data_ospek.php">OSPEK</a></li>

<li class="nav-item mx-2 text-white">|</li>
<li class="nav-item"><span class="nav-link text-white">👋 Halo, <?= $_SESSION['nama']; ?></span></li>
<li class="nav-item ms-2"><a href="../logout.php" class="btn btn-danger btn-sm">Logout</a></li>

</ul>

</div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

<h3 class="mb-3">Data OSPEK</h3>

<!-- tombol kembali HARUS DI ATAS -->
<div class="mb-3">
<a href="dashboard.php" class="btn btn-secondary">← Kembali ke Dashboard</a>
</div>

<!-- FORM TAMBAH -->
<div class="card mb-4">
<div class="card-body">

<form method="POST">

<input type="text" name="judul" class="form-control mb-2" placeholder="Judul Kegiatan" required>

<input type="date" name="tanggal" class="form-control mb-2" required>

<input type="text" name="lokasi" class="form-control mb-2" placeholder="Lokasi" required>

<textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi"></textarea>

<button name="tambah" class="btn btn-primary">Tambah Kegiatan</button>

</form>

</div>
</div>

<!-- TABLE -->
<div class="card">
<div class="card-body table-responsive">

<table class="table align-middle">
<thead>
<tr>
<th>No</th>
<th>Judul</th>
<th>Tanggal</th>
<th>Lokasi</th>
<th>Deskripsi</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php $no=1; while($row=mysqli_fetch_assoc($data)) { ?>
<tr>
<td><?= $no++ ?></td>
<td class="fw-semibold"><?= $row['judul_kegiatan'] ?></td>
<td><?= $row['tanggal'] ?></td>
<td><?= $row['lokasi'] ?></td>
<td><?= $row['deskripsi'] ?></td>

<td>
<a href="?hapus=<?= $row['id_ospek'] ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Hapus data?')">
   Hapus
</a>
</td>

</tr>
<?php } ?>
</tbody>

</table>

</div>
</div>

</div>

</body>
</html>