<?php

// Validasi Role: hanya admin yang boleh akses
if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$sql = "SELECT j.kd_jadwal, g.nm_guru, j.semester, j.tahun_ajaran
        FROM jadwal j
        JOIN tbl_guru g ON j.kd_guru = g.kd_guru
        ORDER BY j.kd_jadwal ASC";
$query = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Semua Jadwal</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .judul { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body onload="window.print()">
    <h2 class="judul">Data Jadwal Semua Kelas</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Jadwal</th>
                <th>Guru</th>
                <th>Semester</th>
                <th>Tahun Ajaran</th>
                <th>Detail Jadwal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>
                        <td>{$row['kd_jadwal']}</td>
                        <td>{$row['nm_guru']}</td>
                        <td>{$row['semester']}</td>
                        <td>{$row['tahun_ajaran']}</td>
                        <td><ul>";
                
                // Ambil detail jadwal untuk setiap kd_jadwal
                $det = mysqli_query($koneksi, "SELECT d.*, m.nm_mapel 
                                               FROM detail_jadwal d
                                               JOIN tbl_mapel m ON d.kd_mapel = m.kd_mapel
                                               WHERE d.kd_jadwal = '{$row['kd_jadwal']}'");
                while ($d = mysqli_fetch_assoc($det)) {
                    echo "<li>{$d['nm_mapel']} - {$d['hari']} - {$d['jam']} - {$d['kelas']}</li>";
                }

                echo "</ul></td></tr>";
            }
            ?>
        </tbody>
    </table>
        <br>
        <a href="index.php?page=jadwal_kelas" class="btn btn-secondary btn-sm">
            Kembali ke Jadwal Kelas
        </a>
</body>
</html>
