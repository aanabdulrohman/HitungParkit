<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="asset/css/bootstrap.css">
	<!-- Intruksi Kerja Nomor 1 CSS -->

	<title>Hitung Biaya Parkir Mall</title>
</head>
<body>
	<div class="container border">
		<!-- Instruksi Kerja Nomor 2: Menampilkan logo Mall -->
		<!-- Menampilkan logo Mall -->
		<div class="container border p-4">
    <div class="row align-items-center mb-4">
        <div class="col-lg-2">
            <img src="asset/img/logo.png" alt="Logo Mall" width="80">
        </div>
        <div class="col-lg-10">
			<!-- Ini adalah judul halaman -->
            <h2 class="mb-0">Hitung Biaya Parkir Mall</h2>
        </div>
    </div>
		<br>
		<form action="index.php" method="post" id="formPerhitungan">
			<div class="row">
				<!-- Masukan data plat nomor kendaraan. Tipe data text. -->
				<div class="col-lg-2"><label for="">Plat Nomor Kendaraan:</label></div>
				<div class="col-lg-2"><input type="text" id="plat" name="plat" class ="form-control" required></div>
			</div>

		<div class="row">
			<!-- Masukan pilihan jenis kendaraan. -->
			<div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
			
				<!-- Instruksi Kerja Nomor 3, 4, dan 5 -->
                <?php
                    // Instruksi Kerja Nomor 3.
                    $kendaraan = array("Truk", "Motor", "Mobil");

                    // Instruksi Kerja Nomor 4.
                    // Urutkan array $kendaraan secara Ascending.
                    sort($kendaraan);
                ?>     
                    <select id="kendaraan" name="kendaraan" class="form-control" required>
                    <option value="">- Jenis kendaraan -</option>
                <?php
                    // instruksi kerja nomor 5.
                    // Menampilkan pilihan jenis kendaraan dari array $kendaraan.
					// foreach = perulangan untuk array
                    foreach ($kendaraan as $jenis) {
                        echo "<option value=\"$jenis\">$jenis</option>";
                    }
                ?>
                </select>
			</div>
		</div>

        <!-- Masukan Jam Masuk Kendaraan -->
        <div class="row">
            <div class="col-lg-2"><label for="nomor">Jam Masuk [jam]:</label></div>
            <div class="col-lg-2">
                <select id="masuk" name="masuk">
                    <option value="">- Jam Masuk -</option>
                <?php
                for ($jam = 1; $jam <= 24; $jam++) {
                    echo "<option value='$jam'>$jam</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Masukan Jam Keluar Kendaraan. -->
    <div class="row">
        <div class="col-lg-2"><label for="nomor">Jam Keluar [jam]:</label></div>
        <div class="col-lg-2">
            <select id="keluar" name="keluar">
                <option value="">- Jam Keluar -</option>
                <?php
                for ($jam = 1; $jam <= 24; $jam++) {
                    echo "<option value='$jam'>$jam</option>";
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
        if (isset($_POST['hitung'])) {
        $jam_masuk = intval($_POST['masuk']);
        $jam_keluar = intval($_POST['keluar']);
        $durasi = $jam_keluar - $jam_masuk;
        // Memanggil fungsi hitung_parkir
        $biaya = hitung_parkir($durasi, $_POST['kendaraan']);
		
			// Instruksi Kerja Nomor 9 (kontrol percabangan)
			
		}

		// Instruksi Kerja Nomor 10 ($biaya_parkir)
		function hitung_parkir($durasi, $kendaraan){
            // Instruksi Kerja Nomor 8 (fungsi)
            if ($kendaraan == "Mobil") {
                $biaya = 5000 + (($durasi - 1) * 3000);
            } elseif ($kendaraan == "Motor") {
                $biaya = 2000 + (($durasi - 1) * 1000);
            } elseif ($kendaraan == "Truk") {
                $biaya = 6000 * $durasi;
            } else {
                $biaya = 0;  // Jenis kendaraan tidak valid
            }
            return $biaya;
        }

		// Instruksi Kerja Nomor 11 (hitung diskon dan simpal hasil akhir setelah diskon pada variabel $biaya_akhir)
		if ($_POST['member'] == 'Member') {
            $diskon = $biaya * 0.1;  // Diskon 10%
            $biaya_akhir = $biaya - $diskon;
        } else {
            $biaya_akhir = $biaya;
        }

		$dataParkir = array(
			'plat' => $_POST['plat'],
			'kendaraan' => $_POST['kendaraan'],
			'masuk' => $_POST['masuk'],
			'keluar' => $_POST['keluar'],
			'durasi' => $durasi,
			'member' => $_POST['member'],
		);

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
	
	?>

</body>
</html>