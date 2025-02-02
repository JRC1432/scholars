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






        if(isset($_GET['sendMailScholar'])){


            $emails = $_POST["scholar_email"];



            $mail = new PHPMailer(true);


    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jrcastanares@sei.dost.gov.ph';
    $mail->Password = '@cc3$$D3n!3d1432';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;


    $mail->setFrom('jrcastanares@sei.dost.gov.ph');
    $mail->addAddress($emails);

    

    $mail->isHTML(true);

    $mail->Subject = "DOST-SEI E-Mail Memo";
    $mail->Body    = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="x-apple-disable-message-reformatting">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  
    <style type="text/css">
      
      @media only screen and (min-width: 620px) {
        .u-row {
          width: 600px !important;
        }

        .u-row .u-col {
          vertical-align: top;
        }

        
            .u-row .u-col-100 {
              width: 600px !important;
            }
          
      }

      @media only screen and (max-width: 620px) {
        .u-row-container {
          max-width: 100% !important;
          padding-left: 0px !important;
          padding-right: 0px !important;
        }

        .u-row {
          width: 100% !important;
        }

        .u-row .u-col {
          display: block !important;
          width: 100% !important;
          min-width: 320px !important;
          max-width: 100% !important;
        }

        .u-row .u-col > div {
          margin: 0 auto;
        }


        .u-row .u-col img {
          max-width: 100% !important;
        }

}
    
body{margin:0;padding:0}table,td,tr{border-collapse:collapse;vertical-align:top}p{margin:0}.ie-container table,.mso-container table{table-layout:fixed}*{line-height:inherit}a[x-apple-data-detectors=true]{color:inherit!important;text-decoration:none!important}


@media (max-width: 480px) {
            .hide-mobile {
              
              max-height: 0px;
              overflow: hidden;
    
              display: none !important;
            }
          }
          

table, td { color: #000000; } #u_body a { color: #0000ee; text-decoration: underline; } @media (max-width: 480px) { #u_content_heading_1 .v-container-padding-padding { padding: 30px 10px 20px !important; } #u_content_heading_1 .v-font-size { font-size: 24px !important; } #u_content_image_1 .v-container-padding-padding { padding: 45px 10px 10px !important; } #u_content_heading_2 .v-font-size { font-size: 20px !important; } #u_content_text_1 .v-container-padding-padding { padding: 10px !important; } #u_content_button_1 .v-size-width { width: 65% !important; } #u_content_button_1 .v-container-padding-padding { padding: 10px 10px 40px !important; } #u_content_text_3 .v-container-padding-padding { padding: 40px 10px 10px !important; } #u_content_menu_1 .v-padding { padding: 5px 10px !important; } }
    </style>
  
  

<!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Raleway:400,700&display=swap" rel="stylesheet" type="text/css"><!--<![endif]-->

</head>

<body class="clean-body u_body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">
  <!--[if IE]><div class="ie-container"><![endif]-->
  <!--[if mso]><div class="mso-container"><![endif]-->
  <table id="u_body" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%" cellpadding="0" cellspacing="0">
  <tbody>
  <tr style="vertical-align: top">
    <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #e7e7e7;"><![endif]-->
    
  
  
<div class="u-row-container" style="padding: 0px;background-color: transparent">
  <div class="u-row" style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
      <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: transparent;"><![endif]-->
      
<!--[if (mso)|(IE)]><td align="center" width="600" style="background-color: #e9e9e9;width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
  <div style="background-color: #e9e9e9;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
  <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]-->
  
<table id="u_content_heading_1" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:40px 10px 30px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <!--[if mso]><table width="100%"><tr><td><![endif]-->
    <h1 class="v-font-size" style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-size: 28px; font-weight: 400;"><strong>Department of Science ad Technology - Science Education Institute</strong></h1>
  <!--[if mso]></td></tr></table><![endif]-->

      </td>
    </tr>
  </tbody>
</table>

  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
  </div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
      <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
    </div>
  </div>
  </div>
  


  
  
<div class="u-row-container" style="padding: 0px;background-color: transparent">
  <div class="u-row" style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
      <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: transparent;"><![endif]-->
      
<!--[if (mso)|(IE)]><td align="center" width="600" style="background-color: #ffffff;width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
  <div style="background-color: #ffffff;height: 100%;width: 100% !important;">
  <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->
  
<table id="u_content_image_1" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:80px 10px 10px;font-family:arial,helvetica,sans-serif;" align="left">
        
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td style="padding-right: 0px;padding-left: 0px;" align="center">
      
      <img align="center" border="0" src="images/image-1.png" alt="image" title="image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 50%;max-width: 290px;" width="290"/>
      
    </td>
  </tr>
</table>

      </td>
    </tr>
  </tbody>
</table>

<table id="u_content_heading_2" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:20px 10px 10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <!--[if mso]><table width="100%"><tr><td><![endif]-->
    <h1 class="v-font-size" style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-size: 25px; font-weight: 400;"><span>A Journey of Success<br />Celebrate Our Milestone with Us!</span></h1>
  <!--[if mso]></td></tr></table><![endif]-->

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="19%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 5px solid #0202aa;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
      <tr style="vertical-align: top">
        <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
          <span>&#160;</span>
        </td>
      </tr>
    </tbody>
  </table>

      </td>
    </tr>
  </tbody>
</table>

<table id="u_content_text_1" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 60px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <div class="v-font-size" style="font-size: 14px; color: #616161; line-height: 140%; text-align: center; word-wrap: break-word;">
    <p style="line-height: 140%;"><span style="font-family: Raleway, sans-serif; line-height: 19.6px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ut labore et dolore magna aliqua. Quis ipsum suspen disse ultrices gravida. Risus commodo viverra dolor sit.</span></p>
  </div>

      </td>
    </tr>
  </tbody>
</table>

<table id="u_content_button_1" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 60px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <!--[if mso]><style>.v-button {background: transparent !important;}</style><![endif]-->
<div align="center">
  <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://unlayer.com" style="height:37px; v-text-anchor:middle; width:180px;" arcsize="11%"  stroke="f" fillcolor="#0202aa"><w:anchorlock/><center style="color:#FFFFFF;"><![endif]-->
    <a href="https://unlayer.com" target="_blank" class="v-button v-size-width v-font-size" style="box-sizing: border-box;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #0202aa; border-radius: 4px;-webkit-border-radius: 4px; -moz-border-radius: 4px; width:31%; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 14px;">
      <span class="v-padding" style="display:block;padding:10px 20px;line-height:120%;"><span style="font-size: 14px; line-height: 16.8px;">Read More</span></span>
    </a>
    <!--[if mso]></center></v:roundrect><![endif]-->
</div>

      </td>
    </tr>
  </tbody>
</table>

  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
  </div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
      <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
    </div>
  </div>
  </div>
  


  
  
<div class="u-row-container" style="padding: 0px;background-color: transparent">
  <div class="u-row" style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
      <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: transparent;"><![endif]-->
      
<!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
  <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
  <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]-->
  
