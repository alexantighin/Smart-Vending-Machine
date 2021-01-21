<?php
$dBServername = "localhost";
$dBUsername = "admin";
$dBPassword = "antighin";
$dBName = "smart_vending_machine";

// Cream conexiunea
$conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);

// verificam conexiunea
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}