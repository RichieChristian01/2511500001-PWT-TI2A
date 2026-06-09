<?php
if (isset($_GET['hapus'])) {
    $kd_jadwal = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE kd_jadwal = '$kd_jadwal'");
    $hapus = mysqli_query($koneksi, "DELETE FROM jadwal WHERE kd_jadwal = '$kd_jadwal'");
?>
    <?php if ($hapus): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Data jadwal telah dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-idden="true">&times;</span>
            </button>
        </div>
    <?php else: ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> Tidak dapat menghapus data.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
<?php } ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Jadwal Guru</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm mb-2">Tambah Jadwal</a>
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
                        $query = mysqli_query($koneksi, "SELECT j.*, g.nm_guru FROM jadwal j  JOIN tbl_guru g ON TRIM(j.kd_guru) = TRIM(g.kd_guru) COLLATE utf8mb4_0900_ai_ci");
                        while ($row = mysqli_fetch_assoc($query)):
                        ?>
                            <tr>
                                <td><?= $row['kd_jadwal'] ?></td>
                                <td><?= $row['nm_guru'] ?></td>
                                <td><?= $row['semester'] ?></td>
                                <td><?= $row['tahun_ajaran'] ?></td>
                                <td>
                                    <ul>
                                        <?php
                                        $det = mysqli_query($koneksi, "SELECT d.*, m.nm_mapel FROM detail_jadwal d  JOIN tbl_mapel m ON d.kd_mapel = m.kd_mapel WHERE d.kd_jadwal = '{$row['kd_jadwal']}'");
                                        while ($d = mysqli_fetch_assoc($det)):
                                        ?>
                                            <li><?= $d['nm_mapel'] ?> - <?= $d['hari'] ?> - <?= $d['jam'] ?> - <?= $d['kelas'] ?></li>
                                        <?php endwhile; ?>
                                    </ul>
                                </td>
                                <td>
                                    <a href="index.php?page=jadwal&hapus=<?= $row['kd_jadwal'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>

                                    <a href="index.php?page=edit_jadwal&kd=<?= $row['kd_jadwal'] ?>"
                                       class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>