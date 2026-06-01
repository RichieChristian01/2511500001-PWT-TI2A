<?php
if (isset($_GET['hapus'])) {
    $kd_jadwal = $_GET['hapus'];

    // Hapus detail jadwal dulu
    mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE kd_jadwal = '$kd_jadwal'");

    // Lalu hapus jadwal
    $hapus = mysqli_query($koneksi, "DELETE FROM jadwal WHERE kd_jadwal = '$kd_jadwal'");

    if ($hapus) {
      echo "<div class='alert alert-success alert-dismissible fade show' Role='alert'>
      <strong>Berhasil!</strong> Data jadwal telah dihapus.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      </div>";
    } else {
      echo "<div class='alert alert-danger alert-dismissible fade show' Role='alert'>
      <strong>Gagal!</strong> Tidak dapat menghapus data.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      </div>";
    }
  }
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm">
                    Tambah Jadwal
                </a>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Kode Jadwal</th>
                            <th>Guru</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Detail Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM jadwal JOIN tbl_guru ON jadwal.kd_guru = tbl_guru.kd_guru");
                        while ($row = mysqli_fetch_assoc($query)) {
                         echo "<tr>
                            <td>{$row['kd_jadwal']}</td>
                            <td>{$row['nm_guru']}</td>
                            <td>{$row['semester']}</td>
                            <td>{$row['tahun_ajaran']}</td>
                            <td>
                            <ul>";
                                $det = mysqli_query($koneksi, "SELECT detail_jadwal.*, tbl_mapel.nm_mapel FROM detail_jadwal 
                        JOIN tbl_mapel ON detail_jadwal.kd_mapel = tbl_mapel.kd_mapel
                        WHERE detail_jadwal.kd_jadwal = '{$row['kd_jadwal']}'");
                        while ($d = mysqli_fetch_assoc($det)) {
                         echo "<li>{$d['nm_mapel']} - {$d['hari']} - {$d['jam']} - {$d['kelas']}</li>";
                        }
                        echo 
                        "</ul>
                        </td>
                        <td>
                        <a href='index.php?page=jadwal_kelas&hapus={$row['kd_jadwal']}'
                        onclick=\"return confirm('Yakin ingin menghapus data ini?')\"
                        class='btn btn-danger btn-sm'>Hapus</a>
                        </td>
                        </tr>";
                    }
                    ?>


                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>