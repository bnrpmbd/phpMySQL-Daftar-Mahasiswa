<?php
// Script untuk membersihkan data yang ter-escape di database
// Nama: Banar Pambudi
// NIM : 21060123140160

include "db.php";

echo "<h2>Script Pembersihan Data Escaped Characters</h2>";

// Check if there are any escaped characters in the database
$sql = "SELECT id, nama FROM mahasiswa WHERE nama LIKE '%\\\\%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p>Ditemukan " . $result->num_rows . " data dengan karakter ter-escape:</p>";
    echo "<ul>";
    
    while($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $nama_lama = $row['nama'];
        $nama_baru = stripslashes($nama_lama); // Remove escaped characters
        
        echo "<li>ID: $id - '$nama_lama' → '$nama_baru'</li>";
        
        // Update the record
        $update_stmt = $conn->prepare("UPDATE mahasiswa SET nama = ? WHERE id = ?");
        $update_stmt->bind_param("si", $nama_baru, $id);
        $update_stmt->execute();
        $update_stmt->close();
    }
    
    echo "</ul>";
    echo "<p><strong>✅ Data berhasil dibersihkan!</strong></p>";
} else {
    echo "<p>✅ Tidak ada data dengan karakter ter-escape yang ditemukan.</p>";
}

echo "<br><a href='index.php' style='padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px;'>Kembali ke Daftar Mahasiswa</a>";

$conn->close();
?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 40px;
    background-color: #f5f5f5;
}
h2 {
    color: #2c3e50;
}
ul {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>