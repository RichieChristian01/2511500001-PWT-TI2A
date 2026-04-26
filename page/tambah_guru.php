<div class="content-header">
    <div class="container-flukd">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Guru</h1>
            </div>
        </div>
    </div>
</div>
<?php
    $carikode = mysqli_query($koneksi,"select max(kd_guru) from tbl_guru") or die (
        mysqli_error());
    $datakode = mysqli_fetch_array($carikode);
    if($datakode) {
        $nilaikode = substr($datakode[0], 2);
        $kode = (int) $nilaikode;
        $kode = $kode + 1;
        $hasilkode ="" .str_pad($kode, 3, "0", STR_PAD_LEFT);
    } else {$hasilkode =""; }
    $_SESSION["KODE"] = $hasilkode;

    if(isset($_POST['tambah'])){
        $kd_guru = $_POST['kd_guru'];
        $nm_guru = $_POST['nm_guru'];
        $jenkel = $_POST['jenkel'];
        $pend_terakhir = $_POST['pend_terakhir'];
        $hp = $_POST['hp'];
        $alamat = $_POST['alamat'];

        $insert = mysqli_query($koneksi,"INSERT INTO tbl_guru values ('$kd_guru','$nm_guru','$jenkel','$pend_terakhir','$hp','$alamat')");
    $inserttbl_users = mysqli_query($koneksi,"INSERT INTO tbl_users (Username, Password, Role) values ('$kd_guru','1234', 'guru')");   
        if ($insert) {
            echo '<div class="alert alert-info alert-dismissible">
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
                                <label for="kd_guru">kode guru</label>
                                <input type="text" name="kd_guru" value="<?= 
                                    $hasilkode; ?>" placeholder="kd Kat" class="
                                form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nm_guru">Nama guru</label>
                                <input type="text" name="nm_guru" kd="nm_guru"
                                placeholder="Nama guru" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="jenkel">Jenis Kelamin</label>
                                <select name="jenkel" id="jenkel" class="form-control">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pend_terakhir">Pendidikan Terakhir</label>
                                <select name="pend_terakhir" id="pend_terakhir" class="form-control">
                                    <option value="">-- Pilih Pendidikan Terakhir --</option>
                                    <option value="Stara 1">Stara 1</option>
                                    <option value="Stara 2">Stara 2</option>
                                    <option value="Stara 3">Stara 3</option>
                                    <option value="Diploma 3">Diploma 3</option>
                                    <option value="Diploma 4">Diploma 4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hp">No Handphone</label>
                                <input type="text" name="hp" kd="hp"
                                placeholder="hp" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" kd="alamat"
                                placeholder="alamat" class="form-control">
                            </div>
                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    