<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data siswa</h1>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $nis =$_GET['nis'];
        $query = mysqli_query($koneksi, "DELETE FROM tbl_siswa where nis = '$nis' ");
        if ($query) {
        echo '
        <div class="alert alert-warning alert-dismissible">
        Berhasil Di Hapus</div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=siswa">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="index.php?page=tambah_siswa" class="btn btn-primary btn-sm">Tambah siswa</a>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIS</th>
                            <th>NAMA SISWA</th>
                            <th>JENIS KELAMIN</th>
                            <th>HP</th>
                            <th>ID KELAS</th>
                            <th>NAMA KELAS</th>
                            <th>AKSI</th>
                        </tr>
                    <thead>
                        <?php
                            $no = 0;
                            $query = mysqli_query($koneksi,"SELECT tbl_siswa.*, tbl_kelas.nm_kelas 
                                    FROM tbl_siswa 
                                    JOIN tbl_kelas ON tbl_siswa.id_kelas = tbl_kelas.id_kelas");
                        while ($result = mysqli_fetch_array($query)) {
                            $no++;
                        ?>
                        <tbody>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $result['nis']; ?></td>
                                <td><?= $result['nm_siswa']; ?></td>
                                <td><?= $result['jenkel']; ?></td>
                                <td><?= $result['hp']; ?></td>
                                <td><?= $result['id_kelas']; ?></td>
                                <td><?= $result['nm_kelas']; ?></td>
                                <td><a href="index.php?page=siswa&action=hapus&nis=<?= $result['nis'] ?>" title="">
                                    <span class="badge badge-danger">Hapus</span></a>
                                    <a href="index.php?page=edit_siswa&nis=<?= $result['nis'] ?>" title="">
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