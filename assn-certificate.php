<?php
    include 'components/authentication.php';
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
    
    
    require('award/fpdf/force_justify.php');
    
     $name = $rws["user_firstname"];
     $lname = $rws["user_lastname"];
     $father= $rws["user_fathername"];
     $dob= $rws["user_dob"];
     $college= $rws["user_college"];
date_default_timezone_set('Asia/Calcutta');
     $date = date('d/m/Y h:i:s a', time());
     $serial= $rws["user_id"];
     $joiningdate= $rws["user_joiningdate"];
     $deadline= $rws["user_deadline"];
     $roll= $rws["user_username"];
     $duration= $rws["user_duration"];
     $topics= $rws["user_assn"];
     $email = $rws["user_email"];


    $pdf = new FPDF();
    $pdf -> AddPage();
    $pdf->Image('award/back-assn.png', 0.5, 0.5, w,h);
    $pdf->SetDrawColor(0,80,180);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',12);
    $pdf->Ln(50);
    $pdf->Cell(0,6,'CERTIFICATE OF LAW INTERNSHIP',0,1,'C');
    $pdf->Cell(0,6,'An autonomous project of APF',0,1,'C');
    $pdf->Cell(0,6,'(Registered under The Indian Trust Acts, 1882)',0,1,'C');
    $pdf->Image('award/Advocatespedia Projects (2).png',150,55,20);
    $pdf->Image('award/Advocatespedia Projects (4).png',40,55,20);
    $y = $pdf->GetY();
    $pdf->SetXY(40,$y);
    $pdf->MultiCell(160,6,"
Name                             : $name $lname
Father Name                 : $father
College/University       : $college
Date of Birth                 : $dob
Duration                        : $duration
Date of Joining             : $joiningdate
Deadline                        : $deadline
Research Subject         : Legal Cases and Articles writing
Serial Number               : $serial
",'FJ');
$pdf->Line(30, 140, 210-30, 140);
    $y = $pdf->GetY();
    $pdf->SetXY(60,$y);
$pdf->MultiCell(160,6,"
$topics
",'FJ');
$y = $pdf->GetY();
    $pdf->SetXY(30,$y);
$pdf->MultiCell(160,6,"
The above ASSN was granted in against of Articles published on Advocatespedia, The Law encyclopedia (www.advocatespedia.com).",'FJ');

$pdf->Cell(0,6,"Issued On: $date",0,1,'C');




// email stuff (change data below)
$to = $email; 
$from = "info@advocatespedia.com"; 
$subject = "Certificate of ASSN"; 
$message = "
<p>To</p>

<p>$name</p>
<p>$college</p>
<p>Roll Number: $roll</p>

<p>Dear $name</p>

<p>I am delighted & excited to inform you that your certificate has been granted.</p>


<p>Congratulations!</p>


<p>Please see the attachment.</p>

<p>Adv. Faiyaz Khalid</p>
<p>President</p>
<p>Advocates Pedia Foundation</p>



";

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "$name.pdf";

// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$body .= "This mail is regarding Certificate of ASSN.".$eol;

// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;

// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";

// send message
mail($to, $subject, $body, $headers);

$filename="award/assncertificate/$roll.pdf";
$pdf->Output($filename,'F');


header("location: award-icertificate.php");



?>


      

<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>


<?php 
    if($_GET["request"]=="profile-update" && $_GET["status"]=="success"){
        $dialogue="Your profile update was successful! ";
    }
    else if($_GET["request"]=="profile-update" && $_GET["status"]=="unsuccess"){
        $dialogue="Your profile update was not at all successful! ";
    }
    else if($_GET["request"]=="login" && $_GET["status"]=="success"){
        $dialogue="Welcome back again! ";
    }
?>

<?php          
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
?>  



