<?php
class AuthController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    // Mengatur otomatisasi cookie "Remember Me" saat gerbang awal dibuka
    public function checkCookie() {
        if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
            $id = $_COOKIE['id'];
            $key = $_COOKIE['key'];

            $row = $this->userModel->cariUserBerdasarkanId($id);

            if ($row && $key === hash('sha256', $row['username'])) {
                $_SESSION['login'] = true;
                $_SESSION['nama'] = $row['nama_lengkap'];
            }
        }
    }

    // Mengatur halaman & proses Login
    public function login() {
        // Jika sudah login, langsung lempar ke halaman inventaris barang
        if (isset($_SESSION['login'])) {
            header("Location: index.php?page=barang");
            exit();
        }

        $error = null;
        if (isset($_POST['login'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $data_user = $this->userModel->cariUserBerdasarkanUsername($user);

            if ($data_user && password_verify($pass, $data_user['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['nama'] = $data_user['nama_lengkap']; 

                // Logika Cookie Remember Me (Durasi 30 detik)
                if (isset($_POST['remember'])) {
                    setcookie('id', $data_user['id'], time() + 30, '/');
                    setcookie('key', hash('sha256', $data_user['username']), time() + 30, '/');
                }

                header("Location: index.php?page=barang");
                exit();
            } else {
                $error = "Username atau Password salah!";
            }
        }
        // ini untuk memanggil view form login 
        include '../app/views/auth/login.php';
    }

    // Mengatur halaman & proses Registrasi
    public function register() {
        if (isset($_SESSION['login'])) {
            header("Location: index.php?page=barang");
            exit();
        }

        $error = null;
        if (isset($_POST['register'])) {
            $nama = $_POST['nama_lengkap'];
            $user = $_POST['username'];
            $pass = $_POST['password'];
         
            $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

            try { 
                $this->userModel->daftarkanUserBaru($user, $pass_hashed, $nama);
                header("Location: index.php?page=auth&action=login&pesan=registrasi_berhasil");
                exit();
            } catch (PDOException $e) {
                $error = "Username sudah digunakan, silakan pilih yang lain.";
            }
        }
        // ini untuk memanggil view form registrasi
        include '../app/views/auth/register.php';
    }

    // Mengatur proses Logout total
    public function logout() {
        session_destroy();
        setcookie('id', '', time() - 3600, "/");
        setcookie('key', '', time() - 3600, "/");

        header("Location: index.php?page=auth&action=login"); 
        exit();
    }
}