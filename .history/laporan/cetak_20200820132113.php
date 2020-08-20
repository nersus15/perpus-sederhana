<?php 
$connect = mysqli_connect("127.0.0.1","root","", "dbperpus");
require('fpdf.php');


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',15);
$pdf->Image('../img/avatar/sma.png',20,5,25,35);
$pdf->Cell(0,5,'DINAS PENDIDIKAN DAN KEBUDAYAAN','0','1','C',false);
$pdf->SetFont('Arial','B',15);
$pdf->Cell(0,10,'SMAN 1 SAKRA','0','1','C',false);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,'Jalan Soekarno-Hatta Sakra-Kabupaten Lombok Timur-Tlpn (0376) 2991030','0','1','C',false);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,'Situs Resmin: www.smansasak.vch.id Email : infosmansasak@yahoo.com','0','1','C',false);
$pdf->Ln(5);
$pdf->Cell(190,0.6,'','0','1','C',true);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'DATA HISTORI PEMINJAMAN BUKU','0','1','C',false);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(8,8,'NO.',1,0,'C');
$pdf->Cell(30,8,'KODE',1,0,'C');
$pdf->Cell(55,8,'JUDUL',1,0,'C');
$pdf->Cell(35,8,'TANGGAL',1,0,'C');
$pdf->Cell(35,8,'NAMA PEMINJAMAN',1,0,'C');
$pdf->Cell(25,8,'STATUS',1,1,'C');
$no = 0;

$sql = mysqli_query($connect, "SELECT tblpinjam.*, tblbuku.judul FROM tblpinjam JOIN tblbuku ON tblbuku.kode = tblpinjam.buku");
while ($data = mysqli_fetch_array($sql)) {

$cellWidth=55; //lebar sel
	$cellHeight=8; //tinggi sel satu baris normal
	
	//periksa apakah teksnya melibihi kolom?
	if($pdf->GetStringWidth($data['judul']) < $cellWidth){
		//jika tidak, maka tidak melakukan apa-apa
		$line=1;
	}else{
		//jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
		//dengan memisahkan teks agar sesuai dengan lebar sel
		//lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
		
		$textLength=strlen($data['judul']);	//total panjang teks
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
				$tmpString=substr($data['judul'],$startChar,$maxChar);
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
	$pdf->Cell(30,($line * $cellHeight),$data['kode'],1,0,'C'); 

	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->MultiCell($cellWidth,$cellHeight,$data['judul'],1,0,'C');
	
	$pdf->SetXY($xPos + $cellWidth , $yPos);
	$pdf->Cell(35,($line * $cellHeight),$data['tanggal'],1,0,'C');
	$pdf->Cell(35,($line * $cellHeight),$data['nama'],1,0,'C');
    $pdf->Cell(25,($line * $cellHeight),$data['status'],1,1,'C'); 
 
}
?>

<script>
	print("OK");
	print(<?php echo $pdf->output()?>)
</script>