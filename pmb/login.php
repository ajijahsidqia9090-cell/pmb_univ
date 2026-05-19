<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'config/koneksi.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $data = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($data);

    if($user){

        if(password_verify($password, $user['password'])){

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = trim($user['role']);

            if($_SESSION['role'] == 'admin'){
                header("Location: admin/dashboard.php");
                exit;
            } else {
                header("Location: mahasiswa/dashboard.php");
                exit;
            }

        } else {
            echo "<script>alert('Password salah');</script>";
        }

    } else {
        echo "<script>alert('Email tidak ditemukan');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login PMB</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    height: 100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: Arial;
}

.card-login{
    width: 380px;
    border: none;
    border-radius: 15px;
    padding: 25px;
    background: rgba(255,255,255,0.95);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.title{
    text-align:center;
    font-weight:bold;
    margin-bottom:20px;
}

.btn-login{
    background:#4f46e5;
    color:white;
}

.btn-login:hover{
    background:#3730a3;
}
</style>

</head>
<body>

<div class="card card-login">

    <h3 class="title">🎓 PMB Login</h3>

    <form method="POST">

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>

        <button class="btn btn-login w-100" type="submit">
            Login
        </button>

    </form>

    <div class="text-center mt-3">
        <small>Belum punya akun? <a href="register.php">Daftar</a></small>
    </div>

</div>

</body>
</html>