<?php

namespace App\Utils;

use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Migrasi
{
  protected $business_id;
  protected $data_desa = [];
  protected $data_paket = [];
  protected $data_cater = [];

  public function __construct($business_id)
  {
    $this->business_id = $business_id;
  }

  public function desa($desa)
  {
    $header = 1;
    $query = [];
    foreach ($desa as $d) {
      if ($header == 1) {
        $header = 0;
        continue;
      }

      $kode_desa = str_pad($d[0], 4, '0', STR_PAD_LEFT);
      $business_id = str_pad($this->business_id, 3, '0', STR_PAD_LEFT);

      $kd_desa =  $business_id . '.' . $kode_desa;
      $this->data_desa[$d[1]] = [
        'kode' => $d[0],
        'nama' => $d[1],
      ];

      $query[] = "INSERT INTO villages (kode, nama, alamat, hp) VALUE ('$kd_desa', '$d[1]','-','08')";
    }

    return $query;
  }

  public function paket($paket)
  {
    $header = 1;
    $query = [];
    foreach ($paket as $p) {
      if ($header == 1) {
        $header = 0;
        continue;
      }

      $this->data_paket[substr($p[1], 0, 1)] = [
        'id' => $p[0],
        'kelas' => $p[1],
      ];

      $harga = [];
      for ($i = 2; $i < count($p); $i++) {
        $harga[] = $p[$i] ?: 0;
      }

      $harga = json_encode($harga);
      $query[] = "INSERT INTO package (business_id, paket, harga) VALUES ('$this->business_id', '$p[1]', '$harga')";
    }

    return $query;
  }

  public function instalasi($instalasi)
  {
    $header = 1;

    $query = [];
    $query_cater = [];
    $query_customer = [];
    foreach ($instalasi as $ins) {
      if ($header == 1) {
        $header = 0;
        continue;
      }

      $kode_instalasi = $ins[0];
      $tgl_pasang = Date::excelToDateTimeObject($ins[1])->format('Y-m-d');
      $desa = $ins[2];
      $kd_desa = $this->data_desa[$desa]['kode'];
      $pelanggan = ucwords(strtolower($ins[3]));
      $cater = strtolower($ins[4]);
      $alamat = $ins[5];
      $abodemen = $ins[6];
      $denda = $ins[7];
      $biaya_instalasi = $ins[8];
      $tgl_tagihan = Date::excelToDateTimeObject($ins[9])->format('Y-m-d');
      $akhir_pemakaian = $ins[10];

      if (!array_key_exists($cater, $this->data_cater)) {
        $this->data_cater[$cater] = $cater;

        $username = $cater . $this->business_id;
        $password = Hash::make($username);
        $query_cater[] = "INSERT INTO users (business_id, nama, jabatan, username, password) VALUES ('$this->business_id', '$cater', '5', '$username', '$password')";
      }

      $query_customer[] = "INSERT INTO customers (business_id, desa, nama) VALUES ('$this->business_id', '$kd_desa', '$pelanggan')";
      $query[] = "INSERT INTO installations () VALUES ()";
    }
  }
}
