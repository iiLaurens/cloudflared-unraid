<?php
$logFile = "/var/log/cloudflared.log";

// Handle AJAX requests for log content only
if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    header('Content-Type: text/plain');
    if (file_exists($logFile)) {
        $logContent = file_get_contents($logFile);
        if (empty($logContent)) {
            echo "Log file is empty.";
        } else {
            echo htmlspecialchars($logContent);
        }
    } else {
        echo "Log file not found.";
    }
    exit;
}

// Regular page load
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    if (empty($logContent)) {
        $logContent = "Log file is empty.";
    }
} else {
    $logContent = "Log file not found.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cloudflared Logs</title>
    <style>
        .log-content {
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
            max-height: 70vh;
            overflow-y: auto;
            border: 1px solid #555;
        }
    </style>
</head>
<body>
    <div class="log-content" id="logContent"><?= htmlspecialchars($logContent) ?></div>

    <script>
        function updateLogs() {
            const logContainer = document.getElementById('logContent');

            fetch('?ajax=1')
                .then(response => response.text())
                .then(data => {
                    logContainer.textContent = data;
                    // Scroll to bottom
                    logContainer.scrollTop = logContainer.scrollHeight;
                })
                .catch(error => {
                    console.error('Error fetching logs:', error);
                });
        }

        // Initial scroll to bottom
        document.addEventListener('DOMContentLoaded', function() {
            const logContainer = document.getElementById('logContent');
            logContainer.scrollTop = logContainer.scrollHeight;
        });

        // Update logs every second
        setInterval(updateLogs, 1000);
    </script>
</body>
</html>
