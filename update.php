<?php
// Nama: Banar Pambudi
// NIM : 21060123140160

include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input (trim only, no need for real_escape_string with prepared statements)
    $id = (int)$_POST['id'];
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama']);
    $prodi = trim($_POST['prodi']);
    $old_nim = trim($_POST['old_nim']);
    
    // Validate input
    $errors = array();
    
    if ($id <= 0) {
        $errors[] = "ID tidak valid";
    }
    
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
    
    // Check if NIM already exists (but allow same NIM for same record)
    if (empty($errors) && $nim != $old_nim) {
        $check_stmt = $conn->prepare("SELECT id FROM mahasiswa WHERE nim = ? AND id != ?");
        $check_stmt->bind_param("si", $nim, $id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            // NIM already exists, redirect back with error
            header("Location: edit.php?id=$id&error=nim_exists");
            exit;
        }
        $check_stmt->close();
    }
    
    // If there are validation errors, redirect back with errors
    if (!empty($errors)) {
        $error_message = implode(", ", $errors);
        header("Location: edit.php?id=$id&error=validation&message=" . urlencode($error_message));
        exit;
    }
    
    // Verify that the record exists
    $check_stmt = $conn->prepare("SELECT id FROM mahasiswa WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows == 0) {
        header("Location: index.php?error=not_found");
        exit;
    }
    $check_stmt->close();
    
    // Update data using prepared statement for security
    $stmt = $conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, prodi = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nim, $nama, $prodi, $id);
    
    if ($stmt->execute()) {
        // Success - redirect to index with success message
        header("Location: index.php?success=2");
    } else {
        // Error - redirect back with error
        header("Location: edit.php?id=$id&error=database");
    }
    
    $stmt->close();
} else {
    // If accessed directly without POST, redirect to index.php
    header("Location: index.php");
}

$conn->close();
?>
