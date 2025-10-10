<?php
$logFile = "/var/log/cloudflared.log";

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
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }
        .log-content {
            background-color: #222;
            color: #eee;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
            max-height: 70vh;
            overflow-y: auto;
            border: 1px solid #555;
        }
        .header {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }
        .buttons {
            margin-top: 10px;
            text-align: center;
        }
        .buttons input {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Cloudflared Logs</h3>
        <p>Log file: <?= $logFile ?></p>
    </div>

    <div class="log-content"><?= htmlspecialchars($logContent) ?></div>

    <div class="buttons">
        <input type="button" value="Refresh" onclick="location.reload();">
        <input type="button" value="Close" onclick="parent.closeBox();">
    </div>
</body>
</html>

