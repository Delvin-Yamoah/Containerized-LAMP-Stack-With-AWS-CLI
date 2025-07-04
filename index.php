<?php
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: 'password';
$db_name = getenv('DB_NAME') ?: 'counter_db';

$hosts = ["127.0.0.1"];
$retries = 10;
$mysqli = null;

foreach ($hosts as $host) {
    $current_retries = $retries;
    while ($current_retries > 0) {
        $mysqli = new mysqli($host, $db_user, $db_pass, $db_name);
        if (!$mysqli->connect_error) {
            break 2;
        }
        $current_retries--;
        sleep(2);
    }
}

if (!$mysqli || $mysqli->connect_error) {
    die("DB Connection failed: " . ($mysqli ? $mysqli->connect_error : "Unable to connect to any host"));
}
if ($mysqli->connect_error) {
    die("DB Connection failed: " . $mysqli->connect_error);
}

$mysqli->query("CREATE TABLE IF NOT EXISTS visits (id INT PRIMARY KEY DEFAULT 1, count INT DEFAULT 0)");
$mysqli->query("INSERT INTO visits (id, count) VALUES (1, 1) ON DUPLICATE KEY UPDATE count = count + 1");
$result = $mysqli->query("SELECT count FROM visits LIMIT 1");
$row = $result->fetch_assoc();
echo "Visit Count: " . $row['count'];
?>
