<?php

include 'ceklogin.php';
include 'function.php';

$tanggalsekarang = Date("Y-m-d");

if (isset($_GET["kembalikan"])) {

  if (kembalikanbuku($_GET) > 0) {
    echo "
        <script>
          alert('Tunggu pengelola perpus konfirmasi!');
          window.location = 'listpeminjaman.php';
        </script>
      ";
  } else {
    echo "
        <script>
          alert('Gagal!');
        </script>
      ";
  }
}

if (isset($_GET["id"])) {

  if (hapushistori($_GET)) {
    echo "
        <script>
          alert('Histori Peminjaman sudah dihapus');
          window.location = 'historipeminjaman.php';
        </script>
      ";
  } else {
    echo "
        <script>
          alert('Gagal!');
        </script>
      ";
  }
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
  <div class="page">
    <?php include 'header.php'; ?>
    <!-- Breadcrumbs -->
    <div class="breadcrumb-holder">
      <div class="container-fluid">
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Histori Peminjaman</li>
        </ul>
      </div>
    </div>
    <section class="dashboard-counts section-padding">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center">

                <h4>Histori Peminjaman Buku</h4>
              </div>
              <?php if ($datauser["lvl"] === 'Admin') : ?>
                <div class="card-header d-flex align-items-center">
                  <a href="laporan/cetak.php">Cetak Histori Peminjaman Buku</a>
                </div>
              <?php endif; ?>
              <div class="card-body">
                <?php echo isset($_GET['tgl']) ? buatDropdownBulan('tblpinjam', $_GET['tgl']) : buatDropdownBulan() ?>
                <div class="table-responsive">
                  <table class="table table-stripped tabble-sm">
                    <thead>
                      <tr>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <?php if ($datauser["lvl"] === 'Admin') : ?>
                          <th>Aksi</th>
                        <?php endif; ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $namausernow = $datauser['nama'];
                      if (isset($_GET['tgl'])) {
                        $tgl = substr($_GET['tgl'], 0, 7);
                        if ($_SESSION['lvl'] == 'User') {
                          $kueri = query("SELECT tblpinjam.*, tblbuku.judul FROM tblpinjam JOIN tblbuku ON tblbuku.kode = tblpinjam.buku WHERE tblpinjam.tanggal LIKE '$tgl%' AND nama = '$namausernow' AND status = 'Diterima'");
                        } else {
                          $kueri = query("SELECT tblpinjam.*, tblbuku.judul FROM tblpinjam JOIN tblbuku ON tblbuku.kode = tblpinjam.buku WHERE tblpinjam.tanggal LIKE '$tgl%' AND status = 'Diterima'");
                        }
                      } else {
                        if ($_SESSION['lvl'] == 'User') {
                          $kueri = query("SELECT tblpinjam.*, tblbuku.judul FROM tblpinjam JOIN tblbuku ON tblbuku.kode = tblpinjam.buku WHERE nama = '$namausernow' AND status = 'Diterima'");
                        } else {
                          $kueri = query("SELECT tblpinjam.*, tblbuku.judul FROM tblpinjam JOIN tblbuku ON tblbuku.kode = tblpinjam.buku WHERE status = 'Diterima'");
                        }
                      }

                      ?>
                      <?php foreach ($kueri as $data) : ?>
                        <?php
                        $kode = $data["kode"];
                        $judul = $data["judul"];
                        $tanggal = $data["tanggal"];
                        $status = $data["status"];
                        ?>
                        <tr>
                          <td><?= $kode; ?></td>
                          <td><?= $judul; ?></td>
                          <td><?= $tanggal; ?></td>
                          <td><?= $status; ?></td>
                          <?php if ($datauser["lvl"] === 'Admin') : ?>
                            <td>
                              <a href="?hapus=&kode=<?= $kode; ?>" onclick="return confirm('Apakah data ini akan dihapus ?');">Hapus</a>
                            </td>
                          <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

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
  <script src="vendor/jquery/jquery.min.js"></script>
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
  <script>
    $('#bulan').change(function(){
      var value = $(this).val();
      if(value != 'semua')
        location.href = location.pathname + '?tgl=' + value
      else
        location.href = location.origin + '/perpusweb/historipeminjaman';  
    });
    
  </script>
</body>

</html>