<?php

require("dbconn.php");

// Update User

if(isset($_GET['updateuser'])){

    $upintid = $_POST["upintid"];
    $upusernames = $_POST["upusernames"];
    $uppassword = $_POST["uppassword"];
    $upacttype = $_POST["upacttype"];
    $passwordsHash = sha1("digi".$uppassword."digi");
    $upregions = $_POST["upregions"];
    $upcode = $_POST["upcode"];
    $upid = $_POST["id"];
    
    
    $stnt = $pdo->prepare("UPDATE users SET username = ?, internal_id = ?, password = ?, account_type = ?, region = ?, school_code = ?
    WHERE id = ?");
    $stnt->execute([$upusernames,$upintid,$passwordsHash,$upacttype,$upregions,$upcode,$upid]);
    
     if($stnt){
            $result =  true;
        } else{
            
            $result = false;
        }
    
        echo json_encode($result);
    
    }


    // Update User Information




    if(isset($_GET['updateuserInfo'])){

        $upid = $_POST["id"];

        $upstaffid = $_POST["upstaffid"];
        $upfname = $_POST["upfname"];
        $upmname = $_POST["upmname"];
        $uplname = $_POST["uplname"];
        $upsname = $_POST["upsname"];
        $upgender = $_POST["upgender"];
        $upbirth = $_POST["upbirth"];
        $uppob = $_POST["uppob"];
        $upwregion = $_POST["upwregion"];
        $upscCode = $_POST["upscCode"];

        $upstreet = $_POST["upstreet"];
        $upvillage = $_POST["upvillage"];
        $upbarangay = $_POST["upbarangay"];
        $upmunicipality = $_POST["upmunicipality"];
        $upprovince = $_POST["upprovince"];
        $upregion = $_POST["upregion"];
        $updistrict = $_POST["updistrict"];
        $upzipcode = $_POST["upzipcode"];
        $upmail = $_POST["upmail"];
        $upcontact = $_POST["upcontact"];
        $upzipid = $_POST["upzipid"] ?? null;

        
        $stnt = $pdo->prepare("UPDATE staff_record SET staff_id = ?, first_name = ?, middle_name = ?, last_name = ?, suffix_name = ?, sex = ?,
        dob = ?, pob = ?, work_region = ?, school_code = ?, street = ?, village = ?, barangay = ?, municipality = ?, province = ?, region = ?,
        district = ?, zipcode = ?, email = ?, contact_no = ?, zip_id = ?
        WHERE user_id = ?");
        $stnt->execute([$upstaffid,$upfname,$upmname,$uplname,$upsname,$upgender,$upbirth,$uppob,$upwregion,$upscCode,$upstreet,$upvillage,$upbarangay,$upmunicipality,
        $upprovince,$upregion,$updistrict,$upzipcode,$upmail,$upcontact,$upzipid,$upid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }



        if(isset($_GET['updateScholar'])){

            $upintid = $_POST["upintid"];
            $upusernames = $_POST["upusernames"];
            $uppassword = $_POST["uppassword"];
            $upacttype = $_POST["upacttype"];
            $passwordsHash = sha1("digi".$uppassword."digi");
            $upregions = $_POST["upregions"];
            $upscode = $_POST["upscode"];
            $upid = $_POST["id"];
            
            
            $stnt = $pdo->prepare("UPDATE users SET username = ?, internal_id = ?, password = ?, account_type = ?, region = ?, school_code = ?
            WHERE id = ?");
            $stnt->execute([$upusernames,$upintid,$passwordsHash,$upacttype,$upregions,$upscode,$upid]);
            
             if($stnt){
                    $result =  true;
                } else{
                    
                    $result = false;
                }
            
                echo json_encode($result);
            
            }

        

?>