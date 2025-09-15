<?php 
// Nama: Banar Pambudi
// NIM : 21060123140160

include "db.php"; 

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_condition = '';
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $search_condition = "WHERE nim LIKE '%$search%' OR nama LIKE '%$search%' OR prodi LIKE '%$search%'";
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total records
$count_sql = "SELECT COUNT(*) as total FROM mahasiswa $search_condition";
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

// Export to CSV
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="daftar_mahasiswa.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, array('ID', 'NIM', 'Nama', 'Prodi', 'Tanggal Dibuat'));
    
    $export_sql = "SELECT * FROM mahasiswa $search_condition ORDER BY id";
    $export_result = $conn->query($export_sql);
    
    while ($row = $export_result->fetch_assoc()) {
        fputcsv($output, array($row['id'], $row['nim'], $row['nama'], $row['prodi'], $row['created_at']));
    }
    
    fclose($output);
    exit;
}
?>

<!doctype html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>Daftar Mahasiswa</h1>
        
        <!-- Success/Error Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" id="successAlert">
                <?php 
                if ($_GET['success'] == '1') {
                    echo "Data mahasiswa berhasil ditambahkan!";
                } elseif ($_GET['success'] == '2') {
                    echo "Data mahasiswa berhasil diupdate!";
                } elseif ($_GET['success'] == '3') {
                    $deleted_name = isset($_GET['deleted_name']) ? htmlspecialchars($_GET['deleted_name']) : 'Mahasiswa';
                    echo "Data $deleted_name berhasil dihapus!";
                }
                ?>
                <span class="close-btn" onclick="closeAlert('successAlert')">&times;</span>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" id="errorAlert">
                <?php 
                if ($_GET['error'] == 'invalid_id') {
                    echo "ID tidak valid!";
                } elseif ($_GET['error'] == 'not_found') {
                    echo "Data mahasiswa tidak ditemukan!";
                } elseif ($_GET['error'] == 'delete_failed') {
                    echo "Gagal menghapus data mahasiswa!";
                } else {
                    echo "Terjadi kesalahan!";
                }
                ?>
                <span class="close-btn" onclick="closeAlert('errorAlert')">&times;</span>
            </div>
        <?php endif; ?>
        
        <!-- Statistics -->
        <div class="stats">
            <h3>Total Mahasiswa: <?php echo $total_records; ?></h3>
        </div>
        
        <!-- Search and Actions -->
        <div class="actions-container">
            <div class="search-container">
                <form method="GET" action="" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="search" class="search-input" placeholder="Cari NIM, Nama, atau Prodi..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <?php if (!empty($search)): ?>
                        <a href="index.php" class="btn btn-warning">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
            <div>
                <a href="tambah.php" class="btn btn-success">+ Tambah Mahasiswa</a>
                <a href="?export=csv<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-primary">Export CSV</a>
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $sql = "SELECT * FROM mahasiswa $search_condition ORDER BY id LIMIT $limit OFFSET $offset";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nim']}</td>
                            <td>" . htmlspecialchars($row['nama']) . "</td>
                            <td>" . htmlspecialchars($row['prodi']) . "</td>
                            <td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>
                            <td class='action-buttons'>
                                <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-small'>Edit</a>
                                <a href='hapus.php?id={$row['id']}' class='btn btn-danger btn-small' 
                                   onclick=\"return confirm('Yakin ingin menghapus data mahasiswa {$row['nama']}?')\">Hapus</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center;'>
                            " . (!empty($search) ? "Tidak ada data yang cocok dengan pencarian '$search'" : "Belum ada data mahasiswa") . "
                          </td></tr>";
                }
                ?>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">&laquo; First</a>
                    <a href="?page=<?php echo $page-1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">&lsaquo; Prev</a>
                <?php endif; ?>
                
                <?php
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);
                
                for ($i = $start_page; $i <= $end_page; $i++):
                ?>
                    <?php if ($i == $page): ?>
                        <span class="current"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page+1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Next &rsaquo;</a>
                    <a href="?page=<?php echo $total_pages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Last &raquo;</a>
                <?php endif; ?>
            </div>
            
            <div style="text-align: center; color: #666;">
                Halaman <?php echo $page; ?> dari <?php echo $total_pages; ?> 
                (Menampilkan <?php echo min($limit, $total_records - $offset); ?> dari <?php echo $total_records; ?> data)
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Auto-hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            
            if (successAlert) {
                setTimeout(function() {
                    fadeOutAlert(successAlert);
                }, 5000); // Hide after 5 seconds
            }
            
            if (errorAlert) {
                setTimeout(function() {
                    fadeOutAlert(errorAlert);
                }, 7000); // Hide after 7 seconds (longer for errors)
            }
        });
        
        // Function to fade out and remove alert
        function fadeOutAlert(element) {
            element.style.transition = 'opacity 0.5s ease-out';
            element.style.opacity = '0';
            setTimeout(function() {
                element.style.display = 'none';
                // Remove URL parameters to clean up
                if (window.history && window.history.pushState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('success');
                    url.searchParams.delete('error');
                    url.searchParams.delete('deleted_name');
                    window.history.pushState({}, '', url);
                }
            }, 500);
        }
        
        // Function to close alert manually
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                fadeOutAlert(alert);
            }
        }
    </script>
</body>
</html>