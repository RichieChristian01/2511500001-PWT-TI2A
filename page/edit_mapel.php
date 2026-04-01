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
   $Kd = $_GET['Kd'];
   $edit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT 8 FROM tbl_mapel WHERE Kd_mapel='$Kd' "));

    if(isset($_POST['tambah'])){
        $Kd_mapel = $_POST['Kd_mapel'];
        $Nm_mapel = $_POST['Nm_mapel'];
        $Kkm = $_POST['Kkm'];

        $insert = mysqli_query($koneksi,"INSERT INTO tbl_mapel values ('$Kd_mapel','$Nm_mapel','$Kkm')");
        if ($insert) {
            echo '<div class="alert alert-info-dismissble">
            <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Berhasil Disimpan</h4></div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=mapel">';
        }else{
            echo 'div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Berhasil Disimpan</h4></div>';
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
                                <label for="Kd_mapel">Kode Mapel</label>
                                <input type="text" name="Kd_mapel" value="<?= 
                                    $edit; ?>"  class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Nm_mapel">Nama Mapel</label>
                                <input type="text" name="Nm_mapel" value="<?= 
                                    $edit; ?>" id="Nm_mapel" placeholder="Nama Mapel" class="form-control">
                            </div>
                             <div class="form-group">
                                <label for="Kkm">KKM</label>
                                <input type="text" name="Kkm" value="<?= 
                                    $edit; ?>" id="Kkm" placeholder="Kkm" class="form-control">
                            </div>
                            <div class="card-footer">
                                <input typr="submit" class="btn btn-primary" name="tambah" value="simpan">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    