<?php
// models/UserModel.php

class UserModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Pindahan kueri cek data user dari login.php lama
    public function cariUserBerdasarkanUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Pindahan kueri dari cookie checking login.php lama
    public function cariUserBerdasarkanId($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Pindahan kueri INSERT data user baru dari register.php lama
    public function daftarkanUserBaru($username, $password_hashed, $nama_lengkap) {
        $sql = "INSERT INTO users (username, password, nama_lengkap) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $password_hashed, $nama_lengkap]);
    }
}