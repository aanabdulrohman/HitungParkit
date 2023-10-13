

<?php 
/**
 * Menghitung biaya parkir berdasarkan jenis kendaraan, durasi parkir, dan jenis keanggotaan.
 *
 * @param string $jenis_kendaraan Jenis kendaraan (Mobil, Motor, atau Truk).
 * @param int $durasi Durasi parkir dalam jam.
 * @param string $keanggotaan Jenis keanggotaan (Member atau Non-Member).
 * @return int Biaya parkir yang dihasilkan setelah diskon.
 */
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

// Contoh pemanggilan fungsi
$jenis_kendaraan = 'Mobil';
$durasi_parkir = 4; // Durasi parkir dalam jam
$jenis_keanggotaan = 'Member'; // Ganti dengan 'Non-Member' jika perlu
$biaya_akhir = hitung_parkir($jenis_kendaraan, $durasi_parkir, $jenis_keanggotaan);
echo "Biaya parkir untuk $jenis_kendaraan selama $durasi_parkir jam (keanggotaan: $jenis_keanggotaan) adalah: Rp $biaya_akhir";

?>