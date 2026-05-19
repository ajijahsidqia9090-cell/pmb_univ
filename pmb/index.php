<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>PMB Kampus</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(135deg,#1e3a8a,#06b6d4);
    font-family:system-ui;
    margin:0;
}

/* HERO */
.hero{
    padding:60px 20px;
    text-align:center;
    color:white;
}

.hero h1{
    font-size:38px;
    font-weight:800;
}

.hero p{
    font-size:16px;
    opacity:0.9;
}

/* CARD SECTION */
.section{
    background:#f4f6fb;
    padding:40px 20px;
    border-radius:30px 30px 0 0;
}

.card-step{
    border:none;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    height:100%;
}

.step-number{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#1e3a8a;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

/* BUTTON */
.btn-custom{
    padding:10px 20px;
    border-radius:10px;
    font-weight:600;
}

.btn-login{
    background:#1e3a8a;
    color:white;
}

.btn-register{
    background:#06b6d4;
    color:white;
}

.btn-login:hover{background:#162c6b;}
.btn-register:hover{background:#0891b2;}
</style>
</head>

<body>

<!-- HERO -->
<div class="hero">
    <h1>🎓 PMB ONLINE KAMPUS</h1>
    <p>Sistem Penerimaan Mahasiswa Baru Terpadu & Modern</p>

    <div class="mt-3">
        <a href="login.php" class="btn btn-login btn-custom me-2">Login</a>
        <a href="register.php" class="btn btn-register btn-custom">Daftar</a>
    </div>
</div>

<!-- CONTENT -->
<div class="section">

    <div class="container">

        <h3 class="text-center mb-4">📌 Alur Pendaftaran PMB</h3>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="card card-step p-3 text-center">
                    <div class="step-number mx-auto mb-2">1</div>
                    <h6>Daftar Akun</h6>
                    <p class="text-muted">Calon mahasiswa membuat akun terlebih dahulu.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-step p-3 text-center">
                    <div class="step-number mx-auto mb-2">2</div>
                    <h6>Isi Pendaftaran</h6>
                    <p class="text-muted">Mengisi data diri & jurusan pilihan.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-step p-3 text-center">
                    <div class="step-number mx-auto mb-2">3</div>
                    <h6>Upload Dokumen</h6>
                    <p class="text-muted">Upload KTP, ijazah, dan foto.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-step p-3 text-center">
                    <div class="step-number mx-auto mb-2">4</div>
                    <h6>Pengumuman</h6>
                    <p class="text-muted">Menunggu hasil seleksi dan daftar ulang.</p>
                </div>
            </div>

        </div>

        <div class="text-center mt-5">
            <h5>Mulai perjalanan kuliahmu sekarang 🚀</h5>
        </div>

    </div>

</div>

</body>
</html>