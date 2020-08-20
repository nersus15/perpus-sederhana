<?php  
	// Koneksi Database
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "dbperpus";
	$conn = mysqli_connect($host,$user,$pass,$db);

	function getDataBuku($jenis = 'semua', $jumlah = false){
		global $conn;
		if($jenis != 'semua')
			$query = "SELECT * FROM tblbuku WHERE jenis = '$jenis'";
		else	
			$query = "SELECT * FROM tblbuku";

		if($jumlah)
			$buku = count(mysqli_fetch_all(mysqli_query($conn, $query)));
		else{
			$result = mysqli_query($conn, $query);
			if(!$result)
				return 0;
			while($data = mysqli_fetch_assoc($result)){
				$buku[] = $data;
			}
		}

		return $jumlah && empty($buku) ? 0 : $buku;
	}
	function buatDropdownBulan($table = 'tblpinjam', $bulanSekarang = null){
		global $conn;

		$grouping = $table == 'tblpinjam' ? 'tanggal' : '';
		$result = mysqli_query($conn, "SELECT * FROM $table GROUP BY MONTH($grouping)");
		$dropdown = '<select id="bulan" class="form-control"><option value="semua">Semua</option>';
		if(!$result)
			echo '<script> alert("Ada kesalahan") </script>';

		while($data = mysqli_fetch_assoc($result)){
			if(!empty($bulanSekarang) && $bulanSekarang == substr($data[$grouping], 0, 7)){
				$dropdown .= "<option selected>" . substr($data[$grouping], 0, 7) . " </option>";
			}else{
				$dropdown .= "<option>" . substr($data[$grouping], 0, 7) . " </option>";
			}
		}
		$dropdown .= '</select>';
		return $dropdown;
	}
	function hapushistori($data) {
		global $conn;
		$kode = $data['kode'];
		$query = "DELETE  FROM tblpinjam WHERE kode = '$kode'";
		$result = mysqli_query($conn, $query);

		return $result;
	}
	
	function query($query) {
		global $conn;
		$result = mysqli_query($conn, $query);
		$rows = [];
		if(!$result)
			return;
		while ( $row = mysqli_fetch_assoc($result) ) {
				$rows[]  = $row;
		}
		return $rows;	
	}

	function tambahbuku($databuku) {
		global $conn;
		$kode = htmlspecialchars($databuku["kode"]);
		$judul = htmlspecialchars($databuku["judul"]);
		$penerbit = htmlspecialchars($databuku["penerbit"]);
		$jumlah = htmlspecialchars($databuku["jumlah"]);
		$jenis = htmlspecialchars($databuku["jenis"]);

		$query = "INSERT INTO tblbuku VALUES ('$kode','$judul','$penerbit','$jumlah','$jenis')";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function hapusbuku($kode) {
		global $conn;
		$query = "DELETE FROM tblbuku WHERE kode = '$kode";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function ubahbuku($databuku) {
		global $conn;
		$kode = htmlspecialchars($databuku["kode"]);
		$judul = htmlspecialchars($databuku["judul"]);
		$penerbit = htmlspecialchars($databuku["penerbit"]);
		$jumlah = htmlspecialchars($databuku["jumlah"]);
		$jenis = htmlspecialchars($databuku["jenis"]);

		$query = "UPDATE tblbuku SET 
					judul = '$judul',
					penerbit = '$penerbit', 
					jumlah = $jumlah, 
					jenis = '$jenis'
				   WHERE kode = '$kode'";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function pencarian($keyword) {
		$query = "SELECT * FROM tblbuku WHERE 
					judul LIKE '%$keyword%'
				 ";
		return query($query);
	}

	function registrasi($datauser) {
		global $conn;

		$nama = $datauser["nama"];
		$username = strtolower(stripslashes($datauser["username"]));
		$password = mysqli_real_escape_string($conn, $datauser["password"]);
		$email = $datauser["email"];
		$jenis_kelamin = $datauser["jenis_kelamin"];
		if ($jenis_kelamin == 'laki-laki') {
			$pict = 'default.png';
		} elseif ($jenis_kelamin == 'perempuan') {
			$pict = 'defaultwoman.png';
		}

		// encrypt password
		$passencrypted = password_hash($password, PASSWORD_DEFAULT);

		// Cek username
		$cekuser = mysqli_query($conn, "SELECT username FROM tbluser WHERE username = '$username'");
		if ( mysqli_fetch_assoc($cekuser) ) {
			echo "
				<script>
					alert('Username sudah ada!')
				</script>
			";
			return false;
		}
		
		mysqli_query($conn, "INSERT INTO tbluser VALUES('','$nama','$username','$passencrypted','$email','User','$pict','$jenis_kelamin', 'Pending')");
		return mysqli_affected_rows($conn); 
	}

	function uploadfoto($data) {
		global $conn;

		// Ambil ID
		$id = $data['id'];

		
		// Ambil Gambar
		$namafile = $_FILES['pict']['name'];
		$ukuranfile = $_FILES['pict']['size'];
		$error = $_FILES['pict']['error'];
		$tmp = $_FILES['pict']['tmp_name'];



		
		// Cek apakah di upload
		if ( $error === 4 ) {
			echo "
		        <script>
		          alert('Pilih Gambar!');
		          window.location = 'changephoto.php';
		        </script>
		      ";
		    return false;
		}
		
		// Cek apakah di upload itu adalah gambar.
		$ekstensivalid = ['jpg', 'jpeg', 'png'];
		$ekstensifile = explode('.', $namafile);
		$ekstensifile = strtolower(end($ekstensifile));
		if ( !in_array($ekstensifile, $ekstensivalid) ) {
			echo "
		        <script>
		          alert('Gambar hanya boleh ber-ekstensi .jpg, .jpeg, .png');
		          window.location = 'changephoto.php';
		        </script>
		      ";
		    return false;
		}
		
		// Cek ukuran gambar harus <2jt byte
		if ( $ukuranfile > 2000000 ) {
			echo "
		        <script>
		          alert('Ukuran gambar terlalu besar!');
		          window.location = 'changephoto.php';
		        </script>
		      ";
		    return false;
		}
		
		// Generate nama file random
		$fixfile = uniqid();
		$fixfile .= '.';
		$fixfile .= $ekstensifile;

		// Upload Gambar
		move_uploaded_file($tmp, 'img/avatar/'.$fixfile);


		// Eksekusi Gambar
		$pict = $fixfile;

		if ( !$pict ) {
		     return false;
		} else {
			$query = "UPDATE tbluser SET pict = '$pict' WHERE id = $id";
			mysqli_query($conn, $query);
		}

		return mysqli_affected_rows($conn);		

	}

	function edituser($datauser) {
		global $conn;
		$id = $datauser["id"];
		$nama = htmlspecialchars($datauser["nama"]);
		$email = htmlspecialchars($datauser["email"]);

		$query = "UPDATE tbluser SET  nama = '$nama', email = '$email' WHERE id = $id";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function editpassworduser($datauser) {
		global $conn;
		$id = $datauser["id"];
		$password = htmlspecialchars($datauser["passbaru"]);

		// Encrypt Password
		$passencrypted = password_hash($password, PASSWORD_DEFAULT);

		$query = "UPDATE tbluser SET password = '$passencrypted' WHERE id = $id";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function pinjambuku($databuku) {
		global $conn;

		$kode = $databuku['kode'];
		$databuku= 1;
		$kode= $_GET['kode'];
		$nama = $_SESSION["datauser"];
		$kodePinjam = substr(uniqid(), 0, 5);
		$tanggal = date('Y-m-d');

		// var_dump($tanggal);die;
		$exe = mysqli_query($conn, "INSERT INTO tblpinjam VALUES('$kodePinjam','$kode', '$nama', '$tanggal','Dibaca')");
		return $exe;
	}

	function kembalikanbuku($databuku) {
		global $conn;

		$kodeKembali = substr(uniqid(), 0, 5);
		$kode = $databuku['kode'];
		$tanggalkembalikan = $databuku['tanggalkembalikan'];
		$exe = mysqli_query($conn, "INSERT INTO tblrequestkembali VALUES ('$kodeKembali','$kode', '$tanggalkembalikan')");
		$exe2 = mysqli_query($conn, "UPDATE tblpinjam SET status = 'Pending' WHERE kode = '$kode'");
		return $exe && $exe2;
	}

	function konfirmasikembalibuku($data) {
		global $conn;
		$kode = $data['kode'];


		$exe = mysqli_query($conn, "DELETE FROM tblrequestkembali WHERE kode = '$kode'");
		$exe2 = mysqli_query($conn, "UPDATE tblpinjam SET status = 'Diterima' WHERE kode = '$kode'");
		
		return mysqli_affected_rows($conn);
	}
	

	function pencarianuser($keyword) {
		$query = "SELECT * FROM tblrequestkembali WHERE 
					nama LIKE '%$keyword%'
				 ";
		return query($query);
	}

	function cariuser($keyword) {
		$query = "SELECT * FROM tbluser WHERE 
					nama LIKE '%$keyword%'
					AND status = 'Active'
					AND lvl = 'User'
				 ";
		return query($query);
	}

	function cariuserpending($keyword) {
		$query = "SELECT * FROM tbluser WHERE 
					nama LIKE '%$keyword%'
					AND status = 'Pending'
					AND lvl = 'User'
				 ";
		return query($query);
	}

	function hapususer($data) {
		global $conn;

		$id = $data['id'];
		$query = "DELETE FROM tbluser WHERE id = $id";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function blockuser($data) {
		global $conn;

		$id = $data['id'];

		$query = "UPDATE tbluser SET status = 'Pending' WHERE id = '$id'";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function aktifkanuser($data) {
		global $conn;

		$id = $data['id'];

		$query = "UPDATE tbluser SET status = 'Active' WHERE id = '$id'";
		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function kirimpesan($datapesan) {
		global $conn;

		$judul = $datapesan['judul'];
		$penerima = $datapesan['penerima'];
		$isi = $datapesan['pesan'];
		$pengirim = $datapesan['nama'];
		$username = $datapesan['username'];
		// var_dump($judul);
		// var_dump($penerima);
		// var_dump($isi);
		// var_dump($pengirim);
		// var_dump($username);
		// die;
		// Cek Username
		$cekuser = mysqli_query($conn, "SELECT username FROM tbluser WHERE username = 'as'");
		var_dump($cekuser);die;
		if (!$cekuser) {
			echo "
				<script>
					alert('Username tidak ada!')
				</script>
			";
			return false;
		} else {
			$query = "INSERT INTO tblpesan VALUES ('','$judul','$isi','$pengirim','$username','$penerima')";
			$success = mysqli_query($conn, $query);

			return $success;
		}
	}

	function hapuspesan($datapesan) {
		global $conn;
		$id = $datapesan['id'];
		$query = "DELETE FROM tblpesan WHERE id = $id";

		mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function daftaradmin($datauser) {
		global $conn;

		$nama = $datauser["nama"];
		$username = strtolower(stripslashes($datauser["username"]));
		$password = mysqli_real_escape_string($conn, $datauser["password"]);
		$email = $datauser["email"];
		$jenis_kelamin = $datauser["jenis_kelamin"];
		if ($jenis_kelamin == 'laki-laki') {
			$pict = 'default.png';
		} elseif ($jenis_kelamin == 'perempuan') {
			$pict = 'defaultwoman.png';
		}

		// encrypt password
		$passencrypted = password_hash($password, PASSWORD_DEFAULT);

		// Cek username
		$cekuser = mysqli_query($conn, "SELECT username FROM tbluser WHERE username = '$username'");
		if ( mysqli_fetch_assoc($cekuser) ) {
			echo "
				<script>
					alert('Username sudah ada!')
				</script>
			";
			return false;
		}
		
		mysqli_query($conn, "INSERT INTO tbluser VALUES('','$nama','$username','$passencrypted','$email','Admin','$pict','$jenis_kelamin', 'Active')");
		return mysqli_affected_rows($conn); 
	}
?>