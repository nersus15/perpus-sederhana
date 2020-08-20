<title>Laporan</title>
<?php
    include 'sampah/conf.php';
      
    session_start();
    //cek session
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }
?>
    <style type="text/css">
        body {
            font-size: 12px!important;
            color: #212121;
        }
        .header {
            text-align: center;
            margin: -.5rem 0;
        }
        .logo1 {
            float: left;
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 0 0 1.2rem;
        }
        .logo2 {
            float: right;
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 0 0 1.2rem;
        }
        .text {
            font-size: 15px!important;
            font-weight: bold;
            text-transform: uppercase;
        }
        #table tr th { 
            font-size: 11px;
        } 
        #table tr td { 
            font-size: 10px; 
        }
    </style>

  <div class="row col-md-10" align="center">
        <div class="header">
            <img src="img/logo/logo_kantor.png" class="logo1">
            <h1 class="text">DIREKTORAT JENDRAL PERHUBUNGAN LAUT<br>KANTOR UNIT PENYELENGGARA PELABUHAN KELAS III LABUHAN LOMBOK</h1>
            <h5>Jl. Dr. Soedjono Lingkar Selatan Mataram Nusa Tenggara Barat<br> Telp:(0370)6177481 Fax: (0370)6177413 <br>  Email : bnnpntb@gmail.com</h5>
            <td colspan="3" bordered="#000000">
                <div align="center" style="border: 2px solid #616161"></div>
            </td>
        </div>
        <br>

            <?php
                if (isset($_POST['cetak'])) {
                    $dari_tanggal = InggrisTgl($_POST['dari_tanggal']);
                    $sampai_tanggal= InggrisTgl($_POST['sampai_tanggal']);

                    //indonesia Tgl
                    $dari_tanggal_indo = IndonesiaTgl($dari_tanggal);
                    $sampai_tanggal_indo= IndonesiaTgl($sampai_tanggal);


                    if ($_REQUEST['dari_tanggal'] == "" || $_REQUEST['sampai_tanggal'] == "") {
                        echo '<script>
                                window.location.href="./index.php?page=lap_surat_masuk";
                             </script>';
                        die();
                    }else{
                        $query  = "SELECT * FROM tb_master, tb_kapal, tb_sertifikat, tb_pemilik, tb_jns_sertifikat, tb_jns_kapal WHERE tb_master.id_kapal= tb_kapal.id_kapal AND tb_master.id_sertifikat= tb_sertifikat.id_sertifikat AND tb_kapal.id_pemilik= tb_pemilik.id_pemilik AND tb_sertifikat.id_jns_sertifikat= tb_jns_sertifikat.id_jns_sertifikat AND tb_kapal.id_jns_kapal= tb_jns_kapal.id_jns_kapal ORDER BY id_master DESC";
                        $sql    = mysqli_query($koneksi, $query);
            ?>
            <div class="col-md-10">
                <h4><strong>LAPORAN DATA SURAT MASUK DARI TANGGAL <?php echo $dari_tanggal_indo ?> SAMPAI TANGGAL <?php echo $sampai_tanggal_indo; ?></strong></h4>
            </div>  
                <table id="table" border="1" cellspacing="0" cellpadding="5" width="100%">
                    <thead>
                        <tr>
									<th width="1">No</th>
									<th width="15%"><strong>NAMA KAPAL</strong></th>
									<th width="2%"><strong>GT</strong></th>
									<th width="15%"><strong>JENIS KAPAL</strong></th>
									<th width="5%"><strong>PEMILIK</strong></th>
									<th width="15%"><strong>JENIS SERTIFIKAT</strong></th>
									<th width="15%"><strong>NO. SERTIFIKAT</strong></th>
									<th width="6%"><strong>NO. BARCODE</strong></th>
									<th width="5%"><strong>TG TERBIT</strong></th>
									<th width="5%"><strong>MASA LAKU</strong></th>
									<th width="5%"><strong>NO. BILLING</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (mysqli_num_rows($sql) >0) {
                                $no=1;
                                while ($data = mysqli_fetch_assoc($sql)) {
                                    
                        ?>
								<td width="1"><?php echo $no++; ?></td>
                                <td><?php echo $data['nm_kapal'];?></td>
                                <td><?php echo $data['gt'];?></td>
                                <td><?php echo $data['nm_jns_kapal'];?></td>
                                <td><?php echo $data['nama_pemilik'];?></td>
                                <td><?php echo $data['nm_jns_sertifikat'];?></td>
                                <td><?php echo $data['no_sertifikat'];?></td>
                                <td><?php echo $data['no_barcode'];?></td>
                                <td><?php echo $data['tgl_terbit'];?></td>
                                <td><?php echo $data['masa_laku'];?></td>
                                <td><?php echo $data['no_billing'];?></td>
                        
                    </tbody>
                    <?php           
                                }
                            }else{
                                echo '<tr><td colspan="9"><center><h2><strong>Tidak ada Data surat Masuk</></strong></h2></center></td></tr>';
                            }
                        }
                        }
                    ?>
                        
                </table>
    </div>
    <script type="text/javascript">
        window.print();
    </script>