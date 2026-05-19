<?php
session_start();
include 'config/koneksi.php';

if(isset($_POST['register'])){

    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role     = "mahasiswa";

    $cek = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Email sudah terdaftar');</script>";
    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,"
            INSERT INTO users (nama,email,password,role)
            VALUES ('$nama','$email','$password_hash','$role')
        ");

        echo "<script>alert('Register berhasil'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register PMB</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg, #06b6d4, #22c55e);
    height: 100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: Arial;
}

.card-register{
    width: 420px;
    border:none;
    border-radius:15px;
    padding:25px;
    background:white;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.title{
    text-align:center;
    font-weight:bold;
    margin-bottom:20px;
}

.btn-reg{
    background:#059669;
    color:white;
}

.btn-reg:hover{
    background:#047857;
}
</style>

</head>
<body>

<div class="card card-register">

    <h3 class="title">📝 Register PMB</h3>

    <form method="POST">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-reg w-100" name="register">
            Daftar
        </button>

    </form>

    <div class="text-center mt-3">
        <small>Sudah punya akun? <a href="login.php">Login</a></small>
    </div>

</div>

</body>
</html>