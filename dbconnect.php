<?php
$mysqli = new mysqli('127.0.0.1', 'meganl33_admin', 'boodle', 'meganl33_project');

if ($mysqli->connect_errno) {
    echo "Errno: " . $mysqli->connect_errno . "</br>";
    echo "Error: " . $mysqli->connect_error . "</br>";
    exit;
}
?>