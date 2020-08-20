<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Laporan_Trouble.doc");
?>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
        <style>
            h2{
                text-align: center
            }
            .mytable{
                border:1px solid black;
                border-collapse: collapse;
                width: 100%;
                height: 100%;
            }
            .mytable tr th  , .mytable tr td {
                border:1px solid black;
                padding: 5px 10px;
                white-space:pre;

            }
        </style>
    </head>
    <body>
        <table class="mytable">
                                                                    
                                                                        <tr>
                                                                            <th>NO</th>
                                                                            <th>BIDANG</th>
                                                                            <th>PERMASALAHAN</th>
                                                                            <th>KATEGORI</th>
                                                                            <th>SOLUSI</th>
                                                                            <th>PETUGAS</th>
                                                                            </tr>
        <?php 
        $koneksi = mysqli_connect("127.0.0.1","root","", "troubleshooting");
                                                                        $sql = mysqli_query($koneksi, "SELECT * FROM tb_master, tb_kategori, tb_petugas, tb_bidang WHERE 
                                                                            tb_master.id_bidang = tb_bidang.id_bidang AND
                                                                            tb_master.id_kategori = tb_kategori.id_kategori AND
                                                                            tb_master.id_petugas = tb_petugas.id_petugas ORDER BY id_master DESC");
                                                                        $no = 0;
                                                                        while ($data = mysqli_fetch_array($sql)) { $no++;?>
                                                                        
                                                                        <tr>
                                                                            <td><?php echo $no;?></td>
                                                                            <td><?php echo $data['nama_bidang'];?></td>
                                                                            <td><?php echo $data['permasalahan'];?></td>
                                                                            <td ><?php echo $data['nama_kategori'];?></td>
                                                                            <td style="height: 100px width: 30px"><?php echo $data['solusi'];?></td>
                                                                            <td><?php echo $data['nama_petugas'];?></td>
                                                                            
                                                                        </tr>
                                                                        <?php } ?>
        </table>
    </body>
</html>