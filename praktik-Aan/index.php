<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Intruksi Kerja Nomor 1 CSS -->
	<link rel="stylesheet" href="bootstrap.css">
	

	<title>Hitung Biaya Parkir Mall</title>
</head>
<body>
	<div class="container border">
		<!-- Instruksi Kerja Nomor 2. -->
		<!-- Menampilkan logo Mall -->
		<img src="logo.png" alt="logo mall">
		

		<h2>Hitung Biaya Parkir Mall</h2>
		<br>
		<form action="index.php" method="post" id="formPerhitungan">
			<div class="row">
				<!-- Masukan data plat nomor kendaraan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Plat Nomor Kendaraan:</label></div>
				<div class="col-lg-2"><input type="text" id="plat" name="plat"></div>
			</div>

			<div class="row">
				<!-- Masukan pilihan jenis kendaraan. -->
				<div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
				<div class="col-lg-2">
					<!-- Instruksi Kerja Nomor 3, 4, dan 5 -->
					<?php
						// Array kendaraan
						$kendaraan = array('truk', 'motor', 'mobil');

						// Mengurutkan array secara ascending
						sort($kendaraan);

						
        // Loop melalui array dan membuat radio button untuk masing-masing kendaraan
        foreach ($kendaraan as $k) {
            echo '<input type="radio" name="jenis_kendaraan" value="' . $k . '"> ' . ucfirst($k) . '<br>';
        }
        
?>

					
					
				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Masuk Kendaraan -->
				<div class="col-lg-2"><label for="nomor">Jam Masuk [jam]:</label></div>
				<div class="col-lg-2">
					<select id="masuk" name="masuk">
					<option value="">- Jam Masuk -</option>
					
					<!-- Instruksi Kerja Nomor 6 -->
						<?php 
						 // Loop untuk membuat pilihan jam masuk dari 1 hingga 24
            for ($jam = 1; $jam <= 24; $jam++) {
                echo "<option value='$jam'>$jam:00</option>";
            }
            ?>

					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Keluar Kendaraan. -->
				<div class="col-lg-2"><label for="nomor">Jam Keluar [jam]:</label></div>
				<div class="col-lg-2">
					<select id="keluar" name="keluar">
					<option value="">- Jam Keluar -</option>
					
					<!-- Instruksi Kerja Nomor 6 -->
					<?php
            // Loop untuk membuat pilihan jam keluar dari 1 hingga 24
            for ($jam = 1; $jam <= 24; $jam++) {
                echo "<option value='$jam'>$jam:00</option>";
            }
            ?>

					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan pilihan Member. -->
				<div class="col-lg-2"><label for="tipe">Keanggotaan:</label></div>
				<div class="col-lg-2">
					<input type='radio' name='member' value='Member'> Member <br>
					<input type='radio' name='member' value='Non-Member'> Non Member <br>
					
				</div>
			</div>

			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPerhitungan" value="hitung" name="hitung">Hitung</button></div>
				<div class="col-lg-2"></div>		
			</div>
		</form>
	</div>

	<?php

	if(isset($_POST['hitung'])) {

		// Instruksi Kerja Nomor 7 (hitung durasi)
		$jamMasuk = $_POST["masuk"];
    $jamKeluar = $_POST["keluar"];
    $jenisKendaraan = $_POST["jenis_kendaraan"];

    // Menghitung durasi parkir (durasi = jam keluar - jam masuk)
    $durasi = $jamKeluar - $jamMasuk;
		

		// Instruksi Kerja Nomor 8 (fungsi)
		function hitung_parkir($jenis_kendaraan, $durasi, $keanggotaan) {
			// Inisialisasi tarif parkir untuk masing-masing jenis kendaraan
			$tarif_mobil_awal = 5000; // Rp 5.000 untuk 1 jam pertama
			$tarif_mobil_berikutnya = 3000; // Rp 3.000 per jam setelah 1 jam pertama
			$tarif_motor_awal = 2000; // Rp 2.000 untuk 1 jam pertama
			$tarif_motor_berikutnya = 1000; // Rp 1.000 per jam setelah 1 jam pertama
			$tarif_truk = 6000; // Rp 6.000 per jam
		
			// Menghitung biaya parkir berdasarkan jenis kendaraan dan durasi parkir
			switch ($jenis_kendaraan) {
					case 'Mobil':
							if ($durasi <= 1) {
									$biaya = $tarif_mobil_awal;
							} else {
									$biaya = $tarif_mobil_awal + ($tarif_mobil_berikutnya * ($durasi - 1));
							}
							break;
					case 'Motor':
							if ($durasi <= 1) {
									$biaya = $tarif_motor_awal;
							} else {
									$biaya = $tarif_motor_awal + ($tarif_motor_berikutnya * ($durasi - 1));
							}
							break;
					case 'Truk':
							$biaya = $tarif_truk * $durasi;
							break;
					default:
							$biaya = 0; // Kendaraan tidak valid
							break;
			}
		
			// Menghitung diskon berdasarkan jenis keanggotaan
			if ($keanggotaan == 'Member') {
					$diskon = 0.10; // 10% diskon
					$biaya_diskon = $biaya * $diskon;
					$biaya_akhir = $biaya - $biaya_diskon;
			} else {
					$biaya_akhir = $biaya; // Tidak ada diskon untuk Non-Member
			}
		
			return $biaya_akhir;
		}
		

		$dataParkir = array(
			'plat' => $_POST['plat'],
			'kendaraan' => $_POST['jenis_kendaraan'],
			'masuk' => $_POST['masuk'],
			'keluar' => $_POST['keluar'],
			'durasi' => $durasi,
			'member' => $_POST['member'],
		);

		var_dump($dataParkir);

		$jenis_kendaraan = ['kendaraan'];
		$durasi = $durasi; // Durasi parkir dalam jam
		$keanggotaan = ['member']; // Ganti dengan 'Non-Member' jika perlu

		$biaya_akhir = hitung_parkir($jenis_kendaraan, $durasi, $keanggotaan);


// var_dump($biaya_akhir);

		// Instruksi Kerja Nomor 12 (menyimpan ke json)
		$json_data = json_encode($dataParkir);
file_put_contents('data.json', $json_data);

// Membaca data pemesanan dari file JSON
$json_data = file_get_contents('data.json');
$dataParkir = json_decode($json_data, true);



		//	Menampilkan data parkir kendaraan.
		//  KODE DI BAWAH INI TIDAK PERLU DIMODIFIKASI!!!
		echo "
		<br/>
		<div class='container'>
		<div class='row'>
		<!-- Menampilkan Plat Nomor Kendaraan. -->
		<div class='col-lg-2'>Plat Nomor Kendaraan:</div>
		<div class='col-lg-2'>".$dataParkir['plat']."</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Jenis Kendaraan. -->
		<div class='col-lg-2'>Jenis Kendaraan:</div>
		<div class='col-lg-2'>".$dataParkir['kendaraan']."</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Durasi Parkir. -->
		<div class='col-lg-2'>Durasi Parkir:</div>
		<div class='col-lg-2'>".$dataParkir['durasi']." jam</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Jenis Keanggotaan. -->
		<div class='col-lg-2'>Keanggotaan:</div>
		<div class='col-lg-2'>".$dataParkir['member']." </div>
		</div>
		<div class='row'>
		<!-- Menampilkan Total Biaya Parkir. -->
		<div class='col-lg-2'>Total Biaya Parkir:</div>
		<div class='col-lg-2'>Rp".number_format($biaya_akhir, 0, ".", ".").",-</div>
		</div>

		</div>
		";
	}
	?>

</body>
</html>