 <?php 

$koneksi = mysqli_connect("127.0.0.1","root","", "troubleshooting");
require('fpdf.php');


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Image('../../../assets/images/logo.png',22,5,15,19);
$pdf->Cell(0,5,'BAPPENDA NTB','0','1','C',false);
$pdf->SetFont('Arial','i',8);
$pdf->Cell(0,5,'Jl. Majapahit No.17, Kekalik Jaya, Kec. Sekarbela, Kota Mataram, Nusa Tenggara Bar. 83115','0','1','C',false);
$pdf->Ln(6);
$pdf->Cell(190,0.6,'','0','1','C',true);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,5,'Laporan Prosedur','0','1','L',false);
$pdf->Ln(3);

$pdf->SetFont('Arial','B',20);

$pdf->Cell(100,10,'Prosedur',0,0,'C');





$sql = mysqli_query($koneksi, "SELECT * FROM tb_prosedur");

while ($data = mysqli_fetch_array($sql)) {

	$cellWidth=190; //lebar sel
    $cellHeight=200; //tinggi sel satu baris normal
    
    //periksa apakah teksnya melibihi kolom?
    if($pdf->GetStringWidth($data['txt']) < $cellWidth){
        //jika tidak, maka tidak melakukan apa-apa
        $line=1;
    }else{
        //jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
        //dengan memisahkan teks agar sesuai dengan lebar sel
        //lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
        
        $textLength=strlen($data['txt']);    //total panjang teks
        $errMargin=5;       //margin kesalahan lebar sel, untuk jaga-jaga
        $startChar=0;       //posisi awal karakter untuk setiap baris
        $maxChar=0;         //karakter maksimum dalam satu baris, yang akan ditambahkan nanti
        $textArray=array(); //untuk menampung data untuk setiap baris
        $tmpString="";      //untuk menampung teks untuk setiap baris (sementara)
        
        while($startChar < $textLength){ //perulangan sampai akhir teks
            //perulangan sampai karakter maksimum tercapai
            while( 
            $pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
            ($startChar+$maxChar) < $textLength ) {
                $maxChar++;
                $tmpString=substr($data['txt'],$startChar,$maxChar);
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
    $pdf->SetFont('Arial','',20);
   
    $pdf->Cell(100,10,$data['nama_prosedur'],0,1,'C');
    $pdf->Ln(5);
    

    $xPos=$pdf->GetX();
    $yPos=$pdf->GetY();
    $pdf->MultiCell($cellWidth,$cellHeight,$data['txt'],1,'L');


}

$pdf->Output();

?>


