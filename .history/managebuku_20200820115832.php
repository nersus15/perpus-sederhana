<?php
include 'ceklogin.php';
include 'function.php';
$kueri = getDataBuku();

// Cek tombol Submit Tambah Data
if (isset($_POST["submit"])) {
  if (tambahbuku($_POST) > 0) {
    echo "
        <script>
          alert('Buku Berhasil Ditambah!');
          window.location = 'managebuku.php';
        </script>
      ";
  } else {
    echo "
        <script>
          alert('Buku Gagal Ditambahkan! Mungkin Saja kode buku sudah ada');
          window.location  = 'managebuku.php';
        </script>
      ";
  }
}

// Cek tombol Submit Pencarian
if (isset($_GET["cari"])) {
  $kueri = pencarian($_GET["keyword"]);
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php include 'head.php'; ?>
</head>

<body>
  <!-- Side Navbar -->
  <?php include 'navbar.php'; ?>

  <?php
  if ($datauser['lvl'] === 'User') {
    header('location: index.php');
  }
  ?>

  <div class="page">
    <?php include 'header.php'; ?>
    <!-- Breadcrumbs -->
    <div class="breadcrumb-holder">
      <div class="container-fluid">
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Admin</li>
          <li class="breadcrumb-item active">Manajemen Buku</li>
        </ul>
      </div>
    </div>
    <section class="dashboard-counts section-padding">
      <div class="container-fluid">
        <div class="row">
          <div class="form-group">
            <form class="input-group" method="get" action="">
              <input type="text" class="form-control" name="keyword" placeholder="Cari Buku Berdasarkan Judul" autocomplete="off">
              <button type="submit" class="btn btn-primary input-group-append" name="cari">Cari</button>
            </form>
          </div>
          <div class="table-responsive">
            <button type="button" id="tambah-buku" class="btn btn-primary">Tambah Buku</button>
            <a href="managebuku.php" class="btn btn-primary">Tampilkan Semua Buku</a>
            <table class="table table-stripped tabble-sm">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Judul</th>
                  <th>Penerbit</th>
                  <th>Jumlah</th>
                  <th>Jenis</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($kueri as $data) : ?>
                  <?php
                  $id = $data["id"];
                  $kode = $data["kode"];
                  $judul = $data["judul"];
                  $penerbit = $data["penerbit"];
                  $jumlah = $data["jumlah"];
                  $jenis = $data["jenis"];
                  ?>
                  <tr>
                    <td><?= $kode; ?></td>
                    <td><?= $judul; ?></td>
                    <td><?= $penerbit; ?></td>
                    <td><?= $jumlah; ?></td>
                    <td><?= $jenis; ?></td>
                    <td><a href="hapus.php?id=<?= $id; ?>" onclick="return confirm('Apakah data ini akan dihapus ?');">Hapus</a> | <a href="editbuku.php?id=<?= $id; ?>">Edit</a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <div class="generated-modals"></div>
    <div class="container-fluid">
      <div class="row">
        <!-- BOTTOM -->
      </div>
    </div>
    <footer class="main-footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <p>Back End by <a href="http://instagram.com/pengguna.tidur">elangtimore_</a> &copy; <span id="year-cred"></span></p>
          </div>
          <div class="col-sm-6 text-right">
            <p>Awesome Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <!-- JavaScript files-->
  <script src="vendor/popper.js/umd/popper.min.js"> </script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
  <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
  <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="js/charts-home.js"></script>
  <!-- Main File-->
  <script src="js/front.js"></script>
  <script src="js/pages/manage.buku.js"></script>
</body>

</html>