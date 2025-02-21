<?php

require("dbconn.php");
require("Encrypt.php");
require("Decrypt.php");
require('vendor/tecnickcom/tcpdf/tcpdf.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';






// User Creation

if(isset($_GET['createuser'])){


    // Account Information
    date_default_timezone_set('Asia/Manila');
    $intid = $_POST["intid"];
    $usname = $_POST["usname"];
    $acttype = $_POST["acttype"];
    $regions = $_POST["regions"];
    $passwords = $_POST["password"];
    $passwordsHash = sha1("digi".$passwords."digi");
    
    $date = date("Y-m-d h:i:s a");

    // Personal Informations

    $staffid = $_POST["staffid"];
    $fname = $_POST["fname"];
    $strfname = strtoupper($fname);
    $mname = $_POST["mname"];
    $strmname = strtoupper($mname);
    $lname = $_POST["lname"];
    $strlname = strtoupper($lname);
    $sname = $_POST["sname"];
    $strsname = strtoupper($sname);
    $gender = $_POST["gender"];
    $birth = $_POST["birth"];
    $pob = $_POST["pob"];
    $wregion = $_POST["wregion"];
    $scCode = $_POST["scCode"];


    $street = $_POST["street"];
    $strstreet = strtoupper($street);
    $village = $_POST["village"];
    $strvillage = strtoupper($village);
    $barangay = $_POST["barangay"];
    $strbarangay = strtoupper($barangay);
    $municipality = $_POST["municipality"];
    $province = $_POST["province"];
    $region = $_POST["region"];
    $district = $_POST["district"];
    $zip = $_POST["zipcode"];
    $mail = $_POST["mail"];
    $contact = $_POST["contact"];
    $zipid = $_POST['zip'];


    // $addby = $_POST["creator"];
    // $authid = $_POST["authid"];
    

    $pdo->beginTransaction();
    $stnt = $pdo->prepare("INSERT INTO users(username,internal_id,password,account_type,region,school_code,date_added) VALUES (?,?,?,?,?,?,?) RETURNING id");
    $stntp = $pdo->prepare("INSERT INTO staff_record(staff_id,user_id,first_name,middle_name,last_name,suffix_name,sex,dob,pob,work_region,school_code,street,village,barangay,municipality,province,region,district,zipcode,email,contact_no,zip_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $params = array($usname,$intid,$passwordsHash,$acttype,$regions,$scCode,$date);
    $stnt -> execute($params);

    if($stnt){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }

    $sid = "";
    try{

        $result = $stnt->fetch();
        $sid = $result["id"];
    }catch(Exception $e){
        echo $e;
    }


    $sparams = array($staffid,$sid,$strfname,$strmname,$strlname,$strsname,$gender,$birth,$pob,$wregion,$scCode,$strstreet,$strvillage,$strbarangay,$municipality,$province,$region,$district,$zip,$mail,$contact,$zipid);
    $stntp -> execute($sparams);
    if($stntp){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }


    if(in_array(false, $errors)){
        echo "false";
        $pdo->rollback();
    } else{
       echo "true";
       $pdo->commit();
   }

} 



 // Bulk Upload



    if(isset($_GET['batchUploads'])){


    date_default_timezone_set('Asia/Manila');
    $date = date("Ymdhi");

    $dates = date("Y-m-d h:i:s a");
    $uname = $_POST["usercreator"];
    $authid = $_POST["authid"];
    // $passwords = $_POST["password"];
    // $passwordsHash = sha1("digi".$passwords."digi");



// Bulk Upload
    $bathcFile = $_FILES['batchUploadUsers']['name'];
    $path = 'batch/';
    $allowed_extensions = array('csv');
    $extension = pathinfo($bathcFile, PATHINFO_EXTENSION);
    if(in_array(strtolower($extension),$allowed_extensions) ) {

        if(!file_exists($path)){

            mkdir($path, 0775, true);
        }

        $temp_file = $_FILES['batchUploadUsers']['tmp_name'];


            $newpath = $path.$authid.$uname.$date.".".$extension;

            if(move_uploaded_file($temp_file,$newpath)){
                echo "";
            } else{
                $newpath = "No_Files";
                    // echo "failed";
            }
        

    }else{
        $newpath = "No_Files";
        // echo "Failed";
    } 

$b = false;
    $file = fopen($newpath, "r");
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
    {
if(!$b) {       //edited for accuracy
       $b = true;
       continue;
    }
    
    $password_sha1 = sha1($emapData[2]);
    $scode = $emapData[14];

    $pdo->beginTransaction();
    $stnt = $pdo->prepare("INSERT INTO users(internal_id,username,password,account_type,region,school_code,date_added) VALUES (?,?,?,?,?,?,?) RETURNING ID");
    $stntp = $pdo->prepare("INSERT INTO staff_record(staff_id,user_id,first_name,middle_name,last_name,suffix_name,sex,dob,pob,work_region,school_code,street,village,barangay,municipality,province,region,district,zipcode,email,contact_no) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $params = array($emapData[0],$emapData[1],$password_sha1,$emapData[3],$emapData[4],$scode,$dates);



    $stnt -> execute($params);


    if($stnt){
    $errors[] =  true;
    } else{

    $errors[] = false;
    }

    $sid = "";
    try{

        $result = $stnt->fetch();
        $sid = $result["id"];
    }catch(Exception $e){
        echo $e;
    }


    $sparams = array($emapData[5],$sid,$emapData[6],$emapData[7],$emapData[8],$emapData[9],$emapData[10],$emapData[11],$emapData[12],
    $emapData[13],$emapData[14],$emapData[15],$emapData[16],$emapData[17],$emapData[18],$emapData[19],$emapData[20],$emapData[21],$emapData[22],$emapData[23],$emapData[24]);
    $stntp -> execute($sparams);
    if($stntp){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }


    if(in_array(false, $errors)){
        $status = "false";
        $pdo->rollback();
       } else{
       $status = "true";
       $pdo->commit();
       }
       
       }
   echo $status;


} 

// Create Scholar


if(isset($_GET['createScholar'])){


    // Account Information
    date_default_timezone_set('Asia/Manila');
    $intid = $_POST["intid"];
    $usname = $_POST["usernames"];
    $acttype = $_POST["acttype"];
    $regions = $_POST["regions"];
    $passwords = $_POST["password"];
    $passwordsHash = sha1("digi".$passwords."digi");
    
    $date = date("Y-m-d h:i:s a");

    // Personal Informations

    $spasid = $_POST["spasid"];
$spasid_no_spaces = str_replace(' ', '', $spasid);
    $strspas = strtoupper($spasid);
    $fname = $_POST["fname"];
    $strfname = strtoupper($fname);
    $mname = $_POST["mname"];
    $strmname = strtoupper($mname);
    $lname = $_POST["lname"];
    $strlname = strtoupper($lname);
    $sname = $_POST["sname"];
    $strsname = strtoupper($sname);
    $fullname = $strlname . ', ' .  $strfname . ' ' . $strmname . ' ' . $strsname;
    $strfullname = strtoupper($fullname);



    $gender = $_POST["gender"];
    $birth = $_POST["birth"];
    $pob = $_POST["pob"];
    $tribe = $_POST["tribe"];
    $scCode = $_POST["scCode"];
    $scregions = $_POST["scregions"];

    $mail = $_POST["mail"];
    $contact = $_POST["contact"];


    $street = $_POST["street"];
    $strstreet = strtoupper($street);
    $village = $_POST["village"];
    $strvillage = strtoupper($village);
    $barangay = $_POST["barangay"];
    $strbarangay = strtoupper($barangay);
    $municipality = $_POST["municipality"];
    $province = $_POST["province"];
    $region = $_POST["region"];
    $district = $_POST["district"];
    $zip = $_POST["zip"];
    $zipid = $_POST['zipid'];

    $diffcur = $_POST['diffcur'];


    $street2 = $_POST["street2"] ?? '';
    $strstreet2 = strtoupper($street2);
    $village2 = $_POST["village2"] ?? '';
    $strvillage2 = strtoupper($village2);
    $barangay2 = $_POST["barangay2"] ?? '';
    $strbarangay2 = strtoupper($barangay2);
    $municipality2 = $_POST["municipality2"] ?? '';
    $province2 = $_POST["province2"] ?? '';
    $region2 = $_POST["region2"] ?? '';
    $district2 = $_POST["district2"] ?? '';
    $zip2 = isset($_POST["zip2"]) && is_numeric($_POST["zip2"]) ? intval($_POST["zip2"]) : 0;


    if ($municipality2 === 'undefined') {
        $municipality2 = '';
    }
    if ($province2 === 'undefined') {
        $province2 = '';
    }
    if ($region2 === 'undefined') {
        $region2 = '';
    }
    if ($district2 === 'undefined') {
        $district2 = '';
    }

    // $addby = $_POST["creator"];
    // $authid = $_POST["authid"];
    

    $pdo->beginTransaction();
    $stnt = $pdo->prepare("INSERT INTO users(username,internal_id,password,account_type,region,school_code,date_added) VALUES (?,?,?,?,?,?,?) RETURNING id");
    $stntp = $pdo->prepare("INSERT INTO scholars_record(spas_id,user_id,first_name,middle_name,last_name,suffix_name,full_name,sex,dob,pob,tribe,street,
    village,barangay,municipality,province,region,district,zipcode,diff_curr_add,email,contact_no,school_region,school_code,zip_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stntd = $pdo->prepare("INSERT INTO curr_add(spas_id,street,village,barangay,municipality,province,region,district,zipcode) VALUES (?,?,?,?,?,?,?,?,?)");

    $params = array($usname,$intid,$passwordsHash,$acttype,$regions,$scCode,$date);

    $stnt -> execute($params);

    if($stnt){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }

    $sid = "";
    try{

        $result = $stnt->fetch();
        $sid = $result["id"];
    }catch(Exception $e){
        echo $e;
    }


    $sparams = array($spasid_no_spaces,$sid,$strfname,$strmname,$strlname,$strsname,$fullname,$gender,$birth,$pob,$tribe,$strstreet,$strvillage,
    $strbarangay,$municipality,$province,$region,$district,$zip,$diffcur,$mail,$contact,$scregions,$scCode,$zipid);
    $stntp -> execute($sparams);
    if($stntp){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }


    $dparams = array($spasid_no_spaces,$strstreet2,$strvillage2,$strbarangay2,$municipality2,$province2,$region2,$district2,$zip2);
    $stntd -> execute($dparams);
    if($stntd){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }


    if(in_array(false, $errors)){
        echo "false";
        $pdo->rollback();
    } else{
       echo "true";
       $pdo->commit();
   }

} 




// Bulk Upload Scholars



if(isset($_GET['batchUploadScholar'])){


    date_default_timezone_set('Asia/Manila');
    $date = date("Ymdhi");

    $dates = date("Y-m-d h:i:s a");
    $uname = $_POST["usercreator"];
    $authid = $_POST["authid"];
    // $passwords = $_POST["password"];
    // $passwordsHash = sha1("digi".$passwords."digi");



// Bulk Upload
    $bathcFile = $_FILES['batchUploadScholars']['name'];
    $path = 'batch/';
    $allowed_extensions = array('csv');
    $extension = pathinfo($bathcFile, PATHINFO_EXTENSION);
    if(in_array(strtolower($extension),$allowed_extensions) ) {

        if(!file_exists($path)){

            mkdir($path, 0775, true);
        }

        $temp_file = $_FILES['batchUploadScholars']['tmp_name'];


            $newpath = $path.$authid.$uname.$date.".".$extension;

            if(move_uploaded_file($temp_file,$newpath)){
                echo "";
            } else{
                $newpath = "No_Files";
                    // echo "failed";
            }
        

    }else{
        $newpath = "No_Files";
        // echo "Failed";
    } 

$b = false;
    $file = fopen($newpath, "r");
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
    {
if(!$b) {       //edited for accuracy
       $b = true;
       continue;
    }
    
    $password_sha1 = sha1($emapData[2]);
    $scode = $emapData[15];
    $spasid = $emapData[5];

    $fullname = $emapData[8] . ', ' .  $emapData[6] . ' ' . $emapData[7] . ' ' . $emapData[9];

    $curradd = ($emapData[26] === 'YES' || $emapData[26] === 'yes') ? 'true' : 'false';

    $street = $emapData[27] ?? '';
    $village = $emapData[28] ?? '';
    $barangay = $emapData[29] ?? '';
    $municipality = $emapData[30] ?? '';
    $province = $emapData[31] ?? '';
    $region = $emapData[32] ?? '';
    $district = $emapData[33] ?? '';
    $zipcodes = isset($emapData[34]) && is_numeric($emapData[34]) ? intval($emapData[34]) : 0;


    $hs_name = $emapData[35] ?? '';
    $hs_code = $emapData[36] ?? '';
    $hs_grad = $emapData[37] ?? '';


    $serial_no = $emapData[38] ?? '';
    $tpr = $emapData[39] == '' ? 0.00 : $emapData[39];
    $trs = $emapData[40] == '' ? 0.00 : $emapData[40];
    $ztot = $emapData[41] == '' ? 0.00 : $emapData[41];
    $prs = $emapData[42] == '' ? 0.00 : $emapData[42];
    $priority = $emapData[43] == '' ? 0 : $emapData[43];


    $income = $emapData[50] ?? '';
    $father_occu = $emapData[51] ?? '';
    $mother_occu = $emapData[52] ?? '';
    $occu = $emapData[53] ?? '';


    $pdo->beginTransaction();
    $stnt = $pdo->prepare("INSERT INTO users(internal_id,username,password,account_type,region,school_code,date_added) VALUES (?,?,?,?,?,?,?) RETURNING ID");
    $stntp = $pdo->prepare("INSERT INTO scholars_record(spas_id,user_id,first_name,middle_name,last_name,suffix_name,full_name,sex,dob,pob,tribe,school_region,school_code,
    street,village,barangay,municipality,province,region,district,zipcode,email,contact_no,diff_curr_add) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stnta = $pdo->prepare("INSERT INTO curr_add(spas_id,street,village,barangay,municipality,province,region,district,zipcode) VALUES (?,?,?,?,?,?,?,?,?)");
    $stnth = $pdo->prepare("INSERT INTO hs_record(spas_id,hs_name,hs_code,hs_grad) VALUES (?,?,?,?)");
    $stnte = $pdo->prepare("INSERT INTO exam_info(spas_id,serial_no,tpr,trs,ztot,prs,priority) VALUES (?,?,?,?,?,?,?)");
    $stntsi = $pdo->prepare("INSERT INTO scholarship_info(spas_id,primary_spas_id,yr_awarded,program,sub_program,category,schp_award,remarks) VALUES (?,?,?,?,?,?,?,?)");
    $stntf = $pdo->prepare("INSERT INTO family_info(spas_id,income,father_occu,mother_occu,occu) VALUES (?,?,?,?,?)");

    $params = array($emapData[0],$emapData[1],$password_sha1,$emapData[3],$emapData[4],$scode,$dates);

    $stnt -> execute($params);


    if($stnt){
    $errors[] =  true;
    } else{

    $errors[] = false;
    }

    $sid = "";
    try{

        $result = $stnt->fetch();
        $sid = $result["id"];
    }catch(Exception $e){
        echo $e;
    }


    $sparams = array($emapData[5],$sid,$emapData[6],$emapData[7],$emapData[8],$emapData[9],$fullname,$emapData[10],$emapData[11],$emapData[12],
    $emapData[13],$emapData[14],$emapData[15],$emapData[16],$emapData[17],$emapData[18],$emapData[19],$emapData[20],$emapData[21],$emapData[22],$emapData[23],$emapData[24],
    $emapData[25],$curradd);
    $stntp -> execute($sparams);
    if($stntp){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }


    $aparams = array($spasid,$street,$village,$barangay,$municipality,$province,$region,$district,$zipcodes);
    $stnta -> execute($aparams);
    if($stnta){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }

    $hparams = array($spasid,$hs_name,$hs_code,$hs_grad);
    $stnth -> execute($hparams);
    if($stnth){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }



    $eparams = array($spasid,$serial_no,$tpr,$trs,$ztot,$prs,$priority);
    $stnte -> execute($eparams);
    if($stnte){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }


    $siparams = array($spasid,$spasid,$emapData[44],$emapData[45],$emapData[46],$emapData[47],$emapData[48],$emapData[49]);
    $stntsi -> execute($siparams);
    if($stntsi){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }



    $fparams = array($spasid,$income,$father_occu,$mother_occu,$occu);
    $stntf -> execute($fparams);
    if($stntf){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }



    if(in_array(false, $errors)){
        $status = "false";
        $pdo->rollback();
       } else{
       $status = "true";
       $pdo->commit();
       }
       
       }
   echo $status;


}


// Add Reply Slip



if(isset($_GET['createReplySlip'])){

    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");
    $uploaded_by = $_POST["user"];

    $scholarid = $_POST["scholarid"];
    $reply = $_POST["reply"];
    $daterep = $_POST["daterep"];
    $reply_reason = $_POST["reply_reason"];
    $reply_reason2 = strtoupper($reply_reason);
    $verified = true;


    $stnt = $pdo->prepare("INSERT INTO reply_slip_details(scholar_id,reply_slip,date_reply,reason,created_by,updated_by,verified_flag,verified_by) VALUES 
    (?,?,?,?,?,?,?,?)");
    $params = array($scholarid,$reply,$daterep,$reply_reason2,$uploaded_by,$uploaded_by,$verified,$uploaded_by);
    $stnt -> execute($params);

    if($stnt){
        $result =  true;
    } else{

        $result = false;
    }

    echo json_encode($result);


}

// Edit Grades print PDF


if(isset($_GET['printGradesPDF'])){

    // 
    $termids = $_POST["id"];
    $grades = json_decode($_POST['grades'], true);


     $sy = $_POST["sy"];
     $sem = $_POST["sem"];
     $school = $_POST["school"];
     $course = $_POST["course"];
     $termreq = $_POST["termreq"];
     $regVerified = $_POST["regVerified"];
     $gradeVerified = $_POST["gradeVerified"];
     $statStart = $_POST["statStart"];
     $statEnd = $_POST["statEnd"];
     $stat1 = $_POST["stat1"];
     $stat2 = $_POST["stat2"];


     $gwa = $_POST["computedGwa"];
     $units = $_POST["computedTotalUnits"];



     $stnt = $pdo->prepare("SELECT t.spas_id, t.term_id, s.full_name

     FROM term_record as t
     
     LEFT OUTER JOIN scholars_record AS s ON t.spas_id = s.spas_id
     
     WHERE term_id = ?");
             $stnt->execute([$termids]);
         
             while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
                 
                  $fname = $row['full_name'];
                  $spas = $row['spas_id'];
                
         }


    
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    
    // ---------------------------------------------------------


    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Grades Report');
    $pdf->SetSubject('Grades Table');
    $pdf->SetKeywords('TCPDF, PDF, table, CSS');
    
    $pdf->AddPage();
   
    $pdf->SetFont('helvetica', 'B', 14); // Set font to bold (B) with size 14
    $pdf->Cell(0, 22, 'Scholar Grade Report', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->SetFont('courier', '', 10, '', true);


    $pdf->ln(3);
    $pdf->Cell(90,10,'SPAS ID: '.$spas, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'Name: '.$fname, 0, 1, 'R', 0, '', 0, false, 'M', 'M');


    

    $pdf->Ln(0); // No extra space between lines
$pdf->MultiCell(90, 5, 'School Year: '.$sy.', '.$sem, 0, 'L', 0, 0, '', '', true); // Adjust height to 5
$pdf->MultiCell(90, 5, 'Term Required: '.$termreq, 0, 'R', 0, 1, '', '', true);
$pdf->MultiCell(90, 5, 'Course: '.$course, 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(90, 5, 'Status(Start): '.$statStart.'-'.$statEnd, 0, 'R', 0, 1, '', '', true);

$pdf->Ln(3); // Add vertical space before the next section

$pdf->MultiCell(90, 10, 'School: '.$school, 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(90, 10, 'Status(END): '.$stat1.'-'.$stat2, 0, 'R', 0, 1, '', '', true); // No extra Ln() added here







    // Set table header
    $html = '<style>
    th {
      text-align: center;
      font-weight: bold;
    }
    
    td {
      text-align: center;
    }
  </style>
    <h3>Grade Reports</h3>';
    $html .= '<table border="1" cellpadding="4">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Units</th>
                        <th>Grade</th>
                        <th>Academic</th>
                        <th>Completion</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>';



                // Populate table rows
    foreach ($grades as $item) {
        $html .= '<tr>
                 
                      <td>' . htmlspecialchars($item['scode']) . '</td>
                      <td>' . htmlspecialchars($item['units']) . '</td>
                      <td>' . htmlspecialchars($item['grade']) . '</td>
                       <td>' . ($item['academic'] ? 'Yes' : 'No') . '</td>
                      <td>' . htmlspecialchars($item['completion']) . '</td>
                      <td>' . htmlspecialchars($item['remarks']) . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // $pdf->writeHTML($html, true, false, false, false, '');
    $pdf->writeHTML($html);

    $pdf->ln(3);
    $pdf->Cell(90,10,'Total Units: '.$units, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'GWA: '.$gwa, 0, 1, 'R', 0, '', 0, false, 'M', 'M');


    $pdf->Ln(5);

    $pdf->Cell(90,10,'Registration Form Verified By: '.$regVerified, 0, 1, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'Grades Verified By: '.$gradeVerified, 0, 1, 'L', 0, '', 0, false, 'M', 'M');
    
    
    
   
 

    // OutPDF
    
    ob_end_clean();
    $pdf->Output(__DIR__ .'/test.pdf','I');
        
    
         }




         // Add print Grades PDF


if(isset($_GET['printAddGradesPDF'])){

    // 
    $scholarids = $_POST["id"];
    $grades = json_decode($_POST['grades'], true);


   
     $school = $_POST["school"];
     $course = $_POST["course"];
     $termreq = $_POST["termreq"];

     $syList = $_POST["syList"];
     $term = $_POST["term"];
     
     $statStart = $_POST["statStart"];
     $statEnd = $_POST["statEnd"];
     $stat1 = $_POST["stat1"];
     $stat2 = $_POST["stat2"];


     $gwa = $_POST["computedGwa"];
     $units = $_POST["computedTotalUnits"];


    
    
        $stnt = $pdo->prepare("SELECT * FROM scholars_record WHERE spas_id = ?");
        $stnt->execute([$scholarids]);
    
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            
             $fname = $row['full_name'];
           
    }
    
   
    
    
    
    
    
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    
    // ---------------------------------------------------------


    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Grades Report');
    $pdf->SetSubject('Grades Table');
    $pdf->SetKeywords('TCPDF, PDF, table, CSS');
    
    $pdf->AddPage();
   
    $pdf->SetFont('helvetica', 'B', 14); // Set font to bold (B) with size 14
    $pdf->Cell(0, 22, 'Scholar Grade Report', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->SetFont('courier', '', 10, '', true);


    $pdf->ln(3);
    $pdf->Cell(90,10,'SPAS ID: '.$scholarids, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'Name: '.$fname, 0, 1, 'R', 0, '', 0, false, 'M', 'M');


    $pdf->Ln(0); // Set to 0 to remove extra space between lines
$pdf->MultiCell(90, 5, 'School Year: '.$syList.', '.$term, 0, 'L', 0, 0, '', '', true); // Adjust height to 5
$pdf->MultiCell(90, 5, 'Term Required: '.$termreq, 0, 'R', 0, 1, '', '', true);
$pdf->MultiCell(90, 5, 'Course: '.$course, 0, 'L', 0, 0, '', '', true);
 $pdf->MultiCell(90, 5, 'Status(Start): '.$stat1.'-'.$stat2, 0, 'R', 0, 1, '', '', true);
 $pdf->Ln(3); // Add vertical space before the next section
$pdf->MultiCell(90, 5, 'School: '.$school, 0, 'L', 0, 0, '', '', true);
// $pdf->MultiCell(90, 10, 'Status(START): '.$stat1.'-'.$stat2, 0, 'R', 0, 1, '', '', true);

$pdf->Ln(10); // Add extra line spacing

    // Set table header
    $html = '<style>
    th {
      text-align: center;
      font-weight: bold;
    }
    
    td {
      text-align: center;
    }
  </style>
    <h3>Grade Reports</h3>';
    $html .= '<table border="1" cellpadding="4">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Units</th>
                        <th>Grade</th>
                        <th>Academic</th>
                        <th>Completion</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>';



                // Populate table rows
    foreach ($grades as $item) {
        $html .= '<tr>
                 
                      <td>' . htmlspecialchars($item['scode']) . '</td>
                      <td>' . htmlspecialchars($item['units']) . '</td>
                      <td>' . htmlspecialchars($item['grade']) . '</td>
                       <td>' . ($item['academic'] ? 'Yes' : 'No') . '</td>
                      <td>' . htmlspecialchars($item['completion']) . '</td>
                      <td>' . htmlspecialchars($item['remarks']) . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // $pdf->writeHTML($html, true, false, false, false, '');
    $pdf->writeHTML($html);

    $pdf->ln(3);
    $pdf->Cell(90,10,'Total Units: '.$units, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'GWA: '.$gwa, 0, 1, 'R', 0, '', 0, false, 'M', 'M');



    // OutPDF
    
    ob_end_clean();
    $pdf->Output(__DIR__ .'/test.pdf','I');
        
    
         }



         // New Term print Grades PDF


if(isset($_GET['printNewTermGradesPDF'])){

    // 
    $scholarids = $_POST["id"];
    $grades = json_decode($_POST['grades'], true);


     $sy = $_POST["newsy"];
     
    
     $termreq = $_POST["newcurriculum"];
     
     $stat1 = $_POST["stat1"];
     $stat2 = $_POST["stat2"];


     $gwa = $_POST["computedGwa"];
     $units = $_POST["computedTotalUnits"];


     $scrTerm = $_POST["scrTerm"];

     $valuesArray = array_map('trim', explode(',', $scrTerm));

     

     $school = isset($valuesArray[0]) ? $valuesArray[0] : null;
     $course = isset($valuesArray[1]) ? $valuesArray[1] : null;



     $sem = $_POST["newterm"];
     $sem1 = $_POST["newterm1"];
     $sem2 = $_POST["newterm2"];


     $maxTerm = max($sem, $sem1, $sem2);

     switch ($maxTerm) {
        case 1:
            $termLabel = "1st Term";
            break;
        case 2:
            $termLabel = "2nd Term";
            break;
        case 3:
            $termLabel = "3rd Term";
            break;
        case 4:
            $termLabel = "4th Term";
            break;
        default:
            $termLabel = "5th Term";
            break;
    }


        $stnt = $pdo->prepare("SELECT * FROM scholars_record WHERE spas_id = ?");
        $stnt->execute([$scholarids]);
    
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            
             $fname = $row['full_name'];
           
    }
    
   
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    
    // ---------------------------------------------------------


    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Grades Report');
    $pdf->SetSubject('Grades Table');
    $pdf->SetKeywords('TCPDF, PDF, table, CSS');
    
    $pdf->AddPage();
   
    $pdf->SetFont('helvetica', 'B', 14); // Set font to bold (B) with size 14
    $pdf->Cell(0, 22, 'Scholar Grade Report', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->SetFont('courier', '', 10, '', true);


    $pdf->ln(3);
    $pdf->Cell(90,10,'SPAS ID: '.$scholarids, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'Name: '.$fname, 0, 1, 'R', 0, '', 0, false, 'M', 'M');


    

    $pdf->Ln(0); // Set to 0 to remove extra space between lines
$pdf->MultiCell(90, 5, 'School Year: '.$sy.', '.$termLabel, 0, 'L', 0, 0, '', '', true); // Adjust height to 5
$pdf->MultiCell(90, 5, 'Term Required: '.$termreq, 0, 'R', 0, 1, '', '', true);
$pdf->MultiCell(90, 5, 'Course: '.$course, 0, 'L', 0, 0, '', '', true);
 $pdf->MultiCell(90, 5, 'Status(Start): '.$stat1.'-'.$stat2, 0, 'R', 0, 1, '', '', true);
 $pdf->Ln(3); // Add vertical space before the next section
$pdf->MultiCell(90, 5, 'School: '.$school, 0, 'L', 0, 0, '', '', true);
// $pdf->MultiCell(90, 10, 'Status(START): '.$stat1.'-'.$stat2, 0, 'R', 0, 1, '', '', true);

$pdf->Ln(10); // Add extra line spacing

    // Set table header
    $html = '<style>
    th {
      text-align: center;
      font-weight: bold;
    }
    
    td {
      text-align: center;
    }
  </style>
    <h3>Grade Reports</h3>';
    $html .= '<table border="1" cellpadding="4">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Units</th>
                        <th>Grade</th>
                        <th>Academic</th>
                        <th>Completion</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>';



                // Populate table rows
    foreach ($grades as $item) {
        $html .= '<tr>
                 
                      <td>' . htmlspecialchars($item['scode']) . '</td>
                      <td>' . htmlspecialchars($item['units']) . '</td>
                      <td>' . htmlspecialchars($item['grade']) . '</td>
                       <td>' . ($item['academic'] ? 'Yes' : 'No') . '</td>
                      <td>' . htmlspecialchars($item['completion']) . '</td>
                      <td>' . htmlspecialchars($item['remarks']) . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // $pdf->writeHTML($html, true, false, false, false, '');
    $pdf->writeHTML($html);

    $pdf->ln(3);
    $pdf->Cell(90,10,'Total Units: '.$units, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'GWA: '.$gwa, 0, 1, 'R', 0, '', 0, false, 'M', 'M');



    // OutPDF
    
    ob_end_clean();
    $pdf->Output(__DIR__ .'/test.pdf','I');
        
    
         }




         // New undergraduate Record



if(isset($_GET['createUndergradRec'])){

    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");
    $user = $_POST["user"];

    $spasid = $_POST["spasid"];
    $school = $_POST["school"];
    $courses = $_POST["courses"];
    $sy = $_POST["sy"];
    $sy_parts = explode(" - ", $sy);
    $first_value = $sy_parts[0];
    $termtype = $_POST["termtype"];
    $term = $_POST["term"];
    $term_id = $spasid . $sy . $term . $termtype;
    $act_flag = 1;
    $latest_flag = 1;
   
    $pdo->beginTransaction();
    $stnt = $pdo->prepare("INSERT INTO course_record(term_id,spas_id,course_code,school_code,sy_start,term_start,term_type,latest_flag,created_at,created_by) VALUES 
    (?,?,?,?,?,?,?,?,?,?) RETURNING id");
    $stnt2 = $pdo->prepare("INSERT INTO term_record(spas_id,term_id,sy,term,term_type,course_id,active_flag,created_at,created_by) VALUES 
    (?,?,?,?,?,?,?,?,?)");

    $params = array($term_id,$spasid,$courses,$school,$first_value,$term,$termtype,$latest_flag,$date,$user);
    $stnt -> execute($params);

    if($stnt){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }

    $sid = "";
    try{

        $result = $stnt->fetch();
        $sid = $result["id"];
    }catch(Exception $e){
        echo $e;
    }

    $params2 = array($spasid,$term_id,$sy,$term,$termtype,$sid,$act_flag,$date,$date);
    $stnt2 -> execute($params2);
    if($stnt2){
        $errors[] =  true;
    } else{

        $errors[] = false;
    }

    if(in_array(false, $errors)){
        echo "false";
        $pdo->rollback();
    } else{
       echo "true";
       $pdo->commit();
   }


}




// Add New Subject



if(isset($_GET['createSubject'])){
  try {


    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");
    $created_by = $_POST["user"];

    $term_id = $_POST["termid"];
    $spasid = $_POST["spasid"];
    $subj_code = strtoupper($_POST["scode"]);
    $academic_type = $_POST["academic"];
    $unit = $_POST["units"];
    $grade = $_POST["grade"];
    $completion = strtoupper($_POST["completion"]);
    $remarks = strtoupper($_POST["remarks"]);
    $verified = 0;
    $act_taken = "ADD";
    $act_message = "The Grade was Added in " . $spasid. "with Term ID: ". $term_id;


    $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

                    $stntf->execute([$spasid]);
         
                    while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
                 
                        $fname = $row['full_name'];    
                
                    }

    
    $pdo->beginTransaction();
    $stnt = $pdo->prepare("INSERT INTO grades(term_id,subj_code,academic_type,unit,grade,completion,remarks,created_at,created_by,verified_flag) VALUES 
    (?,?,?,?,?,?,?,?,?,?)");
    $params = array($term_id,$subj_code,$academic_type,$unit,$grade,$completion,$remarks,$date,$created_by,$verified);
    $stnt -> execute($params);

    $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
                    $params = array($spasid,$fname,$act_taken,$act_message,$created_by,$date);
                    $stnt1 -> execute($params);

   // Commit transaction
   $pdo->commit();
   echo json_encode(true);
} catch (Exception $e) {
   // Rollback transaction on failure
   if ($pdo->inTransaction()) {
           $pdo->rollBack();
       }
   // Log or return the error
   echo json_encode(['error' => $e->getMessage()]);
}


}





// Add New Term Record



if(isset($_GET['newTermRecord'])){

    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");
    $created_by = $_POST["user"];

    $spasid = $_POST["spasid"];
    $sy = $_POST["sy"];
    $term = $_POST["term"];
    $termtype = $_POST['termtype'];


    $termid = $spasid . $sy . $term . $termtype;

    $termreq = $_POST["newcurriculum"] === 'YES' ? 1 : 0;
    $act_flag = 1;



    
    $stnt = $pdo->prepare("INSERT INTO term_record(spas_id,term_id,sy,term,term_type,term_required,active_flag,created_at,created_by) VALUES 
    (?,?,?,?,?,?,?,?,?)");
    $params = array($spasid,$termid,$sy,$term,$termtype,$termreq,$act_flag,$date,$created_by);
    $stnt -> execute($params);

    if($stnt){
        $result =  true;
    } else{

        $result = false;
    }

    echo json_encode($result);


}








if(isset($_GET['createLatest'])){
    
    $termid = $_POST["termid"];
    $latest = 1;


    $stnt = $pdo->prepare("UPDATE term_record SET latest_flag = ?
    WHERE term_id = ?");
    $stnt->execute([$latest,$termid]);
    
     if($stnt){
            $result =  true;
        } else{
            
            $result = false;
        }
    
        echo json_encode($result);
    
    }


    if(isset($_GET['createLatestFalse'])){
    
        $termid = $_POST["termid"];
        $latest = 0;
    
    
        $stnt = $pdo->prepare("UPDATE term_record SET latest_flag = ?
        WHERE term_id = ?");
        $stnt->execute([$latest,$termid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }


        // Create Grades 



        if (isset($_GET['createGrades'])) {
            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d h:i:s a");
        
            $createdby = $_POST["user"];
            $termid = $_POST["termid"];
            $act_flag = 1;
        
            // Initialize an empty array to hold todos
            $todos = [];
        
            // Loop through the posted 'todos' data and collect them into the array
            foreach ($_POST['todos'] as $index => $todo) {
                $scode = isset($todo['scode']) ? $todo['scode'] : null;
                $academic = isset($todo['academic']) ? $todo['academic'] : null;
                $units = isset($todo['units']) ? $todo['units'] : null;
               
        
                // Add each todo to the $todos array
                $todos[] = [
                    'scode' => $scode,
                    'academic' => $academic,
                    'units' => $units
                   
                ];
                // Prepare the SQL statement for each item in the todos array
             $stnt = $pdo->prepare("INSERT INTO grades(term_id,subj_code,academic_type,unit,active_flag,created_at,created_by) VALUES (?,?,?,?,?,?,?)");

                // Execute the statement with the current todo's values
             $success = $stnt->execute([$termid, $scode, $academic, $units, $act_flag, $date, $createdby]);

                // Collect the result of each update
            $results[] = $success;
            }

            $result = in_array(false, $results) ? false : true;

            echo json_encode($result);

            
        }


        // Create Progress Status History
       // Start Status Standing History


        if(isset($_GET['createStatStartsem'])){

            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d h:i:s a");
    
            $termid = $_POST["termid"];
            $spas_id = $_POST["spasid"];
            $sy = $_POST["sy"];
            $term = $_POST["term"];
            $termtype = $_POST["termtype"];
            $startEnd = 1;
            $course_id = $_POST["course_id"];
            $progressStat = $_POST["pstatus"];
            $standing = $_POST["standing"];
            $act_flag = true;
            $created_by = $_POST["user"];


            $pdo->beginTransaction();
              
            $stnt1 = $pdo->prepare("INSERT INTO progress_status_history(term_id,spas_id,sy,term,term_type,start_end,course_id,progress_status,active_flag,created_at,created_by) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?) RETURNING id");

            $stnt2 = $pdo->prepare("INSERT INTO standing_history(term_id,spas_id,sy,term,term_type,start_end,standing,active_flag,created_at,created_by) 
            VALUES (?,?,?,?,?,?,?,?,?,?) RETURNING id");

            $stnt3 = $pdo->prepare("UPDATE term_record SET progress_status_start = ?, standing_start = ? WHERE term_id = ?");

                $params1 = array($termid,$spas_id,$sy,$term,$termtype,$startEnd,$course_id,$progressStat,$act_flag,$date,$created_by);
                $stnt1 -> execute($params1);
             
                 
                if($stnt1){
                    $errors[] =  true;
                } else{
            
                    $errors[] = false;
                }


                $params2 = array($termid,$spas_id,$sy,$term,$termtype,$startEnd,$standing,$act_flag,$date,$created_by);
                $stnt2 -> execute($params2);

                if($stnt2){
                    $errors[] =  true;
                } else{
            
                    $errors[] = false;
                }



                $sid = "";
                try{

                    $result = $stnt1->fetch();
                    $sid = $result["id"];
                   }catch(Exception $e){
                    echo $e;
                    }


                    $sid2 = "";
                try{

                    $result2 = $stnt2->fetch();
                    $sid2 = $result2["id"];
                   }catch(Exception $e){
                    echo $e;
                    }

                    $params3 = array($sid,$sid2,$termid);
                    $stnt3 -> execute($params3);
                    if($stnt3){
                        $errors[] =  true;
                    } else{

                     $errors[] = false;
                    }

                

                if(in_array(false, $errors)){
                    echo "false";
                    $pdo->rollback();
                } else{
                   echo "true";
                   $pdo->commit();
               }
           
        
            }

 
            // Create Progress Status End History


        if(isset($_GET['createPStatusEnd'])){
          try {

            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d h:i:s a");
    
            $termid = $_POST["termid"];
            $spas_id = $_POST["spasid"];
            $sy = $_POST["endPSsy"];
            $term = $_POST["endPSterm"];
            $termtype = $_POST["termtypes"];
            $startEnd = $_POST["endPStartEnd"];;
            $course_id = $_POST["courseid"];
            $progress_status = $_POST["endProgressStats"];
            $latest = $_POST["latest"] === 'YES' ? 1 : 0;
            $act_flag = true;
            $created_by = $_POST["user"];
            $act_taken = "CREATE";
            $act_message = "Created NEW Progress Status End in " . $spas_id. " with Term ID: " . $termid;

            $stntf = $pdo->prepare("SELECT full_name
            FROM scholars_record 
            WHERE spas_id = ?");

            $stntf->execute([$spas_id]); 
 
            while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
         
                $fname = $row['full_name'];    
        
            }


        
            $pdo->beginTransaction();
            $stnt = $pdo->prepare("INSERT INTO progress_status_history(term_id,spas_id,sy,term,term_type,start_end,course_id,progress_status,active_flag,latest_flag,created_at,created_by) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $params = array($termid,$spas_id,$sy,$term,$termtype,$startEnd,$course_id,$progress_status,$act_flag,$latest,$date,$created_by);
            if ($stnt -> execute($params)){
              $returnID = $pdo->lastInsertId();


              $stnt1 = $pdo->prepare("UPDATE term_record SET progress_status_end = ? WHERE term_id = ?");
              $stnt1->execute([$returnID, $termid]);


              $stnt2 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
              $params = array($spas_id,$fname,$act_taken,$act_message,$created_by,$date);
              $stnt2 -> execute($params);


            } else {
              throw new Exception('Transaction Failed.');
            }


             // Commit transaction
             $pdo->commit();
             echo json_encode(true);
         } catch (Exception $e) {
             // Rollback transaction on failure
             if ($pdo->inTransaction()) {
                     $pdo->rollBack();
                 }
             // Log or return the error
             echo json_encode(['error' => $e->getMessage()]);
         }
            
            }



             // Create Start Status Standing History



             if(isset($_GET['createEndStanding'])){
              try {

                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d h:i:s a");
        
                $termid = $_POST["termid"];
                $spas_id = $_POST["spasid"];
                $sy = $_POST["endTermScholyear"];
                $term = $_POST["endTermstate"];
                $termtype = $_POST["termtypes"];
                $startEnd = 2;   
                $standing = $_POST["endTermStandingSelect"];
                $act_flag = true;
                $latest = $_POST["latest"] === 'YES' ? 1 : 0;
                $created_by = $_POST["user"];

                $act_taken = "CREATE";
                $act_message = "Created NEW Term Standing End in " . $spas_id. " with Term ID: " . $termid;



                $stntf = $pdo->prepare("SELECT full_name
                FROM scholars_record 
                WHERE spas_id = ?");

                  $stntf->execute([$spas_id]); 
 
                while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
         
                $fname = $row['full_name'];    
        
                }

                $pdo->beginTransaction();
                $stnt = $pdo->prepare("INSERT INTO standing_history(term_id,spas_id,sy,term,term_type,start_end,standing,latest_flag,active_flag,created_at,created_by) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $params = array($termid,$spas_id,$sy,$term,$termtype,$startEnd,$standing,$latest,$act_flag,$date,$created_by);
                if ($stnt -> execute($params)){
                  $returnID = $pdo->lastInsertId();

                  $stnt1 = $pdo->prepare("UPDATE term_record SET standing_end = ? WHERE term_id = ?");
                  $stnt1->execute([$returnID, $termid]);


                  $stnt2 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
                  $params = array($spas_id,$fname,$act_taken,$act_message,$created_by,$date);
                  $stnt2 -> execute($params);

                } else {
                  throw new Exception('Transaction Failed.');
                }

                // Commit transaction
                $pdo->commit();
                echo json_encode(true);
                } catch (Exception $e) {
                // Rollback transaction on failure
                if ($pdo->inTransaction()) {
                     $pdo->rollBack();
                 }
                // Log or return the error
                echo json_encode(['error' => $e->getMessage()]);
                }      
                            
                }



        // Add New Scholarship Information



if(isset($_GET['newSCHInfo'])){

 
    $primary_spas = $_POST["pspas"];
    $pspasid_no_spaces = str_replace(' ', '', $primary_spas);
    $yr_awarded = $_POST["yrawarded"];
    $program = $_POST["program"];
    $subprogram = $_POST["subprogram"];
    $category = $_POST["category"];
    $schpaward = $_POST["schpaward"];
    $remarks = $_POST["remarks"];
   
    
    $stnt = $pdo->prepare("INSERT INTO scholarship_info(spas_id,primary_spas_id,yr_awarded,program,sub_program,category,schp_award,remarks) VALUES 
    (?,?,?,?,?,?,?,?)");
    $params = array($pspasid_no_spaces,$pspasid_no_spaces,$yr_awarded,$program,$subprogram,$category,$schpaward,$remarks);
    $stnt -> execute($params);

    if($stnt){
        $result =  true;
    } else{

        $result = false;
    }

    echo json_encode($result);


}




       

        



// Print Receipt


if(isset($_GET['printReceipt'])){

    // 
    $spasid = $_POST["spasid"];
     $sy = $_POST["sy"];

     $amount = (string)$_POST["amount"];

     $cards = json_decode($_POST['cards'], true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON error: ' . json_last_error_msg();
        exit;
    }

    // Debugging: Check if cards are being received properly
    print_r($cards);

     $stnt = $pdo->prepare("SELECT * FROM scholars_record WHERE spas_id = ?");
        $stnt->execute([$spasid]);
    
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            
             $fname = $row['full_name'];
           
    }
    
   
    
    
    
    
    
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    
    // ---------------------------------------------------------


    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Financial Statement');
    $pdf->SetSubject('Financial Records');
    $pdf->SetKeywords('TCPDF, PDF, table, CSS');
    
    $pdf->AddPage();
   
    $pdf->SetFont('courier', 'B', 14); // Set font to bold (B) with size 14
    $pdf->Cell(0, 22, 'Financial Statement', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->SetFont('courier', '', 10, '', true);


    $pdf->ln(3);
    $pdf->Cell(90,10,'SPAS ID: '.$spasid, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Cell(90,10,'Name: '.$fname, 0, 1, 'R', 0, '', 0, false, 'M', 'M');


    $pdf->Ln(0); // Set to 0 to remove extra space between lines
    $pdf->MultiCell(90, 5, 'School Year: '.$sy, 0, 'L', 0, 0, '', '', true); // Adjust height to 5
    $pdf->Ln(3); // Add vertical space before the next section

// $pdf->MultiCell(90, 10, 'Status(START): '.$stat1.'-'.$stat2, 0, 'R', 0, 1, '', '', true);

    $pdf->Ln(10); // Add extra line spacing

    // Set table header
    $html = '<style>
    th {
      text-align: center;
      font-weight: bold;
    }
    
    td {
      text-align: center;
    }
  </style>
    <h3>Financial Records</h3>';
    $html .= '<table border="0" cellpadding="4">
                <thead>
                    <tr>
                    <th>School Year / Sem</th>
                        <th>Category</th>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Date Process</th>
                        <th>Amount</th>
                        <th>Date Deposit</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>';



                // Populate table rows
                foreach ($cards as $item) {
                    $html .= '<tr>
                    <td>' . htmlspecialchars($item['termwthRec'] ?? '') . '</td>
                            <td>' . htmlspecialchars($item['itemType'] ?? '') . '</td>
                            <td>' . htmlspecialchars($item['year'] ?? '') . '</td>
                            <td>' . htmlspecialchars($item['month'] ?? '') . '</td>
                            <td>' . htmlspecialchars($item['dateProcess'] ?? '') . '</td>
                            <td>' . htmlspecialchars($item['amount'] ?? '') . '</td>
                            <td>' . htmlspecialchars($item['dateDeposit'] ?? '') . '</td>
                            <td>' . htmlspecialchars($item['remarks'] ?? '') . '</td>
                          </tr>';
                }

    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, false, false, '');
    // $pdf->writeHTML($html);

    $pdf->ln(3);
    $pdf->Cell(90,10,'Total Amount: '.$amount, 0, 0, 'L', 0, '', 0, false, 'M', 'M');




    // OutPDF
    
    ob_end_clean();
$pdf->Output('Financial_Statement.pdf', 'I');


    
         }





          // Create Financial Records 


         if (isset($_GET['createFinancialRec'])) {
            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d h:i:s a");
        
            // Check if necessary POST data exists
            if (isset($_POST["user"], $_POST["spasid"], $_POST["sy"], $_POST["cards"])) {
                $createdby = $_POST["user"];
                $spasid = $_POST["spasid"];
                $sy = $_POST["sy"];
                $total_amt = $_POST["totalAmount"];
        
                $results = []; // Initialize the results array before the loop
        
                try {
                    $pdo->beginTransaction();
        
                    // Insert into financial_r
                    $stnt0 = $pdo->prepare("INSERT INTO financial_release(spas_id, sy, total_amt, created_at, created_by) VALUES (?,?,?,?,?)");
                    if ($stnt0->execute([$spasid, $sy, $total_amt, $date, $createdby])) {
                        $sid = $pdo->lastInsertId();
        
                        foreach ($_POST['cards'] as $card) {
                            // Ensure 'termwthRec' exists within each card
                            if (isset($card['termwthRec'], $card['items'])) {
                                $termwthRec = $card['termwthRec'];
                                
                                foreach ($card['items'] as $item) {
                                    // Check that all necessary fields are set
                                    if (isset($item['itemType'], $item['year'], $item['month'], $item['dateProcess'], $item['amount'], $item['dateDeposit'], $item['remarks'])) {
                                        $itemType = (int)$item['itemType'];
                                        // $year = (int)$item['year'];
                                        $month = (int)$item['month'];
                                        $dateProcess = $item['dateProcess'];
                                        $amount = $item['amount'];
                                        // $dateDeposit = $item['dateDeposit'];
                                        $remarks = $item['remarks'];


                                        $year = $item['year'];
                                        if (empty($year)) {
                                        $year = null; // Ensure NULL is passed
                                        }

                                        $month = $item['month'];
                                        if (empty($month)) {
                                        $month = null; // Ensure NULL is passed
                                        }

                                        $dateDeposit = $item['dateDeposit'];
                                        if (empty($dateDeposit) || $dateDeposit === 'mm/dd/yyyy') {
                                        $dateDeposit = null; // Ensure NULL is passed
                                        }


        
                                        // Prepare and execute the SQL statement
                                        $stnt = $pdo->prepare("INSERT INTO financial_statement(financial_release_id, term_id, category, year, month, date_process, amount, date_deposit, remarks, created_by, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                                        $success = $stnt->execute([$sid, $termwthRec, $itemType, $year, $month, $dateProcess, $amount, $dateDeposit, $remarks, $createdby, $date]);
        
                                        // Collect the result of each update
                                        $results[] = $success;
                                    } else {
                                        // If any required item data is missing, add `false` to results and break the loop
                                        $results[] = false;
                                        break 2; // Exit both loops
                                    }
                                }
                            } else {
                                $results[] = false; // Missing 'termwthRec' or 'items' in a card
                                break;
                            }
                        }
        
                        // Commit the transaction if all queries were successful
                        if (!in_array(false, $results)) {
                            $pdo->commit();
                            echo json_encode(true); // Success response as JSON-encoded true
                        } else {
                            $pdo->rollBack();
                            echo json_encode(false); // Failure response as JSON-encoded false
                        }
                    } else {
                        throw new Exception('Failed to insert into financial_release.');
                    }
                } catch (Exception $e) {
                    $pdo->rollBack();
                    echo json_encode(["success" => false, "error" => $e->getMessage()]);
                    // echo json_encode(false); // Error response as JSON-encoded false
                }
            } else {
                echo json_encode(false); // Missing required POST data response as JSON-encoded false
            }
        }




        // Bulk Upload of Financials



if (isset($_GET['batchUploadFinancial'])) {

    date_default_timezone_set('Asia/Manila');
    $date = date("Ymdhi");
    $dates = date("Y-m-d h:i:s a");
    $uname = $_POST["usercreator"];
    $authid = $_POST["authid"];

    // Bulk Upload
    $batchFile = $_FILES['fileUpload']['name'];
    $path = 'batch/';
    $allowed_extensions = array('csv');
    $extension = pathinfo($batchFile, PATHINFO_EXTENSION);

    if (in_array(strtolower($extension), $allowed_extensions)) {

        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }

        $temp_file = $_FILES['fileUpload']['tmp_name'];
        $newpath = $path . $authid . $uname . $date . "." . $extension;

        if (move_uploaded_file($temp_file, $newpath)) {
            // File uploaded successfully
        } else {
            echo json_encode(false);
            return;
        }

    } else {
        echo json_encode(false);
        return;
    }

    if ($newpath !== "No_Files") {
        // Open the file for reading
        $file = fopen($newpath, "r");
        if ($file !== false) {
            $b = false;
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if (!$b) {
                    $b = true;
                    continue; // Skip the header row
                }

                // Process each row
                $termids = $emapData[0] . $emapData[1] . $emapData[2] . $emapData[3];

                // Fetch the category ID
                $stntf = $pdo->prepare("SELECT id FROM lu_allowances WHERE name = ?");
                $stntf->execute([$emapData[4]]);
                $categ_id = null;
                if ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {
                    $categ_id = $row['id'];
                }

                if ($categ_id) {
                    // Insert data into financial_statement table
                    $stnt = $pdo->prepare("INSERT INTO financial_statement(term_id, category, year, month, date_process, amount, date_deposit, remarks, created_by, created_at) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $params = array($termids, $categ_id, $emapData[5], $emapData[6], $emapData[7], $emapData[8], $emapData[9], $emapData[10], $uname, $dates);
                    $stnt->execute($params);
                }
            }
            fclose($file); // Close the file after processing

            // Echo true in JSON format
            echo json_encode(true);
            return;
        } else {
            echo json_encode(false);
            return;
        }
    }
}





// Terminated Scholars



if(isset($_GET['sendMailScholar'])){


            $emails = $_POST["scholar_email"];
            



            $mail = new PHPMailer(true);


            // Outlook E-mail Address


    // $mail->isSMTP();
    // $mail->Host = 'smtp.office365.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'jrcastanares@sei.dost.gov.ph';
    // $mail->Password = '@cc3$$D3n!3d1432';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = 587;


    // $mail->setFrom('jrcastanares@sei.dost.gov.ph');



     $mail->isSMTP();
     $mail->Host = 'smtp.gmail.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'castanares.jonathan01@gmail.com';
     $mail->Password = 'otmj sano ozit fmgi';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port = 587;


     $mail->setFrom('castanares.jonathan01@gmail.com');
    
    $mail->addAddress($emails);


     if (isset($_FILES["attachFile"])) {
    $attachfile = $_FILES["attachFile"];

    if (!empty($attachfile) && $attachfile['error'] === UPLOAD_ERR_OK) {
        $mail->addAttachment($attachfile['tmp_name'], $attachfile['name']);
    }
    }


    

    $mail->isHTML(true);

    $mail->Subject = "DOST-SEI E-Mail Memo";
    $mail->Body    = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Termination Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Scholarship Termination Notice</div>
        <div class="content">
            <p>Dear Scholar,</p>
            <p>We regret to inform you that your scholarship has been terminated due to the reason provided in the memorandum for scholars attached to this email.</p>
            <p>This decision has been made in accordance with the scholarship program policies and guidelines.</p>
            <p>If you have any questions or believe this decision was made in error, please contact us immediately.</p>
            <p>We appreciate your efforts and encourage you to continue pursuing your academic goals.</p>
            <p>Best regards,</p>
            
        </div>
        <div class="footer">
            <p>&copy; DEPARTMENT OF SCIENCE AND TECHNOLOGY - SCIENCE EDUCATION INSTITUTE</p>
        </div>
    </div>
</body>
</html>';

    $mail->send();

    if($mail){
        $result =  true;
    } else{
        
        $result = false;
    }

    echo json_encode($result);


        }




// Submit Grades E-mail





        if(isset($_GET['sendMailSubmitGrades'])){


            $emails = $_POST["scholar_email"];
            



            $mail = new PHPMailer(true);


            // Outlook E-mail Address


    // $mail->isSMTP();
    // $mail->Host = 'smtp.office365.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'jrcastanares@sei.dost.gov.ph';
    // $mail->Password = '@cc3$$D3n!3d1432';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = 587;


    // $mail->setFrom('jrcastanares@sei.dost.gov.ph');



     $mail->isSMTP();
     $mail->Host = 'smtp.gmail.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'castanares.jonathan01@gmail.com';
     $mail->Password = 'otmj sano ozit fmgi';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port = 587;


     $mail->setFrom('castanares.jonathan01@gmail.com');
    
    $mail->addAddress($emails);


     if (isset($_FILES["attachFile"])) {
    $attachfile = $_FILES["attachFile"];

    if (!empty($attachfile) && $attachfile['error'] === UPLOAD_ERR_OK) {
        $mail->addAttachment($attachfile['tmp_name'], $attachfile['name']);
    }
    }


    

    $mail->isHTML(true);

    $mail->Subject = "DOST-SEI E-Mail Memo";
    $mail->Body    = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Submission Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Grade Submission Reminder</div>
        <div class="content">
            <p>Dear Scholar,</p>
            <p>We hope this email finds you well. This is a gentle reminder that you are required to submit your grades for the current academic term.</p>
            <p>Kindly ensure that you submit your grades before the deadline to maintain your scholarship eligibility.</p>
            <p>If you have already submitted your grades, please disregard this message.</p>
            <p>Kindly see attached pdf document of memorandum to scholars.</p>
            <p style="text-align: center;">
            <p>For any inquiries, please do not hesitate to contact us.</p>
            <p>Best regards,</p>
         
        </div>
        <div class="footer">
            <p>&copy; DEPARTMENT OF SCIENCE AND TECHNOLOGY - SCIENCE EDUCATION INSTITUTE</p>
        </div>
    </div>
</body>
</html>
';

    $mail->send();

    if($mail){
        $result =  true;
    } else{
        
        $result = false;
    }

    echo json_encode($result);


        }








        // Continued Scholarship Memorandum





        if(isset($_GET['sendMailContinued'])){


            $emails = $_POST["scholar_email"];
            



            $mail = new PHPMailer(true);


            // Outlook E-mail Address


    // $mail->isSMTP();
    // $mail->Host = 'smtp.office365.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'jrcastanares@sei.dost.gov.ph';
    // $mail->Password = '@cc3$$D3n!3d1432';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = 587;


    // $mail->setFrom('jrcastanares@sei.dost.gov.ph');



     $mail->isSMTP();
     $mail->Host = 'smtp.gmail.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'castanares.jonathan01@gmail.com';
     $mail->Password = 'otmj sano ozit fmgi';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port = 587;


     $mail->setFrom('castanares.jonathan01@gmail.com');
    
    $mail->addAddress($emails);


     if (isset($_FILES["attachFile"])) {
    $attachfile = $_FILES["attachFile"];

    if (!empty($attachfile) && $attachfile['error'] === UPLOAD_ERR_OK) {
        $mail->addAttachment($attachfile['tmp_name'], $attachfile['name']);
    }
    }


    

    $mail->isHTML(true);

    $mail->Subject = "DOST-SEI E-Mail Memo";
    $mail->Body    = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Continuation Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Scholarship Continuation Notice</div>
        <div class="content">
            <p>Dear Scholar,</p>
            <p>We are pleased to inform you that your scholarship has been reinstated following your successful resolution of deficiencies and passing all required subjects.</p>
            <p>Your dedication and commitment to your studies have been recognized, and as a result, your scholarship will continue as per the programs policies.</p>
            <p>We encourage you to maintain your academic progress and uphold the standards of the scholarship program.</p>
            <p>Kindly see attached pdf document regarding the memo for continued scholarship.</p>
            <p>If you have any questions or require further assistance, please do not hesitate to contact us.</p>
            <p>Best regards,</p>
        </div>
        <div class="footer">
            <p>&copy; DEPARTMENT OF SCIENCE AND TECHNOLOGY - SCIENCE EDUCATION INSTITUTE</p>
        </div>
    </div>
</body>
</html>

';

    $mail->send();

    if($mail){
        $result =  true;
    } else{
        
        $result = false;
    }

    echo json_encode($result);


        }




        // Partial Allowance Memorandum





        if(isset($_GET['sendMailPartial'])){


            $emails = $_POST["scholar_email"];
            



            $mail = new PHPMailer(true);


            // Outlook E-mail Address


    // $mail->isSMTP();
    // $mail->Host = 'smtp.office365.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'jrcastanares@sei.dost.gov.ph';
    // $mail->Password = '@cc3$$D3n!3d1432';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = 587;


    // $mail->setFrom('jrcastanares@sei.dost.gov.ph');



     $mail->isSMTP();
     $mail->Host = 'smtp.gmail.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'castanares.jonathan01@gmail.com';
     $mail->Password = 'otmj sano ozit fmgi';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port = 587;


     $mail->setFrom('castanares.jonathan01@gmail.com');
    
    $mail->addAddress($emails);


     if (isset($_FILES["attachFile"])) {
    $attachfile = $_FILES["attachFile"];

    if (!empty($attachfile) && $attachfile['error'] === UPLOAD_ERR_OK) {
        $mail->addAttachment($attachfile['tmp_name'], $attachfile['name']);
    }
    }


    

    $mail->isHTML(true);

    $mail->Subject = "DOST-SEI E-Mail Memo";
    $mail->Body    = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Partial Payment Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Scholarship Partial Payment Notice</div>
        <div class="content">
            <p>Dear Scholar,</p>
            <p>We would like to inform you that due to existing deficiencies in your academic performance, your scholarship payment will be processed on a partial basis.</p>
            <p>To receive full scholarship benefits, please ensure that you address and resolve the deficiencies in accordance with the scholarship programs requirements.</p>
            <p>Kindly see attached memorandum for scholarship partial allowance.</p>
            <p>If you need any assistance or have any questions, please reach out to our office for further guidance.</p>
            <p>We encourage you to stay committed to your academic progress.</p>
            <p>Best regards,</p>
           
        </div>
        <div class="footer">
            <p>&copy; DEPARTMENT OF SCIENCE AND TECHNOLOGY - SCIENCE EDUCATION INSTITUTE</p>
        </div>
    </div>
</body>
</html>';

    $mail->send();

    if($mail){
        $result =  true;
    } else{
        
        $result = false;
    }

    echo json_encode($result);


        }





        // Scholar Status Memorandum





        if(isset($_GET['sendMailScholarStatus'])){


            $emails = $_POST["scholar_email"];
            



            $mail = new PHPMailer(true);


            // Outlook E-mail Address


    // $mail->isSMTP();
    // $mail->Host = 'smtp.office365.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'jrcastanares@sei.dost.gov.ph';
    // $mail->Password = '@cc3$$D3n!3d1432';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = 587;


    // $mail->setFrom('jrcastanares@sei.dost.gov.ph');



     $mail->isSMTP();
     $mail->Host = 'smtp.gmail.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'castanares.jonathan01@gmail.com';
     $mail->Password = 'otmj sano ozit fmgi';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port = 587;


     $mail->setFrom('castanares.jonathan01@gmail.com');
    
    $mail->addAddress($emails);


     if (isset($_FILES["attachFile"])) {
    $attachfile = $_FILES["attachFile"];

    if (!empty($attachfile) && $attachfile['error'] === UPLOAD_ERR_OK) {
        $mail->addAttachment($attachfile['tmp_name'], $attachfile['name']);
    }
    }


    

    $mail->isHTML(true);

    $mail->Subject = "DOST-SEI E-Mail Memo";
    $mail->Body    = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Scholarship Status Update</div>
        <div class="content">
            <p>Dear Scholar,</p>
            <p>We would like to update you on the current status of your scholarship. Please find the detailed information regarding your scholarship status in the attached pdf document.</p>
            <p>If further action is required on your part, please ensure that you comply with the scholarship program’s requirements to maintain your eligibility.</p>
            <p>If you have any questions or need assistance, please feel free to contact our office.</p>
            <p>We appreciate your dedication to your studies and encourage you to continue striving for excellence.</p>
            <p>Best regards,</p>
            
        </div>
        <div class="footer">
            <p>&copy; DEPARTMENT OF SCIENCE AND TECHNOLOGY - SCIENCE EDUCATION INSTITUTE</p>
        </div>
    </div>
</body>
</html>';

    $mail->send();

    if($mail){
        $result =  true;
    } else{
        
        $result = false;
    }

    echo json_encode($result);


        }

















































// Developed By: CASTAÑARES, JONATHAN R.
?>