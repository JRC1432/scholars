<?php

require("dbconn.php");
require("Encrypt.php");
require("Decrypt.php");

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








?>