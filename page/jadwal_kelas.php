<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $id =$_GET['id'];
        $query = mysqli_query($koneksi, "DELETE FROM jadwal_kelas where id_kelas = '$id' ");
        if ($query) {
        echo '
        <div class="alert alert-warning alert-dismissible">
        Berhasil Di Hapus</div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal_kelas">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm">Tambah Jadwal</a>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID Jadwal</th>
                            <th>ID Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    <thead>
                        <?php
                        $no = 0;
                        $query= mysqli_query($koneksi,"SELECT jadwal_kelas.id_jadwal, jadwal_kelas.id_kelas, jadwal_kelas.thn_ajaran, jadwal_kelas.semester, tbl_kelas.nm_kelas 
                                            FROM jadwal_kelas 
                                            JOIN tbl_kelas ON jadwal_kelas.id_kelas = tbl_kelas.id_kelas");
                        while ($result = mysqli_fetch_array($query) ) {
                            $no++;
                        ?>
                        <tbody>
                            <tr>
                                <td><?=$no; ?></td>
                                <td><?=$result ['id_jadwal']; ?></td>
                                <td><?=$result ['id_kelas']; ?></td>
                                <td><?=$result ['thn_ajaran']; ?></td>
                                <td><?=$result ['semester']; ?></td>
                                <td><a href="index.php?page=jadwal_kelas&action=hapus&id=<?= $result['id_kelas'] ?>" title="">
                                    <span class="badge badge-danger">Hapus</span></a>
                                    <a href="index.php?page=detail_jadwal&id=<?= $result['id_kelas'] ?>" title="">
                                    <span class="badge badge-warning">Edit</span></a>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>