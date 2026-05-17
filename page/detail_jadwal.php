<?php
$kd = isset($_GET['kd']) ? $_GET['kd'] : 0;

if (isset($_GET['action']) && $_GET['action'] === 'hapus') {
    $id_jadwal = $_GET['id_jadwal'];
    $kd_mapel  = $_GET['kd_mapel'];
    $kd_guru   = $_GET['kd_guru'];

    $stmt = mysqli_prepare($koneksi, "DELETE FROM detail_jadwal WHERE id_jadwal = ? AND kd_mapel = ? AND kd_guru = ?");
    mysqli_stmt_bind_param($stmt, 'iss', $id_jadwal, $kd_mapel, $kd_guru);
    $exec = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($exec) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                Data berhasil dihapus.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=detail_jadwal&kd='.$id_jadwal.'">';
    } else {
        echo '<div class="alert alert-danger">Gagal menghapus data.</div>';
    }
}
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Detail Jadwal Pelajaran</h1>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <a href="index.php?page=tambah_detail_jadwal&kd=<?= $kd; ?>" class="btn btn-primary btn-sm mb-3">
          Tambah Detail Jadwal
        </a>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>NO</th>
              <th>Kd Mapel</th>
              <th>Nama Mapel</th>
              <th>Nama Guru</th>
              <th>Hari</th>
              <th>Jam</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $query = mysqli_query($koneksi, "
              SELECT detail_jadwal.id_jadwal, detail_jadwal.kd_mapel, detail_jadwal.kd_guru,
                     detail_jadwal.hari, detail_jadwal.jam_mulai, detail_jadwal.jam_selesai,
                     tbl_mapel.nm_mapel, tbl_guru.nm_guru
              FROM detail_jadwal
              JOIN tbl_mapel ON tbl_mapel.kd_mapel = detail_jadwal.kd_mapel
              JOIN tbl_guru ON tbl_guru.kd_guru = detail_jadwal.kd_guru
              WHERE detail_jadwal.id_jadwal = '$kd'
              ORDER BY FIELD(detail_jadwal.hari,'senin','selasa','rabu','kamis','jumat','sabtu'),
                       detail_jadwal.jam_mulai
            ");
            while ($result = mysqli_fetch_array($query)) {
              $no++;
              $jamMulai   = substr($result['jam_mulai'], 0, 5);
              $jamSelesai = substr($result['jam_selesai'], 0, 5);
              $hari       = ucfirst(strtolower($result['hari']));
            ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['kd_mapel']; ?></td>
              <td><?= $result['nm_mapel']; ?></td>
              <td><?= $result['nm_guru']; ?></td>
              <td><?= $hari; ?></td>
              <td><?= $jamMulai; ?> s.d <?= $jamSelesai; ?></td>
              <td>
                <a href="index.php?page=edit_detail_jadwal&id_jadwal=<?= $result['id_jadwal']; ?>&kd_mapel=<?= $result['kd_mapel']; ?>&kd_guru=<?= $result['kd_guru']; ?>" class="badge badge-warning">Edit</a>
                <a href="index.php?page=detail_jadwal&action=hapus&id_jadwal=<?= $result['id_jadwal']; ?>&kd_mapel=<?= $result['kd_mapel']; ?>&kd_guru=<?= $result['kd_guru']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="badge badge-danger">Hapus</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?page=jadwal_kelas'">Kembali</button>
      </div>
    </div>
  </div>
</div>