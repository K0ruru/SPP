<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nisn = $_POST['nisn'];
  $nis = $_POST['nis'];
  $nama = $_POST['nama'];
  $nama_kelas = $_POST['nama_kelas'];
  $kompetensi_keahlian = $_POST['kompetensi_keahlian'];
  $alamat = $_POST['alamat'];
  $no_telp = $_POST['no-telp'];
  $list_spp = $_POST['list_spp'];

  // Server-side validation: Check if required fields are not empty
  if (empty($nisn) || empty($nis) || empty($nama) || empty($nama_kelas) || empty($kompetensi_keahlian) || empty($alamat) || empty($no_telp) || empty($list_spp)) {
    echo "Please fill in all the required fields.";
  } else {
    // All required fields are filled, so you can proceed with database insertion or other actions
    require './conn.php';

    // Insert data into the "siswa" table
    $sql = "INSERT INTO siswa (nisn, nis, nama, id_kelas, alamat, no_telp, id_spp) VALUES (?, ?, ?, (SELECT id_kelas FROM data_kelas WHERE nama_kelas = ? AND kompetensi_keahlian = ?), ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $nisn, $nis, $nama, $nama_kelas, $kompetensi_keahlian, $alamat, $no_telp, $list_spp);


    if ($stmt->execute()) {
      echo "Success"; // Return a success message
    } else {
      echo "Error inserting data: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
  }
} else {
  echo "Invalid request.";
}
?>