<?php
// index.php (Router Utama Ter-update)
session_start();

require_once '../config/koneksi.php'; 
require_once '../app/models/BarangModel.php';   
require_once '../app/models/UserModel.php';      
require_once '../app/controllers/BarangController.php'; 
require_once '../app/controllers/AuthController.php';

$userModel = new UserModel($pdo);
$authController = new AuthController($userModel);
$barangModel = new BarangModel($pdo);
$barangController = new BarangController($barangModel);

// ini untuk menjalankan pengecekan cookie otomatis di awal
$authController->checkCookie(); 

// Tangkap halaman dari URL
$page = $_GET['page'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

// JALUR 1: ini buat urusan login / logout / register
if ($page === 'auth') {
    switch ($action) {
        case 'login':
            $authController->login();
            break;
        case 'register':
            $authController->register();
            break;
        case 'logout':
            $authController->logout();
            break;
        default:
            $authController->login();
            break;
    }
} 
// JALUR 2: ini buat urusan data barang inventaris
else if ($page === 'barang') {
    if (!isset($_SESSION['login'])) {
        header("Location: index.php?page=auth&action=login");
        exit();
    }

    include '../app/views/layout/header.php';

    switch ($action) {
        case 'index':   $barangController->index(); break;
        case 'tambah':  $barangController->tambah(); break; 
        case 'simpan':  $barangController->simpan(); break; 
        case 'edit':    $barangController->edit(); break;
        case 'update':  $barangController->update(); break;
        case 'hapus':   $barangController->hapus(); break;  
        default:        $barangController->index(); break;
    }

    include '../app/views/layout/footer.php';
} else {
    header("Location: index.php?page=auth&action=login");
    exit();
}