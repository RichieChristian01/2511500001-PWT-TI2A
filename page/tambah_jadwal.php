<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Jadwal</h1>
      </div>
    </div>
  </div>
</div>

<?php
$carikode = mysqli_query($koneksi, "SELECT MAX(kd_jadwal) FROM jadwal") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode && $datakode[0] != null) {
  $nilaikode = substr($datakode[0], 2);
  $kode = (int) $nilaikode;
  $kode++;
  $hasilkode = "J-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
  $hasilkode = "J-001"; // default kode pertama
}

$_SESSION["KODE"] = $hasilkode;

if (isset($_POST['tambah'])) {
  $kd_jadwal   = $_POST['kd_jadwal'];
  $kd_guru     = $_POST['kd_guru'];
  $semester    = $_POST['semester'];
  $tahun_ajaran= $_POST['tahun_ajaran'];
$kd_mapel = $_POST['kd_mapel'];
$hari     = $_POST['hari'];
$jam      = $_POST['jam'];
$kelas    = $_POST['kelas'];

$insertJadwal = mysqli_query($koneksi, "INSERT INTO jadwal VALUES ('$kd_jadwal', '$kd_guru', '$semester', '$tahun_ajaran')");
if (!$insertJadwal) {
    echo "Gagal insert ke tabel jadwal : " . mysqli_error($koneksi);
} else {
    // Insert ke detailJadwal
    $allSuccess = true;
    for ($i = 0; $i < count($kd_mapel); $i++) {
        $insert = mysqli_query($koneksi, "INSERT INTO detail_jadwal (kd_jadwal, kd_mapel, hari, jam, kelas)
        VALUES ('$kd_jadwal', '{$kd_mapel[$i]}', '{$hari[$i]}', '{$jam[$i]}', '{$kelas[$i]}')");
        if (!$insert) {
            $allSuccess = false;
            echo "Gagal insert detail ke {$i}: " . mysqli_error($koneksi);
        }
    }

    if ($allSuccess) {
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info!</h5>
        <h4>Berhasil Disimpan!</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal_kelas">';
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info!</h5>
        <h4>Gagal menyimpan sebagian atau seluruh data detail.</h4></div>';
    }
}
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3>Tambah Jadwal</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Kode Jadwal</label>
                        <input type="text" name="kd_jadwal" value="<?= $hasilkode ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Guru</label>
                        <select name="kd_guru" class="form-control">
                            <?php
                            $tbl_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                            while ($tbl_guru = mysqli_fetch_assoc($tbl_guru)) {
                                echo "<option value='{$tbl_guru['kd_guru']}'>{$tbl_guru['nm_guru']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
    <div class="form-group">
        <label>Semester</label>
        <select name="semester" class="form-control" required>
            <option selected disabled>--Pilih semester--</option>
            <option>Ganjil</option>
            <option>Genap</option>
        </select>
    </div>
    <div class="form-group">
        <label>Tahun Ajaran</label>
        <select name="tahun_ajaran" class="form-control" required>
            <option selected disabled>--Pilih Tahun Ajaran--</option>
            <option>2024-2025</option>
            <option>2025-2026</option>
        </select>
    </div>
</div>

<hr>
<h5>Detail Jadwal</h5>
<div id="detail_jadwal1">
    <div class="row mt-2">
        <div class="col-md-3">
            <select name="kd_mapel[]" class="form-control">
                <option selected disabled>--Pilih Mapel--</option>
                <?php
                $tbl_mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel");
                while ($tbl_mapel = mysqli_fetch_assoc($tbl_mapel)) {
                    echo "<option value='{$tbl_mapel['kd_mapel']}'>{$tbl_mapel['nm_mapel']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="hari[]" class="form-control" required>
                <option selected disabled>--Pilih Hari--</option>
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="jam[]" class="form-control" required>
                <option selected disabled>--Pilih Jam--</option>
                <option>08.00-09.30</option>
                <option>09.30-11.00</option>
                <option>11.00-12.30</option>
                <option>12.30-14.00</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="kelas[]" class="form-control" placeholder="Kelas" required>
        </div>
    </div>
</div>

<button type="button" class="btn btn-info" onclick="tambahBaris()">+ Tambah Mapel</button>
<input type="submit" class="btn btn-primary" name="tambah" value="simpan">
</form>

<script>
function tambahBaris() {
    let container = document.getElementById('detail_jadwal');
    let row = container.firstElementChild.cloneNode(true);
    row.querySelectorAll('input').forEach(input => input.value = '');
    container.appendChild(row);
}
</script>