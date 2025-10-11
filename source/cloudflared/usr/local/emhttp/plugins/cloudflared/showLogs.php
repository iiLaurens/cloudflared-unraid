<?php
$logFile = "/var/log/cloudflared.log";

// Handle AJAX requests for log content only
if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    header('Content-Type: text/plain; charset=UTF-8');
    if (file_exists($logFile)) {
        $logContent = file_get_contents($logFile);
        if (empty($logContent)) {
            echo "Log file is empty.";
        } else {
            echo $logContent;
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
    <title>Cloudflared live logs</title>
    <style>
      body { margin: 0; padding: 0; font-family: monospace; }
      .log-content {
        padding: 10px;
        border-radius: 4px;
        font-family: monospace;
        white-space: pre-wrap;
        height: 100vh;
        overflow-y: auto;
        border: 1px solid #555;
        box-sizing: border-box;
        overflow-anchor: none;
      }
    </style>
</head>
<body>
    <div class="log-content" id="logContent"><?= $logContent ?></div>

    <script>
      let stickToBottom = true;

      function distanceFromBottom(el) {
        return el.scrollHeight - el.scrollTop - el.clientHeight;
      }

      function updateLogs() {
        const el = document.getElementById('logContent');

        const wasAtBottom = distanceFromBottom(el) <= 3;
        const oldTop = el.scrollTop;
        const oldHeight = el.scrollHeight;

        fetch('?ajax=1', { cache: 'no-store' })
          .then(r => r.text())
          .then(data => {
            // No change
            if (data === el.textContent) return;

            // Append only the new part if it's a pure append
            if (data.startsWith(el.textContent)) {
              const addition = data.slice(el.textContent.length);
              if (addition.length) el.append(document.createTextNode(addition));
            } else {
              // Fallback: full replace (e.g., rotation/truncation)
              el.textContent = data;
            }

            // Anchor position
            if (stickToBottom || wasAtBottom) {
              el.scrollTop = el.scrollHeight; // stay at bottom
            } else {
              const newHeight = el.scrollHeight;
              el.scrollTop = Math.max(0, oldTop + (newHeight - oldHeight));
            }
          })
          .catch(err => console.error('Error fetching logs:', err));
      }

      document.addEventListener('DOMContentLoaded', () => {
        const el = document.getElementById('logContent');
        el.scrollTop = el.scrollHeight; // start at bottom
        stickToBottom = true;

        el.addEventListener('scroll', () => {
          stickToBottom = distanceFromBottom(el) <= 3;
        });
      });

      setInterval(updateLogs, 1000);
    </script>
</body>
</html>