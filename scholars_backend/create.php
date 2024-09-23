<?php

require("dbconn.php");
require("Encrypt.php");
require("Decrypt.php");
require('vendor/tecnickcom/tcpdf/tcpdf.php');

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


    $pdo->beginTransaction();
    $stnt = $pdo->prepare("INSERT INTO users(internal_id,username,password,account_type,region,school_code,date_added) VALUES (?,?,?,?,?,?,?) RETURNING ID");
    $stntp = $pdo->prepare("INSERT INTO scholars_record(spas_id,user_id,first_name,middle_name,last_name,suffix_name,full_name,sex,dob,pob,tribe,school_region,school_code,
    street,village,barangay,municipality,province,region,district,zipcode,email,contact_no,diff_curr_add) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stnta = $pdo->prepare("INSERT INTO curr_add(spas_id,street,village,barangay,municipality,province,region,district,zipcode) VALUES (?,?,?,?,?,?,?,?,?)");

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

    $spasid = $_POST["spasid"];
    $reply = $_POST["reply"];
    $daterep = $_POST["daterep"];
    $reply_reason = $_POST["reply_reason"];
    $reply_reason2 = strtoupper($reply_reason);
    $verified = true;


    $stnt = $pdo->prepare("INSERT INTO reply_slip_details(spas_id,reply_slip,date_reply,reason,created_by,updated_by,verified_flag,verified_by) VALUES 
    (?,?,?,?,?,?,?,?)");
    $params = array($spasid,$reply,$daterep,$reply_reason2,$uploaded_by,$uploaded_by,$verified,$uploaded_by);
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


    

    $pdf->Ln(0); // Set to 0 to remove extra space between lines
$pdf->MultiCell(90, 5, 'School Year: '.$sy.', '.$sem, 0, 'L', 0, 0, '', '', true); // Adjust height to 5
$pdf->MultiCell(90, 5, 'Term Required: '.$termreq, 0, 'R', 0, 1, '', '', true);
$pdf->MultiCell(90, 5, 'Course: '.$course, 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(90, 5, 'Status(Start): '.$statStart.'-'.$statEnd, 0, 'R', 0, 1, '', '', true);
$pdf->MultiCell(90, 10, 'School: '.$school, 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(90, 10, 'Status(END): '.$stat1.'-'.$stat2, 0, 'R', 0, 1, '', '', true);



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


     $sy = $_POST["sy"];
     $sem = $_POST["sem"];
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
    $uploaded_by = $_POST["user"];

    $spasid = $_POST["spasid"];
    $school = $_POST["school"];
    $courses = $_POST["courses"];
    $sy = $_POST["sy"];
    $courses = $_POST["termtype"];
    $sy = $_POST["term"];
   

    $stnt = $pdo->prepare("INSERT INTO course_record(spas_id,reply_slip,date_reply,reason,created_by,updated_by,verified_flag,verified_by) VALUES 
    (?,?,?,?,?,?,?,?)");
    $params = array($spasid,$reply,$daterep,$reply_reason2,$uploaded_by,$uploaded_by,$verified,$uploaded_by);
    $stnt -> execute($params);

    if($stnt){
        $result =  true;
    } else{

        $result = false;
    }

    echo json_encode($result);


}
















?>