<table id="u_content_text_3" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:40px 80px 10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <div class="v-font-size" style="font-size: 14px; color: #5b5b5b; line-height: 160%; text-align: center; word-wrap: break-word;">
    <p style="font-size: 14px; line-height: 160%;">if you have any questions, please email us at <a rel="noopener" href="https://sei.dost.gov.ph/#/" target="_blank">sei.dost.gov.ph</a> or visit our FAQS, you can also chat with a reel live human during our operating hours. They can answer questions about your account</p>
  </div>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:20px 0px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
      <tr style="vertical-align: top">
        <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
          <span>&#160;</span>
        </td>
      </tr>
    </tbody>
  </table>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
<div align="center" style="direction: ltr;">
  <div style="display: table; max-width:187px;">
  <!--[if (mso)|(IE)]><table width="187" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-collapse:collapse;" align="center"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace: 0pt;mso-table-rspace: 0pt; width:187px;"><tr><![endif]-->
  
    
    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 15px;" valign="top"><![endif]-->
    <table border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
      <tbody><tr style="vertical-align: top"><td valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <a href="https://www.facebook.com/unlayer" title="Facebook" target="_blank">
          <img src="images/image-2.png" alt="Facebook" title="Facebook" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
        </a>
      </td></tr>
    </tbody></table>
    <!--[if (mso)|(IE)]></td><![endif]-->
    
    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 15px;" valign="top"><![endif]-->
    <table border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
      <tbody><tr style="vertical-align: top"><td valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <a href="https://www.linkedin.com/company/unlayer/mycompany/" title="LinkedIn" target="_blank">
          <img src="images/image-3.png" alt="LinkedIn" title="LinkedIn" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
        </a>
      </td></tr>
    </tbody></table>
    <!--[if (mso)|(IE)]></td><![endif]-->
    
    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 15px;" valign="top"><![endif]-->
    <table border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
      <tbody><tr style="vertical-align: top"><td valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <a href="https://www.instagram.com/unlayer_official/" title="Instagram" target="_blank">
          <img src="images/image-4.png" alt="Instagram" title="Instagram" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
        </a>
      </td></tr>
    </tbody></table>
    <!--[if (mso)|(IE)]></td><![endif]-->
    
    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 0px;" valign="top"><![endif]-->
    <table border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 0px">
      <tbody><tr style="vertical-align: top"><td valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <a href="https://twitter.com/unlayerapp" title="X" target="_blank">
          <img src="images/image-5.png" alt="X" title="X" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
        </a>
      </td></tr>
    </tbody></table>
    <!--[if (mso)|(IE)]></td><![endif]-->
    
    
    <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
  </div>
