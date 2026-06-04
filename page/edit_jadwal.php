<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Jadwal</h1>
      </div>
    </div>
  </div>
</div>

<?php
$kd = $_GET['kd_jadwal'];
$edit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jadwal WHERE kd_jadwal='$kd' "));

// Ambil detail jadwal
$detail = mysqli_query($koneksi, "SELECT d.*, m.nm_mapel 
                                  FROM detail_jadwal d 
                                  JOIN tbl_mapel m ON d.kd_mapel = m.kd_mapel
                                  WHERE d.kd_jadwal='$kd'");

if (isset($_POST['update'])) {
  $kd_guru     = $_POST['kd_guru'];
  $semester    = $_POST['semester'];
  $tahun_ajaran= $_POST['tahun_ajaran'];
  $kd_mapel    = $_POST['kd_mapel'];
  $hari        = $_POST['hari'];
  $jam         = $_POST['jam'];
  $kelas       = $_POST['kelas'];

  // Update jadwal utama
  $update = mysqli_query($koneksi,"UPDATE jadwal SET kd_guru='$kd_guru', semester='$semester', tahun_ajaran='$tahun_ajaran' WHERE kd_jadwal='$kd'");

  if ($update) {
    // Hapus detail lama
    mysqli_query($koneksi,"DELETE FROM detail_jadwal WHERE kd_jadwal='$kd'");

    // Insert detail baru
    $allSuccess = true;
    for ($i=0; $i<count($kd_mapel); $i++) {
      $insert = mysqli_query($koneksi,"INSERT INTO detail_jadwal (kd_jadwal, kd_mapel, hari, jam, kelas)
      VALUES ('$kd', '{$kd_mapel[$i]}', '{$hari[$i]}', '{$jam[$i]}', '{$kelas[$i]}')");
      if (!$insert) $allSuccess = false;
    }

    if ($allSuccess) {
      echo '<div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-info"></i> Info</h5>
      <h4>Berhasil Disimpan!</h4></div>';
      echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal_kelas">';
    } else {
      echo '<div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-info"></i> Info</h5>
      <h4>Gagal menyimpan detail jadwal!</h4></div>';
    }
  }
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="">
          <div class="form-group">
            <label>Kode Jadwal</label>
            <input type="text" name="kd_jadwal" value="<?= $edit['kd_jadwal']; ?>" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Guru</label>
            <select name="kd_guru" class="form-control">
              <?php
              $guru = mysqli_query($koneksi,"SELECT * FROM tbl_guru");
              while ($g = mysqli_fetch_assoc($guru)) {
                $sel = ($g['kd_guru']==$edit['kd_guru'])?"selected":"";
                echo "<option value='{$g['kd_guru']}' $sel>{$g['nm_guru']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control" required>
              <option <?= ($edit['semester']=='Ganjil')?'selected':''; ?>>Ganjil</option>
              <option <?= ($edit['semester']=='Genap')?'selected':''; ?>>Genap</option>
            </select>
          </div>
          <div class="form-group">
            <label>Tahun Ajaran</label>
            <select name="tahun_ajaran" class="form-control" required>
              <option <?= ($edit['tahun_ajaran']=='2024-2025')?'selected':''; ?>>2024-2025</option>
              <option <?= ($edit['tahun_ajaran']=='2025-2026')?'selected':''; ?>>2025-2026</option>
            </select>
          </div>

          <hr>
          <h5>Detail Jadwal</h5>
          <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
          <div class="row mt-2">
            <div class="col-md-3">
              <select name="kd_mapel[]" class="form-control">
                <?php
                $mapel = mysqli_query($koneksi,"SELECT * FROM tbl_mapel");
                while ($m = mysqli_fetch_assoc($mapel)) {
                  $sel = ($m['kd_mapel']==$d['kd_mapel'])?"selected":"";
                  echo "<option value='{$m['kd_mapel']}' $sel>{$m['nm_mapel']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <select name="hari[]" class="form-control" required>
                <option <?= ($d['hari']=='Senin')?'selected':''; ?>>Senin</option>
                <option <?= ($d['hari']=='Selasa')?'selected':''; ?>>Selasa</option>
                <option <?= ($d['hari']=='Rabu')?'selected':''; ?>>Rabu</option>
                <option <?= ($d['hari']=='Kamis')?'selected':''; ?>>Kamis</option>
                <option <?= ($d['hari']=='Jumat')?'selected':''; ?>>Jumat</option>
                <option <?= ($d['hari']=='Sabtu')?'selected':''; ?>>Sabtu</option>
              </select>
            </div>
            <div class="col-md-3">
              <input type="text" name="jam[]" value="<?= $d['jam']; ?>" class="form-control" required>
            </div>
            <div class="col-md-3">
              <input type="text" name="kelas[]" value="<?= $d['kelas']; ?>" class="form-control" required>
            </div>
          </div>
          <?php } ?>

          <br>
          <input type="submit" class="btn btn-primary" name="update" value="Simpan Perubahan">
        </form>
      </div>
    </div>
  </div>
</section>
