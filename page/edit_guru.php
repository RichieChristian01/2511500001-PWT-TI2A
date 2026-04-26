<div class="content-header">
    <div class="container-flukd">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Guru</h1>
            </div>
        </div>
    </div>
</div>
<?php
   $kd = $_GET['kd'];
   $edit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_guru WHERE kd_guru='$kd' "));

    if(isset($_POST['tambah'])){
        $kd_guru = $_POST['kd_guru'];
        $nm_guru = $_POST['nm_guru'];
        $jenkel = $_POST['jenkel'];
        $pend_terakhir = $_POST['pend_terakhir'];
        $hp = $_POST['hp'];
        $alamat = $_POST['alamat'];

        $insert = mysqli_query($koneksi,"UPDATE tbl_guru SET  nm_guru='$nm_guru', jenkel='$jenkel', pend_terakhir='$pend_terakhir',hp='$hp', alamat='$alamat' WHERE kd_guru='$kd' ");
        if ($insert) {
            echo '<div class="alert alert-info alert-dismissble">
            <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Berhasil Disimpan</h4></div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
        }else{
            echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Gagal Disimpan</h4></div>';
        }
    }
?>

<section class="content">
    <div class="container-flukd">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                            <div class="form-group">
                                <label for="kd_guru">kd guru</label>
                                <input type="text" name="kd_guru" value="<?= 
                                    $edit['kd_guru']; ?>"  class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="id_user">ID User</label>
                                <input type="text" name="id_user" value="<?= 
                                    $edit['id_user']; ?>" id="id_user" placeholder="ID User" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nm_guru">Nama guru</label>
                                <input type="text" name="nm_guru" value="<?= 
                                    $edit['nm_guru']; ?>" kd="nm_guru" placeholder="Nama guru" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="jenkel_guru">Jenis Kelamin</label>
                                <input type="text" name="jenkel" value="<?= 
                                    $edit['jenkel']; ?>" kd="jenkel" placeholder="Jenis Kelamin" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pend_terakhir">Pendidikan Akhir</label>
                                <input type="text" name="pend_terakhir" value="<?= 
                                    $edit['pend_terakhir']; ?>" kd="pend_terakhir" placeholder="Pendidikan Terakhir" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="hp">No Handphone</label>
                                <input type="text" name="hp" value="<?= 
                                    $edit['hp']; ?>" kd="hp" placeholder="No Handphone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" value="<?= 
                                    $edit['alamat']; ?>" kd="alamat" placeholder="Alamat" class="form-control">
                            </div>
                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    