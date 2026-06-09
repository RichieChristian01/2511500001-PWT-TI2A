<?php
require_once "config/koneksi.php";
?>
<div class="content header">
    <div class="content-flukd">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
$carikode = mysqli_query($koneksi, "SELECT MAX(kd_jadwalk) FROM jadwal_kelas") or die (mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);
if ($datakode && $datakode[0] !== null) {
    $nilaikode = substr($datakode[0], 3);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "JK-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "JK-001";
}
$_SESSION["KODE"] = $hasilkode;

if (isset($_POST['tambah'])) {
    $kd_jadwalk = $_POST['kd_jadwalk'];
    $kd_kelas = $_POST['kd_kelas'];
    $semester = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $Kd_mapel = $_POST['Kd_mapel'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $nm_guru = $_POST['nm_guru'];

    $insertjadwal = mysqli_query($koneksi, "INSERT INTO jadwal_kelas values ('$kd_jadwalk','$kd_kelas','$tahun_ajaran','$semester')");
   
    if (!$insertjadwal) {
        echo "Gagal insert tabel jadwalkelas: " . mysqli_error($koneksi);
        die;
    }

    $allSuccess = true;
    for ($i = 0; $i < count($Kd_mapel); $i++) {
        $insert = mysqli_query($koneksi, "INSERT INTO detail_jadwal_kelas (kd_jadwalk, Kd_mapel, nm_guru, hari, jam) VALUES ('$kd_jadwalk', '{$Kd_mapel[$i]}', '{$nm_guru[$i]}', '{$hari[$i]}', '{$jam[$i]}')");
        if (!$insert) {
            $allSuccess = false;
            echo "Gagal insert detail ke-{$i}: " . mysqli_error($koneksi);
            die;
        }
    }

    if($allSuccess) {
        echo '<div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" 
            aria-idden="true">&times;</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Data Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="2;url=index.php?page=jadwal_kelas"/>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Gagal menyimpan sebagian atau seluruh data detail.</h4>
        </div>';
         }
    
    }

?>
<div class="content">
    <div class="content-flukd">
        <div class="card">
            <div class="card-body">
                <h3>Tambah Jadwal</h3>
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Kode Jadwal</label>
                            <input type="text" name="kd_jadwalk" value="<?=  $hasilkode ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="kd_kelas" class="form-control">
                                <option value="">Pilih Kelas</option>
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM tbl_kelas");
                                while ($g = mysqli_fetch_array($query)) {
                                    echo "<option value=' {$g['kd_kelas']} '>{$g['nm_kelas']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" kd="semester" class="form-control" required>
                                <option selected disabled>---Pilih Semester---</option>
                                <option>Ganjil</option>
                                <option>Genap</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <select name="tahun_ajaran" kd="semester" class="form-control" required>
                                <option selected disabled>---Pilih Tahun Ajaran---</option>
                                <option>2025/2026</option>
                                <option>2026/2027</option>
                            </select>
                        </div>
                        <hr>
                        <h5>Detail Jadwal</h5>
                        <div class="detail_jadwal" kd="detail_jadwal">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <select name="Kd_mapel[]" class="form-control" required>
                                        <option selected disabled>---Pilih Mata Pelajaran---</option>
                                        <?php
                                        $mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel");
                                        while ($m = mysqli_fetch_array($mapel)) {
                                            echo "<option value='{$m['kd_mapel']}'>{$m['nm_mapel']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="hari[]" class="form-control" required>
                                        <option selected disabled>---Pilih Hari---</option>
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
                                        <option selected disabled>---Pilih Jam---</option>
                                        <option>07:15-09:15</option>
                                        <option>07:15-08:00</option>                                       
                                        <option>08:00-09:15</option>
                                        <option>08:00-09:15</option>
                                        <option>09:45-10:30</option>
                                        <option>10:30-11:15</option>
                                        <option>10:30-12:00</option>
                                        <option>12:45-14:00</option>
                                        <option>14:00-15:30</option>                                        
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="nm_guru[]" class="form-control" required>
                                        <option selected disabled>---Pilih Guru---</option>
                                        <?php
                                        $Guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                        while ($g = mysqli_fetch_array($Guru)) {
                                            echo "<option value='{$g['nm_guru']}'>{$g['nm_guru']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info" onclick="tambahBaris()">Tambah Mapel</button>
                        <br><br>
                        <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                        <script>
                            function tambahBaris() {
                                let container = document.getElementBykd('detailjadwal');
                                let row = container.firstElementChild.cloneNode(true);
                                row.querySelectorAll('input').forEach(input => input.value = '');
                                container.appendChild(row);
                            }
                        </script>
             </div>
        </div>
    </div>

</div>
</form>