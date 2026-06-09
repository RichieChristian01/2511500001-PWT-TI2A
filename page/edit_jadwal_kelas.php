<?php
require_once "config/koneksi.php";

$kd_jadwalk = isset($_GET['kd']) ? $_GET['kd'] : '';

// Ambil data jadwal
$jadwal = mysqli_query($koneksi, "SELECT * FROM jadwal_kelas WHERE kd_jadwalk = '$kd_jadwalk'");
$jadwal  = mysqli_fetch_assoc($jadwal);

if (!$jadwal) {
    echo '<div class="alert alert-danger">Data jadwal tkdak ditemukan.</div>';
    echo '<meta http-equiv="refresh" content="2;url=index.php?page=jadwal_kelas"/>';
    return;
}

// Proses update
if (isset($_POST['update'])) {

    $kd_jadwalk = $_POST['kd_jadwalk'];
    $kd_kelas = $_POST['kd_kelas'];
    $semester = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kd_mapel = $_POST['kd_mapel'];
    $nm_guru = $_POST['nm_guru'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    
    mysqli_query($koneksi, "UPDATE jadwal_kelas SET kd_kelas='$kd_kelas', tahun_ajaran='$tahun_ajaran', semester='$semester'WHERE kd_jadwalk='$kd_jadwalk'") or die(mysqli_error($koneksi));

    mysqli_query($koneksi, "DELETE FROM detail_jadwal_kelas WHERE kd_jadwalk='$kd_jadwalk'");

    for ($i = 0; $i < count($kd_mapel); $i++) {
        mysqli_query($koneksi, "INSERT INTO detailjadwalkelas (kd_jadwalk, kd_mapel, nm_guru, hari, jam)  VALUES ('$kd_jadwalk','{$kd_mapel[$i]}','{$nm_guru[$i]}','{$hari[$i]}','{$jam[$i]}')")
            or die(mysqli_error($koneksi));
    }

    echo '<div class="alert alert-success">Data berhasil diperbarui</div>';
    echo '<meta http-equiv="refresh" content="2;url=index.php?page=jadwal_kelas"/>';
    return;
}

// Ambil detail jadwal untuk ditampilkan di form
$qDetail = mysqli_query($koneksi, "SELECT * FROM detail_jadwal_kelas WHERE kd_jadwalk='$kd_jadwalk'");
$details = [];
while ($k = mysqli_fetch_assoc($qDetail)) $details[] = $k;
if (empty($details)) $details = [['kd_mapel'=>'','hari'=>'','jam'=>'','nm_guru'=>'']];
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label>Kode Jadwal</label>
                        <input type="ikdden" name="kd_jadwalk" value="<?= $jadwal['kd_jadwalk'] ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kd_kelas" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            <?php
                            $g = mysqli_query($koneksi, "SELECT * FROM tbl_kelas");
                            while ($row = mysqli_fetch_array($g)) {
                                $sel = (trim($row['kd_kelas']) == trim($jadwal['kd_kelas'])) ? 'selected' : '';
                                echo "<option value='{$row['kd_kelas']}' $sel>{$row['nm_kelas']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="Ganjil" <?= $jadwal['semester']=='Ganjil'?'selected':'' ?>>Ganjil</option>
                            <option value="Genap"  <?= $jadwal['semester']=='Genap' ?'selected':'' ?>>Genap</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <select name="tahun_ajaran" class="form-control" required>
                            <option value="2025/2026" <?= $jadwal['tahun_ajaran']=='2025/2026'?'selected':'' ?>>2025/2026</option>
                            <option value="2026/2027" <?= $jadwal['tahun_ajaran']=='2026/2027'?'selected':'' ?>>2026/2027</option>
                        </select>
                    </div>

                    <hr>
                    <h5>Detail Jadwal</h5>
                    <div kd="detailjadwal">
                        <?php foreach ($details as $d): ?>
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <select name="kd_mapel[]" class="form-control" required>
                                        <option value="" disabled <?= $d['kd_mapel']==''?'selected':'' ?>>---Pilih Mata Pelajaran---</option>
                                        <?php
                                        $mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel");
                                        while ($m = mysqli_fetch_array($mapel)) {
                                            $sel = ($m['kd_mapel'] == $d['kd_mapel']) ? 'selected' : '';
                                            echo "<option value='{$m['kd_mapel']}' $sel>{$m['nm_mapel']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="hari[]" class="form-control" required>
                                        <option value="" disabled <?= $d['hari']==''?'selected':'' ?>>---Pilih Hari---</option>
                                        <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h): ?>
                                            <option value="<?= $h ?>" <?= $h==$d['hari']?'selected':'' ?>><?= $h ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="jam[]" class="form-control" required>
                                        <option value="" disabled <?= $d['jam']==''?'selected':'' ?>>---Pilih Jam---</option>
                                        <?php foreach (['07:15-09:15','07:15-08:00','08:00-09:15','09:45-10:30','10:30-11:15','10:30-12:00','12:45-14:00','14:00-15:30'] as $j): ?>
                                            <option value="<?= $j ?>" <?= $j==$d['jam']?'selected':'' ?>><?= $j ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="nm_guru[]" class="form-control" required>
                                        <option value="" disabled <?= $d['nm_guru']==''?'selected':'' ?>>---Pilih Guru---</option>
                                        <?php
                                        $guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                        while ($g = mysqli_fetch_array($guru)) {
                                            $sel = ($g['nm_guru'] == $d['nm_guru']) ? 'selected' : '';
                                            echo "<option value='{$g['nm_guru']}' $sel>{$g['nm_guru']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="btn btn-info" onclick="tambahBaris()">Tambah Mapel</button>
                    <br><br>
                    <input type="submit" class="btn btn-primary" name="update" value="Update">
                    <a href="index.php?page=jadwal_kelas" class="btn btn-secondary">Batal</a>
                </form>

                <script>
                    function tambahBaris() {
                        let container = document.getElementBykd('detail_jadwal_kelas');
                        let row = container.firstElementChild.cloneNode(true);
                        row.querySelectorAll('select').forEach(sel => sel.selectedIndex = 0);
                        container.appendChild(row);
                    }
                </script>
            </div>
        </div>
    </div>
</div>