</div>

      </td>
    </tr>
  </tbody>
</table>

<table id="u_content_menu_1" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
<div class="menu" style="text-align:center;">
<!--[if (mso)|(IE)]><table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style=""><tr><![endif]-->

  <!--[if (mso)|(IE)]><td style="padding:5px 15px"><![endif]-->
  
    <a href="https://www.unlayer.com" target="_self" style="padding:5px 15px;display:inline-block;color:#5b5b5b;font-size:14px;text-decoration:none"  class="v-padding v-font-size">
      Home
    </a>
  
  <!--[if (mso)|(IE)]></td><![endif]-->
  
    <!--[if (mso)|(IE)]><td style="padding:5px 15px"><![endif]-->
    <span style="padding:5px 15px;display:inline-block;color:#5b5b5b;font-size:14px;" class="v-padding v-font-size hide-mobile">
      |
    </span>
    <!--[if (mso)|(IE)]></td><![endif]-->
  

  <!--[if (mso)|(IE)]><td style="padding:5px 15px"><![endif]-->
  
    <a href="https://www.unlayer.com" target="_self" style="padding:5px 15px;display:inline-block;color:#5b5b5b;font-size:14px;text-decoration:none"  class="v-padding v-font-size">
      Page
    </a>
  
  <!--[if (mso)|(IE)]></td><![endif]-->
  
    <!--[if (mso)|(IE)]><td style="padding:5px 15px"><![endif]-->
    <span style="padding:5px 15px;display:inline-block;color:#5b5b5b;font-size:14px;" class="v-padding v-font-size hide-mobile">
      |
    </span>
    <!--[if (mso)|(IE)]></td><![endif]-->
  

  <!--[if (mso)|(IE)]><td style="padding:5px 15px"><![endif]-->
  
    <a href="https://www.unlayer.com" target="_self" style="padding:5px 15px;display:inline-block;color:#5b5b5b;font-size:14px;text-decoration:none"  class="v-padding v-font-size">
      About Us
    </a>
  
  <!--[if (mso)|(IE)]></td><![endif]-->
  
    <!--[if (mso)|(IE)]><td style="padding:5px 15px"><![endif]-->
    <span style="padding:5px 15px;display:inline-block;color:#5b5b5b;font-size:14px;" class="v-padding v-font-size hide-mobile">
      |
    </span>
    <!--[if (mso)|(IE)]></td><![endif]-->
  

  <!--[if (mso)|(IE)]><td style="padding:5px 15px"><![endif]-->
  
    <a href="https://www.unlayer.com" target="_self" style="padding:5px 15px;display:inline-block;color:#5b5b5b;font-size:14px;text-decoration:none"  class="v-padding v-font-size">
      Contact US
    </a>
  
  <!--[if (mso)|(IE)]></td><![endif]-->
  

<!--[if (mso)|(IE)]></tr></table><![endif]-->
</div>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 40px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <div class="v-font-size" style="font-size: 14px; color: #5b5b5b; line-height: 160%; text-align: center; word-wrap: break-word;">
    <p style="font-size: 14px; line-height: 160%;">you have received this email as a registered user of <a rel="noopener" href="https://www.unlayer.com" target="_blank">yourcompany.com</a></p>
<p style="font-size: 14px; line-height: 160%;">can <a rel="noopener" href="https://www.unlayer.com" target="_blank">unsubscribe</a> from these emails here.</p>
<p style="font-size: 14px; line-height: 160%;"> </p>
<p style="font-size: 14px; line-height: 160%;">2361 Market Street #4567 San Francisco, CA 94124 All rights reserved</p>
  </div>

      </td>
    </tr>
  </tbody>
</table>

  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
  </div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
      <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
    </div>
  </div>
  </div>
  


    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
    </td>
  </tr>
  </tbody>
  </table>
  <!--[if mso]></div><![endif]-->
  <!--[if IE]></div><![endif]-->
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















































// Developed By: CASTAÑARES, JONATHAN R.
?>