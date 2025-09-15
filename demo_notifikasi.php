<!DOCTYPE html>
<html>
<head>
    <title>Demo Notifikasi Auto-Hide</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>Demo Notifikasi Auto-Hide</h1>
        
        <p>Klik tombol di bawah untuk menguji notifikasi:</p>
        
        <button onclick="showSuccessAlert()" class="btn btn-success">Show Success Alert</button>
        <button onclick="showErrorAlert()" class="btn btn-danger">Show Error Alert</button>
        <button onclick="showWarningAlert()" class="btn btn-warning">Show Warning Alert</button>
        
        <div id="alert-container" style="margin-top: 20px;"></div>
        
        <br><br>
        <a href="index.php" class="btn btn-primary">Kembali ke Daftar Mahasiswa</a>
    </div>
    
    <script>
        let alertCounter = 0;
        
        function showSuccessAlert() {
            showAlert('success', 'Data berhasil disimpan!');
        }
        
        function showErrorAlert() {
            showAlert('danger', 'Terjadi kesalahan saat menyimpan data!');
        }
        
        function showWarningAlert() {
            showAlert('warning', 'Peringatan: Data akan ditimpa!');
        }
        
        function showAlert(type, message) {
            alertCounter++;
            const alertId = 'alert-' + alertCounter;
            const container = document.getElementById('alert-container');
            
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-' + type;
            alertDiv.id = alertId;
            alertDiv.innerHTML = message + '<span class="close-btn" onclick="closeAlert(\'' + alertId + '\')">&times;</span>';
            
            container.appendChild(alertDiv);
            
            // Auto-hide after 5 seconds
            setTimeout(function() {
                fadeOutAlert(document.getElementById(alertId));
            }, 5000);
        }
        
        function fadeOutAlert(element) {
            if (element) {
                element.style.transition = 'opacity 0.5s ease-out';
                element.style.opacity = '0';
                setTimeout(function() {
                    if (element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                }, 500);
            }
        }
        
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                fadeOutAlert(alert);
            }
        }
    </script>
</body>
</html>