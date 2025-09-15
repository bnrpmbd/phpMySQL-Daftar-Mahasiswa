<?php
// Nama: Banar Pambudi
// NIM : 21060123140160

include "db.php";

// Validate and sanitize ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit;
}

$id = (int)$_GET['id'];

// First, get the student data for logging/confirmation
$stmt = $conn->prepare("SELECT nim, nama FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Record not found
    header("Location: index.php?error=not_found");
    exit;
}

$student_data = $result->fetch_assoc();
$stmt->close();

// Delete the record using prepared statement for security
$delete_stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
$delete_stmt->bind_param("i", $id);

if ($delete_stmt->execute()) {
    if ($delete_stmt->affected_rows > 0) {
        // Success - redirect to index with success message
        header("Location: index.php?success=3&deleted_name=" . urlencode($student_data['nama']));
    } else {
        // No rows affected (shouldn't happen if we got here, but just in case)
        header("Location: index.php?error=not_found");
    }
} else {
    // Database error
    header("Location: index.php?error=delete_failed");
}

$delete_stmt->close();
$conn->close();
?>