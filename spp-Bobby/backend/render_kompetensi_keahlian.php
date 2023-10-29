<?php
require './conn.php';

if (isset($_POST['grade'])) {
	$selectedGrade = $_POST['grade'];

	// Query to retrieve kelas options based on the selected grade
	$sql = "SELECT kompetensi_keahlian FROM data_kelas WHERE nama_kelas = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $selectedGrade);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result) {
		while ($row = $result->fetch_assoc()) {
			echo '<option value="' . $row['kompetensi_keahlian'] . '">' . $row['kompetensi_keahlian'] . '</option>';
		}
	} else {
		echo "Error fetching kelas options: " . mysqli_error($conn);
	}

	$stmt->close();
}

mysqli_close($conn);
?>