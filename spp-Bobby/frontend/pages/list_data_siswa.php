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
			<?php
			require '../../backend/conn.php';

			$sql = "SELECT siswa.*, data_kelas.nama_kelas, data_kelas.kompetensi_keahlian FROM siswa JOIN data_kelas ON siswa.id_kelas = data_kelas.id_kelas";
			$result = mysqli_query($conn, $sql);

			if (!$result) {
				echo "Error fetching data: " . mysqli_error($conn);
			} else {
				// Fetch the data and store it in an array
				$data = [];
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
			}

			mysqli_close($conn);
			?>
			<?php foreach ($data as $row): ?>
				<li class="table-row">
					<div class="col col-1" data-label="NISN">
						<?= $row['nisn'] ?>
					</div>
					<div class="col col-2" data-label="NIS">
						<?= $row['nis'] ?>
					</div>
					<div class="col col-3" data-label="NAMA">
						<?= $row['nama'] ?>
					</div>
					<div class="col col-4" data-label="KELAS">
						<?= $row['nama_kelas'] . ' - ' . $row['kompetensi_keahlian'] ?>
					</div>
					<div class="col col-5" data-label="ALAMAT">
						<?= $row['alamat'] ?>
					</div>
					<div class="col col-6" data-label="NO TELP">
						<?= $row['no_telp'] ?>
					</div>
					<div class="col col-7" data-label="ACTION">
						<!-- Add any action buttons or links here -->
						<a href="#" class="edit-button" data-id="<?= $row['nisn'] ?>"><i class="fa-solid fa-pen-to-square fa-xl"
								style="color: #00996b;"></i></a> | <a href="#">Delete</a>
					</div>
				</li>
			<?php endforeach; ?>
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
				<select name="list_spp" id="spp">
					<option value="" disabled selected>SPP</option>
					<?php
					require '../../backend/conn.php';

					$sql = "SELECT * FROM spp";
					$result = mysqli_query($conn, $sql);

					if ($result) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="' . $row['id_spp'] . '">' . $row['id_spp'] . '</option>';
						}
					} else {
						echo "Error fetching spp options: " . mysqli_error($conn);
					}

					mysqli_close($conn);
					?>
				</select>
				<div class="btn__container">
					<input type="submit" class="button" value="Login" />
					<input type="submit" class="button danger" value="Cancel" />
				</div>
			</form>

			<a href="#" class="modal__close" id="modalCloseButton">&times;</a>
		</div>
	</div>

	<script src="https://kit.fontawesome.com/65503aad7e.js" crossorigin="anonymous"></script>
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
							$("#demo-modal").hide();
							alert("Data inserted successfully.");
							location.reload();
						} else {
							alert(response);
						}
					}
				});
			});
		});

		$(document).ready(function () {
			// Handle the click event of the "Edit" button
			$(".edit-button").click(function (e) {
				e.preventDefault();
				var siswaId = $(this).data("id");

				// Fetch the data for the selected Siswa record and populate the form
				$.ajax({
					type: "POST",
					url: "../../backend/edit_data_siswa.php",
					data: { id: siswaId },
					success: function (response) {
						// Parse the response data and populate the form fields
						var data = JSON.parse(response);
						if (data) {
							$("#nisn").val(data.nisn);
							$("#nis").val(data.nis);
							$("#nama").val(data.nama);
							$("#nama_kelas").val(data.nama_kelas);
							$("#kompetensi_keahlian").val(data.kompetensi_keahlian);
							$("#alamat").val(data.alamat);
							$("#no-telp").val(data.no_telp);
							$("#list_spp").val(data.list_spp);
						}
					}
				});
			});
		});
	</script>
</body>

</html>