<?php 
$conn = new mysqli('localhost','root', '', 'spp_bobs');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}