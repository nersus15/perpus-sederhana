<?php 
$connect = mysqli_connect("127.0.0.1","root","", "smart");
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',25);
$pdf->Image('../img/logo/coba.png',22,5,25,35);
$pdf->Cell(0,5,'BADAN NARKOTIKA NASIONAL','0','1','C',false);
$pdf->SetFont('Arial','B',20);
$pdf->Cell(0,10,'PROVINSI NUSA TENGGARA BARAT','0','1','C',false);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,'Jl. Dr. Soedjono Lingkar Selatan Mataram Nusa Tenggara Barat','0','1','C',false);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,'Telp:(0370)6177481 Fax: (0370)6177413','0','1','C',false);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,'Email : bnnpntb@gmail.com','0','1','C',false);
$pdf->Ln(5);
$pdf->Cell(275,0.8,'','0','1','C',true);
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'DATA SURAT KELUAR','0','1','C',false);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(8,8,'NO.',1,0,'C');
$pdf->Cell(25,8,'NO. AGENDA',1,0,'C');
$pdf->Cell(50,8,'KLASIFIKASI SURAT',1,0,'C');
$pdf->Cell(55,8,'PERIHAL',1,0,'C');
$pdf->Cell(40,8,'TANGGAL KIRIM',1,0,'C');
$pdf->Cell(55,8,'TUJUAN',1,0,'C');
$pdf->Cell(42,8,'NO. SURAT',1,1,'C');
$no = 0;

$sql = mysqli_query($connect, "SELECT * FROM surat_keluar, klasifikasi_surat where surat_keluar.id_klasifikasi= klasifikasi_surat.id_klasifikasi");
while ($data = mysqli_fetch_array($sql)) {

$cellWidth=55; //lebar sel
	$cellHeight=8; //tinggi sel satu baris normal
	
	//periksa apakah teksnya melibihi kolom?
	if($pdf->GetStringWidth($data['tujuan']) < $cellWidth){
		//jika tidak, maka tidak melakukan apa-apa
		$line=1;
	}else{
		//jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
		//dengan memisahkan teks agar sesuai dengan lebar sel
		//lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
		
		$textLength=strlen($data['tujuan']);	//total panjang teks
		$errMargin=5;		//margin kesalahan lebar sel, untuk jaga-jaga
		$startChar=0;		//posisi awal karakter untuk setiap baris
		$maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
		$textArray=array();	//untuk menampung data untuk setiap baris
		$tmpString="";		//untuk menampung teks untuk setiap baris (sementara)
		
		while($startChar < $textLength){ //perulangan sampai akhir teks
			//perulangan sampai karakter maksimum tercapai
			while( 
			$pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
			($startChar+$maxChar) < $textLength ) {
				$maxChar++;
				$tmpString=substr($data['tujuan'],$startChar,$maxChar);
			}
			//pindahkan ke baris berikutnya
			$startChar=$startChar+$maxChar;
			//kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
			array_push($textArray,$tmpString);
			//reset variabel penampung
			$maxChar=0;
			$tmpString='';
			
		}
		//dapatkan jumlah baris
		$line=count($textArray);
	}
	
    //tulis selnya
    $pdf->SetFillColor(255,255,255);
    $no++;
	$pdf->Cell(8,($line * $cellHeight),$no.".	",1,0,'C',true); 
	$pdf->Cell(25,($line * $cellHeight),$data['no_agenda'],1,0,'C'); 
	$pdf->Cell(50,($line * $cellHeight),$data['nama_klasifikasi'],1,0,'C');
	$pdf->Cell(55,($line * $cellHeight),$data['perihal'],1,0,'C');
	$pdf->Cell(40,($line * $cellHeight),$data['tanggal_kirim'],1,0,'C');
	
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->MultiCell($cellWidth,$cellHeight,$data['tujuan'],1,0,'C');
	
	$pdf->SetXY($xPos + $cellWidth , $yPos);
	$pdf->Cell(42,($line * $cellHeight),$data['no_surat'],1,1,'C');
		

}

$pdf->Output();

?>


