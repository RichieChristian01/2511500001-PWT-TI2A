<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Tambah Detail Jadwal</h1>
      </div>
    </div>
  </div>
</div>

<?php
$kd = isset($_GET['kd']) ? $_GET['kd'] : 0;

if(isset($_POST['tambah'])){
  $id_jadwal   = $_POST['id_jadwal'];
  $kd_mapel    = $_POST['kd_mapel'];
  $kd_guru     = $_POST['kd_guru'];
  $hari        = $_POST['hari'];
  $jam_mulai   = $_POST['jam_mulai'];
  $jam_selesai = $_POST['jam_selesai'];

  $insert = mysqli_query($koneksi,"INSERT INTO detail_jadwal (id_jadwal, kd_mapel, kd_guru, hari, jam_mulai, jam_selesai) 
                                   VALUES ('$id_jadwal','$kd_mapel','$kd_guru','$hari','$jam_mulai','$jam_selesai')");
  if ($insert){
    echo '<div class="alert alert-info alert-dismissible">Berhasil Disimpan</div>';
    echo '<meta http-equiv="refresh" content="1;url=index.php?page=detail_jadwal&kd='.$id_jadwal.'">';
  } else {
    echo '<div class="alert alert-warning alert-dismissible">Gagal Disimpan</div>';
  }
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body p-2">
        <form method="POST" action="">
          <div class="form-group">
            <label for="id_jadwal">ID Jadwal</label>
            <input type="number" name="id_jadwal" id="id_jadwal" class="form-control" value="<?= $kd; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="kd_mapel">Mata Pelajaran</label>
            <select name="kd_mapel" id="kd_mapel" class="form-control" required>
              <option value="">-- Pilih Mata Pelajaran --</option>
              <?php
                $query_tbl_mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel");
                while ($row_tbl_mapel = mysqli_fetch_array($query_tbl_mapel)) {
                  echo '<option value="'.$row_tbl_mapel['kd_mapel'].'">'.$row_tbl_mapel['kd_mapel'].' - '.$row_tbl_mapel['Nm_mapel'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="kd_guru">Guru</label>
            <select name="kd_guru" id="kd_guru" class="form-control" required>
              <option value="">-- Pilih Guru --</option>
              <?php
                $query_tbl_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                while ($row_tbl_guru = mysqli_fetch_array($query_tbl_guru)) {
                  echo '<option value="'.$row_tbl_guru['kd_guru'].'">'.$row_tbl_guru['kd_guru'].'  '.$row_tbl_guru['nm_guru'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="hari">Hari</label>
            <select name="hari" id="hari" class="form-control" required>
              <option value="">-- Pilih Hari --</option>
              <option value="senin">Senin</option>
              <option value="selasa">Selasa</option>
              <option value="rabu">Rabu</option>
              <option value="kamis">Kamis</option>
              <option value="jumat">Jumat</option>
              <option value="sabtu">Sabtu</option>
            </select>
          </div>
          <div class="form-group">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control">
          </div>
          <div class="form-group">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control">
          </div>
          <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?page=detail_jadwal&kd=<?= $kd; ?>'">Kembali</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>