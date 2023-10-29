<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>Dashboard</title>
	<link rel="stylesheet" href="../styles/list.css" />
</head>

<body>
	<div class="container">
		<h2>LIST DATA SISWA</h2>
		<ul class="responsive-table">
			<a href="#demo-modal" class="add__btn">Add Data</a>
			<li class="table-header">
				<div class="col col-1">NISN</div>
				<div class="col col-2">NIS</div>
				<div class="col col-3">NAMA</div>
				<div class="col col-4">KELAS</div>
				<div class="col col-5">ALAMAT</div>
				<div class="col col-6">NO TELP</div>
				<div class="col col-7">ACTION</div>
			</li>
			<li class="table-row">
				<div class="col col-1" data-label="NISN">3423423</div>
				<div class="col col-2" data-label="NIS">3011</div>
				<div class="col col-3" data-label="NAMA">Nurfaiz Muhammad Qalbi</div>
				<div class="col col-4" data-label="KELAS">XII - RPL</div>
				<div class="col col-5" data-label="ALAMAT">JL. Pasir Putih</div>
				<div class="col col-6" data-label="NO TELP">082383887162</div>
				<div class="col col-7" data-label="ACTION">E D</div>
			</li>
			<li class="table-row">
				<div class="col col-1" data-label="NISN">3423423</div>
				<div class="col col-2" data-label="NIS">3011</div>
				<div class="col col-3" data-label="NAMA">Aldi Yusron</div>
				<div class="col col-4" data-label="KELAS">XII - RPL</div>
				<div class="col col-5" data-label="ALAMAT">JL. Pasir Putih</div>
				<div class="col col-6" data-label="NO TELP">082383887162</div>
				<div class="col col-7" data-label="ACTION">E D</div>
			</li>
			<li class="table-row">
				<div class="col col-1" data-label="NISN">3423423</div>
				<div class="col col-2" data-label="NIS">3011</div>
				<div class="col col-3" data-label="NAMA">Muhammad Ilham Maulana</div>
				<div class="col col-4" data-label="KELAS">XII - RPL</div>
				<div class="col col-5" data-label="ALAMAT">JL. Pasir Putih</div>
				<div class="col col-6" data-label="NO TELP">082383887162</div>
				<div class="col col-7" data-label="ACTION">E D</div>
			</li>
		</ul>
	</div>

	<div id="demo-modal" class="modal">
		<div class="modal__content">
			<h1>Add Data</h1>

			<form id="formSiswa" method="post" action="">
				<input name="nisn" type="text" placeholder="NISN" />
				<input name="nis" type="text" placeholder="NIS" />
				<input name="nama" type="text" placeholder="Nama" />
				<div class="opt__container">
					<select name="nama_kelas" id="grade">
						<option value="" disabled selected>Kelas</option>
						<?php
						require '../../backend/conn.php';

						$sql = "SELECT DISTINCT nama_kelas FROM data_kelas";
						$result = mysqli_query($conn, $sql);

						if ($result) {
							while ($row = mysqli_fetch_assoc($result)) {
								echo '<option value="' . $row['nama_kelas'] . '">' . $row['nama_kelas'] . '</option>';
							}
						} else {
							echo "Error fetching grade options: " . mysqli_error($conn);
						}

						mysqli_close($conn);
						?>
					</select>
					<select name="kompetensi_keahlian" id="kelas">
						<option value="" disabled selected>Kompetensi Keahlian</option>
					</select>
				</div>

				<input name="alamat" type="text" placeholder="Alamat" />
				<input name="no-telp" type="text" placeholder="No-Telpon" />
				<div class="btn__container">
					<input type="submit" class="button" value="Login" />
					<input type="submit" class="button danger" value="Cancel" />
				</div>
			</form>

			<a href="#" class="modal__close">&times;</a>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>

		// script untuk merender option kelas & kompetensi keahlian
		$(document).ready(function () {
			$("#grade").change(function () {

				var selectedGrade = $(this).val();

				$.ajax({
					type: "POST",
					url: "../../backend/render_kompetensi_keahlian.php",
					data: { grade: selectedGrade },
					success: function (response) {
						$("#kelas").html(response);
					}
				});
			});
		});

		// script untuk menginsert data siswa
		$(document).ready(function () {
			$("#formSiswa").on("submit", function (e) {
				e.preventDefault();

				var formData = $(this).serialize();

				$.ajax({
					type: "POST",
					url: "../../backend/insert_data_siswa.php",
					data: formData,
					success: function (response) {
						if (response === "Success") {
							alert("Data inserted successfully.");
						} else {
							alert(response);
						}
					}
				});
			});
		});
	</script>
</body>

</html>