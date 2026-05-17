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
    $carikode = mysqli_query($koneksi,"select max(id_jadwal) from jadwal_kelas") or die (mysqli_error());
    $datakode = mysqli_fetch_array($carikode);
    
    if($datakode) {
        $nilaikode = (int)($datakode[0]);
        $kode = (int) $nilaikode;
        $kode = $kode + 1;
        $hasilkode ="" .str_pad($kode, 3, "0", STR_PAD_LEFT);
    } else {$hasilkode =""; }
    $_SESSION["KODE"] = $hasilkode;

    if(isset($_POST['tambah'])){
        $id_jadwal = $_POST['id_jadwal'];
        $id_kelas = $_POST['id_kelas'];
        $thn_ajaran = $_POST['thn_ajaran'];
        $semester = $_POST['semester'];

        $insert = mysqli_query($koneksi,"INSERT INTO jadwal_kelas (id_jadwal, id_kelas, thn_ajaran, semester) 
                                   VALUES ('$id_jadwal','$id_kelas','$thn_ajaran','$semester')");

        if ($insert) {
            echo '<div class="alert alert-info-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Berhasil Disimpan</h4></div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal_kelas">';
        }else{
            echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Gagal Disimpan</h4></div>';
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
            <input type="number" name="id_jadwal" id="id_jadwal" class="form-control" value="<?= $hasilkode; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="id_kelas">Kelas</label>
            <select name="id_kelas" id="id_kelas" class="form-control">
              <option value="">-- Pilih Kelas --</option>
              <?php
                $query_kelas = mysqli_query($koneksi, "SELECT * FROM tbl_kelas");
                while ($row_kelas = mysqli_fetch_array($query_kelas)) {
                  echo '<option value="'.$row_kelas['id_kelas'].'">'.$row_kelas['nm_kelas'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="thn_ajaran">Tahun Ajaran</label>
            <input type="text" name="thn_ajaran" id="thn_ajaran" placeholder="2024/2025" class="form-control" maxlength="10">
          </div>
          <div class="form-group">
            <label for="semester">Semester</label>
            <select name="semester" id="semester" class="form-control">
              <option value="">-- Pilih Semester --</option>
              <option value="ganjil">Ganjil</option>
              <option value="genap">Genap</option>
            </select>
          </div>
          <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?page=jadwal_kelas'">Kembali</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>