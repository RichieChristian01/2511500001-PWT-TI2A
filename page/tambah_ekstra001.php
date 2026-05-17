<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>
<?php
    $carikode = mysqli_query($koneksi,"select max(id_ekstra001) from ekstra_2511500001") or die (mysqli_error());
    $datakode = mysqli_fetch_array($carikode);
    
    if($datakode) {
        $nilaikode = (int)($datakode[0]);
        $kode = (int) $nilaikode;
        $kode = $kode + 1;
        $hasilkode ="" .str_pad($kode, 3, "0", STR_PAD_LEFT);
    } else {$hasilkode =""; }
    $_SESSION["KODE"] = $hasilkode;

    if(isset($_POST['tambah'])){
        $id_ekstra001 = $_POST['id_ekstra001'];
        $nama_ekstra001 = $_POST['nama_ekstra001'];
        $ket001 = $_POST['ket001'];
        $semester001 = $_POST['semester001'];
        $thn_ajaran001 = $_POST['thn_ajaran001'];


        $insert = mysqli_query($koneksi,"INSERT INTO ekstra_2511500001 values ('$id_ekstra001','$nama_ekstra001','$ket001','$semester001','$thn_ajaran001')");
        if ($insert) {
            echo '<div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Berhasil Disimpan</h4></div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra001">';
        }else{
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
                                <label for="id_ekstra001">Id Ekstrakurikuler</label>
                                <input type="text" name="id_ekstra001" value="<?= $hasilkode; ?>" placeholder="id ekstra" class=" form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama_ekstra001">Nama Ekstrakurikuler</label>
                                <input type="text" name="nama_ekstra001" id="nama_ekstra001" placeholder="Nama Ekstrakurikuler" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="ket001">Keterangan</label>
                                <input type="text" name="ket001" id="ket001" placeholder="Keterangan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="semester001">Semester</label>
                                <select name="semester001" id="semester001" class="form-control">
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="thn_ajaran001">Tahun Ajaran</label>
                                <select name="thn_ajaran001" id="thn_ajaran001" class="form-control">
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2025/2026">2025/2026</option>
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
    