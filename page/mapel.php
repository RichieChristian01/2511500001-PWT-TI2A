<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Mapel</h1>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $Kd =$_GET['Kd'];
        $query = mysqli_query($koneksi, "DELETE FROM tbl_mapel where Kd_mapel = '$Kd' ");
        if ($query) {
        echo '
        <div class="alert alert-warning alert-dismissible">
        Berhasil Di Hapus</div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=mapel">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="index.php?page=tambah_mapel" class="btn btn-primary btn-sm">Tambah Mapel</a>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Kode Mapel</th>
                            <th>Nama Mapel</th>
                            <th>KKM</th>
                            <th>Aksi</th>
                        </tr>
                    <thead>
                        <?php
                        $no = 0;
                        $query= mysqli_query($koneksi,"SELECT * FROM tbl_mapel");
                        while ($result = mysqli_fetch_array($query) ) {
                            $no++;
                        ?>
                        <tbody>
                            <tr>
                                <td><?=$no; ?></td>
                                <td><?=$result ['Kd_mapel']; ?></td>
                                <td><?=$result ['Nm_mapel']; ?></td>
                                <td><?=$result ['Kkm']; ?></td>
                                <td><a href="index.php?page=mapel&action=hapus&Kd=<?= $result['Kd_mapel'] ?>" title="">
                                    <span class="badge badge-danger">Hapus</span></a>
                                    <a href="index.php?page=edit_mapel&Kd=<?= $result['Kd_mapel'] ?>" title="">
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