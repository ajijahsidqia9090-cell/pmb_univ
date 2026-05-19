<?php
session_start();
include '../config/koneksi.php';

// proteksi
if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    echo "Akses ditolak!";
    exit;
}

// ==========================
// PROSES UPDATE HASIL
// ==========================
if(isset($_GET['aksi'])){
    $id = $_GET['id'];

    if($_GET['aksi'] == 'lulus'){
        mysqli_query($conn,"UPDATE pendaftaran SET hasil_seleksi='lulus' WHERE id_pendaftaran='$id'");
    }elseif($_GET['aksi'] == 'tidak'){
        mysqli_query($conn,"UPDATE pendaftaran SET hasil_seleksi='tidak lulus' WHERE id_pendaftaran='$id'");
    }

    header("Location: pengumuman.php");
    exit;
}

// ==========================
// AMBIL DATA
// ==========================
$data = mysqli_query($conn,"
SELECT p.*, u.nama
FROM pendaftaran p
JOIN users u ON p.id_user = u.id_user
ORDER BY p.id_pendaftaran DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengumuman Kelulusan</title>

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

/* TABLE HEADER */
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

    <a class="navbar-brand fw-bold" href="#">PMB Admin</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

        <ul class="navbar-nav me-auto"></ul>

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
                <a class="nav-link active" href="pengumuman.php">Pengumuman</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="data_ospek.php">OSPEK</a>
            </li>

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

    <h3 class="mb-3">Pengumuman Kelulusan</h3>

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
                        <th>NIK</th>
                        <th>Asal Sekolah</th>
                        <th>Status Berkas</th>
                        <th>Status Pembayaran</th>
                        <th>Hasil Seleksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no=1; while($row = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-semibold"><?= $row['nama'] ?></td>
                        <td><?= $row['nik'] ?></td>
                        <td><?= $row['asal_sekolah'] ?></td>

                        <!-- BERKAS -->
                        <td>
                            <?php
                            if($row['status_berkas']=='valid'){
                                echo "<span class='badge bg-success'>Valid</span>";
                            }elseif($row['status_berkas']=='ditolak'){
                                echo "<span class='badge bg-danger'>Ditolak</span>";
                            }else{
                                echo "<span class='badge bg-warning text-dark'>Menunggu</span>";
                            }
                            ?>
                        </td>

                        <!-- PEMBAYARAN -->
                        <td>
                            <?php
                            $cek = mysqli_query($conn,"SELECT * FROM pembayaran WHERE id_pendaftaran='".$row['id_pendaftaran']."'");
                            $bayar = mysqli_fetch_assoc($cek);

                            if($bayar && $bayar['status_verifikasi']=='lunas'){
                                echo "<span class='badge bg-success'>Lunas</span>";
                            }else{
                                echo "<span class='badge bg-warning text-dark'>Belum</span>";
                            }
                            ?>
                        </td>

                        <!-- HASIL -->
                        <td>
                            <?php
                            if($row['hasil_seleksi']=='lulus'){
                                echo "<span class='badge bg-success'>Lulus</span>";
                            }elseif($row['hasil_seleksi']=='tidak lulus'){
                                echo "<span class='badge bg-danger'>Tidak Lulus</span>";
                            }else{
                                echo "<span class='badge bg-secondary'>Belum</span>";
                            }
                            ?>
                        </td>

                        <!-- AKSI -->
                        <td class="d-flex gap-2">

                            <a href="?aksi=lulus&id=<?= $row['id_pendaftaran'] ?>"
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Yakin luluskan?')">
                               ✔ Lulus
                            </a>

                            <a href="?aksi=tidak&id=<?= $row['id_pendaftaran'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin tidak lulus?')">
                               ✖ Tidak Lulus
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