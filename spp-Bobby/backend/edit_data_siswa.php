<?php
require '../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nisn'])) {
  $siswaId = $_POST['nisn'];

  // Query to retrieve Siswa data by ID
  $sql = "SELECT * FROM siswa WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $siswaId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $row = $result->fetch_assoc()) {
    // Return the data as JSON
    echo json_encode($row);
  } else {
    echo json_encode(null);
  }

  $stmt->close();
} else {
  echo json_encode(null);
}

mysqli_close($conn);
?>