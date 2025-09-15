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

// Get student data
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php?error=not_found");
    exit;
}

$data = $result->fetch_assoc();
$stmt->close();
?>
<!doctype html>
<html>
<head>
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>Edit Mahasiswa</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                if ($_GET['error'] == 'nim_exists') {
                    echo "NIM sudah terdaftar! Silakan gunakan NIM yang berbeda.";
                } else {
                    echo "Terjadi kesalahan saat mengupdate data.";
                }
                ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="post" action="update.php" id="editForm">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <input type="hidden" name="old_nim" value="<?php echo $data['nim']; ?>">
                
                <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" required maxlength="15" 
                           pattern="[0-9]+" title="NIM harus berupa angka" 
                           value="<?php echo htmlspecialchars($data['nim']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required maxlength="50"
                           value="<?php echo htmlspecialchars($data['nama']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="prodi">Program Studi:</label>
                    <select id="prodi" name="prodi" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="Teknik Sipil" <?php echo ($data['prodi'] == 'Teknik Sipil') ? 'selected' : ''; ?>>Teknik Sipil</option>
                        <option value="Arsitektur" <?php echo ($data['prodi'] == 'Arsitektur') ? 'selected' : ''; ?>>Arsitektur</option>
                        <option value="Teknik Kimia" <?php echo ($data['prodi'] == 'Teknik Kimia') ? 'selected' : ''; ?>>Teknik Kimia</option>
                        <option value="Teknik Mesin" <?php echo ($data['prodi'] == 'Teknik Mesin') ? 'selected' : ''; ?>>Teknik Mesin</option>
                        <option value="Teknik Elektro" <?php echo ($data['prodi'] == 'Teknik Elektro') ? 'selected' : ''; ?>>Teknik Elektro</option>
                        <option value="Perencanaan Wilayah & Kota" <?php echo ($data['prodi'] == 'Perencanaan Wilayah & Kota') ? 'selected' : ''; ?>>Perencanaan Wilayah & Kota</option>
                        <option value="Teknik Industri" <?php echo ($data['prodi'] == 'Teknik Industri') ? 'selected' : ''; ?>>Teknik Industri</option>
                        <option value="Teknik Lingkungan" <?php echo ($data['prodi'] == 'Teknik Lingkungan') ? 'selected' : ''; ?>>Teknik Lingkungan</option>
                        <option value="Teknik Perkapalan" <?php echo ($data['prodi'] == 'Teknik Perkapalan') ? 'selected' : ''; ?>>Teknik Perkapalan</option>
                        <option value="Teknik Geologi" <?php echo ($data['prodi'] == 'Teknik Geologi') ? 'selected' : ''; ?>>Teknik Geologi</option>
                        <option value="Teknik Geodesi" <?php echo ($data['prodi'] == 'Teknik Geodesi') ? 'selected' : ''; ?>>Teknik Geodesi</option>
                        <option value="Teknik Komputer" <?php echo ($data['prodi'] == 'Teknik Komputer') ? 'selected' : ''; ?>>Teknik Komputer</option>
                        <option value="Profesi" <?php echo ($data['prodi'] == 'Profesi') ? 'selected' : ''; ?>>Profesi</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </div>
            </form>
        </div>
        
        <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
            <small style="color: #666;">
                <strong>Info:</strong> Data dibuat pada <?php echo date('d/m/Y H:i', strtotime($data['created_at'])); ?>
                <?php if ($data['updated_at'] != $data['created_at']): ?>
                    | Terakhir diupdate pada <?php echo date('d/m/Y H:i', strtotime($data['updated_at'])); ?>
                <?php endif; ?>
            </small>
        </div>
    </div>
    
    <script>
        // Form validation
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const nim = document.getElementById('nim').value;
            const nama = document.getElementById('nama').value;
            const prodi = document.getElementById('prodi').value;
            
            if (nim.length < 8) {
                alert('NIM harus minimal 8 digit');
                e.preventDefault();
                return false;
            }
            
            if (nama.trim().length < 2) {
                alert('Nama harus minimal 2 karakter');
                e.preventDefault();
                return false;
            }
            
            if (prodi === '') {
                alert('Silakan pilih Program Studi');
                e.preventDefault();
                return false;
            }
        });
        
        // Auto-format NIM input
        document.getElementById('nim').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Auto-capitalize nama (fixed to handle apostrophes properly)
        document.getElementById('nama').addEventListener('input', function(e) {
            let value = this.value;
            // Capitalize first letter of each word, but preserve apostrophes
            this.value = value.replace(/\b\w/g, function(match, offset) {
                // Don't capitalize if the previous character is an apostrophe
                if (offset > 0 && value[offset - 1] === "'") {
                    return match.toLowerCase();
                }
                return match.toUpperCase();
            });
        });
    </script>
</body>
</html>
