<?php

include "config/koneksi.php";

if($_SESSION['Role']=="admin"){

$query = mysqli_query($koneksi,"SELECT 
jadwal.*,
tbl_guru.nm_guru

FROM jadwal

JOIN tbl_guru
ON jadwal.kd_guru = tbl_guru.kd_guru

ORDER BY kd_jadwal ASC
");

}elseif($_SESSION['Role']=="guru"){

$query = mysqli_query($koneksi,"SELECT DISTINCT
jadwal.*,
tbl_guru.nm_guru

FROM jadwal

JOIN tbl_guru
ON jadwal.kd_guru = tbl_guru.kd_guru

ORDER BY kd_jadwal ASC
");

}else{

$query = mysqli_query($koneksi,"SELECT 
jadwal.*,
tbl_guru.nm_guru

FROM jadwal

JOIN tbl_guru
ON jadwal.kd_guru = tbl_guru.kd_guru

ORDER BY kd_jadwal ASC
");

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Cetak Jadwal</title>

<style>

body{
font-family:Arial,sans-serif;
margin:30px;
}

.tanggal{
text-align:right;
margin-bottom:10px;
font-size:14px;
}

.kop{
display:flex;
align-items:center;
margin-bottom:10px;
}

.logo{
width:100px;
height:90px;
position:relative;
right:-10px;
margin-right:15px;
}

.judul{
flex:1;
text-align:center;
}

.judul h2,
.judul h3,
.judul p{
margin:3px;
}

hr{
border:2px solid black;
margin-bottom:20px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:15px;
}

table th,
table td{
border:1px solid black;
padding:8px;
font-size:13px;
vertical-align:top;
}

th{
background:#eeeeee;
}

.print{
margin-bottom:20px;
}

.ttd{
width:250px;
float:right;
text-align:center;
margin-top:50px;
}

@media print{

.print{
display:none;
}

body{
margin:10px;
}

}

</style>

</head>

<body>

<div class="print">

<button onclick="window.print()">
Cetak Jadwal
</button>

</div>


<div class="tanggal">

Tanggal Cetak :
<?php echo date("d-m-Y H:i"); ?>

</div>


<div class="kop">

<img src="../logoisbal.png" class="logo">

<div class="judul">

<h2>INSTITUT SAINS DAN BISNIS ATMA LUHUR</h2>

<h3>SISTEM INFORMASI JADWAL KAMPUS</h3>

<p>
Jl. Jendral Sudirman, Selindung Baru,
Kecamatan Gabek, Pangkalpinang
</p>

<p>
Kepulauan Bangka Belitung 33117
</p>

<p>
Telp: (0717) XXXXXXX | Email: info@atmaluhur.ac.id
</p>

</div>

</div>

<hr>


<table>

<tr>

<th>No</th>

<th>Kode Jadwal</th>

<?php if($_SESSION['Role']=="admin" || $_SESSION['Role']=="guru"){ ?>
<th>Guru</th>
<?php } ?>

<?php if($_SESSION['Role']=="mahasiswa"){ ?>
<th>Kelas</th>
<?php } ?>

<th>Semester</th>

<th>Tahun Ajaran</th>

<th>Detail Jadwal</th>

</tr>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($query)){

echo "<tr>";

echo "<td>".$no++."</td>";

echo "<td>".$row['kd_jadwal']."</td>";

if($_SESSION['Role']=="mahasiswa"){

$kelasData = mysqli_query($koneksi,"
SELECT DISTINCT kelas
FROM detail_jadwal
WHERE kd_jadwal='".$row['kd_jadwal']."'
");

echo "<td>";

while($kelas = mysqli_fetch_assoc($kelasData)){

echo $kelas['kelas']." ";

}

echo "</td>";

}else{

echo "<td>".$row['nm_guru']."</td>";

}

echo "<td>".$row['semester']."</td>";

echo "<td>".$row['tahun_ajaran']."</td>";

echo "<td>";

$detail = mysqli_query($koneksi,"SELECT

detail_jadwal.*,
tbl_mapel.nm_mapel,
tbl_guru.nm_guru

FROM detail_jadwal

JOIN tbl_mapel
ON detail_jadwal.kd_mapel = tbl_mapel.kd_mapel

JOIN jadwal
ON detail_jadwal.kd_jadwal = jadwal.kd_jadwal

JOIN tbl_guru
ON jadwal.kd_guru = tbl_guru.kd_guru

WHERE detail_jadwal.kd_jadwal='".$row['kd_jadwal']."'
");

while($d = mysqli_fetch_assoc($detail)){

echo $d['nm_mapel'];

echo " - ";

echo $d['hari'];

echo " - ";

echo $d['jam'];

echo " - ";

if($_SESSION['Role']=="siswa"){

echo $d['nm_guru'];

}else{

echo $d['kelas'];

}

echo "<br>";

}

echo "</td>";

echo "</tr>";

}

?>

</table>


<div class="ttd">

<p>

Pangkalpinang,

<?php echo date("d-m-Y"); ?>

</p>

<p>Dosen</p>

<br><br><br><br>

<p>

<b>

(__________________)

</b>

</p>

</div>


<script>

window.onload=function(){

window.print();

}

</script>

</body>

</html>