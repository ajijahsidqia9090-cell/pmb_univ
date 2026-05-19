# 📰 Sistem PMB Online (PHP & MySQL)
## 📖 Description

Website ini merupakan Sistem Penerimaan Mahasiswa Baru (PMB) berbasis PHP dan MySQL yang digunakan untuk mengelola proses pendaftaran mahasiswa secara online mulai dari registrasi, pendaftaran, upload dokumen, pembayaran, hingga pengumuman hasil seleksi dan OSPEK.

## Sistem ini memiliki 2 level pengguna utama:

👨‍💼 Admin
🎓 Mahasiswa
Setiap pengguna memiliki hak akses berbeda sesuai dengan perannya dalam sistem.


## 🚀 Features
### 🔐 Authentication
Login & Logout
Session-based security
Role-based access (Admin & Mahasiswa)

### 🎓 Fitur Mahasiswa
📝 Pendaftaran mahasiswa baru
📄 Upload dokumen (KTP, ijazah, foto)
💳 Pembayaran PMB & daftar ulang
📊 Melihat status pendaftaran
📢 Melihat hasil seleksi (lulus / tidak lulus)
🏫 Informasi & pendaftaran OSPEK
🔁 Daftar ulang setelah lulus


### 👨‍💼 Fitur Admin
📊 Dashboard statistik (total user, pendaftar, lulus, pembayaran)
📝 Verifikasi berkas pendaftaran
💰 Verifikasi pembayaran
📢 Kelola pengumuman hasil seleksi
🏫 Kelola data OSPEK
👥 Manajemen data mahasiswa


## 📂 Project Structure
pmb/

index.php → Landing page (public)
login.php → Login system
logout.php → Logout system

mahasiswa/
    dashboard.php → Dashboard mahasiswa
    pendaftaran.php → Form pendaftaran
    upload_dokumen.php → Upload berkas
    pembayaran.php → Pembayaran PMB
    hasil.php → Hasil seleksi
    ospek.php → Informasi OSPEK
    daftar_ulang.php → Pendaftaran ulang

admin/
    dashboard.php → Dashboard admin
    verifikasi_berkas.php → Validasi dokumen
    verifikasi_pembayaran.php → Validasi pembayaran
    pengumuman.php → Kelola hasil seleksi
    data_ospek.php → Kelola OSPEK

config/
    koneksi.php → Database connection

uploads/
    → Folder file dokumen & bukti pembayaran

    
## ⚙️ Installation
Clone repository:
https://github.com/ajijahsidqia9090-cell/pmb_univ.git


## 🧑‍💻 User Role
### 👨‍💼 Admin
Mengelola seluruh data sistem PMB
Verifikasi berkas & pembayaran
Mengumumkan hasil seleksi
Mengatur OSPEK


### 🎓 Mahasiswa
Mendaftar sebagai calon mahasiswa
Upload dokumen
Melakukan pembayaran
Melihat hasil seleksi
Daftar ulang jika lulus
Mengikuti OSPEK


## 📌 Notes
Project ini dibuat untuk keperluan pembelajaran dan tugas akademik dalam pengembangan sistem informasi berbasis web menggunakan PHP & MySQL.

## 👨‍💻 Author
Nama: Khajizatu Sidqiyah
NIM: 2488010044
Kelas: Informatika-B
Project: Sistem PMB Online
