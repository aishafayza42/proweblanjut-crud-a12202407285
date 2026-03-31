<?php
session_start();
session_destroy(); // Menghapus semua data login
header("Location: login.php"); // Balik ke pintu awal
exit();
?>