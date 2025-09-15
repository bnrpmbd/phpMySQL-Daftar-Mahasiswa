<?php
// Nama: Banar Pambudi
// NIM : 21060123140160

include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input (trim only, no need for real_escape_string with prepared statements)
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama']);
    $prodi = trim($_POST['prodi']);
    
    // Validate input
    $errors = array();
    
    if (empty($nim)) {
        $errors[] = "NIM tidak boleh kosong";
    } elseif (!preg_match('/^[0-9]+$/', $nim)) {
        $errors[] = "NIM harus berupa angka";
    } elseif (strlen($nim) < 8) {
        $errors[] = "NIM harus minimal 8 digit";
    }
    
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    } elseif (strlen($nama) < 2) {
        $errors[] = "Nama harus minimal 2 karakter";
    }
    
    if (empty($prodi)) {
        $errors[] = "Program Studi harus dipilih";
    }
    
    // Check if NIM already exists (UNIQUE validation)
    if (empty($errors)) {
        $check_stmt = $conn->prepare("SELECT id FROM mahasiswa WHERE nim = ?");
        $check_stmt->bind_param("s", $nim);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            // NIM already exists, redirect back with error
            $redirect_url = "tambah.php?error=nim_exists&nim=" . urlencode($nim) . "&nama=" . urlencode($nama) . "&prodi=" . urlencode($prodi);
            header("Location: $redirect_url");
            exit;
        }
        $check_stmt->close();
    }
    
    // If there are validation errors, redirect back with errors
    if (!empty($errors)) {
        $error_message = implode(", ", $errors);
        $redirect_url = "tambah.php?error=validation&message=" . urlencode($error_message) . "&nim=" . urlencode($nim) . "&nama=" . urlencode($nama) . "&prodi=" . urlencode($prodi);
        header("Location: $redirect_url");
        exit;
    }
    
    // Insert data using prepared statement for security
    $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, prodi) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nim, $nama, $prodi);
    
    if ($stmt->execute()) {
        // Success - redirect to index with success message
        header("Location: index.php?success=1");
    } else {
        // Error - redirect back with error
        $redirect_url = "tambah.php?error=database&nim=" . urlencode($nim) . "&nama=" . urlencode($nama) . "&prodi=" . urlencode($prodi);
        header("Location: $redirect_url");
    }
    
    $stmt->close();
} else {
    // If accessed directly without POST, redirect to tambah.php
    header("Location: tambah.php");
}

$conn->close();
?>