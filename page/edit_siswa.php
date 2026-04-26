
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Mata Pelajaran</h1>
            </div>
        </div>
    </div>
</div>

<?php
$nis = $_GET['nis'] ?? null;
if (!$nis) {
    die("NIS tidak ditemukan!");
}
$edit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tbl_siswa WHERE nis='$nis'"));

if(isset($_POST['tambah'])){
  $nis      = $_POST['nis'];
  $nm_siswa = $_POST['nm_siswa'];
  $jenkel   = $_POST['jenkel'];
  $hp       = $_POST['hp'];
  $id_kelas = $_POST['id_kelas'];

    $insert = mysqli_query($koneksi,"UPDATE tbl_siswa SET  nm_siswa='$nm_siswa', jenkel='$jenkel', hp='$hp', id_kelas='$id_kelas' WHERE nis='$nis' ");
    if ($insert) {
        echo '<div class="alert alert-info-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=siswa">';
    } else {
        echo '<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Gagal Disimpan</h4></div>';
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                        
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" name="nis" value="<?= $edit['nis']; ?>" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="nm_siswa">Nama Siswa</label>
                            <input type="text" name="nm_siswa" value="<?= $edit['nm_siswa']; ?>" id="nm_siswa" placeholder="Nama Siswa" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="jenkel">Jenis Kelamin</label>
                            <input type="text" name="jenkel" value="<?= $edit['jenkel']; ?>" id="jenkel" placeholder="L/P" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="hp">HP</label>
                            <input type="text" name="hp" value="<?= $edit['hp']; ?>" id="hp" placeholder="No HP" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="id_kelas">ID Kelas</label>
                            <select class="form-control" input type="text" name="id_kelas" value="<?= $edit['id_kelas']; ?>" id="id_kelas" placeholder="ID Kelas" >
                            <option value="" disabled selected> -- Pilih Id -- </option>
                            <?php
                            $getkelas = mysqli_query($koneksi,"SELECT * FROM tbl_kelas");
                            while ($returnkelas = mysqli_fetch_array($getkelas)) {
                            ?>
                            <option value="<?= $returnkelas['id_kelas'] ?>">
                            <?= $returnkelas['id_kelas'] ?>
                            </option>
                            <?php } ?>
                            </div>
                            </select>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>