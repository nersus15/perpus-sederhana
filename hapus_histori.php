<?php
	include 'ceklogin.php';
	include 'function.php';
	
	if (isset($_GET['id'])) {

	$id= $_GET['id'];
	
	// perintah query untuk menghapus data pada tabel bidang
	$query = mysqli_query($conn, "DELETE FROM tblpinjam WHERE id_bidang='$id_bidang'");

	// cek hasil query
	if ($query) {
		// jika berhasil tampilkan pesan berhasil delete data
		header('location:historipeminjaman.php');
	} else {
		// jika gagal tampilkan pesan kesalahan
		header('location:historipeminjaman.php');
	}
	}
?>