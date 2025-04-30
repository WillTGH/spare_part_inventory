<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Optional: prevent script from timing out
set_time_limit(0);

// Sample data from server — you can update this to query a DB later
$time = date('H:i:s');
echo "data: The time is now $time\n\n";
flush();
?>