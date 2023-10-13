<!-- php -->
<?php 
// array untuk menampilakan kendaraan menggunakan perulangan foreach dan array 1 dimensi
$kendaraan = array("Motor", "Mobil", "Truk");

// mengurutkan array menjadi ascending
sort($kendaraan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="asset/css/bootstrap.css">
  <title>Menghitung Biaya Parkir</title>
</head>
<body>
  
<!-- title -->
<div class="container">
  <div class="align-items-center row mb-5">
    <div class="col-m-lg-2">
      <img src="asset/img/logo.png" alt="Logo AandKomputer" width="80">
    </div>
    <div class="col-lg-10">
      <h2 class="text-center mt-5">Parkir toko AandKomputer</h2>
    </div>
  </div>
  <!-- title -->

  <form action="parkir.php" method="post">
    <table>
      <tr>
      <td><label for="plat">Plat No</label></td>
      <td><input type="text" name="plat"></td>
      </tr>
      <tr>
        <td><Label>Jenis Kendaraan</Label></td>
        <td>
      <!-- menampilkan pilihan kendaraan menggunakan perulangan foreach dan menampilkan dengan radio button -->
      <?php 
        foreach ($kendaraan as $k){
          echo '<input type="radio" name="jenis_kendaraan" value="'.$k.'">' . ucfirst($k) . '</br>';
        }
        ?>
        </select>
      </td>
      </tr>
      <td>
        <label for="jam_masuk">Jam Masuk</label>
      </td>
      <td>
        <select name="jam_masuk" id="jam_masuk">
          <!-- php untuk menampilkan urutan jam menggunakan looping for -->
          <?php 
          for ($jam = 1; $jam<= 24; $jam++){
            echo "<option value='$jam'>$jam:00</option>";
          }
          ?>
        </select>
      </td>
      <tr>
        <td><label for="jam_keluar">Jam Keluar</label></td>
        <td><select name="jam_keluar" id="jam_keluar">
          <!-- php untuk menampilkan urutan jam menggunakan Looping for -->
          <?php 
          for ($jam = 1; $jam <= 24; $jam++){
            echo "<option value ='$jam'>$jam:00</option>";
          }
          ?>
        </select>
      </td>
      </tr>
      <tr>
        <td>
          <label for="keanggotaan" class="text-danger">Keanggotaa</label>
      </td>
      <td>
        <input type="radio" name="member" value="Member" > Member <br>
        <input type="radio" name="member" value="Non-Member"> Non Member <br>
      </td>
      </tr>
    </table>
    <input type="submit" name="button" id="button" value="Hitung">
  </form>

  <?php 
  
  // menangkap data yang di kirimkan dari form
  if(isset($_POST['button'])){
    $plat             = $_POST['plat'];
    $jenis_kendaraan  = $_POST['jenis_kendaraan'];
    $jam_masuk        = $_POST['jam_masuk'];
    $jam_keluar       = $_POST['jam_keluar'];
    $keanggotaan      = $_POST['member'];
  }

// menghitung durasi
$durasi = $jam_keluar - $jam_masuk;

// membuat perintah untuk menghitung parkir
function hitungParkir($durasi, $kendaraan) {
  if($kendaraan == "Mobil"){
    $biaya = 5000 + (($durasi - 1) * 3000);
  } elseif ($kendaraan == "Motor"){
    $biaya = 2000 + (($durasi - 1) * 1000);
  } elseif($kendaraan == "Truk"){
    $biaya = 6000 * $durasi;
  } else {
    $biaya = 0;
  }
  return $biaya;
}
  ?>

<!-- memasukan hasil dari function hitungParkir ke variabel biaya -->
<?php 
$biaya = hitungParkir($durasi, $_POST['jenis_kendaraan']);
?>

  <!-- membuat diskon jika yang masuk adalah member -->
  <?php 
  if($_POST['member'] == 'Member'){
    $diskon = $biaya * 0.1; // Diskon 10%
    $biaya_akhir = $biaya - $diskon;
  } else {
    $biaya_akhir = $biaya;
  }

  // memasukan data akhir kedalam array
  $dataParkir = array(
    'plat'        => $_POST['plat'],
    'kendaraan'   => $_POST['jenis_kendaraan'],
    'jam_masuk'   => $_POST['jam_masuk'],
    'jam_keluar'  => $_POST['jam_keluar'],
    'durasi'      => $durasi,
    'member'      => $_POST['member'],
  );


// simpan data ke json
$data_json = json_encode($dataParkir);
file_put_contents('parkir.json', $data_json);


echo "
		<br/>
		<div class='container'>
		<div class='row'>
		<!-- Menampilkan Plat Nomor Kendaraan. -->
		<div class='col-lg-2'>Plat Kendaraan:</div>
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
  
  </div>
</body>
</html>