<!doctype html>
<!-- 
Nama: Banar Pambudi
NIM : 21060123140160
-->

<html>
<head>
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>Tambah Mahasiswa</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                if ($_GET['error'] == 'nim_exists') {
                    echo "NIM sudah terdaftar! Silakan gunakan NIM yang berbeda.";
                } else {
                    echo "Terjadi kesalahan saat menyimpan data.";
                }
                ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="post" action="simpan.php" id="tambahForm">
                <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" required maxlength="15" 
                           pattern="[0-9]+" title="NIM harus berupa angka" 
                           value="<?php echo isset($_GET['nim']) ? htmlspecialchars($_GET['nim']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required maxlength="50"
                           value="<?php echo isset($_GET['nama']) ? htmlspecialchars($_GET['nama']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="prodi">Program Studi:</label>
                    <select id="prodi" name="prodi" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="Teknik Sipil" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Sipil') ? 'selected' : ''; ?>>Teknik Sipil</option>
                        <option value="Arsitektur" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Arsitektur') ? 'selected' : ''; ?>>Arsitektur</option>
                        <option value="Teknik Kimia" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Kimia') ? 'selected' : ''; ?>>Teknik Kimia</option>
                        <option value="Teknik Mesin" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Mesin') ? 'selected' : ''; ?>>Teknik Mesin</option>
                        <option value="Teknik Elektro" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Elektro') ? 'selected' : ''; ?>>Teknik Elektro</option>
                        <option value="Perencanaan Wilayah & Kota" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Perencanaan Wilayah & Kota') ? 'selected' : ''; ?>>Perencanaan Wilayah & Kota</option>
                        <option value="Teknik Industri" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Industri') ? 'selected' : ''; ?>>Teknik Industri</option>
                        <option value="Teknik Lingkungan" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Lingkungan') ? 'selected' : ''; ?>>Teknik Lingkungan</option>
                        <option value="Teknik Perkapalan" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Perkapalan') ? 'selected' : ''; ?>>Teknik Perkapalan</option>
                        <option value="Teknik Geologi" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Geologi') ? 'selected' : ''; ?>>Teknik Geologi</option>
                        <option value="Teknik Geodesi" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Geodesi') ? 'selected' : ''; ?>>Teknik Geodesi</option>
                        <option value="Teknik Komputer" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Teknik Komputer') ? 'selected' : ''; ?>>Teknik Komputer</option>
                        <option value="Profesi" <?php echo (isset($_GET['prodi']) && $_GET['prodi'] == 'Profesi') ? 'selected' : ''; ?>>Profesi</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Form validation
        document.getElementById('tambahForm').addEventListener('submit', function(e) {
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
