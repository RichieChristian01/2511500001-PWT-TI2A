<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>
<?php
   $id = $_GET['id'];
   $edit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ekstra_2511500001 WHERE id_ekstra001='$id' "));

    if(isset($_POST['tambah'])){
        $id_ekstra001 = $_POST['id_ekstra001'];
        $nama_ekstra001 = $_POST['nama_ekstra001'];
        $ket001 = $_POST['ket001'];
        $semester001 = $_POST['semester001'];
        $thn_ajaran001 = $_POST['thn_ajaran001'];


        $insert = mysqli_query($koneksi,"UPDATE ekstra_2511500001 SET nama_ekstra001='$nama_ekstra001', ket001='$ket001', semester001='$semester001', thn_ajaran001='$thn_ajaran001'  WHERE id_ekstra001='$id_ekstra001' ");
        if ($insert) {
            echo '<div class="alert alert-info alert-dismissble">
            <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Berhasil Disimpan</h4></div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra001">';
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
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                            <div class="form-group">
                                <label for="id_ekstra001">Id Ekstrakurikuler</label>
                                <input type="text" name="id_ekstra001" value="<?= 
                                    $edit['id_ekstra001']; ?>"  class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama_ekstra001">Nama Ekstrakurikuler</label>
                                <input type="text" name="nama_ekstra001" value="<?= 
                                    $edit['nama_ekstra001']; ?>" id="nama_ekstra001" placeholder="Nama Ekstrakurikuler" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="ket001">Keterangan</label>
                                <input type="text" name="ket001" value="<?= 
                                    $edit['ket001']; ?>" id="ket001" placeholder="Keterangan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="semester001">Semester</label>
                                <select name="semester001" id="semester001" class="form-control">
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="1" <?= ($edit['semester001']=="1")?"selected":""; ?>>Semester 1</option>
                                    <option value="2" <?= ($edit['semester001']=="2")?"selected":""; ?>>Semester 2</option>
                                    <option value="3l" <?= ($edit['semester001']=="3")?"selected":""; ?>>Semester 3</option>
                                    <option value="4" <?= ($edit['semester001']=="4")?"selected":""; ?>>Semester 4</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="thn_ajaran001">Tahun Ajaran</label>
                                <select name="thn_ajaran001" id="thn_ajaran001" class="form-control">
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <option value="2024/2025" <?= ($edit['thn_ajaran001']=="2024/2025")?"selected":""; ?>>2024/2025</option>
                                    <option value="2025/2026" <?= ($edit['thn_ajaran001']=="2025/2026")?"selected":""; ?>>2025/2026</option>
                                </select>
                            </div>

                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    